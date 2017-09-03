(function($) {

	$(document).ready(function() {

		//*Recipe tabs
		var do_recipe_tabs = function() {
			var tabContent = $('.recipe-single');

			$('.recipe-links .recipe-title').on('click', function(e) {
					var tabClicked = '#' + e.target.dataset.recipeId;
					$(tabContent).hide();
					$(tabClicked).show();
			});
		}

		do_recipe_tabs();

		//* Our Menu Main Tabs

		var do_menu_main_tabs = function() {
			var tabContent = $('.menu-wrapper');

			$('.menu-tab').on('click', function(e) {
					console.log(e);
					var tabClicked = '#' + e.target.dataset.menuTabId;

					var assocMenu = tabClicked + ' .menu-days-wrapper span:first-child';

					console.log(assocMenu);

					$('.menu-tab').css( 'background-color', '#eeeeee' );
					$(e.target).css( 'background-color', '#ffffff')
					$(tabContent).hide();
					$(tabClicked).show();
					$(assocMenu).trigger('click');
			});
		}

		do_menu_main_tabs();

		//* Our Menu Day Tabs

		var do_menu_day_tabs = function() {
			var tabContent = $('.menu-items-wrapper');

			$('.menu-days-wrapper span').on('click', function(e) {
					var tabClicked = '#' + e.target.dataset.menuDayId;
					$('.menu-days-wrapper span').css( 'color', 'black' );
					$(e.target).css( 'color', '#CFAA42')
					$(tabContent).hide();
					$(tabClicked).css( 'display', 'flex' );
					$(tabClicked).show();
			});
		}

		do_menu_day_tabs();


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

		}

		do_eco_toggles();


		//Do Eco Popup

		var doEcoPopUp = function( divID ) {
			console.log(divID);

			var width = 550;
			var height = 'auto';

			if( '#itin-agenda-popup' == divID || '#view-dates-popup' ==divID ) {
				width = 900;
				height = 500;
			}


			$( divID ).dialog({
				modal: true,
				closeOnEscape: true,
				height: height,
				width: width,
			});
		}

		// Rates Page PopUp

		$( function() {
			$( ".td-rate-decks" ).on( 'click', function(e) {
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
			$( ".itinerary-expedition .book-now-box" ).on( 'click', function(e) {
				console.log(e);
				var divID = '#' + e.target.dataset.popupId;

				doEcoPopUp(divID);
			});
		});


	});

})(jQuery);
