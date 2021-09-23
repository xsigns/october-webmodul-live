$(document).ready(function () {
    var roadmap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{ maxZoom: 18, attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>, Service <a href="https://www.fewo-verwalter.de" target=_blank">Fewo-Verwalter</a>' });
    var plain1 = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', { maxZoom: 18, attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>, Service <a href="https://www.fewo-verwalter.de" target=_blank">Fewo-Verwalter</a>' });
    var plain2 = L.tileLayer('https://{s}.tiles.wmflabs.org/hikebike/{z}/{x}/{y}.png', { maxZoom: 18, attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>, Service <a href="https://www.fewo-verwalter.de" target=_blank">Fewo-Verwalter</a>' });
    var satellit = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 18, attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>, Service <a href="https://www.fewo-verwalter.de" target=_blank">Fewo-Verwalter</a>' });

    var baseLayers = {"ROADMAP": roadmap, "PLAIN 1": plain1, "PLAIN 2": plain2, "Satellit": satellit};

    if (fullscreen) {
        var mymap = L.map('mapid', {
            fullscreenControl: true,
            fullscreenControlOptions: { // optional
                title: "Vollbildansicht",
                titleCancel: "Normalansicht"
            },
            center: [centerlat, centerlong],
            zoom: 13,
            scrollWheelZoom: false,
        });
    } else {
        var mymap = L.map('mapid', {
            center: [centerlat, centerlong],
            zoom: 13,
            scrollWheelZoom: false,
        });
    }

    L.tileLayer(leafletMap, {
        maxZoom: 18,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>, Service <a href="https://www.fewo-verwalter.de" target=_blank">Fewo-Verwalter</a>'
    }).addTo(mymap);

    if (showcircle) {
        L.circle([latitude, longitude], {
            color: color,
            fillColor: color,
            fillOpacity: 0.5,
            radius: 500
        }).addTo(mymap);
    } else {
        L.marker([latitude, longitude]).addTo(mymap);
    }

    L.control.layers(baseLayers).addTo(mymap);

    mymap.on('click', function() {
        if (mymap.scrollWheelZoom.enabled()) {
            mymap.scrollWheelZoom.disable();
        } else {
            mymap.scrollWheelZoom.enable();
        }
    });

    L.control.scale().addTo(mymap);

    mymap.on('mouseout', function() {
        mymap.scrollWheelZoom.disable();
    });

    if (isInTab) {
        $(selectedTab).on('shown.bs.tab', function (e) {
            mymap.invalidateSize();
        });
    }
});