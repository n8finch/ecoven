(function($) {

	$(document).ready(function() {

		//*Departure tabs
		var do_departure_tabs = function() {
			var tabContent = $('.departure-table-tab-content');

			$('.departure-table-tabs').on('click', function(e) {
					var tabClicked = $(this).attr('data-tab');
					$(tabContent).hide();
					$(tabClicked).show();
					console.log(tabClicked);
					console.log(tabContent);
			});


		}

		do_departure_tabs();


		//*Hide and toggle Terms and Conditions on Departure pages
		var do_departure_toggles = function() {

			$('.departure-term-condition h5').on('click', function(e) {

				if( $(this).siblings('p').hasClass('tc-open') ) {
					$('.tc-open').removeClass('tc-open').toggle('slow');
				} else {
					$('.tc-open').removeClass('tc-open').toggle('slow');
					$(this).siblings('p').toggle('slow').addClass('tc-open');
				}

			});

		}
		do_departure_toggles();

		var doEcoPopUp = function( divID ) {
			$( divID ).dialog({
				modal: true,
				closeOnEscape: true,
				height: 'auto',
				width: 400,
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
		});


	});

})(jQuery);
