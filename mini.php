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

	<title>Treasherlocked 1.x Mini Series</title>
	
	<meta name="description" content="Treasherlocked 1.x is a warm-up to the final event which will have a series of short quizzes commencing 9 days before the final event i.e. 29th October –  Treasherlocked 1.1, 1.2, 1.3, 1.4, 1.5, 1.6, 1.7, 1.8 and 1.9." />
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
					<h1>Treasherlocked 1.x</h1>
					<h2>October 29<sup>th</sup> to November 6<sup>th</sup></h2>
					<h3>Everyday,  2100 to 2359 hours (IST)</h3>
				</div>
				<div class="center">
				<div class="highlight inline">
					<p class="text-center">
						As Treasherlocked 2.0 now draws close,<br/>
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
				<p>
					Treasherlocked 2.0 is going to be more demanding, more thrilling and more exhilarating than its predecessor. 
					This time we’re back with questions that are not only going to make you think, but questions that will force 
					you to logically reconstruct ideas and premises, before you can unlock each round. Therefore, as a warm-up to 
					the final event there will be a series of short quizzes commencing 9 days before the final event i.e. 29<sup>th</sup> October – 
					Treasherlocked 1.1, 1.2, 1.3, 1.4, 1.5, 1.6, 1.7, 1.8 and 1.9.
				</p>
				<p>
					The questions of these warm-up rounds will basically be limited to two broad categories – 
					detectives and organizations. The first is exactly what the name suggests: we’re going to look into your 
					<strong>deductive quotient</strong> by testing your knowledge on the stalwarts of the trade, on the godfathers 
					who provide inspiration for this event and those mysterious people who have worked in mysterious ways to 
					unravel some of the most perplexing events in history! The second case is slightly more challenging, 
					as we thrust you into a more real-world scenario of the navy seal, the military, the air-force or the 
					intricate spy networks. Be it the covert missions being carried out to success in perfect silence, or 
					the ones that were marred before execution, this subject provides great depth and insight! 
				</p>
				<p>
					So, we urge you to put on your thinking caps, while you wait with Treasherlocked 2.0 and activate those 
					grey cells for the final event!
				</p>
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