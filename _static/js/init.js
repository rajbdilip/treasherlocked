"use strict";

var site_url = 'http://localhost/tsl3/';

/*************************************/
/* Ready Function */
/**************************************/

jQuery( document ).ready(function( $ ) {
	
	/*** Auto height function ***/
	var setElementHeight = function () {
		var height = $(window).height();
		$('.autoheight').css('min-height', (height));	
	};

	$(window).on("resize", function () {
		setElementHeight();
	}).resize();
	
	/*******Smooth scroll***********/
	var height = $(".navbar.navbar-default").height();
	
	smoothScroll.init({
		speed: 1000,
		easing: 'easeInOutCubic',
		offset: height,
		updateURL: false,
		callbackBefore: function ( toggle, anchor ) {},
		callbackAfter: function ( toggle, anchor ) {},
	});
	
	$(window).scroll(function() {
		var height = $(window).height();
		var scroll = $(window).scrollTop();
		if (scroll) {
			$(".header-hide").addClass("scroll-header");
		} else {
			 $(".header-hide").removeClass("scroll-header");
		}
	
	});
	
	/***************** Animation ******************/
	var wow = new WOW( {
		boxClass: 'wow', // animated element css class (default is wow)
		animateClass: 'animated', // animation css class (default is animated)
		offset: 0, // distance to the element when triggering the animation (default is 0)
		mobile: false, // trigger animations on mobile devices (default is true)
		live: true // act on asynchronously loaded content (default is true)
	});
	
	wow.init();
	
	/**********Menu Close Logic***************/

	$( '.navbar-collapse.in' ).niceScroll( { cursorcolor: "#c8bd9f" } );
	
	$( '.nav li a' ).click( function() {
			$( '.navbar-collapse.collapse' ).toggleClass( 'in' );
	});	
	
	
	/******** Dropdown Menu ************/
	$( '.dropdown-btn' ).click( function() {
		$( '.dropdown' ).fadeToggle();
	});
	
	$( '.dropdown' ).mouseleave( function() {
		$( '.dropdown' ).fadeOut();
	});
	
	/******* Nice Scroll *******/
	$("html").niceScroll();

});