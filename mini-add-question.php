<?php 
	require_once('config/consts.php'); 
	$page = NON_NAV;
	session_start();
	
	require_once( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
	require_once( DOCUMENT_ROOT . 'config/db.php' );
	require(DOCUMENT_ROOT . 'includes/html/mini_add_question.php');
	
	/*	Prevent form spoofing */
	$spoof_proof = sha1( time() . chr( mt_rand( 97, 122 ) ) );
	$_SESSION['spoof_proof'] = $spoof_proof;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<link rel="shortcut icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">
	<link rel="icon" href="<?php echo SSTATIC; ?>favicon.png" type="image/png">

	<title>Add Questions</title>
	
	<meta name="description" content="Sign up for Treasherlocked 2.0. Register and become a detective because the hunt is on." />
	<meta name="keywords"  content="treasherlocked register, treasherlocked registration, treasherlocked sign up, how to register for treasherlocked" />

	<link href="<?php echo SSTATIC; ?>css/bootstrap.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/animate.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/base.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/social.css" rel="stylesheet" />
	<link href="<?php echo SSTATIC; ?>css/queries.css" rel="stylesheet" />
  <script type="text/javascript" src="<?php echo SSTATIC; ?>plugins/ckeditor/ckeditor.js"></script>
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
				<?php
					if(isset($success))
					{	
						echo "<p>Question Added Successfully.</p><br />
						<a href=\"". $_SERVER["PHP_SELF"] . "\" class=\"btn btn-primary\">Add Another Question</a>";
					}
					if(isset($error))
					{
						echo "<p>".$error ."</p>". 
						"<br /><a href=\"". $_SERVER["PHP_SELF"] . "\" class=\"btn btn-primary\">Try Again</a>";
					}
				?>
			</div>
			<?php if(!isset($_POST['level'])):?>
				<div class="row">
					<form id="new-question" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="post" class="form-horizontal" enctype="multipart/form-data">
						<div class="col-md-9">
							<h2>Add Question</h2>
							<div class="form-group">
								<div class="col-md-5">
									<input id="level" class="form-control" name="level" type="number" max="99" placeholder="Level" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-5">
									<input id="answer" class="form-control" name="answer" type="password" maxlength="40" placeholder="Answer" required />
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-11">
									<textarea name="html" id="html required"></textarea>
									<script type="text/javascript">
									CKEDITOR.replace('html');
									</script>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<input class="form-control btn btn-primary" type="submit" value="Add Question" name="submit"/>
								</div>
							</div>
						</div>
					</form>
				</div>
			<?php endif;?>
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
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/validator.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/init.js"></script>
	<script type="text/javascript" src="<?php echo SSTATIC; ?>js/init_signup.js"></script>
	
	
	<?php require('includes/html/tracking.php'); ?>
</body>
</html>