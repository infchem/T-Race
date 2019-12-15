const tRacer = DocumentCookies.get(TRaceConfig.players.loggedInCookie);
let voucherInfos = {};
let nextVoucherIndex = 0;

async function countDown(elmts, indices, remaining) {
    let numVouchersTotal;
    let timers = elmts.map(e => e.find(".timer"));
    if(remaining === undefined)
        remaining = TRaceConfig.vouchers.defaultTimeout;

    while(remaining > 0) {
        numVouchersTotal = $("#vouchers-output").children().length;
        indices.forEach((idx, i) => {
            if(voucherInfos[idx].wasRedeemed)
                elmts[i] = undefined;
        });
        
        if(elmts.filter(e => !!e).length === 0)
            break;
        if(numVouchersTotal === 1)
            break;

        const timerStr = (remaining--).toString().padStart(2, '0');
        timers.forEach(t => { if(t) t.html(timerStr); });
        await sleep(1000);
    }

    if($("#vouchers-output").children().length === 1) {
        const infos = voucherInfos[indices[elmts.findIndex(e => !!e)]];
        fillVoucher(infos.elmt, infos.data, true);
        return;
    }

    if(remaining === 0) {
        elmts = elmts.filter(e => !!e);
        if(elmts.length === 1) {
            if(numVouchersTotal === 1)
                replaceVouchers(elmts, { isIndefinite: true });
            else
                elmts[0].remove();
        }
        else {
            replaceVouchers(elmts.slice(1), {
                isIndefinite: numVouchersTotal === 2,
                fnBeforeHiding: () => elmts[0].addClass("content-hidden"),
                fnWhileHidden: () => elmts[0].remove(),
            });
        }
        await TRaceAPI.get(`players/${tRacer}/expiry_penalty`);
    }
}

function generateVoucherHTML(apiEntry, isIndefinite) {
    const voucherTemplate = "<img src='{{img}}'><div class='description'>" +
        (isIndefinite ? "E" : "Noch <span class='timer'></span>s e") +
        "inlösbar beim {{shop}}</div>";
    return processTemplate(voucherTemplate, { img: Resources.images.rabatt[apiEntry.Rabatt.R_ID], shop: apiEntry.Laden.Name });
}

function fillVoucher(elmt, data, isIndefinite) {
    const idx = nextVoucherIndex++;
    elmt.attr("data-voucher-index", idx);
    elmt.html(generateVoucherHTML(data, isIndefinite));
    voucherInfos[idx] = { id: data.GutscheinID, elmt, data };
    return idx;
}

async function replaceVouchers(elmts, {isInitial = false, isIndefinite = false, fnBeforeHiding, fnWhileHidden}) {
    if(elmts.length == 0)
        return;
    const voucherData = await TRaceAPI.get(`vouchers/generate/${tRacer}/${elmts.length}`);

    if(!isInitial) {
        elmts.forEach(e => voucherInfos[e.attr("data-voucher-index")].wasRedeemed = true);
        elmts.forEach(e => e.addClass("content-hidden"));
        if(typeof fnBeforeHiding === "function")
            fnBeforeHiding();
        await sleep(300);
    }

    let newIndices = elmts.map((e, i) => fillVoucher(e, voucherData[i], isIndefinite));
    if(!isIndefinite)
        countDown(elmts, newIndices);
    if(typeof fnWhileHidden === "function")
        fnWhileHidden();

    if(!isInitial) {
        await sleep(100);
        elmts.forEach(e => e.removeClass("content-hidden"));
    }
}

async function addVouchers(n) {
    let out = $("#vouchers-output");
    let newElmts = [...Array(n)].map(e => $("<div></div>").addClass("voucher").appendTo(out));
    replaceVouchers(newElmts, { isInitial: true });

    newElmts.forEach(v => v.click(function() {
        const idx = $(this).attr("data-voucher-index");
        TRaceAPI.post("vouchers/redemption/" + voucherInfos[idx].id);
        replaceVouchers([$(this)], { isIndefinite: out.children().length === 1 });
    }));
}



(async () => {
    // if not yet logged in, show link to login page
    const container = $("#vouchers-container");
    if(!DocumentCookies.has(TRaceConfig.players.loggedInCookie)) {
        loadTemplate(container, "common/not-logged-in");
        return;
    }

    // if the player's info indicates that his game is over, refer to his results page; "playerInfo" is filled by the "player-status" gadget
    if(await SharedData.get("isGameOver")) {
        window.location.href = Resources.pagePaths.playerResult;
        return;
    }

    // otherwise, load DOM into respective container
    await loadTemplate(container, "gadgets/vouchers");

    // after that, the jQuery listeners can be registered
    $("#start-game").click(async () => {
        await TRaceAPI.get("players/" + tRacer + "/start_game");
        $("#start-game-container").remove();
        $("#vouchers-output").empty();
        await addVouchers(await SharedData.get("numVouchers"));
    });

    // keep watching for the "isGameOver" variable to redirect to the results page then
    while(!(await SharedData.get("isGameOver", true))) {}
    window.location.href = Resources.pagePaths.playerResult;
})();
