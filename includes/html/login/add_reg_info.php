<?php 
	/*
		This page serves as a template which asks additional registration information
		from the user to what their Oauth provider has already given. This page is
		included by getHTML() method of `Registrar` class
		
		Assumes `consts.php` (config file) included and session started.
	*/

	$page = NON_NAV;
	
	/*	Prevent form spoofing */
	$spoof_proof = sha1( time() . chr( mt_rand( 97, 122 ) ) );
	$_SESSION['spoof_proof'] = $spoof_proof;
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<link rel="shortcut icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">
	<link rel="icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">

	<title>Just one more step - Treasherlocked 2.0 Registration</title>
	
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
						<h3>Just one more step</h3>
						<form id="reg-complete" method="POST">
							<div class="row">
								<?php if ( isset($_SESSION['gender_received']) && !$_SESSION['gender_received'] ): ?>
								<select id="gender" name="gender" placeholder="Gender">
									<option value="male">Male</option>
									<option value="female">Female</option>
								</select>
								<?php endif; ?>
								
								<input type="text" class="text" id="institute" name="institute" placeholder="Institute (optional)" maxlength="100" />
								<p class="error" id="e_institute"><span>Institute</span> must be at least 10 characters characters long and can only contain alphabets.</p>
								
								<?php if ( isset($_SESSION['location_received']) && !$_SESSION['location_received'] ): ?>
								<input type="text" class="text" id="location" name="location" placeholder="Location (your town/city, country)" />
								<p class="error" id="e_location"><span>Location</span> must be at least 6 characters long and can only contain alphabets and a comma(,).</p>
								<?php endif; ?>
							</div>
							<div class="row">
								<?php if ( isset($_SESSION['email_received']) && !$_SESSION['email_received'] ): ?>
								<input type="text" class="text" id="email" name="email" placeholder="Email" maxlength="255" />
								<p class="error" id="e_email"><span>Email</span> must be in the form <em>someone@somewhere.tld</em>.</p>
								<?php endif; ?>
								
								<input type="text" class="text" id="username" name="username" placeholder="Choose username" maxlength="25" />
								<p class="error" id="e_username"><span>Username</span> must be at least 3 characters long and can only contain alphanumeric characters and one of <span>!@#$%^&amp;*_</span></p>							
							</div>
							<div class="row">
								<input type="hidden" name="spoof_proof" value="<?php echo $spoof_proof; ?>" />
								<p class="error" id="submit_error"></p>
								<a class="btn btn-effect btn-block btn-login" id="submit" href="javascript:void(0);">Confirm and sign up</a>
								<p>By signing up, you agree to the <a href="<?php echo SITE_URL; ?>privacy" target="_blank">privacy policy</a>.</p>
							</div>
						</form>
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
				
				if ( processing )
					return;
					
				processing = true;
				
				
				if ( !validator.validateInstitute( 'institute' )
					|| !validator.validateLocation( 'location' )
					|| !validator.validateEmail( 'email' )
					|| !validator.validateUsername( 'username' )
				) {
					processing = false;
					return;
				}
				
				var formData =  $('#reg-complete').serialize();
				console.log( formData );
				$.get( 
					site_url + 'ajax/get/IsUsernameAvailable.php', 
					{ username : $( '#username' ).val() },
					function( response ) {
						if ( response.available ) {
							
							$( '#submit' ).html( 'Signing you up...' );
						
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