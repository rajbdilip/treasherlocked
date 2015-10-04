<?php
/*
	Final step of registration takes place in this place.
	Additional information is POSTed to this page
*/
require_once($_SERVER['DOCUMENT_ROOT'] . 'config/consts.php'); /*notneeded*/

session_start();
//require('classes/loginHelper.php');

/*	Registration is pending and additional information has been POSTed	*/
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['registration_pending']) ) {
		
	require_once( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
	require_once( DOCUMENT_ROOT . 'classes/Registrar.php' );
	require_once( DOCUMENT_ROOT . 'config/db.php' );

	$username = $_POST['username'];
	$institute = ( isset($_POST['institute']) ) ? $_POST['institute'] : '';
	
	// Server-side input validation begins here
	$error = array();
	
	/*	Username Validation	*/
	if (!preg_match('/^[a-z_][\w.]{2,29}$/i', $username))
		$error['username'] = "Username should be 3 to 30 characters long (inclusive) and can begin with only an alphabet or an underscore.";
	else {
		// Check username availability
		$db->where('LCASE(username)', strtolower($username));
		$db->getOne('users');
		
		if ($db->count > 0)
			$error['username'] = "Username is not available.";
	}
	/*	End of Username validation */
	
	/*	Institute Validation */
	if ($institute != '' && !preg_match('/^[a-z. ]{10,60}$/i', $institute)) 
		$error['institute'] = "Institute should be 10 to 60 characters long and can only contain alphabets and dots.";
	/*	End of institute validation	*/
	
	/*	Location Validation */
	if (!isset($_SESSION['location_received'])) {
		$location = ( isset($_POST['location']) ) ? $_POST['location'] : '';
		
		if (!preg_match('/^[a-z., ]{3,30}$/i', $location)) 
			$error['location'] = "Location should be 3 to 30 characters long.";
	}
	/*	End of Location Validation */
	
	if ( sizeof($error) == 0 ) {
		// No errors - register the user
		// Get the tempUser's detail
		$db->where('id', $_SESSION['temp_user_id']);
		$user = $db->getOne('users_temp', '*');
		
		unset($user['id']);		// ID will be assigned automatically - This ID is ID from Temporary table
		
		// Add rest of the user fields
		$user['username'] = $username;
		$user['institute'] = $institute;
		if (isset($location))
			$user['location'] = $location;
		
		// Add user's record to the database
		$registrar = new Registrar($db);
		$id = $registrar->registerUser($user);

		if ($id) {
			// Delete tempUser record
			$db->where('id', $_SESSION['temp_user_id']);
			$db->delete('users_temp');
			
			unset($_SESSION['registration_pending']);
			unset($_SESSION['temp_user_id']);
			
			// Now that the registration is complete, log in the user
			$loginHelper = new LoginHelper();
			$loginHelper->Login( $id, $user['oauth_type'], $user['oauth_id'] );
			exit;
			// END OF SCRIPT //
		}
		
	} else {
		$registrar = new Registrar($db);
		echo $registrar->getHTML( $error );		// Get error HTML
		var_dump($error);
		exit;
	}
	
}

/*	No any data POSTed but registration is pending - show Additional Information page */
if ( isset($_SESSION['registration_pending']) ) {
	require_once(DOCUMENT_ROOT . 'classes/Registrar.php');
	require_once(DOCUMENT_ROOT . 'config/db.php');
	$registrar = new Registrar($db);
	echo $registrar->getHTML();
	exit;
}

/*	No data is POSTed and no registration is pending - Redirect to login page	*/
if ( isset($_SERVER['HTTP_REFERER']) ) {
	$_SESSION['redirect_uri'] = $_SERVER['HTTP_REFERER'];
}

header( SITE_URL . 'login/' );
exit;
?>