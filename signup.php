<?php 
	require('config/consts.php'); 
	$page = NON_NAV;
	session_start();
	
	require_once( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
	require_once( DOCUMENT_ROOT . 'config/db.php' );
	
	$loginHelper = new LoginHelper( $db );
	if ( $loginHelper->IsLoggedIn() ) {
		header( 'Location: ' . SITE_URL );
		exit;
	}
	
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

	<title>Sign up for Treasherlocked 2.0</title>
	
	<meta name="description" content="Sign up for Treasherlocked 2.0. Register and become a detective because the hunt is on." />
	<meta name="keywords"  content="treasherlocked register, treasherlocked registration, treasherlocked sign up, how to register for treasherlocked" />

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

	<?php require( 'includes/html/header.php' ); ?>
	
	<section class="page section-padding">
		<div class="container">
			<div class="row">
				<div class="social">
					<a class="btn btn-block btn-social btn-lg btn-facebook" href="<?php echo SITE_URL; ?>oauth/facebook">
						<img src="<?php echo SSTATIC; ?>img/icons/facebook.png" /> Sign up using Facebook
					</a>
					<a class="btn btn-block btn-social btn-lg btn-google-plus" href="<?php echo SITE_URL; ?>oauth/google/">
						<img src="<?php echo SSTATIC; ?>img/icons/google-plus.png" /> Sign up using Google
					</a>
					<a class="btn btn-block btn-social btn-lg btn-twitter" href="<?php echo SITE_URL; ?>oauth/twitter/">
						<img src="<?php echo SSTATIC; ?>img/icons/twitter.png" /> Sign up using Twitter
					</a>
					<a class="btn btn-block btn-social btn-lg btn-ts">
						<img src="<?php echo SSTATIC; ?>img/icons/treasherlocked.png" /> Sign up using Treasherlocked
					</a>
					
					<div class="treasherlocked no-display">
						<h3>Sign up using Treasherlocked</h3>
						<form id="signup-form" method="post" action="login/">
							<div class="row">
								<input type="text" class="text" id="name" name="name" placeholder="Name" maxlength="100" />
								<p class="error" id="e_name"><span>Name</span> must be at least 4 characters long and can only contain alphabets.</p>
								
								<select id="gender" name="gender" placeholder="Gender">
									<option value="male">Male</option>
									<option value="female">Female</option>
								</select>
								
								<input type="text" class="text" id="institute" name="institute" placeholder="Institute/College" maxlength="100" />
								<p class="error" id="e_institute"><span>Institute</span> must be at least 10 characters characters long and can only contain alphabets.</p>
								
								<input type="text" class="text" id="location" name="location" placeholder="Location (your town/city, country)" maxlength="100" />
								<p class="error" id="e_location"><span>Location</span> must be at least 6 characters long and can only contain alphabets and a comma(,).</p>
							</div>
							<div class="row">
								<input type="text" class="text" id="email" name="email" placeholder="Email" maxlength="255" />
								<p class="error" id="e_email"><span>Email</span> must be in the form <em>someone@somewhere.tld</em>.</p>
								
								<input type="text" class="text" id="username" name="username" placeholder="Choose username" maxlength="25" />
								<p class="error" id="e_username"><span>Username</span> must be at least 3 characters long and can only contain alphanumeric characters and one of <span>!@#$%^&amp;*_</span></p>							
								
								<input type="password" class="text" id="password" name="password" placeholder="Password" maxlength="100" />
								<p class="error" id="e_password"><span>Password</span> must be 6 to 30 characters long.</p>
								
								<input type="password" class="text" id="password2" name="password2" placeholder="Confirm password" maxlength="100" />
								<p class="error" id="e_password2">Passwords do not match.</p>
							</div>
							<div class="row">
								<p class="error spaced" id="submit_error"></p>
								<input type="hidden" name="spoof_proof" value="<?php echo $spoof_proof; ?>" />
								<a class="btn btn-effect btn-block btn-login" id="submit" href="javascript:void(0);">Sign up</a>
								<p>By signing up, you agree to the <a href="<?php echo SITE_URL; ?>privacy" target="_blank">privacy policy</a>.</p>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
		
	<!--FOOTER-->	
	<?php require('includes/html/footer.php'); ?>
	<!-- /FOOTER -->
		
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/jquery-ui-1.10.4.min.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/smooth-scroll.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/jquery.nicescroll.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/wow.min.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/validator.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/init.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/init_signup.js"></script>
	
	<?php require('includes/html/tracking.php'); ?>
</body>
</html>