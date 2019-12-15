// game configuration
const TRaceConfig = {
    vouchers: {
        defaultTimeout: 10,
        maxNumber: 4
    },
    players: {
        loggedInCookie: "t-racer",
    },
    registration: {
        maxStringLength: 20,
    },
    status: {
        refreshInterval: 2000,
    },
};

// resources
const Resources = {
    images: {
        rabatt: {
            "1": "/public/img/3fuer2.png",
            "2": "/public/img/spar1tracey.png",
            "3": "/public/img/spar2traceys.png",
            "4": "/public/img/spar3traceys.png",
        },
    },
    webshopArticles: {         // IDs for the articles returned by the API endpoint   players/SID/webshop
        dinobild: {
            id: 24,
            url: "/public/img/t-race.png",
            filename: "t-race.png",
        },           
        dinosong: {
            id: 25,
            url: "/public/img/dinosong.mp3",
            filename: "dinosong.mp3",
        },
    },
    errorMessages: {
        "nickname-already-exists": "Der gewünschte Spielername ist bereits vergeben.",
        "invalid-pin": "Die von dir eingegebene PIN ist falsch.",
        "unknown-nickname": "Der eingegebene Spielername ist unbekannt.",
        "unknown-player-id": "Die übergebene Spieler-ID ist unbekannt.",
        "parameter-out-of-bounds": "Ein übergebener Parameter ist außerhalb der definierten Grenzen.",
    },
    pagePaths: {
        home: "/index.php",
        game: "/index.php/Spiel",
        playerRegistration: "/index.php/Registrierung",
        playerLogin: "/index.php/Login",
		playerResult: "/index.php/Auswertung",
    },
    chartColors: {
        red: "rgb(255, 99, 132)",
        orange: "rgb(255, 159, 64)",
        yellow: "rgb(255, 205, 86)",
        green: "rgb(75, 192, 192)",
        blue: "rgb(54, 162, 235)",
        purple: "rgb(153, 102, 255)",
        grey: "rgb(201, 203, 207)",
    },
};

// API configuration
const APIConfig = {
    prefix: "/api/v1.php?",
};
