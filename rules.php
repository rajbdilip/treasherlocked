<?php 
	require( 'config/consts.php' ); 
	$page = RULES;
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

	<title>Rules and regulations - Treasherlocked 2.0</title>
	
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
				<ul>
					<li>
						The event entails an Online Cryptic Treasure Hunt in which participants make their way through 
						a series of cryptic levels.
					</li>
					<li>
						The event shall be held over 3 days, starting from 7<sup>th</sup> November 2014. Check 
						<a href="https://www.facebook.com/MicrosoftCampusClub">this page</a> for regular updates.
					</li>
					<li>
						Participation is open to everyone. Each participant represents himself/herself only.
					</li>
					<li>
						The participants' aim is to crack the levels as quickly as they can so as to place themselves 
						at the top of the leaderboard. They can make unlimited number of attempts at any level
						until they get the correct answer.
					</li>
					<li>
						At each level, the participants will encounter a number of clues which shall all, together, point 
						to one answer. Each level has one and only one correct answer. The answer will be limited to a word
						or a phrase sometimes.
					</li>
					<li>
						The participants should beware of the spelling they enter, we cannot auto correct your spellings.
					</li>
					<li>
						Sharing of answers with other participants in any form is banned. This also includes providing hints 
						towards the clues/answer. The organizers reserve the right to disqualify or refuse participation to any 
						participant without prior notice.
					</li>
				</ul>
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