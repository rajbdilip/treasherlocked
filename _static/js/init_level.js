jQuery( document ).ready(function( $ ) {
	var processing = false;
	
	var submitForm = function() {
		if ( processing )
			return;
			
		processing = true;
		
		var formData =  $( '#mini' ).serialize();
		$( '#submit' ).html( '...' );
		
		console.log( formData );

		$.post(
			site_url + 'ajax/post/check_answer.php',
			formData,
			function( response ) {
			
				console.log( response );
				if ( response.success && response.correct && response.finished ) {
					window.location.href = site_url + 'play/';
				} else if ( response.success && response.correct ) {
					$( '#question' ).hide();
					$( '#answer-box' ).hide();
					$( '#wrong-ans' ).hide();
					$( '#correct-ans' ).fadeIn();
					scrollTo( 'level-info' );
				} else if ( response.success && !response.correct ) {
					$( '#question' ).hide();
					$( '#correct-ans' ).hide();
					$( '#wrong-ans' ).fadeIn();
					$( '#submit' ).html( 'Submit' );
					$( '#answer' ).val('');
					scrollTo( 'level-info' );
					processing = false;
				}
			}
		);
	}
	
	var scrollTo = function ( elem ) {
		$('html, body').animate({
			scrollTop: $( '#' + elem ).offset().top - $( '#header' ).height()
		}, 1000);
	}
	
	$( '#submit' ).click( function() { submitForm(); } );
	$( '#mini' ).submit( function(e) { e.preventDefault(); submitForm(); });
	$( '#back' ).click( function() {
		$( '#wrong-ans' ).hide();
		$( '#question' ).fadeIn();
		scrollTo( 'level-info' );
	});
	
});