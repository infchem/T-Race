(async () => {
	// show status only if logged in
	const container = $("#player-result-container");
	if(!DocumentCookies.has(TRaceConfig.players.loggedInCookie)) {
		await loadTemplate(container, "common/not-logged-in");
		return;
	}
	
	// otherwise, load DOM into respective container
	const tRacer = DocumentCookies.get(TRaceConfig.players.loggedInCookie);
	const playerResult = await TRaceAPI.get("players/" + tRacer + "/result");

	// construct DOM for "did you know" fields
	playerResult.didYouKnowDOM = playerResult.ageGroupComparisons.map(({Anteil, Name}) => {
		if(Anteil < 25)
			return `<li>Wusstest du, dass für <b>${100 - Anteil}%</b> deiner Altersgruppe <b>${Name}</b> nicht das Lieblingsessen ist?</li>`;
		return `<li>Wusstest du, dass du zu den <b>${Anteil}%</b> deiner Altersgruppe gehörst, die auch am liebsten <b>${Name}</b> kaufen?</li>`
	}).join("");
	await loadTemplate(container, "gadgets/player-result", playerResult);
	
	const configNumBought = {
		type: "line",
		data: {
			labels: [...Array(playerResult.totalPlayTime + 1)].map((_, i) => i.toString()),
			datasets: [
				{
					label: "Gekaufte Artikel",
					backgroundColor: Resources.chartColors.red,
					borderColor: Resources.chartColors.red,
					data: [...Array(playerResult.totalPlayTime + 1)].map((_, i) => playerResult.buyTimestamps.filter(x => x <= i).length),
					fill: false
				},
				{
					label: "Aktivierte Gutscheine",
					backgroundColor: Resources.chartColors.blue,
					borderColor: Resources.chartColors.blue,
					data: [...Array(playerResult.totalPlayTime + 1)].map((_, i) => playerResult.redeemTimestamps.filter(x => x <= i).length),
					fill: false
				}
			]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			tooltips: {
				mode: "index",
				intersect: false,
			},
			hover: {
				mode: "nearest",
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true,
						labelString: "Spielzeit"
					}
				}],
				yAxes: [{
					display: true,
					scaleLabel: {
						display: true,
						labelString: "Anzahl"
					},
					ticks: {
						min: 0
					}
				}]
			}
		}
	};

	const configShopVisits = {
		type: "bar",
		data: {
			labels: playerResult.shopVisits.map(v => v.name),
			datasets: [
				{
					label: "Shopbesuche",
					backgroundColor: Resources.chartColors.orange,
					borderColor: Resources.chartColors.orange,
					data: playerResult.shopVisits.map(v => v.visits),
					fill: false
				}
			]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			tooltips: {
				mode: "index",
				intersect: false,
			},
			hover: {
				mode: "nearest",
				intersect: true
			},
			scales: {
				yAxes: [{
					display: true,
					scaleLabel: {
						display: true,
						labelString: "Anzahl"
					},
					ticks: {
						min: 0
					}
				}]
			}
		}
	};
	
	let numBoughtChart = new Chart($("#player-result-canvas-num-bought")[0].getContext("2d"), configNumBought);
	let shopVisitsChart = new Chart($("#player-result-canvas-shop-visits")[0].getContext("2d"), configShopVisits);
})();
