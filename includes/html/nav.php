					<li<?php echo IsActive( $page, HOME );			?>><a data-scroll href="<?php echo SITE_URL; ?>">Home</a></li>
					<li<?php echo IsActive( $page, ABOUT ); 		?>><a data-scroll href="<?php echo SITE_URL; ?>about/">About</a></li>
					<li<?php echo IsActive( $page, HOW_TO_PLAY ); 	?>><a data-scroll href="<?php echo SITE_URL; ?>how-to-play/">How to Play</a></li>
					<li<?php echo IsActive( $page, RULES ); 		?>><a data-scroll href="<?php echo SITE_URL; ?>rules/">Rules</a></li>
					<li<?php echo IsActive( $page, MINI_SERIES ); 		?>><a data-scroll href="<?php echo SITE_URL; ?>mini/">2.x Mini</a></li>
					
					
					<?php if ( isset( $_SESSION['logged_in'] ) ): ?>
					<!--<li<?php echo IsActive( $page, LEADERBOARD ); 	?>><a data-scroll href="<?php echo SITE_URL; ?>leaderboard/">Leaderboard</a></li>-->
					<?php endif; ?>

				<?php if ( !isset( $_SESSION['logged_in'] ) || !$_SESSION['logged_in'] ): ?>
					<li><a class="btn-effect btn" data-scroll href="<?php echo SITE_URL; ?>login/">Login</a></li>
					<li><a class="btn-effect btn" data-scroll href="<?php echo SITE_URL; ?>signup/">Sign Up</a></li>
					<?php endif; ?>
<?php
function IsActive( $page, $pageID ) {
	if ($page == $pageID)
		return ' class="active"';
	return '';
}
?>