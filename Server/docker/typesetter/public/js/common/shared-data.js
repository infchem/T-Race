let SharedDataInternal = {};

// A simple mechanism for sharing data across gadgets using promises.
// Scenario: one gadget loads data, and another gadget wants to have access to this data as well, but may not reload it itself.
// Presuming that it's not known in which order the gadgets will load, the second gadget will be notified via a promise when the data has been loaded from the first gadget.
const SharedData = {
    get(key, onlyNextChange) {
        let resolveFn;
        let retPromise = new Promise((resolve, reject) => resolveFn = resolve);

        // if the key is not yet known at all, create a new entry for it
        if(SharedDataInternal[key] === undefined)
            SharedDataInternal[key] = { val: undefined, pendingResolvers: [] };
        
        // if its value is not yet set, or the listener wants to be informed only about the next change, put it on the 'pending' list, otherwise resolve immediately
        if(SharedDataInternal[key].val === undefined || onlyNextChange)
            SharedDataInternal[key].pendingResolvers.push(resolveFn);
        else
            resolveFn(SharedDataInternal[key].val);
        return retPromise;
    },
    set(key, val) {
        // if the key is not yet known at all, create a new entry for it
        if(SharedDataInternal[key] === undefined)
            SharedDataInternal[key] = { val: undefined, pendingResolvers: [] };
        SharedDataInternal[key].val = val;
        
        // notify all pending listeners about the change, then clear that list
        SharedDataInternal[key].pendingResolvers.forEach(r => r(val));
        SharedDataInternal[key].pendingResolvers = [];

        // calculate dependent variables
        if(key === "playerInfo")
            SharedData.set("isGameOver", val.Essen <= 0 || val.Fitness <= 0 || val.Guthaben <= 0);
        if(key == "playerInfo") {
            val.AnzahlGutscheine = parseInt(val.AnzahlGutscheine);
            SharedData.set("numVouchers", val.AnzahlGutscheine <= 1 ? 1 : (val.AnzahlGutscheine > TRaceConfig.vouchers.maxNumber ? TRaceConfig.vouchers.maxNumber : val.AnzahlGutscheine));
        }
    }
};
