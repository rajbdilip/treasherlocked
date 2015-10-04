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

// If session says the registration is pending and no data has been POSTed, 
// registration-completion form hasn't been completed yet.
if ( isset($_SESSION['registration_pending']) && $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	$registrar = new Registrar();
	$registrar->getHTML();
	exit;
}

// If user doesn't grant the access, redirect to the login page
if ( isset($_GET['denied']) ) {
	header( "Location: " . SITE_URL . "login/?access_denied" );
	exit;
}

require( 'config/consumer.php' );
require( 'config/login.php' );
require( 'Twitter/Twitter.php' );

$twitter = new Twitter( CONSUMER_KEY, CONSUMER_SECRET, REDIRECT_URI );

if ( $twitter->IsAuthenticated() ) {
	// Twitter user is authenticated and authorized
	// Login/Registration can be proceeded
	
	$twitter_user = $twitter->getUserProfile();
	
	$loginHelper = new LoginHelper($db);
	$user_id = $loginHelper->IsRegistered( OAUTH_TWITTER, $twitter_user->id );

	if ($user_id) {
	
		// User is registered 
		// TWITTER user needs to have their email verfieid
		if ( $loginHelper->IsVerified( $user_id ) ) {
			$redirect_uri = $loginHelper->Login( $user_id, OAUTH_TWITTER, $twitter_user->id );
			header( "Location: $redirect_uri" );
		} else {
			$not_verified = true;
			/* 	Keeping `access token` alive generates login URL with invalid Oauth token if
				user goes to `oauth\twitter\index.php`
			*/
			// TBD: clearTwitterCredentials
			if ( isset( $_SESSION['access_token'] ) )
				unset( $_SESSION['access_token'] );
				
			require( DOCUMENT_ROOT . 'includes/html/login/email_not_verified.php' );
		}
		
		exit;
		
	} else {
	
		// User is not registerd
		
		// Facebook user is loggin in for the first time
		// Register the user
		$tempUser = array();
		$tempUser['oauth_type'] = OAUTH_TWITTER;
		$tempUser['oauth_id'] = $twitter_user->id;
		//$tempUser['email'] = ''; 		// Twitter doesn't provide with Email (Fu*k twitter)
		$tempUser['first_name'] = $twitter_user->name;
		$tempUser['middle_name'] = '';	// Twitter doesn't exclusively mention middle name
		$tempUser['last_name'] = '';	// Twitter doesn't exclusively mention last name
		//$tempUser['gender'] = -1;		// Twitter doesn't fu*king provide gender either
		
		if ( !empty( $twitter_user->location ) ) {
			$tempUser['location'] = $twitter_user->location;
		} else {
			$_SESSION['location_received'] = false;
		}
		
		$_SESSION['email_received'] = false;
		$_SESSION['gender_received'] = false;
		
		// Register the user data into temporary table -
		// This data will later be moved to the main table after additional information has been obtained
		// Get HTML form to obtain additional information
		$registrar = new Registrar($db);
		if ( $registrar->registerTempUser( $tempUser ) ) {
		
			// TBD: clearTwitterCredentials
			if ( isset( $_SESSION['access_token'] ) )
				unset( $_SESSION['access_token'] );
				
			echo $registrar->getHTML();
		} else {
			echo "<html><body><h3>Unexpected error</h3></body></html>";
		}
		exit;
		
	}
} else {
    header( "Location: " . $twitter->getLoginURL() );
	exit;
}

header( "Location: " . SITE_URL );
exit;
?>