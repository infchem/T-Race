(async () => {
    // if not logged in or on game over, show nothing
    const container = $("#webshop-container");
    if(!DocumentCookies.has(TRaceConfig.players.loggedInCookie) || await SharedData.get("isGameOver"))
		return;

	// otherwise, load DOM into respective container
	const tRacer = DocumentCookies.get(TRaceConfig.players.loggedInCookie);
	const webshopArticles = await TRaceAPI.get("players/" + tRacer + "/webshop");

	let templateContent = webshopArticles.map(({Name, aktiv, Preis}) => {
		let ret = `<img data-is-buyable='${aktiv ? 1 : 0}' data-article-name='${Name}' src='/public/img/${Name}${aktiv ? "" : "_na"}.png' width='100' height='100'>`;
		ret += `<br>${Preis} Traceys`;
		return ret;
	});

	await loadTemplate(container, "gadgets/webshop", { dinosong: templateContent[0], dinobild: templateContent[1] });
	$("#webshop-popup").popup();

	const statusOutput = $("#webshop-message");
	$("#webshop-items img[data-is-buyable=1]").click(async function() {
		const article = Resources.webshopArticles[$(this).attr("data-article-name")];
		if(!article) return;

		// show a short status message to the user to indicate whether the purchase was successful
		const res = await TRaceAPI.get("players/" + tRacer + "/buy/" + article.id);
		const msg = res.success ? "Du hast den Artikel erfolgreich gekauft!" : "Du konntest den Artikel leider nicht kaufen.";
		if(res.success)
			statusOutput.removeClass("error");
		else
			statusOutput.addClass("error");
		statusOutput.html(msg);

		// actually make the browser download the file
		if(res.success)
			forceDownloadFile(article.url, article.filename);
	});
})();
