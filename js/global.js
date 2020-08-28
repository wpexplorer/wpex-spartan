( function( $ ) {
	"use strict";
	$( document ).ready(function(){

		// Vars
		var $window = $( window );
		var $isRTL = false;
		if ( $( 'body' ).hasClass( 'rtl' ) ) {
			$isRTL = true;
		}

		// Top header search toggle
		$( '.topbar-search-mobile-toggle' ).on( 'click', function(event) {
			$( '#topbar-search' ).toggleClass( 'mobile-show' );
			$( '.topbar-searchform-input' ).focus();
			$( '#header' ).toggleClass( 'opacity' );
			return false;
		} );

		// Main menu superfish
		$( 'ul.sf-menu' ).superfish( {
			delay     : 200,
			animation : {opacity:'show', height:'show'},
			speed     : 'fast',
			speedOut  : 'fast',
			cssArrows : false,
			disableHI : true
		} ); // End superfish

		// Sticky Nav
		$("body.fixed-nav div#site-navigation-wrap").sticky( {
			topSpacing: 0
		} );
		if ( window.location.hash ){
			var windowHash = location.hash;
			var $fixedHeader = $( '#site-navigation-wrap-sticky-wrapper' );
			if ( $fixedHeader.length ) {
				var headerHeight = $fixedHeader.outerHeight();
				$( 'html,body' ).animate( {
					scrollTop: $( windowHash ).offset().top -50
				}, 'normal' );
			}
		}

		// Back to top link
		var $scrollTopLink = $( 'a.site-scroll-top' );
		$window.scroll( function () {
			if ( $(this).scrollTop() > 100 ) {
				$scrollTopLink.addClass( 'show' );
			} else {
				$scrollTopLink.removeClass( 'show' );
			}
		} );
		$scrollTopLink.on( 'click', function() {
			$( 'html, body' ).animate( {
				scrollTop : 0
			}, 400 );
			return false;
		} );

		// Fluid Videos
		if ( 'true' == wpexLocalize.enableFitvids ) {
			$( '.entry' ).fitVids();
		}

		// Tabs Widget
		$( 'div.wpex-tabs-widget-tabs a' ).on( 'click', function(event) {
			if ( ! $(this).hasClass( 'active' ) ) {
				$( 'div.wpex-tabs-widget-tabs a' ).removeClass( 'active' );
				$(this).addClass( 'active' );
				var data = $(this).data( 'tab' );
				$( '.wpex-tabs-widget-tab.active-tab' ).stop(true,true).hide();
				$(this).removeClass( 'active-tab' );
				$(data).addClass( 'active-tab' );
				$(data).show();
			}
			return false;
		} ); // End tabs widget

		// Add class for columns if cookie set
		var $columnsCookie = $.cookie( 'wpex-entry-columns' );
		if ( $columnsCookie == 'enabled' ) {
			// Add column class
			$( '.loop-entry' ).addClass( 'col' );
			// Change icon class
			$( '.layout-toggle' ).find( '.fa' ).removeClass( 'fa-bars' ).addClass( 'fa-th-list' );
		};

		// Toggle entry columns
		$( '.layout-toggle' ).on( 'click', function(event) {
			var $firstEntry = $( '.loop-entry.col-1' ),
				$offset = 30;
			if ( $( 'body' ).hasClass( 'fixed-nav' ) ) {
				var $offset = 83;
			}
			if ( $firstEntry.length ) {
				if ( $firstEntry.hasClass( 'col' ) ) {
					// Remove columns class
					$( '.loop-entry' ).removeClass( 'col' );
					// Change icon class
					$(this).find( '.fa' ).removeClass( 'fa-th-list' ).addClass( 'fa-bars' );
					// Delete cookie
					$.cookie( "wpex-entry-columns", 'disabled', {
						expires: 10,
						path: '/'
					} );
				} else {
					// Toggle columns
					$( '.loop-entry' ).addClass( 'col' );
					// Change icon class
					$(this).find( '.fa' ).removeClass( 'fa-bars' ).addClass( 'fa-th-list' );
					// Set cookie
					$.cookie( "wpex-entry-columns", 'enabled', {
						expires: 10,
						path: '/'
					} );
				}
				$( 'html,body' ).animate( {
					scrollTop: $firstEntry.offset().top - $offset
				}, 'normal' );
			}
			return false;
		} ); // End toggle entry columns

		// Slider widget
		$( '#wrap' ).imagesLoaded(function(){
			// Featured carousel and related carousel
			$( '.featured-carousel, .related-carousel' ).owlCarousel( {
				dots			: false,
				items			: 4,
				margin			: 20,
				autoplay		: false,
				autoplayTimeout	: 5000,
				nav				: true,
				loop			: false,
				rtl				: $isRTL,
				navText			: [ '<span class="fa fa-caret-left"><span>', '<span class="fa fa-caret-right"></span>' ],
				responsive		: {
					0	: {
						items: '2'
					},
					480	: {
						 items: '2'
					},
					768	: {
						items: '3'
					},
					960	: {
						items: '4'
					}
				}
			} );
			// Slider widget
			$( '.slider-widget' ).owlCarousel( {
				items			: 1,
				margin			: 0,
				nav				: false,
				loop			: false,
				dots			: true,
				autoHeight		: true,
				autoplay		: true,
				autoplayTimeout	: 5000,
				stopOnHover		: true,
				rtl				: $isRTL,
				navText			: [ '<span class="fa fa-caret-left"><span>', '<span class="fa fa-caret-right"></span>' ]
			} );
		} ); // End imagesLoaded

		// Placeholder for WP login form-submit
		$( '.login-template-forms #user_login' ).attr( 'placeholder', wpexLocalize.UsernamePlaceholder );
		$( '.login-template-forms #user_pass' ).attr( 'placeholder',  wpexLocalize.PasswordPlaceholder );

		// Post Gallery
		var $postSliderWrap = $( 'body.single div.single-post-media' );
		$postSliderWrap.imagesLoaded( function() {

			// Define post gallery
			var $postGallery = $( '.post-gallery' );

			// Add lightbox to post gallery
			$postGallery.on( 'initialized.owl.carousel', function( event ) {
				$( '.post-gallery .owl-stage' ).each( function() {
					var $this		= $( this ),
						$delegate	= $this.find( '.owl-item:not(.cloned) a.post-gallery-lightbox-item' );
					$this.magnificPopup( {
						delegate	: $delegate,
						type		: 'image',
						gallery		: {
							enabled	: true
						}
					} );
				} );
			} );

			// Initiate owl carousel
			$postGallery.owlCarousel( {
				items		: 1,
				margin		: 0,
				nav			: true,
				loop		: true,
				dots		: true,
				autoHeight	: true,
				autoplay	: false,
				rtl			: $isRTL,
				smartSpeed	: 450,
				dotsData	: true,
				callbacks	: true,
				navText		: [ '<span class="fa fa-caret-left"><span>', '<span class="fa fa-caret-right"></span>' ]
			} );

		} ); // End post gallery

		// Homepage Slider
		var $homeSliderContainer = $( 'div#home-slider-wrap' );
		$homeSliderContainer.imagesLoaded(function(){
			var $slideshow = false;
			if ( 'true' == wpexLocalize.homeSlideshow ) {
				$slideshow = true;
			}
			$( '#home-slider' ).owlCarousel( {
				items			: 1,
				margin			: 0,
				nav				: true,
				loop			: true,
				dots			: true,
				dotsEach		: 1,
				animation		: 'true',
				autoHeight		: true,
				stopOnHover		: true,
				autoplay		: $slideshow,
				autoplayTimeout	: wpexLocalize.homeSlideshowSpeed,
				rtl				: $isRTL,
				smartSpeed		: 450,
				dotsData		: true,
				navText			: [ '<span class="fa fa-caret-left"><span>', '<span class="fa fa-caret-right"></span>' ]
			} );
		} ); // End home Slider

		// Lightbox
		$( '.wpex-lightbox' ).magnificPopup( { type: 'image' } );
		$( '.wpex-gallery-lightbox' ).each( function() {
			var $this = $( this );
			$this.magnificPopup( {
				delegate	: 'a',
				type		: 'image',
				gallery		: {
					enabled	: true
				}
			} );
		} ); // End lightbox

		/*** Topbar Mobile Menu ***/

		// Prepend Main Mobile menu
		if ( $( '#topbar-nav' ).length ) {
			$( '#header' ).prepend( '<div class="wpex-mobile-top-nav"></div>' );
			// Grab all content from menu and add into wpex-mobile-top-nav element
			var mobileMenuContents = $( '.top-nav' ).html();
			$( '.wpex-mobile-top-nav' ).html( '<ul class="wpex-mobile-top-nav-ul">' + mobileMenuContents + '</ul>' );
			// Remove all classes inside prepended nav
			$( '.wpex-mobile-top-nav-ul, .wpex-mobile-top-nav-ul *' ).children().each(function() {
				var attributes = this.attributes;
				$(this).removeAttr("style");
			} );
			// Main toggle
			$( '.topbar-nav-mobile-toggle' ).on( 'click', function(event) {
				//e.preventDefault();
				$(this).toggleClass( 'fa-bars fa-times' );
				$( '.wpex-mobile-top-nav' ).toggle();
				return false; // Better support for theme customizer
			} );
			// Close on orientation change
			$( window ).on( "orientationchange", function( event ) {
				$( '.wpex-mobile-top-nav' ).hide();
				$( '.navigation-toggle-icon' ).removeClass( 'fa-times' );
				$( '.navigation-toggle-icon' ).addClass( 'fa-bars' );
				$( '.navigation-toggle-text' ).text(wpexLocalize.mobileMenuOpen);
			} );
		}

		/*** Main Mobile Menu ***/

		// Prepend Main Mobile menu
		$( '.site-main-wrap' ).prepend( '<div class="wpex-mobile-main-nav"></div>' );
		// Grab all content from menu and add into wpex-mobile-main-nav element
		var mobileMenuContents = $( '.main-nav' ).html();
		$( '.wpex-mobile-main-nav' ).html( '<ul class="wpex-mobile-main-nav-ul">' + mobileMenuContents + '</ul>' );
		// Remove all classes inside prepended nav
		$( '.wpex-mobile-main-nav-ul, .wpex-mobile-main-nav-ul *' ).children().each(function() {
			var attributes = this.attributes;
			$(this).removeAttr("style");
		} );
		// Add classes where needed
		$( '.wpex-mobile-main-nav-ul' ).addClass( 'container' );
		// Main toggle
		$( '.navigation-toggle' ).on( 'click', function(event) {
			//e.preventDefault();
			var txt = $(".wpex-mobile-main-nav").is( ':visible' ) ? wpexLocalize.mobileMenuOpen : wpexLocalize.mobileMenuClosed;
			$(this).children( '.navigation-toggle-text' ).text(txt);
			$(this).children( '.navigation-toggle-icon' ).toggleClass( 'fa-bars fa-times' );
			$( '.wpex-mobile-main-nav' ).toggle();
			return false; // Better support for theme customizer
		} );
		// Close on orientation change
		$( window ).on( "orientationchange", function( event ) {
			$( '.wpex-mobile-main-nav' ).hide();
			$( '.navigation-toggle-icon' ).removeClass( 'fa-times' );
			$( '.navigation-toggle-icon' ).addClass( 'fa-bars' );
			$( '.navigation-toggle-text' ).text(wpexLocalize.mobileMenuOpen);
		} );
		
	} ); // End doc ready
} ) ( jQuery );