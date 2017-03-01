//
    // Script summary: When a user clicks an observation image, prevent default and show the overlay
//


// Existing Variables
var $tdImage = $('#obs-image');
var $anchor = $tdImage.find('a');
var href = $anchor.attr('href');
var $img = $anchor.find('img');
var alt = $img.attr('alt');


// Create the overlay and its linked elements
var $overlay = $('<div id="overlay"></div>');
var $overlayImgContainer = $('<div id="overlayImgContainer"></div>');
var $closeThis = $('<p>Fermer la fenêtre</p>')
var $imgToShow = $('<img src="" alt="">');


// Append the elements to the container
$overlayImgContainer.append($imgToShow);
$overlayImgContainer.append($closeThis);
$overlay.append($overlayImgContainer);
$('.main-wrapper').append($overlay);


// The click event which shows the overlay
$anchor.click(function(event) {
    event.preventDefault();

    // Fill in the image information
    $imgToShow.attr('src', href);
    $imgToShow.attr('alt', alt);

    // Show the overlay & its picture
    $overlay.fadeIn('fast');
});


$closeThis.click(function() {
    $overlay.fadeOut('fast');
});

$(document).keydown(function(event) {
    if (event.which === 27) {
        $overlay.fadeOut('fast');
    }
});