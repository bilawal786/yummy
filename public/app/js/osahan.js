/*
Template Name: Grofar - Online Grocery Supermarket HTML Mobile Template
Author: Askbootstrap
Author URI: https://themeforest.net/user/askbootstrap
Version: 1.0
*/

(function($) {
"use strict"; // Start of use strict

// Tooltip
$('[data-toggle="tooltip"]').tooltip();

// Category Slider
$('.category-slider').slick({
  dots: false,
  infinite: true,
  arrows: false,
  speed: 100,
  slidesToShow: 3,
  slidesToScroll: 3,
  autoplay: true
});


// Osahan Slider
$('.osahan-slider').slick({
  dots: false,
  infinite: true,
  arrows: false,
  speed: 400,
  slidesToShow: 4,
  slidesToScroll: 4,
  responsive: [
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ],
  autoplay: true
});

// Promo Slider
$('.promo-slider').slick({
  centerMode: false,
  infinite: true,
  speed: 400,
  slidesToShow: 1,
  arrows: false,
  adaptiveHeight: true,
  autoplay: true
});

// Recommend Slider
$('.recommend-slider').slick({
  centerMode: true,
  infinite: true,
  speed: 300,
  slidesToShow: 1,
  adaptiveHeight: true,
  arrows: false,
  autoplay: true
});

// Trending Slider
$('.trending-slider').slick({
  centerPadding: '30px',
  slidesToShow: 2,
  arrows: false,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }
  ]
});

// Sidebar
var $main_nav = $('#main-nav');
  var $toggle = $('.toggle');

  var defaultOptions = {
      disableAt: false,
      customToggle: $toggle,
      levelSpacing: 40,
      navTitle: 'Askbootstrap',
      levelTitles: true,
      levelTitleAsBack: true,
      pushContent: '#container',
      insertClose: 2
  };

// call our plugin
var Nav = $main_nav.hcOffcanvasNav(defaultOptions);

})(jQuery); // End of use strict
