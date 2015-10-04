<?php 
	require( 'config/consts.php' ); 
	$page = HOW_TO_PLAY;
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

	<title>How to play Treasherlocked? - Treasherlocked 2.0</title>
	
	<meta name="description" content="Tutorial on how to play Treasherlocked." />
	<meta name="keywords"  content="how to play treasherlocked, how to play treasure hunt, treasherlocked tutorial" />

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
				<p>
					Treasherlocked is an online cryptic hunt. The questions can be based on books, scientific notations, 
					locations, different languages, important events and more. You don't need to be a coder or affiliated
					with any specific subject to decode the answers. Search Engines are your biggest rifles to win this 
					cryptic war. A question will test your ability to decipher a very simple message hidden somewhere 
					in your portal, rest you need to <strong>Power Search</strong>. Also, you will be provided with hints 
					which will ultimately get you on the right path.
				</p>
				<p>
					Once you have found the answer to a level you will be advanced to the next. As you progress through the 
					levels, the questions might start getting trickier. The winner will be the person who uses provided hints
					and resources to the fullest and manages to cross all the level first.
				</p>
				<h2>Example</h2>
				<div class="highlight">
					<h3>Puzzle</h3>
					<p class="text-center">
						<span><img src="<?php echo SSTATIC; ?>img/picture.png" />
						<span>Picture.png</span>
					</p>
				</div>
				<div class="highlight">
					<h3>Breaking the puzzle</h3>
					<ul>
						<li>
							Let's decode the picture. In this picture, we have a
							word <strong>M</strong>. A quick Google search on keyword <em>M</em> tells us it could be:
							<ul>
								<li>James Bond - a fictional character</li>
								<li>M (1931 film)</li>
								<li>Roman representation of numeber <strong>1000</strong></li>
							</ul>
							Let's try each of these as an answer.
						</li>
						<li>
							We got all wrong. Let's think more. <em>James Bond</em>, <em>M (1931 film)</em> or <em>1000</em> alone could lead to thousand of answers.
							There must be another hint. Let's try and find the name of the picture. You can see the page's source 
							(hit <strong>Ctrl + U</strong> while in page) or use tools such as <strong>Inspect Element</strong> to 
							do this. For this picture we have the name <em>Picture</em>.
						</li>
						<li>
							Now let's relate the <em>Picture</em> with the earlier pieces of information. Search engine again best serves
							the purpose. At this point, googling <em>picure 1000</em> will land you to the most sensible result which is
							a famous proverb <strong>"A picture is worth a thousand words."</strong> Let's try the proverb as an answer.
						</li>
						<li>
							We got wrong again. But we are close. Let's think about the proverb again. Maybe like who authored it? Who did?
							Google says <em>Arthur Brisbane</em> did. Let's try that.
						</li>
						<li>
							Bingo! That was the right answer.
						</li>
					</ul>
				</div>
				<p>
					<strong>Note: </strong>
					<em>This tutorial uses Google as the search engine but you can freely choose your favorite one. Besides, since
					different search engines give you slightly different results, switching between different search engines might
					help you find the answer quicker.</em>
				</p>
				<h2>How to answer?</h2>
				<p>
					The answer, usually, is limited to few words. You submit answer in the format as you would in any regular
					occasion. Letter case and presence/absence of spaces or any other punctuation character won't affect the
					correctness of your answer. However, we cannot take care of the spelling mistakes you make.
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