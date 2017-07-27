(function($) {

	$(document).ready(function() {

		//*Departure tabs
		$( function() {
		   $( "#tabs" ).tabs();
		 } );

		//*Hide and toggle Terms and Conditions on Departure pages
		var do_departure_toggles = function() {
			// $('.departure-term-condition p').hide();

			$('.departure-term-condition h5').on('click', function(e) {
				console.log(this);

				if( $(this).next().hasClass('tc-open') ) {
					$('.tc-open').removeClass('tc-open').toggle('slow');
				} else {
					$('.tc-open').removeClass('tc-open').toggle('slow');
					$(this).next().toggle('slow').addClass('tc-open');
				}

			});

		}
		do_departure_toggles();

	});

})(jQuery);
