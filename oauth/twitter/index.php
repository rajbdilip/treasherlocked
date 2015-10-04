<?php
require( $_SERVER['DOCUMENT_ROOT'] . '/ts2/config/consts.php' );
require( DOCUMENT_ROOT . 'classes/LoginHelper.php' );

session_start();
$loginHelper = new LoginHelper();
if ( $loginHelper->IsLoggedIn() ) {
	header( 'Location: ' . SITE_URL );
	exit;
}

$loginHelper->suppressRegistration( OAUTH_TWITTER );

require( 'config/consumer.php' );
require( 'config/login.php' );	
require( 'Twitter/Twitter.php' );

$twitter = new Twitter( CONSUMER_KEY, CONSUMER_SECRET, REDIRECT_URI );

header( "Location: " . $twitter->getLoginURL() );
exit;
/*
$temp_credentials = $connection->getRequestToken( REDIRECT_URI );

$_SESSION['oauth_token'] = $token = $temp_credentials['oauth_token'];
$_SESSION['oauth_token_secret'] = $temp_credentials['oauth_token_secret'];

header( "Location: " . $connection->getAuthorizeURL($token) ); 
exit;
*/
?>