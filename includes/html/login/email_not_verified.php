<?php 
	/*
		
		
		Assumes `consts.php` (config file) included and session started.
	*/

	$page = NON_NAV;
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<link rel="shortcut icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">
	<link rel="icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">

	<title>Email verification pending - Treasherlocked 2.0</title>
	
	<link href="<?php echo SSTATIC; ?>css/bootstrap.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/animate.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/base.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/social.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/queries.css" rel="stylesheet" />
  
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>	   
<body id="top">

	<?php require( DOCUMENT_ROOT . 'includes/html/header.php' ); ?>
	
	<section class="page section-padding">
		<div class="container">
			<div class="row">
				<div class="social">
					<div class="treasherlocked">
						<p>Your email has not been verified yet. Please check your email inbox and open the link provided to verify your email and complete the registration.</p>
						<?php // TBD: Allow user to have the link resent. ?>
					</div>
				</div>
			</div>
		</div>
	</section>
		
	<?php require( DOCUMENT_ROOT . 'includes/html/footer.php' ); ?>
		
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/jquery-ui-1.10.4.min.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/smooth-scroll.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/jquery.nicescroll.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/wow.min.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/validator.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/init.js"></script>
	
	<script type="text/javascript">
		$(function( $ ) {
			validator = new Validator();
			
			$( '#institute' ).blur( function() { validator.validateInstitute( 'institute' ); });
			$( '#username' ).blur( function() { validator.validateUsername( 'username' ); });
			
			<?php if ( isset($_SESSION['location_received']) && !$_SESSION['location_received'] ): ?>
			$( '#location' ).blur( function() { validator.validateLocation( 'location' ); });
			<?php endif; ?>
			
			<?php if ( isset($_SESSION['email_received']) && !$_SESSION['email_received'] ): ?>
			$( '#email' ).blur( function() { validator.validateEmail( 'email' ); });
			<?php endif; ?>
			
			$( '#submit' ).blur( function() { $( '#submit_error' ).fadeOut(); });
			
			var processing = false;
			
			$( '#submit' ).click( function() {
				
				//if ( processing )
					//return;
					
				processing = true;
				
				$( '#submit' ).html( 'Signing you up...' );
				
				if ( !validator.validateInstitute( 'institute' )
					|| !validator.validateLocation( 'location' )
					|| !validator.validateEmail( 'email' )
					|| !validator.validateUsername( 'username' )
				) {
					return;
				}
				
				var formData =  $('#reg-complete').serialize();
				console.log( formData );
				$.get( 
					site_url + 'ajax/get/IsUsernameAvailable.php', 
					{ username : $( '#username' ).val() },
					function( response ) {
						if ( response.available ) {
							$.post(
								site_url + 'ajax/post/signup.php',
								formData,
								function( response2 ) {
									console.log( response2 );
									if ( response2.hasOwnProperty('verify') ) {
										$( '.treasherlocked' ).html( '<p class="email">A verification link has been to sent to your email. Please open the link to complete the registration.</p>' );
									} else if ( response2.success ) {
										$( '#submit_error' ).fadeOut();
										window.location.href = response2.redirect_uri;
									} else {
										$( '#submit_error' ).html( response2.error );
										$( '#submit_error' ).fadeIn();
									}
								}
							);
						} else {
							$( '#e_username' ).html( '<span>Username</span> is not available.' );
							$( '#e_username' ).fadeIn();
							
							$( '#submit' ).html( 'Confirm and sign up' );
							processing = false;
						}
					}
				);
			});
		});
	</script>
	
	<?php require( DOCUMENT_ROOT . 'includes/html/tracking.php' ); ?>
</body>
</html>