function sleep(ms) {
    return new Promise((resolve, reject) => {
        setTimeout(() => resolve(), ms);
    });
}

function forceDownloadFile(url, filename) {         // from https://stackoverflow.com/a/37673039
    let anchor = document.createElement("a");
    anchor.href = url;
    anchor.target = "_blank";
    anchor.download = filename;
    anchor.click();
}
