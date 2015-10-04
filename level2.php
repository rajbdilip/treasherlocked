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
	
	$curLevel = $ts->getCurrentLevel();		// Current levels of the user
	
	if ( isset( $_GET['level'] ) 
		&& is_numeric( $_GET['level'] ) 
		&& $_GET['level'] <= $curLevel
	) {
		$reqLevel = $db->escape( $_GET['level'] );			// Requested level

		if ( $reqLevel == 0 && $curLevel == 0 ) {
			// Only Faceook users will be forced to like pages
			if ( $_SESSION['oauth_type'] == OAUTH_FACEBOOK ) {
				require( DOCUMENT_ROOT . 'includes/html/event/facebook_likes.php' );
				exit;
			} else {
				$ts->upgradeLevel( 1 );
				header( 'Location: ' . SITE_URL . 'level2/' . $curLevel . '/' );
				exit;
			}
		} elseif ( $reqLevel == 0 && $curLevel != 0) {
			header( 'Location: ' . SITE_URL . 'level2/' . $curLevel . '/' );
			exit;
		}
	} else {
		
		if ( $curLevel > NO_OF_LEVELS )
			require( DOCUMENT_ROOT . 'includes/html/event/finished.php' );
		else
			header( 'Location: ' . SITE_URL . 'level2/' . $curLevel . '/' );
		
		exit;
	}
	
	// TBD: Check DIVERGENCE && CONVERGENCE
	
	// Load questions
	$question = $ts->getQuestion( $reqLevel );
	$favicon = ( isset( $question['favicon'] ) ) ? $question['favicon']: false;
	
	var_dump( $question ); var_dump( $favicon ); exit;
	/*	Begin Page Rendering */
	$page = NON_NAV;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	
	<?php if ( $favicon ) :?>
	<link rel="shortcut icon" href="<?php echo SSTATIC . 'img/questions/' . $favicon; ?>" type="image/png">
	<link rel="icon" href="<?php echo SSTATIC . 'img/questions/' . $favicon; ?>" type="image/png">
	<?php else : ?>
	<link rel="shortcut icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">
	<link rel="icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">
	<?php endif; ?>

	<title>Level <?php echo $reqLevel; ?> - Treasherlocked 2.0 Gameplay</title>

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
				<div class="row box status" id="level-info">
					<div class="info">
						<div class="level">Level <?php echo $reqLevel; ?></div>
						<div class="rank">Rank #<?php echo $ts->getUserRank(); ?></div>
					</div>
					<div class="progress-bar">
						<div class="progress" style="width: <?php echo ( ($curLevel - 1)/NO_OF_LEVELS )*100; ?>%;"></div>
					</div>
				</div>
				<div class="space space-20"></div>
				<div class="row box question-box" id="question-box">
					<div class="row" id="question">
						<?php echo $question['html']; ?>
					</div>
					<div class="row result wrong-ans" id="wrong-ans">
						<h1>Oops!</h1>
						<h3>We gotta tell you, that's not correct!</h3>
						<a class="btn btn-effect" id="back" href="javascript:void(0);">Back to question</a>
					</div>
					<div class="row result correct-ans" id="correct-ans">
						<h1>Congratulations!</h1>
						<h3>That was correct!</h3>
						<a class="btn btn-effect" id="back" href="<?php echo SITE_URL; ?>play/">Next question</a>
					</div>
				</div>
				<div class="space space-20"></div>
				
				<?php if ( $reqLevel == $curLevel ) : ?>
				<div class="row box answer-box" id="answer-box">
					<div class="row">
						<form id="mini">
							<input type="hidden" name="level" value="<?php echo $curLevel; ?>" />
							<input type="text" class="text" id="answer" name="answer" placeholder="Answer" maxlength="254" />
							<a class="btn btn-effect inline-block" id="submit" href="javascript:void(0);">Submit</a>
						</form>
					</div>
				</div>
				<div class="space space-20"></div>
				<?php else: ?>
				<div class="row text-center">
					<a class="btn btn-effect" href="<?php echo SITE_URL; ?>level/<?php echo $curLevel; ?>/">Go to current level</a>
				</div>
				<?php endif; ?>
				
				<div class="row box disqus" id="disqus">
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
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/init_level.js"></script>
	<?php require('includes/html/tracking.php'); ?>
</body>
</html>