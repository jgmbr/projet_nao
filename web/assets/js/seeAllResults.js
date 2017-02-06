// Initialize The Google Map Element
var initMap = function() {
    var myLatLng = {lat: 48.866667, lng: 2.333333};
    // Create a map object and specify the DOM element for display.
    var map = new google.maps.Map(document.getElementById('map'), {
        center: myLatLng,
        scrollwheel: false,
        zoom: 6,
        maxZoom: 6
    });
};