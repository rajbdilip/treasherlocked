<?php
require( $_SERVER['DOCUMENT_ROOT'] . '/ts2/config/consts.php' );
require( DOCUMENT_ROOT . 'config/db.php' );
require( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
require( DOCUMENT_ROOT . 'classes/Registrar.php' );

session_start();

$loginHelper = new LoginHelper();
if ( $loginHelper->IsLoggedIn() ) {
	header('Location: ' . SITE_URL);
	exit;
}

/* 	If session says the registration is pending and no data has been POSTed, 
	additional information hasn't been submitted yet. */
if ( isset($_SESSION['registration_pending']) && $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	$registrar = new Registrar();
	echo $registrar->getHTML();
	exit;
}

/*	If user doesn't grant the access, redirect to the login page */
if (isset($_GET['error']) && $_GET['error'] == 'access_denied') {
	header( "Location: " . SITE_URL . "login/?access_denied" );
	exit;
}

// Load configurations
require( 'config/client.php' );
require( 'config/login.php' );

require_once( 'Google/Client.php' );
require_once( 'Google/Service/Oauth2.php' );
require( 'Google/Google.php' );

$google = new Google( APP_NAME, CLIENT_ID, CLIENT_SECRET, unserialize(SCOPES), REDIRECT_URI );

if ( isset( $_GET['code'] ) ) {
	// Exchange the code for access token
	$google->authenticate( $_GET['code'] );
	$_SESSION['access_token'] = $google->getAccessToken();
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	header( 'Location: ' . filter_var($redirect, FILTER_SANITIZE_URL) );
	exit;
}

if ( $google->IsAuthenticated() ) {

	// Google User is authenticated and authorized
	// Login/Registration can be proceeded
	
	$gUser = $google->getUserProfile();
	
	$loginHelper = new LoginHelper($db);
	$user_id = $loginHelper->IsRegistered( OAUTH_GOOGLE, $gUser['id'] );
	
	if ($user_id) {
	
		// User is already registered - Log in the user
		$redicrect_uri = $loginHelper->Login( $user_id, OAUTH_GOOGLE, $gUser['id'] );
		header( "Location: $redirect_uri" );
		exit;
		
	} else {
	
		// User is not registerd
		// Email may be registered already
		$rUser = $loginHelper->IsEmailRegistered( $gUser['email'] );
		
		if ($rUser) {
			// Email is already registered - Login the user
			$redirect_uri = $loginHelper->Login( $rUser['id'], $rUser['oauth_type'], $rUser['oauth_id'] );
			header( "Location: $redirect_uri" );
			exit;
		}
		
		// Google user is logging in for the first time
		// Register the user
		$tempUser = array();
		$tempUser['oauth_type'] = OAUTH_GOOGLE;
		$tempUser['oauth_id'] = $gUser['id'];
		$tempUser['email'] = $gUser['email'];
		$tempUser['first_name'] = $gUser['givenName'];
		$tempUser['last_name'] = ( isset($gUser['familyName']) ) ? $gUser['familyName'] : '';
		$tempUser['gender'] = ( $gUser['gender'] == 'male' ) ? 1 : 0;
		
		// Google OAuth doesn't provide with location
		$_SESSION['location_received'] = false;
		
		// Register the user data into temporary table -
		// This data will later be moved to the main table after additional information has been obtained
		// Get HTML form to obtain additional information
		$registrar = new Registrar($db);
		if ( $registrar->registerTempUser( $tempUser ) )
			$registrar->getHTML();
		else
			echo "<html><body><h3>Unexpected error</h3></body></html>";
		
		exit;
	}
	
} else {
    header( "Location: " . $google->getLoginURL() );
	exit;
}

header( "Location: " . SITE_URL );
exit;
?>