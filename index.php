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

	<title>Treasherlocked 3.0 by Microsoft Campus Club, NIT Rourkela - Treasure is locked, yet again!</title>
	
	<meta name="description" content="Treasherlocked 3.0 is the third installment to a three-day online cryptic treasure hunt organized by Microsoft Campus Club of NIT Rourkela. It will be held between 6th November and 8th November, 2015." />
	<meta name="keywords"  content="treasherlocked, treasure locked, treasure sherlocked, sherlock, treasherlocked 3.0, innovision 2015, NIT Rourkela, NIT Rourkela treasure hunt, cryptic hunt, online cryptic hunt, treasure hunt" />

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
			<p class="wow animated fadeInUp" data-wow-duration="1s" data-wow-delay="1s">6-8 November 2015</p>
			<!--<?php if($loggedIn && $event_status==EVENT_STARTED){?>
			<a class="btn-effect wow animated fadeIn" data-wow-duration="0.5s" data-wow-delay="1.5s" data-scroll href="<?php echo SITE_URL . 'play/'; ?>">Play Now</a>
			<?php } ?>-->
			<?php if($loggedIn /*&& $event_status==EVENT_NOT_STARTED*/){?>
			<a class="btn-effect wow animated fadeIn" data-wow-duration="0.5s" data-wow-delay="1.5s" data-scroll href="<?php echo SITE_URL . 'about/'; ?>">Learn More</a>
			<?php }?>
			<?php if(!$loggedIn){?>
			<a class="btn-effect wow animated fadeIn" data-wow-duration="0.5s" data-wow-delay="1.5s" data-scroll href="<?php echo SITE_URL . 'signup/'; ?>">Register Now</a>
			<?php }?>
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
				<img src="<?php echo SSTATIC; ?>img/sponsors/standard.png" />
				<span class="sponsor-font">Sponsor</span>
			</div>
			<div class="sponsor">
				<a href="http://www.facebook.com/javatechnocrat/" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/jt.png" /></a>
				<span class="sponsor-font">Co Sponsor</span>
			</div>
			<div class="sponsor">
				<a href="http://punambookstore.com" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/punam.png" /></a>
				<span class="sponsor-font">Co Sponsor</span>
			</div>
			<div class="sponsor">
				<a href="http://www.newindianexpress.com" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/indianexpress.png" /></a>
				<span class="sponsor-font">Media Partner</span>
			</div>
			<div class="sponsor">
				<a href="http://innovision.nitrkl.ac.in" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/innovision.png" /></a>
				<span class="sponsor-font">Event Partner</span>
			</div>
			<div class="sponsor">
				<a href="http://dare2compete.com" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/d2c.png" /></a>
				<span class="sponsor-font">Competition Partner</span>
			</div><br />
			<div class="sponsor">
				<a href="http://www.hackerrank.com" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/hackerrank.png" /></a>
				<span class="sponsor-font">Student Partner</span>
			</div>
			<div class="sponsor">
				<a href="https://www.facebook.com/ptbn.inter.college.network/?fref=ts" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/ptbn.png" /></a>
				<span class="sponsor-font">Publicity Partner</span>
			</div>
			<div class="sponsor">
				<a href="https://www.facebook.com/M.n.internationale/?fref=ts" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/mn.png" /></a>
				<span class="sponsor-font">Recreation Partner</span>
			</div>
			<div class="sponsor">
				<a href="http://mondaymorning.nitrkl.ac.in" target="_blank"><img src="<?php echo SSTATIC; ?>img/sponsors/mm.png" /></a>
				<span class="sponsor-font">Media Partner</span>
			</div>		
			<div class="space space-40"></div>
			<div class="row">
				<a href="http://www.microsoftcampusclub.in" target="_blank"><img src="<?php echo SSTATIC; ?>img/msclublogo.png" /></a>
				<p>a <a href="http://www.microsoftcampusclub.in">Microsoft Campus Club</a> event</p>
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