let Maps = function() {};
let allMarkers = [];
let map;

Maps.createMap = function() {
    let markers = [];
    let infoWindows = [];
    let markerlist = gesMapMarkerlist;
    let markerBox = gesMapMarkerBox;
    let mapTypeId = gesMapTypeId;
    let mapcenterlat = gesMapMapcenterlat;
    let mapcenterlng = gesMapMapcenterlng;
    let marker_img = gesMapmarker_img;
    let use_marker = gesMapuse_marker;
    let mapFullscreen = gesMapFullscreen;
    let gestureHandling = gesMapGestureHandling;
    let showMarkerBox = gesMapShowMarkerBox;
    let clickedobjid = -1;

    map = new google.maps.Map(document.getElementById("map"), {
        center: {lat: mapcenterlat, lng: mapcenterlng},
        mapTypeId: mapTypeId,
        gestureHandling: gestureHandling,
        fullscreen: mapFullscreen,
    });

    let marker;
    let i;
    let bounds = new google.maps.LatLngBounds();

    for (i = 0; i < markerlist.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(markerlist[i][0], markerlist[i][1]),
            map: map,
            draggable: false,
            objektId: markerlist[i][2],
            page: markerlist[i][3],
            icon: (use_marker ? marker_img : '/plugins/xsigns/fewo/assets/images/pin.png'),
        });
        markers.push(marker);
        allMarkers.push(marker);

        let infoWindow = new google.maps.InfoWindow({
            content: markerBox[i][0],
            objektId: markerBox[i][1],
        });
        infoWindows.push(infoWindow);

        (function(marker) {
            google.maps.event.addListener(marker, "click", function() {
                stopAnimation();
                startAnimation(marker);

                clickedobjid = marker.objektId;

                if (showMarkerBox)
                    closeInfoWindow();

                if (showMarkerBox)
                    openInfoWindow(infoWindow, marker);

                $('.mapObjekt').removeClass('on-map-selected');
                $('#obj' + marker.objektId).addClass('on-map-selected');
                $('#fewo-map-liste').scrollTop($('#fewo-map-liste').scrollTop() + $('#obj' + marker.objektId).offset().top - ($('#obj' + marker.objektId).height() * 2));
            });
        })(marker);

        marker.setAnimation(null);
        bounds.extend(marker.position);
    }

    google.maps.event.addListener(map, 'idle', function() {
        loadList(clickedobjid);
    });

    map.fitBounds(bounds);

    let markerCluster = new MarkerClusterer(map, markers, {maxZoom: 12, imagePath: 'plugins/xsigns/fewo/assets/images/kreis'});

    const styles = markerCluster.getStyles();
    for (let i = 0; i < styles.length; i++) {
        styles[i].textColor = "#fff";
        styles[i].textSize = 14;
        styles[i].height = 34;
        styles[i].width = 34;
    }

    function startAnimation(marker) {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }

    function stopAnimation() {
        clickedobjid = -1;

        for (i = 0; i < markerlist.length; i++) {
            let marker = markers[i];
            marker.setAnimation(null);
        }
    }

    function openInfoWindow(infoWindow, marker) {
        infoWindow.open(map, marker);
    }

    function closeInfoWindow() {
        for (i = 0; i < infoWindows.length; i++) {
            let infoWindow = infoWindows[i];
            infoWindow.close();
        }
    }

    function loadList(objid = -1) {
        let bounds = map.getBounds();
        let objekte = [];

        for (let i = 0; i < markers.length; i++) {
            let marker = markers[i];

            if (bounds.contains(marker.getPosition()) === true) {
                objekte.push(marker.objektId);
            }
        }

        let ladeurl = (document.location.href.indexOf('?') > -1 ? document.location.href.substring(0, document.location.href.indexOf('?')) : document.location.href).trim();
        let ladedata = 'objekte=' + (objekte ? objekte.join() : "") + (objid > -1 ? "&objid=" + objid : "");

        jQuery.ajax({
            url: ladeurl,
            data: ladedata,
            dataType: "html",
            success: function(resp) {

                if (objekte.length !== 0) {
                    $('#fewo-map-liste').html($('#fewo-map-liste', resp).html());

                    for (i = 0; i < markerlist.length; i++) {
                        let marker = markers[i];

                        if (marker.getAnimation() !== null) {
                            $('.mapObjekt').removeClass('on-map-selected');
                            $('#obj' + marker.objektId).addClass('on-map-selected');
                        }
                    }
                } else {
                    $('#fewo-map-liste').html('<div class="fewo-map-liste-container"></div>');
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
                console.error('error occurred: ' + textStatus + ', ' + errorThrown);
            }
        });
    }
}

function onListSelected(objektId) {
    let markerlist = gesMapMarkerlist;
    let i;

    for (i = 0; i < markerlist.length; i++) {
        let marker = allMarkers[i];
        marker.setAnimation(null);
    }

    for (i = 0; i < markerlist.length; i++) {
        if (objektId === markerlist[i][2]) {
            map.setZoom(19);
            map.setCenter({lat: markerlist[i][0], lng: markerlist[i][1]});

            let marker = allMarkers[i];
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }

    $('.mapObjekt').removeClass('on-map-selected');
    $('#obj' + objektId).addClass('on-map-selected');
}