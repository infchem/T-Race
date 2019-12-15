function outputError(errMsg) {
    $("#player-login-message").removeClass("success").addClass("error").html(errMsg);
}



(async () => {
    // if already logged in, just show link to homepage
    const container = $("#player-login-container");
    if(DocumentCookies.has(TRaceConfig.players.loggedInCookie)) {
        loadTemplate(container, "common/already-logged-in");
        return;
    }

    // otherwise, load DOM into respective container
    await loadTemplate(container, "gadgets/player-login");

    // after that, the jQuery listeners can be registered
    $("#player-login").submit(async e => {
        e.preventDefault();
    
        // load input data from DOM
        let data = {
            Spielername: $("#player-login-nickname").val(),
            PIN: $("#player-login-pin").val(),
        };
    
        // client-side checks of input data
        let errMsg;
        if(data.Spielername.length === 0)
            errMsg = "Bitte gib einen Spielernamen ein.";
        else if(!/^[0-9]{4}$/.test(data.PIN))
            errMsg = "Bitte gib eine gültige, vierstellige PIN ein.";
        
        // output error to user
        $("#player-registration-message").empty();
        if(errMsg !== undefined) {
            outputError(errMsg);
            return;
        }
    
        // send data to server
        const res = await TRaceAPI.post("players/login", data);
        if(!res.success) {
            if(res.message)
                errMsg = Resources.errorMessages[res.message];
            if(errMsg === undefined)
                errMsg = "Beim Login ist ein unbekannter Fehler aufgetreten.";
            outputError(errMsg);
            return;
        }
    
        // output error to user
        $("#player-login-message").empty();
        if(errMsg !== undefined) {
            $("#player-login-message").removeClass("success").addClass("error").html(errMsg);
            return;
        }
    
        // if no error happened, store player ID in cookie and redirect to vouchers page
        DocumentCookies.set(TRaceConfig.players.loggedInCookie, res.playerId, undefined, "/");
        window.location.href = Resources.pagePaths.game;
    });
})();

