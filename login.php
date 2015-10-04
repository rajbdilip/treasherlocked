<?php 
	require('config/consts.php'); 
	$page = NON_NAV;
	
	session_start();
	require_once( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
	require_once( DOCUMENT_ROOT . 'config/db.php' );
	
	/* Check if the user is logged in/Login the user if presence cookie is present */
	$loginHelper = new LoginHelper( $db );
	if ( $loginHelper->IsLoggedIn() ) {
		header( 'Location: ' . SITE_URL );
		exit;
	}
	
	// The user is not logged in. But the user will be redirected back to current page once s/he logs in.
	if ( isset( $_GET['continue'] ) )
		$_SESSION['redirect_uri'] = $_GET['continue'];
		
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

	<title>Login to play Treasherlocked 2.0</title>
	
	<meta name="description" content="Treasherlocked 2.0 is the second installment to a three-day online cryptic treasure hunt organized by Microsoft Campus Club of NIT Rourkela. The second installment will be held between 7th November and 9th November, 2014." />
	<meta name="keywords"  content="treasherlocked, innovision 2014, NIT Rourkela, NIT Rourkela treasure hunt, cryptic hunt, online cryptic hunt, treasure hunt" />

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
					<a class="btn btn-block btn-social btn-lg btn-facebook" href="<?php echo SITE_URL; ?>oauth/facebook/">
						<img src="<?php echo SSTATIC; ?>img/icons/facebook.png" /> Login with Facebook
					</a>
					<a class="btn btn-block btn-social btn-lg btn-google-plus" href="<?php echo SITE_URL; ?>oauth/google/">
						<img src="<?php echo SSTATIC; ?>img/icons/google-plus.png" /> Login with Google
					</a>
					<a class="btn btn-block btn-social btn-lg btn-twitter" href="<?php echo SITE_URL; ?>oauth/twitter/">
						<img src="<?php echo SSTATIC; ?>img/icons/twitter.png" /> Login with Twitter
					</a>
					<a class="btn btn-block btn-social btn-lg btn-ts">
						<img src="<?php echo SSTATIC; ?>img/icons/treasherlocked.png" /> Login with Treasherlocked
					</a>
					
					<div class="treasherlocked no-display">
						<h3>Login with Treasherlocked</h3>
						<form id="login">
							<div class="row">
								<input type="text" class="text" id="username" name="username" placeholder="Username or email" />
								<input type="password" class="text" id="passwod" name="password" placeholder="Password" />
							</div>
							<div class="row">	
								<input type="checkbox" class="checkbox" id="remember" name="remember"  /><span>Remember Me</span>
							</div>
							<div class="row">
								<p class="error spaced" id="submit_error">Invalid combination!</p>
								<input type="hidden" name="spoof_proof" value="<?php echo $spoof_proof; ?>" />
								<a class="btn btn-effect btn-block btn-login" id="submit">Login</a>
								<a href="<?php echo SITE_URL; ?>forgot-password/">Forgot your password?</a>
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
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/init.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/init_login.js"></script>
	
	<?php require('includes/html/tracking.php'); ?>
</body>
</html>