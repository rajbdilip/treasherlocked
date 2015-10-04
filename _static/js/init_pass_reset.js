jQuery( document ).ready(function( $ ) {

	var processing = false;
	var validator = new Validator();
	
	var submitForm = function() {
		if ( processing || !validator.validatePassword( 'new_password', 'new_password2' ) )
			return;
			
		processing = true;
		
		// Check if passwords match
		if ( $( '#new_password' ).val() != $( '#new_password2' ).val() ) {
			$( '#submit-error' ).html( 'Passwords don\'t match.' );
			$( '#submit-error' ).fadeIn();
			return;
		} else {
			$( '#submit-error' ).fadeOut();
		}
			
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
					$( '.treasherlocked' ).html( '<p class="email">Your password has been successfully reset. You have been logged in.</p><div class="row"><a class="btn btn-effect btn-block" href="' + site_url + '">Continue</a></div>' );
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