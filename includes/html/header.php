	<div class="header header-hide<?php if ($page != HOME) echo ' scroll-header" id="header'; ?>">
		<div class="container">
			<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" <?php if ($page == HOME) echo 'data-scroll href="#home"'; else echo 'href="' . SITE_URL . '"'; ?>>
						<img src="<?php echo SSTATIC; ?>img/icon.png" alt="icon"/>
					</a>
				</div>
				<div class="collapse navbar-collapse" id="navbar-collapse">
				
					<?php 
						if ( isset( $_SESSION['logged_in'] ) && $_SESSION['logged_in'] ): 
							/* Image avatar */
							$avatar = SSTATIC . 'img/avatar_icon.png';
							
							if ( $_SESSION['oauth_type'] == OAUTH_FACEBOOK )
								$avatar = 'https://graph.facebook.com/' . $_SESSION['oauth_id'] . '/picture';
					?>
					<ul class="nav navbar-nav dropdown-btn">
						<li><a href="javascript:void(0);"><img src="<?php echo $avatar; ?>"></a></li>
					</ul>
					<?php endif; ?>
					
					<ul class="nav navbar-nav">
						<?php require('nav.php'); ?>
					</ul>
					
					<?php if ( isset( $_SESSION['logged_in'] ) && $_SESSION['logged_in'] ): ?>
					<ul class="nav dropdown">
						<li class="last"><a data-scroll href="<?php echo SITE_URL; ?>logout/">Log Out</a></li>
					</ul>
					<ul class="nav dropdown2">
						<li><a data-scroll href="#">Profile</a></li>
						<li><a data-scroll href="<?php echo SITE_URL; ?>logout/">Log Out</a></li>
						<li class="last"><a data-scroll href="#">Deactivate</a></li>
					</ul>
					<?php endif; ?>
					
			   </div>
			</nav>
		</div>
	</div>