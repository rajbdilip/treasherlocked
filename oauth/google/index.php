<?php
require( '../../config/consts.php' );
require( DOCUMENT_ROOT . 'classes/LoginHelper.php' );

session_start();

$loginHelper = new LoginHelper();
if ( $loginHelper->IsLoggedIn() ) {
	header('Location: ' . SITE_URL);
	exit;
}

$loginHelper->suppressRegistration( OAUTH_GOOGLE );

require( 'config/client.php' );
require( 'config/login.php' );
require( 'Google/Google.php' );

$google = new Google( APP_NAME, CLIENT_ID, CLIENT_SECRET, unserialize(SCOPES), REDIRECT_URI );

header( "Location: " . $google->getLoginURL() );
exit;
?>