// The main-nav hamburger menu
var $mainNav = $('.main-nav ul');
var hamburger = $('.hamburger');

hamburger.on('click', function () {
    $mainNav.slideToggle('slow');
});


// The footer right arrow element
var rightArrow = $('.right-arrow');

rightArrow.on('click', function() {
    $(this).next().slideToggle('fast');
});