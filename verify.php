<?php 
	require( 'config/consts.php' );
	require( 'config/db.php' );
	$page = NON_NAV;
	session_start();
	
	if ( isset( $_GET['auth_code'] ) && isset( $_GET['id'] ) ) {
	
		$user_id 	= $db->escape( $_GET['id'] );
		$auth_code 	= $db->escape( $_GET['auth_code'] );
		
		/*	Check if there is a record with such authorization code */
		$db->where( 'id', $user_id )->where( 'auth_code', $auth_code );
		$user =  $db->getOne( 'users', 'email' );
		
		if ( $user ) {
		
			/*	Authorization code is valid. But check if the email has been already associated to some
				account (trial to create multiple accounts) */
			
			$db->where( 'email', $user['email'] )->where( 'verified', '1' );
			$db->getOne( 'users' );
			
			if ( $db->count > 0 ) {
				
				// Email is already associated to another account
				$verified = false;
				
				// Record is no more usable. User will be asked to register using different email
				$db->where( 'id', $user_id );
				$db->delete( 'users' );
				
			} else {
				
				$db->where( 'id', $user_id );
				if ( $db->update( 'users', array( 'verified' => '1', 'auth_code' => '' ) ) ) {
					$verified = true;
			
					/*	Login the user */
					require( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
					$loginHelper = new LoginHelper( $db );
					$loginHelper->Login( $user_id );
				}
			}
		} else {
			/* Spoof request */
			$invalid_request = true;
		}
		
	} else {
		/*	Spoof Request */
		$invalid_request = true;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<link rel="shortcut icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">
	<link rel="icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">

	<title>Email verification complete - Treasherlocked 2.0</title>
	
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
					<div class="treasherlocked">
						<?php if ( isset( $verified ) && $verified ): ?>
						<h3>Email Verification Complete</h3>
						<div class="row">
							<p>You have successfully verified your email. You have been logged in.</p>
						</div>
						<div class="row">
							<a href="http://www.treasherlocked.in" class="btn btn-effect btn-block btn-login">Continue</a>
						</div>
						<?php elseif ( isset( $verified ) && !$verified ): ?>
						<div class="row">
							<p>You cannot use this email address because it is already associated to an account. Please register using different email address.</p>
						</div>
						<?php elseif ( isset( $invalid_request ) ): ?>
						<div class="row">
							<p>Invalid Request!</p>
						</div>
						<?php else: ?>
						<h3>Email Verification Failed</h3>
						<div class="row">
							<p>An unexpected error occured while verifying your email.</p>
						</div>
						<?php endif; ?>
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
	
	<?php require('includes/html/tracking.php'); ?>
</body>
</html>