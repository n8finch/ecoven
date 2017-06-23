//********************************************************
// plugin for equalizing heights, responsively
//********************************************************
(function ($) {
	$.fn.eqHeights = function() {
		var el = $(this);
		if (el.length > 0 && !el.data('eqHeights')) {
			$(window).on('resize.eqHeights', function() {
				el.eqHeights();
			});
			el.data('eqHeights', true);
		}
		return el.each(function() {
			var curHighest = 0;
			$(this).children().each(function() {
				var el = $(this),
					elHeight = el.height('auto').height();
				if (elHeight > curHighest) {
					curHighest = elHeight;
				}
			}).height(curHighest);
		});
	};
}(jQuery));

(function ($) {
	"use strict";
	$(function () {
		// ********************************************************
		// Make videos responsive
		// ********************************************************
		$('.entry-content').fitVids();

		// ********************************************************
		// Menu Navigation
		// ********************************************************
		$('.menu-toggle').on('click',function(evt){
			evt.preventDefault();
			$('.nav-primary').toggleClass('expanded');
			$(this).toggleClass('expanded');
		});

		// Responsive nav menus
		$(".menu-primary > .menu-item a").each(function() {
			if ($(this).next().length > 0) {
				$(this).addClass("parent");
			}
		});

		// Add click handler to mobile menu items
		var menuClickHandler = function(e) {
			var $this = $(this);
			if (!$this.hasClass('expanded')) {
				e.preventDefault();
				$this.toggleClass("expanded");
				$this.parent(".menu-item").find("ul").toggleClass("hover");
			}
		};

		// Get the window width
		var ww = $(window).width();
		if (ww < 850) {
			$(".menu-primary .menu-item a.parent").addClass("click-bound").click(menuClickHandler);
		}
		// remove child menu classes if resized larger
		$(window).on("resize", function() {
			var ww = document.body.clientWidth;
			if (ww > 850) {
				$(".menu-primary .menu-item ul").removeClass("hover");
				$(".menu-primary .menu-item a.parent").removeClass("click-bound expanded").off('click');
			} else {
				$(".menu-primary .menu-item a.parent:not(.click-bound)").addClass("click-bound").click(menuClickHandler);
			}
		});

		// ********************************************************
		// World Nomads
		// ********************************************************
		$('#world-nomads').on('click', function(evt){
			evt.preventDefault();
			var $calculator = $('#wn_calculator');
			var $overlay    = $('#wn-overlay');

			// Show overlay, and add click handler to hide dialog
			$overlay.show()
							.on('click', function(){
								$calculator.dialog('close');
							});
			// Show dialog
			$calculator.dialog({
				width: 550,
				draggable: false,
				closeOnEscape: true,
				closeText: 'X',

				close: function(){
					$overlay.hide();
				}
			});
		});

		// ********************************************************
		// 10 Reasons
		// ********************************************************
		$('div.eco-reasons').each(function() {
			$(this).eqHeights();
		});

		// ********************************************************
		// Expandable sections
		// ********************************************************
		// $('.section-title').each(function() {
			$('.section-title').on('click', function(evt){
				evt.preventDefault();

				var $this = $(this);
				$this.nextAll('.section-content:first').slideToggle( 'fast', 'swing', function(){
					$this.toggleClass('expanded');
				});
			});
		// });

		// ********************************************************
		// Itineraries
		// ********************************************************

		// Colorbox for maps
		$('.itinerary-map a').colorbox({
			width: '75%'
		});

		// Itinerary slideshows
		$(window).load(function() {
			$( '.itinerary-slider' ).each(function(){
				$(this).flexslider2({
					namespace: "underscores_slider-",
					animation: 'fade',
					slideshowSpeed: 4000,
					animationSpeed: 600,
					slideshow: false,
					directionNav: true,
					animationLoop: true,
					pauseOnAction: true,
					pauseOnHover: true,
					smoothHeight: false,
					controlNav: true
				});
			});

			// Cuisine
			$( '.cuisine-slider' ).each(function(){
				$(this).flexslider2({
					namespace: "underscores_slider-",
					animation: 'fade',
					slideshowSpeed: 4000,
					animationSpeed: 600,
					slideshow: false,
					directionNav: true,
					animationLoop: true,
					pauseOnAction: true,
					pauseOnHover: true,
					smoothHeight: false,
					controlNav: true
				});
			});

			// Yachts sliders
			$( '#dolphin-deck-slider-nav' ).each(function(){
				$(this).flexslider2({
					namespace: "underscores_slider-",
					animation: 'slide',
					animationSpeed: 600,
					slideshow: false,
					directionNav: true,
					animationLoop: false,
					controlNav: false,
					itemWidth: 150,
					itemMargin: 5,
					asNavFor: '#dolphin-deck-slider'
				});
			});

			$( '#dolphin-deck-slider' ).each(function(){
				$(this).flexslider2({
					namespace: "underscores_slider-",
					animation: 'slide',
					animationSpeed: 600,
					slideshow: false,
					directionNav: true,
					animationLoop: false,
					controlNav: false,
					sync: '#dolphin-deck-slider-nav'
				});
			});

			// Gallery sliders
			$( '.gallery-slideshow' ).each(function(){
				$(this).flexslider2({
					namespace: "underscores_slider-",
					animation: 'slide',
					slideshowSpeed: 4000,
					animationSpeed: 600,
					slideshow: false,
					directionNav: true,
					animationLoop: true,
					pauseOnAction: true,
					pauseOnHover: true,
					smoothHeight: true,
					controlNav: true
				});
			});

		}); // window.load

		$('.yachts-menu-nav .main-button-nav a').on('click', function(e){
			if (e.currentTarget.hash === '#booby-deck-slideshow'){
				$( '#booby-deck-slider-nav' ).each(function(){
					$(this).flexslider2({
						namespace: "underscores_slider-",
						animation: 'slide',
						animationSpeed: 600,
						slideshow: false,
						directionNav: true,
						animationLoop: false,
						controlNav: false,
						itemWidth: 150,
						itemMargin: 5,
						asNavFor: '#booby-deck-slider'
					});
				});

				$( '#booby-deck-slider' ).each(function(){
					$(this).flexslider2({
						namespace: "underscores_slider-",
						animation: 'slide',
						animationSpeed: 600,
						slideshow: false,
						directionNav: true,
						animationLoop: false,
						controlNav: false,
						sync: '#booby-deck-slider-nav'
					});
				});
			}
			if (e.currentTarget.hash === '#iguana-deck-slideshow'){
				$( '#iguana-deck-slider-nav' ).each(function(){
					$(this).flexslider2({
						namespace: "underscores_slider-",
						animation: 'slide',
						animationSpeed: 600,
						slideshow: false,
						directionNav: true,
						animationLoop: false,
						controlNav: false,
						itemWidth: 150,
						itemMargin: 5,
						asNavFor: '#iguana-deck-slider'
					});
				});

				$( '#iguana-deck-slider' ).each(function(){
					$(this).flexslider2({
						namespace: "underscores_slider-",
						animation: 'slide',
						animationSpeed: 600,
						slideshow: false,
						directionNav: true,
						animationLoop: false,
						controlNav: false,
						sync: '#iguana-deck-slider-nav'
					});
				});
			}
		});


		// ********************************************************
		// Tabs
		// ********************************************************
		$('ul.tabs').each(function(){
			// For each set of tabs, we want to keep track of
			// which tab is active and it's associated content
			var $active, $content, $links = $(this).find('a');

			// If the location.hash matches one of the links, use that as the active tab.
			// If no match is found, use the first link as the initial active tab.
			$active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
			$active.addClass('active');
			$content = $($active.attr('href'));

			// Hide the remaining content
			$links.not($active).each(function () {
				$($(this).attr('href')).hide();
			});

			// Bind the click event handler
			$(this).on('click', 'a', function(e){
				// Make the old tab inactive.
				$active.removeClass('active');
				$content.hide();

				// Update the variables with the new link and content
				$active = $(this);
				$content = $($(this).attr('href'));

				// Make the tab active.
				$active.addClass('active');
				$content.show();

				// Prevent the anchor's default click action
				e.preventDefault();
			});
		});

		$('.rates-content').find('p:empty').remove();
		$('.itineraries-content').find('p:empty').remove();

	}); // $(function
}(jQuery));
