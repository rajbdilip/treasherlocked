<?php
define( 'REDIRECT_URI', SITE_URL . 'oauth/facebook/login.php' );
define( 'SCOPES', serialize( array('email', 'user_location', 'user_likes', 'publish_actions' ) ) );
define( 'REREQUEST', true );
?>