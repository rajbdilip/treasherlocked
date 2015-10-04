jQuery( document ).ready(function( $ ) {
	$( '.btn-ts' ).click( function() {
		$( '.btn-ts' ).slideUp();
		$( '.treasherlocked' ).show();
	});
	
	var validator = new Validator();
			
	$( '#name' ).blur( function() { validator.validateName( 'name' ); });
	$( '#institute' ).blur( function() { validator.validateInstitute( 'institute' ); });
	$( '#location' ).blur( function() { validator.validateLocation( 'location' ); });
	$( '#email' ).blur( function() { validator.validateEmail( 'email' ); });
	$( '#username' ).blur( function() { validator.validateUsername( 'username' ); });
	$( '#password' ).blur( function() { validator.validatePassword( 'password', 'password2' ); });
	$( '#password2' ).blur( function() { validator.validatePassword( 'password', 'password2' ); });
	
	$( '#submit' ).blur( function() { $( '#submit_error' ).fadeOut(); });
	
	var processing = false;
	
	$( '#submit' ).click( function() {
		
		if ( processing )
			return;
			
		processing = true;
		
		if ( !validator.validateName( 'name' )
			|| !validator.validateInstitute( 'institute' )
			|| !validator.validateLocation( 'location' )
			|| !validator.validateEmail( 'email' )
			|| !validator.validateUsername( 'username' )
			|| !validator.validatePassword( 'password', 'password2' )
		) {
			processing = false;
			return;
		}
		
		var formData =  $('#signup-form').serialize();
		
		$( '#submit' ).html( 'Signing you up...' );
		
		console.log( formData );
		$.post(
			site_url + 'ajax/post/signup_default.php',
			formData,
			function( response ) {
			
				console.log( response );
				if ( response.success ) {
					$( '.btn-social' ).slideUp("fast");
					$( '.treasherlocked' ).html( '<p class="email">A verification link has been to sent to your email. Please open the link to complete the registration.</p>' );
					processing = false;
				} else {
					$( '#submit_error' ).html( response.error );
					$( '#submit_error' ).fadeIn();
					$( '#submit' ).html( 'Sign Up' );
					processing = false;
				}
				
			}
		);
	});
});