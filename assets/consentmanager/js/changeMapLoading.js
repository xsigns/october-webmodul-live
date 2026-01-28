const changeMapLoading = (cookie) => {
    if (cookie &&
        cookie.services &&
        cookie.services.leaflet_map &&
        cookie.services.leaflet_map[0] === 'load') {

        document.cookie = "keepMap=1; path=/; max-age=31536000; SameSite=Lax";

        const mapButtons = document.querySelectorAll('.mapHintContainer form button');

        mapButtons.forEach(button => {
            button.click();
        });
    }
};