<?php 
	require('../config/consts.php'); 
	$page = NON_NAV;
	
	session_start();
	
	if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !isset( $_SESSION['admin_logged_in'] ) ) {
		
		if ( $_POST['password'] == 'neverbackdown!@#' )
			$_SESSION['admin_logged_in'] = true;
	}
	
	if ( isset( $_GET['logout'] ) ) {
		unset( $_SESSION['admin_logged_in'] );
		header( 'Location: admin/' );
		exit;
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<link rel="shortcut icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">
	<link rel="icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">

	<title>Admin Login</title>
	
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

	<?php require( DOCUMENT_ROOT . 'includes/html/header.php' ); ?>
	
	<section class="page section-padding">
		<div class="container">
			<div class="row">
				<div class="social">
					<div class="treasherlocked">
						<?php if ( !isset( $_SESSION['admin_logged_in'] ) ): ?>
						<h3>Login as Admin</h3>
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="login">
							<div class="row">
								<input type="password" class="text" name="password" placeholder="Password" />
							</div>
							<div class="row">
								<a class="btn btn-effect btn-block btn-login" id="submit">Login</a>
							</div>
						</form>
						<?php else: ?>
						<p>
							<ul>
								<li><a href="<?php echo SITE_URL; ?>admin/users.php" target="_blank">Registrations</a></li>
								<li><a href="<?php echo SITE_URL; ?>admin/info.php" target="_blank">User Information</a></li>
								<li><a href="<?php echo SITE_URL; ?>admin/level_stat.php" target="_blank">Level Stats</a></li>
							</ul>
						</p>
						<a href="<?php echo $_SERVER['PHP_SELF']; ?>?logout">Log Out</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
		
	<!--FOOTER-->	
	<?php require( DOCUMENT_ROOT . 'includes/html/footer.php' ); ?>
	<!-- /FOOTER -->
		
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/jquery-ui-1.10.4.min.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/smooth-scroll.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/jquery.nicescroll.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/wow.min.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/init.js"></script>
	<script type="text/javascript">
		jQuery( document ).ready(function( $ ) {
			$( '#submit' ).click( function() { $( '#login' ).submit(); });
		});
	</script>
	
	<?php require( DOCUMENT_ROOT . 'includes/html/tracking.php' ); ?>
</body>
</html>