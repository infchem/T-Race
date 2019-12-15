async function refreshStatus() {
    // if no player is logged in, show no status
    const container = $("#player-status-container");
    if(!DocumentCookies.has(TRaceConfig.players.loggedInCookie))
        return false;
	
    // otherwise, definitely show his status
    const playerInfo = await TRaceAPI.get("players/" + DocumentCookies.get(TRaceConfig.players.loggedInCookie));
    SharedData.set("playerInfo", playerInfo);

    if(playerInfo.Essen < 0)
        playerInfo.Essen = 0;
    if(playerInfo.Fitness < 0)
        playerInfo.Fitness = 0;
    await loadTemplate(container, "gadgets/player-status", playerInfo);
    return true;
}

(async () => {
    if(await refreshStatus()) {
        $("#player-status-container").on("click", "#player-logout-button", () => {
            DocumentCookies.remove(TRaceConfig.players.loggedInCookie);
            window.location.href = Resources.pagePaths.playerLogin;
        });

        while(true) {
            await sleep(TRaceConfig.status.refreshInterval);
            await refreshStatus();
        }
    }
})();
