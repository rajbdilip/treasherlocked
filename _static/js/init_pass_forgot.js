jQuery( document ).ready(function( $ ) {

	var processing = false;
	
	var submitForm = function() {
		if ( processing || $('#email').val().length == 0 )
			return;
			
		processing = true;
		
		var formData =  $('#reset').serialize();
		
		$( '#submit_error' ).fadeOut();
		$( '#submit' ).html( 'Working...' );
		
		console.log( formData );
		$.post(
			site_url + 'ajax/post/reset_password.php',
			formData,
			function( response ) {
			
				console.log( response );
				if ( response.success ) {
					$( '.treasherlocked' ).html( '<p class="email">Instructions on how to reset your password have been sent to your email. Please find the email in your inbox/spam/junk folder and follow the instructions.</p>' );
					processing = false;
				} else {
					$( '#submit_error' ).html( response.error );
					$( '#submit_error' ).fadeIn();
					$( '#submit' ).html( 'Reset Password' );
					processing = false;
				}
				
			}
		);
	}
	
	$( '#submit' ).click( function() { submitForm(); } );
	$( '#reset' ).submit( function(e) { e.preventDefault(); submitForm(); });
});