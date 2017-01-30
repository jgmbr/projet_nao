// Initialize The Google Map Element
var initMap = function() {
    var myLatLng = {lat: 48.866667, lng: 2.333333};
    // Create a map object and specify the DOM element for display.
    var map = new google.maps.Map(document.getElementById('map'), {
        center: myLatLng,
        scrollwheel: false,
        zoom: 6
    });
}



//Creating the variables
// The address input
var addressInput = document.getElementById('address');
// The button "Me Localiser"
var localizeBtn = document.getElementById('localize');
// The object used for geolocation
var loc = navigator.geolocation;
// The two forms field for latitude & longitude
var latInput = document.getElementById('observation_form_latitude');
var lonInput = document.getElementById('observation_form_longitude');


// Creating the functions
// Get the lattitude & longitude for the localize button
function getLocationByLocalizeBtn(position) {
    // assign them to variables
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;
    // fill in the two relative fields
    latInput.value = lat;
    lonInput.value = lon;
    // Update the map
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: lat, lng: lon},
        zoom: 12
    });
    // Create the marker
    var marker = new google.maps.Marker({
        position: {lat: lat, lng: lon},
        map: map,
        title: "Vous êtes ici"
    });
}


// Get the latitude & longitude according to the address field
function getLocationByAddress() {
    // Create & assign variables
    var addressValue = addressInput.value;
    var geocoder = new google.maps.Geocoder();
    // Run the geocode
    geocoder.geocode(
        {'address': addressValue},
        function(results) {
            var loc = results[0].geometry.location;
            var lat = loc.lat();
            var lon = loc.lng();
            // fill in the two relative fields
            latInput.value = lat;
            lonInput.value = lon;
            // Update the map
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: lat, lng: lon},
                zoom: 12
            });
            // Create the marker
            var marker = new google.maps.Marker({
                position: {lat: lat, lng: lon},
                map: map,
                title: "Vous êtes ici"
            });
        }
    );
}

// Creating the event handlers
// When the address field is not focus anymore
addressInput.onblur = getLocationByAddress;


// When the "Me Localiser" button is clicked
localizeBtn.onclick = function() {
    loc.getCurrentPosition(getLocationByLocalizeBtn);
}
