<?php 
	require('config/consts.php'); 
	$page = MINI_SERIES;
	session_start();
	
	require_once( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
	require_once( DOCUMENT_ROOT . 'config/db.php' );
		
	/* Check if the user is logged in/Login the user if presence cookie is present */
	$loginHelper = new LoginHelper($db);
	$loggedIn = $loginHelper->IsLoggedIn();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<link rel="shortcut icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">
	<link rel="icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">

	<title>Treasherlocked 2.x Mini Series</title>
	
	<meta name="description" content="Treasherlocked 2.x is a warm-up to the final event which will have a series of short quizzes commencing 9 days before the final event i.e. 28th October –  Treasherlocked 2.1, 2.2, 2.3, 2.4, 2.5, 2.6, 2.7, 2.8 and 2.9." />
	<meta name="keywords"  content="treasherlocked, treasherlocked 1.x, treasherlocked mini series innovision 2014, NIT Rourkela, NIT Rourkela treasure hunt, cryptic hunt, online cryptic hunt, treasure hunt" />

	<link href="<?php echo SSTATIC; ?>css/bootstrap.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/animate.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/base.css" rel="stylesheet" />
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
				<div class="title">
					<h1>Treasherlocked 2.x Mini series</h1>
					<h2>"Criminal Minds"</h2>
					<h2>October 28 to November 5</h2>
					<h3>Everyday,  2100 to 2359 hours (IST)</h3>
				</div>
				<div class="text-center title">
					<a href="<?php echo SITE_URL; ?>mini/play/"  class="btn-effect wow animated fadeIn animated">Click here to play Treasherlocked 2.x</a>
				</div>
				<p>
					The Treasherlocked Mini Series is a run-up to the final event – that gives you a chance to think, analyze and answer some fun questions. For the first timers who are anticipating the thrill of Treasherlocked 3.0, this is a practice ground which will give you a fair idea of how things will proceed in the main event; and for the seasoned players eagerly awaiting this year’s edition this will merely be a warm-up. So, if you haven’t pulled out your thinking caps yet, you better – cause the hunt is definitely on!
				</p>
				<p>
					This year we’ve decided to combine the magic of celluloid with the thrill of a mystery – <strong>Criminal Minds</strong>. Everyone remembers the heroes in the movies they’ve watched, but what if you had to step over to the dark side? In the course of these 9 questions we’ll bring you some of the most notorious, heinous and dangerous Criminals that you’ve ever seen in movies. You’ve hated them, you’ve been terrified of them, and you’ve hoped you never met them – but do you dare to step into their shoes? We proudly bring to you, the celebrated bad guys, the illustrious scoundrels and the bone-chilling criminals of cinema all in the same game.  Watch out for the cold-blooded murderers, the psychotic serial killers, the infamous mass murders, the defamed outlaws, the revered drug lords, the stealthiest thieves and the wild rebels. Are you ready for the hunt?
				</p>
				<div class="center">
					<div class="highlight inline">
						<p class="text-center">
							As Treasherlocked 3.0 now draws close,<br/>
							And you put your thinking caps back on,<br/>
							You’ve waited long enough we suppose,<br/>
							And the final straws have now been drawn.<br/>
							To keep you busy, till D-day’s here,<br/>
							We have a plan chalked out and ready:<br/>
							For 9 days, 9 questions will serially appear,<br/>
							And we’ll have 9 lucky winners already!<br/>
							Coming to the theme: It’s elementary, cause<br/>
							Mysteries call for detectives of course,<br/>
							But things will get harder, as we pause<br/>
							To trace secret missions back to their source,<br/>
							When you’ll be looking into secret spies,<br/>
							The armed forces and the navy seal-<br/>
							Disregarding your novice attempts and tries,<br/>
							We promise you every minute worth the thrill and feel!
						</p>
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