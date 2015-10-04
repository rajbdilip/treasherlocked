<?php 
	require( 'config/consts.php' );
	session_start();
	
	require_once( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
	require_once( DOCUMENT_ROOT . 'config/db.php' );
	require( DOCUMENT_ROOT . 'classes/Treasherlocked.php' );
		
	/* Check if the user is logged in */
	$loginHelper = new LoginHelper( $db );
	if ( !$loginHelper->IsLoggedIn() ) {
		$continue = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		header( "Location: " . SITE_URL . "login/?continue=$continue" );
		exit;
	}
	
	// Check if the event has started
	$ts = new Treasherlocked( $db );		// Treasherlocked is the boss
	if ( $ts->getEventStatus() == EVENT_NOT_STARTED ) {
		header( 'Location: ' . SITE_URL );
		exit;
	}
	
	/*	Begin Page Rendering */
	$page = LEADERBOARD;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<link rel="shortcut icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">
	<link rel="icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">

	<title>Leaderboard - Treasherlocked 2.0 Gameplay</title>

	<link href="<?php echo SSTATIC; ?>css/bootstrap.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/animate.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/base.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/game.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/table.css" rel="stylesheet" />
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
				<div class="box leaderboard rank no-padding">
					<h3>Your Rank: #<span id="user-rank"><?php echo $ts->getUserRank(); ?></span></h3>
				</div>
				<div class="space space-20"></div>
				<div class="box leaderboard">
					<a href="javascript:void(0);" id="refresh">Refresh</a>
					<div class="space space-30"></div>
					<div class="row">
						<table>
							<thead>
								<tr>
									<th>Rank #</th>
									<th>Username</th>
									<th>Level</th>
								</tr>
							</thead>
							<tbody id="ranking"></tbody>
						</table>
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
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/init_leaderboard.js"></script>
	<?php require('includes/html/tracking.php'); ?>
</body>
</html>