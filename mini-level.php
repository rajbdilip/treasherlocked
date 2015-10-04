<?php 
	require( 'config/consts.php' );
	session_start();
	
	require_once( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
	require_once( DOCUMENT_ROOT . 'config/db.php' );
	require( DOCUMENT_ROOT . 'classes/Mini.php' );
		
	/* Check if the user is logged in */
	$loginHelper = new LoginHelper($db);
	if ( !$loginHelper->IsLoggedIn() ) {
		header( 'Location: ' . SITE_URL . 'login/' );
		exit;
	}
	
	$mini = new Mini( $db );		// Mini is the boss
	$todaysLevel = $mini->getTodaysLevel();

	if ( isset( $_GET['level'] ) && is_numeric( $_GET['level'] ) && $_GET['level'] == $todaysLevel ) {
		
		if ( $todaysLevel > 9 ) {
			require( DOCUMENT_ROOT . 'includes/html/event/mini_ended.php' );
			exit;
		} elseif ( $todaysLevel == 0 ) {
			require( DOCUMENT_ROOT . 'includes/html/event/mini_not_started.php' );
			exit;
		} elseif ( !$mini->isLevelAvailable( $todaysLevel ) ) {
			require( DOCUMENT_ROOT . 'includes/html/event/mini_started.php' );
			exit;
		}
		
		if ( $mini->isAnswered() ) {
			require( DOCUMENT_ROOT . 'includes/html/event/mini_answered.php' );
			exit;
		}
		
		$question = $mini->getQuestion( $todaysLevel );
		$page = MINI_SERIES;
		
		/*	Prevent form spoofing */
		$spoof_proof = sha1( time() . chr( mt_rand( 97, 122 ) ) );
		$_SESSION['spoof_proof'] = $spoof_proof;
	} else {
		header( 'Location: ' . SITE_URL . 'mini/1.' . $todaysLevel .'/' );
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

	<title>Treasherlocked 1.<?php echo $todaysLevel; ?> - Pre-Treasherlocked 2.0</title>

	<link href="<?php echo SSTATIC; ?>css/bootstrap.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/animate.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/base.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/game.css" rel="stylesheet" />
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
				<div class="row box no-padding">
					<h1>Treasherlocked 1.6</h1>
				</div>
				<div class="space space-20"></div>
				<div class="row box question-box" id="question-box">
					<div class="row" id="question">
						<?php echo $question; ?>
						<!-- http://static.treasherlocked.com/img/questions/mini/text.txt -->
						<img src="http://static.treasherlocked.com/img/questions/mini/economics.jpg" />
					</div>
					<div class="row" id="result wrong-ans">
						<h1>Oops!</h1>
						<h3>We gotta tell you, that's not correct!</h3>
						<a class="btn btn-effect" id="back" href="javascript:void(0);">Back to question</a>
					</div>
				</div>
				<div class="space space-20"></div>
				<div class="row box answer-box">
					<div class="row">
						<form id="mini">
							<input type="hidden" name="spoof_proof" value="<?php echo $spoof_proof; ?>" />
							<input type="hidden" name="level" value="<?php echo $todaysLevel; ?>" />
							<input type="text" class="text" id="answer" name="answer" placeholder="Answer" maxlength="254" />
							<a class="btn btn-effect inline-block" id="submit" href="javascript:void(0);">Submit</a>
						</form>
					</div>
				</div>
				<div class="space space-20"></div>
				<!--<div class="row box disqus" id="disqus">
				    <div id="disqus_thread"></div>
					<script type="text/javascript">
						var disqus_shortname = 'treasherlocked2-0';

						(function() {
							var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
							dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
							(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
						})();
					</script>
					<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
				</div>-->
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
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/init_mini_level.js"></script>
	<?php require('includes/html/tracking.php'); ?>
</body>
</html>