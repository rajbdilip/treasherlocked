<?php
/*	
	This page receives the additional information after a Oauth login via an AJAX
	request. The page validates and completes the Oauth registration.
*/
require( '../../config/consts.php' );
session_start();

if (  $_SERVER['REQUEST_METHOD'] == 'POST'
	&& isset( $_SESSION['registration_pending'] )
	&& isset( $_POST['spoof_proof'] ) 
	&& $_POST['spoof_proof'] == $_SESSION['spoof_proof'] 
	) {

	/*	Registration is pending and additional information has been POSTed	*/

	require_once( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
	require_once( DOCUMENT_ROOT . 'classes/Registrar.php' );
	require_once( DOCUMENT_ROOT . 'config/db.php' );

	$username = $_POST['username'];
	$institute = ( isset($_POST['institute']) ) ? $_POST['institute'] : '';
	
	// Server-side input validation begins here
	$error = array();
	
	/*	Username Validation	*/
	if ( !preg_match( '/^[a-z0-9_!@#$%^&*]{3,25}$/i', $username ) )
		$error['username'] = "<span>Username</span> must be at least 3 characters long and can only contain alphanumeric characters and one of <span>!@#$%^&amp;*_</span>";
	else {
		// Check username availability
		$db->where( 'LCASE(username)', strtolower($username) );
		$db->getOne( 'users' );
		
		if ( $db->count > 0 )
			$error['username'] = "<span>Username</span> is not available.";
	}
	/*	End of Username validation */
	
	/*	Institute Validation */
	if ( $institute != '' && !preg_match( '/^[a-z][a-z.\s]{9,99}$/i', $institute ) ) 
		$error['institute'] = "Institute should be atleast 10 characters long and can only contain alphabets and dots.";
	/*	End of institute validation	*/
	
	/*	Location Validation */
	if ( isset( $_SESSION['location_received'] ) && !$_SESSION['location_received'] ) {
		$location = ( isset($_POST['location']) ) ? $_POST['location'] : '';
		
		if ( !preg_match( '/^[a-z][a-z.,\s]{5,30}$/i', $location ) ) 
			$error['location'] = "Location should be at least 6 characters long.";
	}
	/*	End of Location Validation */
	
	/*	Email Validation */
	if ( isset( $_SESSION['email_received'] ) && !$_SESSION['email_received'] ) {
		$email = ( isset($_POST['email']) ) ? $_POST['email'] : '';
		
		if ( !preg_match( '/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/', $email ) ) 
			$error['email'] = "The email has an invalid format.";
	}
	/*	Email Validation */
	
	/* --- VALIDATION ENDS ----- */

	if ( sizeof($error) == 0 ) {
		// No errors - register the user
		// Get the tempUser's detail
		$db->where( 'id', $_SESSION['temp_user_id'] );
		$user = $db->getOne( 'users_temp', '*' );
		
		unset( $user['id']) ;		// ID will be assigned automatically - This ID is from Temporary table
		
		// Add rest of the user fields
		$user['username'] 	= $username;
		$user['institute'] 	= $institute;
		
		if ( isset($location) )
			$user['location'] = $location;
			
		if ( isset($email) )
			$user['email'] = $email;
			
		if ( isset( $_POST['gender'] ) )
			$user['gender'] = ( $_POST['gender'] == 'male' ) ? 1 : 0;

		$user['registered_in'] = date( "Y-m-d H:i:s", time() );
		
		// Disable E-email verification
		/*if ( $user['oauth_type'] != OAUTH_TWITTER )
			$user['verified'] = 1;*/
		
		$user['verified'] = 1;
			
		// Add user's record to the database
		$registrar = new Registrar($db);
		$id = $registrar->registerUser($user);

		if ($id) {
		
			// Delete tempUser record and unset temporary session variables
			$db->where('id', $_SESSION['temp_user_id']);
			$db->delete('users_temp');
			
			unset( $_SESSION['registration_pending'] );
			unset( $_SESSION['temp_user_id'] );
			unset( $_SESSION['spoof_proof'] );
			
			// Disable Email Verification
			/*/* If email has been manually provided, it needs to be verified.
			if ( isset($email) ) {
				$registrar->sendVerificationEmail( $id, $user['email'] );
				// Show verification page link
				$result = array( 'success' => true, 'verify' => true );
				
				header( 'Content-Type: application/json' );
				echo json_encode( $result );
				exit;
			}*/
			
			// Now that the registration is complete, login the user
			$loginHelper = new LoginHelper();
			$redirect_uri = $loginHelper->Login( $id, $user['oauth_type'], $user['oauth_id'] );
			
			// Return the success information
			$result = array( 'success' => true, 'redirect_uri' => $redirect_uri );
			
			header( 'Content-Type: application/json' );
			echo json_encode( $result );
			exit;
			
		} else {
		
			$result = array( 'success' => false, 'error' => 'Unexpected error!' );
			
			header( 'Content-Type: application/json' );
			echo json_encode( $result );
			exit;
			
		}
		
	} else {
		$result = array( 'success' => false, 'error' => implode( "<br/>", $error ) );
		
		header( 'Content-Type: application/json' );
		echo json_encode( $result );
		exit;
	}
}

header( 'HTTP/1.1 404 Not Found' );
?>