<?php
require( $_SERVER['DOCUMENT_ROOT'] . '/ts2/config/consts.php' );
require( DOCUMENT_ROOT . 'classes/LoginHelper.php' );

session_start();

$loginHelper = new LoginHelper();
if ( $loginHelper->IsLoggedIn() ) {
	header( 'Location: ' . SITE_URL );
	exit;
}

$loginHelper->suppressRegistration( OAUTH_FACEBOOK );

require( 'config/app.php' );
require( 'config/login.php' );
require( 'Facebook/Facebook.php' );

$facebook = new Facebook( APP_ID, APP_SECRET, REDIRECT_URI );
$facebook->setScopes( unserialize(SCOPES) );

$loginURL = $facebook->getLoginURL();
header( "Location: $loginURL" );
exit;
?>