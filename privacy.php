<?php 
	require( 'config/consts.php' );
	$page = NON_NAV;
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

	<title>Treasherlocked Privacy Policy</title>
	
	<meta name="description" content="Treasherlocked 3.0 Privacy Policy" />
	<meta name="keywords"  content="treasherlocked, privacy, privacy policy" />

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
			<div class="row title">
				<h1>PRIVACY POLICY</h1>
			</div>
			<div class="row">
				<p>
					This Privacy Policy governs the manner in which Treasherlocked collects, uses, maintains and 
					discloses information collected from users (each, a "User") of the 
					<a href="http://www.treasherlocked.in">www.treasherlocked.com</a> website.
				</p>
				<h2>Personal identification information</h2>
				<p>
					We may collect personal identification information from Users in a variety of ways, including, 
					but not limited to, when Users visit our site, register on the site, and in connection with other 
					activities, services, features or resources we make available on our Site. Users may be asked for, 
					as appropriate, name, email address. We will collect personal identification information from Users 
					only if they voluntarily submit such information to us. Users can always refuse to supply personally 
					identification information, except that it may prevent them from accessing the site features.
				</p>
				<h2>Non-personal identification information</h2>
				<p>
					We may collect non-personal identification information about Users whenever they interact with our 
					Site. Non-personal identification information may include the browser name, the type of computer and 
					technical information about Users means of connection to our Site, such as the operating system and the 
					Internet service providers utilized and other similar information.
				</p>
				<h2>Web browser cookies</h2>
				<p>
					Our Site may use "cookies" to enhance User experience. User's web browser places cookies on their hard 
					drive for record-keeping purposes and sometimes to track information about them. User may choose to set 
					their web browser to refuse cookies, or to alert you when cookies are being sent. If they do so, note that 
					some parts of the Site may not function properly.
				</p>
				<h2>How we use collected information</h2>
				<p>
					Treasherlocked may collect and use Users personal information for the following purposes:
				</p>
				<ul>
					<li>
						<strong>To personalize user experience</strong><br/>We may use information in the aggregate to 
						understand how our Users as a group use the services and resources provided on our Site.
					</li>
					<li>
						<strong>To send periodic emails</strong><br/>We may use the email address to respond to their 
						inquiries, questions, and/or other requests. If User decides to opt-in to our mailing list, they 
						will receive emails that may include company news, updates, related product or service information, 
						etc. 
					</li>
				</ul>
				<h2>How we protect your information</h2>
				<p>
					We adopt appropriate data collection, storage and processing practices and security measures to protect 
					against unauthorized access, alteration, disclosure or destruction of your personal information, username, 
					password, transaction information and data stored on our Site.
				</p>
				<h2>Sharing your personal information</h2>
				<p>
					We do not sell, trade, or rent Users personal identification information to others. We may share generic 
					aggregated demographic information not linked to any personal identification information regarding visitors 
					and users with our business partners, trusted affiliates and advertisers for the purposes outlined above.
				</p>
				<h2>Changes to this privacy policy</h2>
				<p>
					Treasherlocked has the discretion to update this privacy policy at any time. When we do, we will post a 
					notification on the main page of our Site. We encourage Users to frequently check this page for any changes 
					to stay informed about how we are helping to protect the personal information we collect. You acknowledge 
					and agree that it is your responsibility to review this privacy policy periodically and become aware of 
					modifications.
				</p>
				<h2>Your acceptance of these terms</h2>
				<p>
					By using this Site, you signify your acceptance of this policy. If you do not agree to this policy, 
					please do not use our Site. Your continued use of the Site following the posting of changes to this 
					policy will be deemed your acceptance of those changes.
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