//
    // Script summary: When a user clicks an observation image, prevent default and show the overlay
//


// Adding new Variables
$imgToShow = $('<img>');

// Existing Variables
$tdImage = $('#obs-image');
$anchor = $tdImage.find('a');
href = $anchor.attr('href');
$img = $anchor.find('img');



$anchor.click(function(event) {
    event.preventDefault();
    console.log('foo');
    
});