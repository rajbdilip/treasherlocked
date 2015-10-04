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
			site_url + 'ajax/post/mini_check_answer.php',
			formData,
			function( response ) {
			
				console.log( response );
				if ( response.success || response.timeOut ) {
					window.location.reload();
				} else {
					$( '#question' ).hide();
					$( '#wrong-ans' ).fadeIn();
					$( '#submit' ).html( 'Submit' );
					$( '#answer' ).val('');
					processing = false;
				}
			}
		);
	}
	
	$( '#submit' ).click( function() { submitForm(); } );
	$( '#mini' ).submit( function(e) { e.preventDefault(); submitForm(); });
	$( '#back' ).click( function() {
		$( '#wrong-ans' ).hide();
		$( '#question' ).fadeIn();
	});
	
	$( 'disqus' ).niceScroll();
	
});