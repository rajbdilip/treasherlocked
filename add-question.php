<?php 
	require_once('config/consts.php'); 
	$page = NON_NAV;
	session_start();
	
	require_once( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
	require_once( DOCUMENT_ROOT . 'config/db.php' );
	
	$loginHelper = new LoginHelper( $db );
	if ( $loginHelper->IsLoggedIn() ) {
		header( 'Location: ' . SITE_URL );
		exit;
	}
	
	/*	Prevent form spoofing */
	$spoof_proof = sha1( time() . chr( mt_rand( 97, 122 ) ) );
	$_SESSION['spoof_proof'] = $spoof_proof;
?>

<?php
	if(isset($_POST['submit']))
	{
		$upload_ok=1;
		if($_FILES['favicon']['name']!='')
		{
			$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/ts2/_static/img/favicon/"; 
			$target_file = $target_dir . basename($_FILES['favicon']['name']);
			if(strlen($_FILES['favicon']['name'])>20)	//checks the filename string size
			{
				$error = "File name is too large. It should be less than 20 characters.";
				$upload_ok = 0;
			}
			$check = getimagesize($_FILES['favicon']['tmp_name']);
			if($check['mime'] != "image/jpeg" && $check['mime'] !="image/png")	//checks if the file is an image.
			{
				$error = "The file type is not supported.";
				$upload_ok = 0;
			}			
			if($_FILES['favicon']['size'] > 500000)	//checks filesize < 500 KB
			{
				$error = "The file size is too large.";
				$upload_ok = 0;
			}
			if(!move_uploaded_file($_FILES['favicon']['tmp_name'], $target_file))	//checks error in file upload
			{
				$error = "error uploading image.";
				$upload_ok = 0;
			}
		}
		if($upload_ok === 1)
		{
			$db->where('level', $_POST['level']);
			$db->getOne('questions');
			if($db->count > 0)
			{
				$error = "Question for this level already exists.";
				$upload_ok = 0;
			}
			$data['level'] = $_POST['level'];
			$data['html'] = $_POST['html'];
			$data['answer'] = sha1($_POST['answer']);			
			if(isset($_POST['url_mask']))
			{
				$data['url_mask'] = $_POST['url_mask'];
			}
			if($_FILES['favicon']['name']!= '' && $upload_ok == 1)
			{
				$data['favicon'] = $_FILES['favicon']['name'];
			}
			if($upload_ok != 0)
			{
				$query = $db->insert('questions', $data);
				if($query === 0)
				{
					$success = true;
				}
			}
		}
	}
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
					if(isset($_POST['submit']))
					{
						if(isset($success))
						{	
							if($success === true)
							{
								echo "<p>Question Added Successfully.</p><br />
									<a href=\"". $_SERVER["PHP_SELF"] . "\" class=\"btn btn-primary\">Add Another Question</a>";
							}
						}
						if(isset($error))
						{
							echo "<p>".$error ."</p>". 
							"<br /><a href=\"". $_SERVER["PHP_SELF"] . "\" class=\"btn btn-primary\">Try Again</a>";
						}
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
								<div class="col-md-5">
									<input id="url_mask" class="form-control" name="url_mask" type="text" maxlength="12" placeholder="URL Mask If Required" />
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
								<div class="col-md-5">
									<input id="favicon" class="form-control" name="favicon" type="file" />
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