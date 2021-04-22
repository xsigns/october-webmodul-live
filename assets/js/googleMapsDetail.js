function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: {lat: googleCenterlat, lng: googleCenterlong},
        zoom: mapZoom,
        fullscreenControl: fullscreen,
        mapTypeId: googleMapType,
        gestureHandling: 'greedy'
    });

    marker = new google.maps.Marker({
        position: new google.maps.LatLng(googleCenterlat, googleCenterlong),
        map: map,
        draggable: false,
        icon: (use_marker ? marker_img : ''),
    });
}