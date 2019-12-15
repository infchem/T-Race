function outputError(errMsg) {
    $("#player-registration-message").removeClass("success").addClass("error").html(errMsg);
}



(async () => {
    // if already logged in, just show link to homepage
    const container = $("#player-registration-container");
    if(DocumentCookies.has(TRaceConfig.players.loggedInCookie)) {
        loadTemplate(container, "common/already-logged-in");
        return;
    }

    // otherwise, load DOM into respective container
    await loadTemplate(container, "gadgets/player-registration");

    // after that, the jQuery listeners can be registered
    $("#player-given-name, #player-last-name").keyup(() => {
        const suggestedNickname = $("#player-given-name").val().substr(0, 3) + $("#player-last-name").val().substr(0, 3);
        $("#player-nickname").val(suggestedNickname.toLowerCase());
    });

    $("#player-registration").submit(async e => {
        e.preventDefault();
    
        // load input data from DOM
        let data = {
            Vorname: $("#player-given-name").val(),
            Name: $("#player-last-name").val(),
            Spielername: $("#player-nickname").val(),
            Alter: $("#player-age").val(),
            Geschlecht: $("#player-registration input[name=player-gender]:checked").val(),
            PIN: $("#player-pin").val(),
        };
    
        // client-side checks of input data
        let errMsg;
        if(data.Vorname.length === 0)
            errMsg = "Bitte gib einen Vornamen ein.";
        else if(data.Vorname.length > TRaceConfig.registration.maxStringLength)
            errMsg = "Bitte gib einen kürzeren Vornamen ein.";
        else if(data.Name.length === 0)
            errMsg = "Bitte gib einen Namen ein.";
        else if(data.Name.length > TRaceConfig.registration.maxStringLength)
            errMsg = "Bitte gib einen kürzeren Namen ein.";
        else if(data.Spielername.length === 0)
            errMsg = "Bitte gib einen Spielernamen ein.";
        else if(data.Spielername.length > TRaceConfig.registration.maxStringLength)
            errMsg = "Bitte gib einen kürzeren Spielernamen ein.";
        else if(data.Alter <= 0 || data.Alter > 100 || isNaN(parseInt(data.Alter)))
            errMsg = "Bitte gib ein gültiges Alter ein.";
        else if(data.Geschlecht === undefined)
            errMsg = "Bitte wähle ein Geschlecht aus.";
        else if(!/^[0-9]{4}$/.test(data.PIN))
            errMsg = "Bitte gib eine gültige, vierstellige PIN ein.";
    
        // output error to user
        $("#player-registration-message").empty();
        if(errMsg !== undefined) {
            outputError(errMsg);
            return;
        }
    
        // send data to server
        const res = await TRaceAPI.post("players/register", data);
        if(!res.success) {
            if(res.message)
                errMsg = Resources.errorMessages[res.message];
            if(errMsg === undefined)
                errMsg = "Beim Login ist ein unbekannter Fehler aufgetreten.";
            outputError(errMsg);
            return;
        }
    
        // if no error happened, clear all input fields and suggest to go to login page
        $("#player-given-name").val("");
        $("#player-last-name").val("");
        $("#player-nickname").val("");
        $("#player-age").val("");
        $("#player-registration input[name=player-gender]:checked").attr("checked", false);
        $("#player-pin").val("");
        $("#player-registration-message").removeClass("error").addClass("success")
            .html("Neuer Spieler wurde erfolgreich registriert. <a href='" + Resources.pagePaths.playerLogin + "'>Zum Login.</a>");
    });
})();
