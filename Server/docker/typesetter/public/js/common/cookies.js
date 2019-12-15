// taken from: https://developer.mozilla.org/en/DOM/document.cookie
// DocumentCookies.set("test1", "Hello world!");
// alert(DocumentCookies.get("test1"));

const DocumentCookies = { 
    get(sKey) {
        if(!sKey || !DocumentCookies.has(sKey))
            return;
        return unescape(document.cookie.replace(new RegExp("(?:^|.*;\\s*)" + escape(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*((?:[^;](?!;))*[^;]?).*"), "$1"));
    },  
    
    set(sKey, sValue, vEnd, sPath, sDomain, bSecure) {
        if(!sKey || /^(?:expires|max\-age|path|domain|secure)$/.test(sKey))
            return;
        let sExpires = ""; 
        if(vEnd) {
            switch(typeof vEnd) {
                case "number": sExpires = "; max-age=" + vEnd; break;
                case "string": sExpires = "; expires=" + vEnd; break;
                case "object": if(vEnd.hasOwnProperty("toGMTString")) { sExpires = "; expires=" + vEnd.toGMTString(); } break;
            }   
        }   
        document.cookie = escape(sKey) + "=" + escape(sValue) + sExpires + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "") + (bSecure ? "; secure" : "");
    },  
    
    remove(sKey) {
        if(!sKey || !DocumentCookies.has(sKey))
            return;
        let oExpDate = new Date();
        oExpDate.setDate(oExpDate.getDate() - 1); 
        document.cookie = escape(sKey) + "=; expires=" + oExpDate.toGMTString() + "; path=/";
        console.log(document.cookie);
    },  
    
    has(sKey) {
        return (new RegExp("(?:^|;\\s*)" + escape(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=")).test(document.cookie);
    }
};
