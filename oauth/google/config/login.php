<?php
define( 'APP_NAME', 		'Treasherlocked' );
define( 'REDIRECT_URI', 	SITE_URL . 'oauth/google/login.php' );
define( 'SCOPES', 			serialize( array( 'profile', 'email') ) );
?>