function processTemplate(src, obj) {
    if(obj === undefined)
        obj = Resources;        // from constants.js

    while(true) {
        const newSrc = src.replace(/\{\{(([a-zA-Z0-9]+\.)*[a-zA-Z0-9]+)\}\}/, (match, path, idx) => {
            const res = path.split(".").reduce((prev, curr) => {
                if(prev === undefined)
                    return prev;
                return prev[curr];
            }, obj);

            if(res === undefined)
                return match;
            return res;
        });
        
        if(newSrc == src)
            return src;
        src = newSrc;
    }
}

function loadTemplate(dest, path, obj) {
    return new Promise((resolve, reject) => {
        $.get("/public/dom/" + path + ".html")
            .done(resp => {
                dest.html(processTemplate(resp, obj));
                resolve();
            })
            .fail(msg => {
                reject(msg);
            });
    });
}
