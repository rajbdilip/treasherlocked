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

/* 	
	* If session says the registration is pending and no data has been POSTed, 
	* registration-completion form hasn't been completed yet 
*/
if ( isset($_SESSION['registration_pending'] ) && $_SERVER['REQUEST_METHOD'] != 'POST' ) {
	$registrar = new Registrar();
	echo $registrar->getHTML();
	exit;
}

/*	If user doesn't grant Facebook app the access, redirect to the login page */
if (isset($_GET['error']) && $_GET['error'] == 'access_denied') {
	header( "Location: " . SITE_URL . "login/?access_denied" );
	exit;
}

/*	User has granted Facebook app (some or all) permissions. */
if (isset($_GET['code'])) {
	
	require( 'Facebook/Facebook.php');
	require( 'config/app.php');
	require( 'config/login.php');

	$facebook = new Facebook(  APP_ID, APP_SECRET, REDIRECT_URI );

	if ( $facebook->IsAuthenticated() ) {
		
		/* 	Verify that all of the required scopes have been granted */
		if ( !$facebook->verifyScopes( unserialize(SCOPES) ) ) {
			//var_dump($facebook); exit;
			header( "Location: " . $facebook->getLoginURL( $facebook->denied_scopes, REREQUEST) );
			exit;
		}
		
		// All scopes have been granted
		// Login/Registration can be proceeded
		
		$fb_user = $facebook->getUserProfile();

		// Check if the facebook user is already registered
		$loginHelper = new LoginHelper($db);
		$user_id = $loginHelper->IsRegistered( OAUTH_FACEBOOK, $fb_user['id'] );
	
		if ($user_id) {
		
			// Facebook user is already registered - Login the user
			$redirect_uri = $loginHelper->Login( $user_id, OAUTH_FACEBOOK, $fb_user['id'] );
			header( "Location: $redirect_uri" );
			exit;
			
		} else {
		
			// User is not registered - Register the user

			// Check if the email is already registered			
			if (isset($fb_user['email'])) {
				$registeredUser = $loginHelper->IsEmailRegistered( $fb_user['email'] );
				
				if ($registeredUser) {
					// Email is already registered
					$redirect_uri = $loginHelper->Login( $registeredUser['id'], $registeredUser['oauth_type'], $registeredUser['oauth_id'] );
					header( "Location: $redirect_uri" );
					exit;
				}
			}
			
			// Email is not registered; Facebook user is loggin in for the first time - Register the user
			$tempUser = array();
			$tempUser['oauth_type'] = OAUTH_FACEBOOK;
			$tempUser['oauth_id'] = $fb_user['id'];
			$tempUser['email'] = ( isset($fb_user['email']) ) ? $fb_user['email'] : null;
			$tempUser['first_name'] = $fb_user['first_name'];
			$tempUser['middle_name'] = ( isset($fb_user['middle_name']) ) ? $fb_user['middle_name'] : null;
			$tempUser['last_name'] = ( isset($fb_user['last_name']) ) ? $fb_user['last_name'] : null;
			$tempUser['gender'] = ( $fb_user['gender'] == 'male' ) ? 1 : 0;
			
			if ( isset($fb_user['location']) ) {
				$tempUser['location'] = $fb_user['location']->name;
				$_SESSION['location_received'] = true;
			} else {
				$_SESSION['location_received'] = false;
			}
			
			// Register the user data into temporary table
			// This record will later be moved to the main table after additional information has been obtained
			// Get HTML form to obtain additional information
			$registrar = new Registrar($db);
			if ( $registrar->registerTempUser( $tempUser ) )
				require( DOCUMENT_ROOT . 'includes/html/login/add_reg_info.php' );
			else
				echo "<html><body><h3>Unexpected error</h3></body></html>";	// Facebook would know what happens at this point. :P
			
			exit;
		}
	} else {
		// Facebook user is not authenticated - request authentication
		header("Location: " . $facebook->getLoginURL());
		exit;
		
	}
}

header( "Location: " . SITE_URL );
exit;
?>