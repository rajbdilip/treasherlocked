<?php 
	require('config/consts.php' ); 
	
	$page = HOME;
	session_start();
	
	require_once( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
	require_once( DOCUMENT_ROOT . 'config/db.php' );
		
	/* Check if the user is logged in/Login the user if presence cookie is present */
	$loginHelper = new LoginHelper($db);
	$loggedIn = $loginHelper->IsLoggedIn();
		
	/*	Get the event status	*/
	require( 'classes/Event.php' );
	$event = new Event();
	$event_status = $event->get_event_status();
	
	/*	Countdown to be sent to the client	*/
	if ( $event_status == EVENT_NOT_STARTED )
		$countdown = EVENT_START - time();
	elseif ( $event_status == EVENT_STARTED )
		$countdown = EVENT_END - time();
	else
		$countdown = null;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<link rel="shortcut icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">
	<link rel="icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">

	<title>Treasherlocked 2.0 by Microsoft Campus Club, NIT Rourkela</title>
	
	<meta name="description" content="Treasherlocked 2.0 is the second installment to a three-day online cryptic treasure hunt organized by Microsoft Campus Club of NIT Rourkela. The second installment will be held between 7th November and 9th November, 2014." />
	<meta name="keywords"  content="treasherlocked, innovision 2014, NIT Rourkela, NIT Rourkela treasure hunt, cryptic hunt, online cryptic hunt, treasure hunt" />

	<link href="<?php echo SSTATIC; ?>css/bootstrap.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/animate.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/base.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/home.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/queries.css" rel="stylesheet" />
  
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>	   
<body id="top">
 
	<?php require( 'includes/html/header.php' ); ?>
		
	<section id="home" class="autoheight">
		<div class="home-bg"></div>
		<div class="col-lg-12 landing-text-pos align-center">
			<img id="logo" class="wow animated fadeInDown" data-wow-duration="1s" data-wow-delay="1s" src="<?php echo SSTATIC; ?>img/logo.png" />
			<h2 class="wow animated fadeInDown" data-wow-duration="1s" data-wow-delay="1s">because the hunt is on</h2>
			<hr id="title_hr" />
			<p class="wow animated fadeInUp" data-wow-duration="1s" data-wow-delay="1s">7-9 November 2014</p>
			<a class="btn-effect wow animated fadeIn" data-wow-duration="0.5s" data-wow-delay="1.5s" data-scroll href="<?php echo SITE_URL . 'play/'; ?>">Play Now</a>
		</div>
	</section>
	
	<?php /* COUNTDOWN--- */ ?>
	<section id="countdown" class="text-center section-padding">
		<div class="container">
			<div class="row">
				<input type="hidden" id="serve_time" name="serve_time" value="<?php echo $countdown; ?>" />
				<?php
				switch ($event_status) {
					case EVENT_NOT_STARTED:	{ require( 'includes/html/event/not_started.php' ); break; }
					case EVENT_STARTED:		{ require( 'includes/html/event/running.php' ); break; }
					case EVENT_CLOSED:		{ require( 'includes/html/event/closed.php' ); break; }
				}
				?>
			</div>
		</div>
	</section>
	<?php /* ---COUNTDOWN */ ?>
	
	<?php /* SPONSORS--- */ ?>	
	<section id="sponsors" class="text-center section-padding">
		<div class="container">
			<div class="sponsor">
				<a href="http://www.10kya.com" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/10kya.png" /></a>
				<span>Sponsor</span>
			</div>
			<div class="sponsor">
				<a href="http://www.punambookstore.com" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/punam.png" /></a>
				<span>Co-sponsor</span>
			</div>
			<div class="sponsor">
				<a href="http://scholarscharm.com/" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/scholarscharm.png" /></a>
				<span>Powered by</span>
			</div>
			<div class="sponsor">
				<a href="http://innovision.nitrkl.ac.in" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/innovision.png" /></a>
				<span>Event Partner</span>
			</div>
			<div class="sponsor">
				<a href="http://www.hackerrank.com" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/hackerrank.png" /></a>
				<span>Student Partner</span>
			</div>			
			<div class="sponsor">
				<a href="http://www.newindianexpress.com/" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/indianexpress.png" /></a>
				<span>Media Partner</span>
			</div>
			<div class="sponsor">
				<a href="http://mondaymorning.nitrkl.ac.in" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/mondaymorning.png" /></a>
				<span>Campus Media Partner</span>
			</div>
			<div class="space space-40"></div>
			<div class="row">
				<a href="http://www.microsofcampusclub.in" target="_blank"><img src="<?php echo SSTATIC; ?>img/msclublogo.png" /></a>
				<p>a <a href="http://www.microsofcampusclub.in">Microsoft Campus Club</a> event</p>
			</div>
		</div>
	</section>
	<?php /* ---SPONSORS */ ?>

	<?php /* FOOTER--- */ ?>	
	<?php require('includes/html/footer.php'); ?>
	<?php /* ---FOOTER */ ?>

	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/jquery-ui-1.10.4.min.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/bootstrap.min.js" ></script>

	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/smooth-scroll.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/jquery.nicescroll.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/wow.min.js"></script>
	
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/init.js"></script>
	
	<?php if ( $event_status == EVENT_NOT_STARTED || $event_status == EVENT_STARTED ): ?>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/countdown.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/init_countdown.js"></script>
	<?php endif; ?>
	
	<?php require( 'includes/html/tracking.php' ); ?>
</body>
</html>