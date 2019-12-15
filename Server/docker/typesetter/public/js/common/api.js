$(document).ajaxError(function(event, request, settings) {
    console.log(event, request);
});

const TRaceAPI = {
    get(s) {
        return $.getJSON(APIConfig.prefix + s);
    },
    post(s, data) {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "POST",
                url: APIConfig.prefix + s,
                contentType: "application/json",
                data: data===undefined ? "" : JSON.stringify(data),
                error(xhr, status, error) {
                    reject({ status, error });
                },
                success(result) {
                    resolve(result);
                },
            });
        });
    },
};
