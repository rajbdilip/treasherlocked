<?php 
	require('config/consts.php'); 
	$page = ABOUT;
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

	<link rel="shortcut icon" href="favicon.png" type="image/png">
	<link rel="icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">

	<title>About Treasherlocked 2.0</title>
	
	<meta name="description" content="Treasherlocked 2.0 is the second installment to a three-day online cryptic treasure hunt organized by Microsoft Campus Club of NIT Rourkela. The second installment will be held between 7th November and 9th November, 2014." />
	<meta name="keywords"  content="treasherlocked, innovision 2014, NIT Rourkela, NIT Rourkela treasure hunt, cryptic hunt, online cryptic hunt, treasure hunt" />

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
				<blockquote>You know my method. It is founded upon the observation of trifles.<cite>Sherlock Holmes</cite></blockquote>
				<p>
					Treasherlocked is an online cryptic hunt to be organized by Microsoft Campus Club of National Institute of 
					Techonlogy Rourkela. The competition tests one's power of logic, knowledge and creativity. Most 
					signficantly, <strong>it assesses one's aptitude of making connection between discrete ideas</strong>.
				</p>
				<p>
					The simple idea of a string of clues conducive to their successors leading to the final puzzle is central 
					to the competition, making it sophisticated and enjoyable. The players are usually given textual and/or visual 
					questions in the game. The player cracks the picture/text to get an answer to the question using the 
					Internet and hints, which will take her/him to the next question. The one who solves the last question 
					first wins the game.
				</p>
				<p>
					The competition is open to anybody and everybody i.e. no restrictions on age, gender, concentration or 
					geography have been implied. Participants can freely use the Internet (Google, Bing or any other search 
					engine) or any other source at their disposal to get the right answer.
				</p>
				<p>	
					Apart from offering an exciting experience, an online treasure hunt also provides you with a very 
					good learning opportunity. It enables you to explore new areas of which you might have been unaware. 
					It increases your general awareness in a wide range of randomly selected fields giving you an extra 
					edge in various competitions or events, which require your ability for a comprehensive knowledge. And 
					what’s more? – prizes worth Rs. 30000, goodies and T-shirts awaiting you.
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