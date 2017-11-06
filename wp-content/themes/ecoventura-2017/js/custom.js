(function($) {

	$(document).ready(function() {

		TenUp.tabs({
			'target': '.tabs',
		});

		//* Homepage Booking

		$('#booking-dropdown-trigger').on('click', function(e) {
			e.preventDefault();
			$('.homepage-booking-form').slideToggle();
		});

		//*Recipe tabs
		var do_recipe_tabs = function() {
			var tabContent = $('.recipe-single');

			$('.recipe-links .recipe-title').on('click', function(e) {
					e.preventDefault();
					var tabClicked = '#' + e.target.dataset.recipeId;
					$(tabContent).hide();
					$(tabClicked).show();
			});
		};

		// do_recipe_tabs();

		//* Our Menu Main Tabs

		var do_menu_main_tabs = function() {
			var tabContent = $('.menu-wrapper');

			$('.menu-tab a').on('click', function(e) {
					e.preventDefault();
					var tabClicked = e.target.attributes.href.nodeValue;

					var assocMenu = tabClicked + ' .menu-days-wrapper ul li:first-child a';

					$('.menu-tab a').css( 'background-color', '#eeeeee' );
					$(e.target).css( 'background-color', '#ffffff');
					$(tabContent).attr('aria-hidden', 'true'); //hide
					$(tabClicked).attr('aria-hidden', 'false'); //show
					$(assocMenu).trigger('click');
			});
		};

		do_menu_main_tabs();

		//* Our Menu Day Tabs

		var do_menu_day_tabs = function() {
			var tabContent = $('.menu-items-wrapper');

			$('.menu-days-wrapper a').on('click', function(e) {
				e.preventDefault();

				var tabClicked = e.target.attributes.href.nodeValue;

				$('.menu-days-wrapper a').css( 'color', 'black' );
				$(e.target).css( 'color', '#CFAA42');
				$(tabContent).hide();
				$(tabClicked).css( 'display', 'flex' );
				$(tabClicked).show();
			});
		};

		do_menu_day_tabs();


		//* Hotel Tabs

		var do_hotel_tabs = function() {

			$('section.hotels li.tab-item a').on('click', function(e) {

					$('section.hotels li.tab-item a').css( 'background-color', '#eeeeee' );
					$(e.target).css( 'background-color', '#ffffff');
			});
		};

		do_hotel_tabs();

		//*Hide and toggle Terms and Conditions on Departure pages
		var do_eco_toggles = function() {

			$('.eco_toggles h5').on('click', function(e) {

				if( $(this).siblings('p').hasClass('tc-open') ) {
					$('.tc-open').removeClass('tc-open').toggle('slow');
				} else {
					$('.tc-open').removeClass('tc-open').toggle('slow');
					$(this).siblings('p').toggle('slow').addClass('tc-open');
				}

			});

		};

		do_eco_toggles();

		//Do Eco Popup
		var doEcoPopUp = function( divID ) {

			var winHeight = window.innerHeight;
			var winWidth = window.innerWidth;
			var scrollY = window.scrollY;
			var popupWidth = winWidth * 0.9;
			var centeredWidth = winWidth / 2 - popupWidth / 2;

			if( winWidth > 1000 ) {
				centeredWidth = winWidth / 2 - 450;
			}

			$('.ui-widget-overlay').show();
			$(divID).show().css({
				'z-index': '1001',
				'width': popupWidth,
				'max-width': '900px',
				'height': 'auto',
				'position': 'absolute',
				'top': scrollY + 100,
				'left': centeredWidth
			}).append('<span class="popup-close-button">&times;</span>');

			$('.popup-close-button, .ui-widget-overlay').on('click', function(e) {
				$(divID).hide();
				$('.ui-widget-overlay').hide();
			});

		};

		// Page PopUps

		$( function() {
			$( ".rates-table .td-rate-decks" ).on( 'click', function(e) {
				var divID = '#' + e.target.id.replace(' ', '-').toLowerCase();

				doEcoPopUp(divID);
			});
			$( ".highlight-box .image-container" ).on( 'click', function(e) {
				var divID = '#' + e.target.dataset.popupId;

				doEcoPopUp(divID);
			});
			$( ".itinerary-box .itinerary-day" ).on( 'click', function(e) {

				var divID = '#' + e.target.dataset.popupId;

				doEcoPopUp(divID);
			});
			$( '.js-departure-date-popup' ).on( 'click', function(e) {
				e.preventDefault();
				var $this = $(this);

				if ( $this.data( 'itinerary' ) ) {
					doEcoPopUp('#itinerary-' + $this.data( 'itinerary' ) + '-popup');
				}
			});
		});

		// ********************************************************
		// Expandable sections
		// ********************************************************
		$('.section-title').on('click', function(evt){
			evt.preventDefault();

			var $this = $(this);
			$this.nextAll('.section-content:first').slideToggle( 'fast', 'swing', function(){
				$this.toggleClass('expanded');
			});
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

	}); //end document.ready

})(jQuery);
