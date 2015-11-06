<?php
define( 'REDIRECT_URI', SITE_URL . 'oauth/facebook/login.php' );
define( 'SCOPES', serialize( array('email' ) ) );
define( 'REREQUEST', true );
?>