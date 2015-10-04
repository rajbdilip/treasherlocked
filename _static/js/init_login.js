jQuery( document ).ready(function( $ ) {
	$( '.btn-ts' ).click( function() {
		$( '.btn-ts' ).slideUp();
		$( '.treasherlocked' ).show();
	});
	
	var processing = false;
	
	$( '#submit' ).click( function() {
			
		if ( processing )
			return;
			
		processing = true;
		
		var formData =  $('#login').serialize();
		
		$( '#submit_error' ).fadeOut();
		$( '#submit' ).html( 'Logging you in...' );
		
		console.log( formData );

		$.post(
			site_url + 'ajax/post/login_default.php',
			formData,
			function( response ) {
			
				console.log( response );
				if ( response.success ) {
					console.log( response );
					window.location.href = response.redirect_uri;
				} else {
					$( '#submit_error' ).html( response.error );
					$( '#submit_error' ).fadeIn();
					$( '#submit' ).html( 'Log In' );
					processing = false;
				}
				
			}
		);
	});

});