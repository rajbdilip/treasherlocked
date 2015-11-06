<?php
/*	
	This page receives the sign up information (Sign up using Treasherlocked i.e Oauth_Default) 
	via an AJAX request. The page validates and completes the Oauth registration.
*/
require( '../../config/consts.php' );
session_start();

if (  $_SERVER['REQUEST_METHOD'] == 'POST'
	&& isset( $_POST['spoof_proof'] ) 
	&& $_POST['spoof_proof'] == $_SESSION['spoof_proof'] 
) {

	require_once( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
	require_once( DOCUMENT_ROOT . 'classes/Registrar.php' );
	require_once( DOCUMENT_ROOT . 'config/db.php' );


	$name		= $_POST['name'];
	$gender		= strtolower( $_POST['gender'] );
	$institute	= $_POST['institute'];
	$location	= $_POST['location'];
	$email		= $_POST['email'];
	$username	= $_POST['username'];
	$password	= $_POST['password'];
	$password2	= $_POST['password2'];


	/* VALIDATION ------ */
	
	$error = array();		// Validation errors will be stored in this array
	
	// >>>> NAME
	if ( !preg_match( '/^[a-z][a-z\s]{3,100}$/i', $name ) )
		$error['name'] = '<span>Name</span> must be at least 4 characters long and can only contain alphabets.';
	// NAME <<<<
	
	// >>>> GENDER
	if ( $gender != 'male' && $gender != 'female' )
		$error['gender'] = 'Invalid <span>gender</span>.';
	// GENDER <<<<
	
	// >>>> INSTITUTE
	if ( !preg_match( '/^[a-z][a-z\s]{9,100}$/i', $institute ) )
		$error['institute'] = '<span>Institute</span> must be at least 10 characters characters long and can only contain alphabets.';
	// INSTITUTE <<<<
	
	// >>>> LOCATION
	if ( !preg_match( '/^[a-z][a-z,\s]{5,100}$/i', $institute ) )
		$error['institute'] = '<span>Location</span> must be at least 6 characters long and can only contain alphabets and comma(,).';
	// LOACTION <<<<
	
	// >>>> EMAIL
	if ( !preg_match( '/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/', $email ) ) {
		$error['email'] = '<span>Email</span> must be in the form <em>someone@somewhere.tld</em>.';
	} else {
		$loginHelper = new LoginHelper( $db );
		if ( $loginHelper->IsEmailRegistered( $email ) )
			$error['email'] = '<span>Email</span> address is already registered.';
	}
	// EMAIL <<<<
	
	// >>>> USERNAME
	if ( !preg_match( '/^[a-z0-9_!@#$%^&*]{3,25}$/i', $username ) ) {
		$error['username'] = '<span>Username</span> must be at least 3 characters long and can only contain alphanumeric characters and one of <span>!@#$%^&amp;*_</span>';
	} else {
		$loginHelper = new LoginHelper( $db );
		if ( !$loginHelper->IsUsernameAvailable( $username ) )
			$error['username'] = '<span>Username</span> is not available.';
	}
	// USERNAME <<<<
	
	// >>>> PASSWORD
	if ( strlen( $password ) < 6 ) {
		$error['password'] = '<span>Password</span> must be 6 to 30 characters long.';
	} else {
		if ( $password != $password2 )
			$error['password'] = 'Passwords don\'t match.';
	}
	// PASSWORD <<<<
	
	/* ----- VALIDATION  */
	
	if ( sizeof($error) == 0 ) {
		
		// No validation errors. Can continue.
		
		$user = array();
		
		$user['username']		= $db->escape( $username );
		$user['email']			= $db->escape( $email );
		$user['password']		= sha1( $password );
		$user['first_name']		= $db->escape( $name );
		$user['gender']			= ( $gender == 'male' ) ? 1 : 0;
		$user['institute']		= $db->escape( $institute );
		$user['location']		= $db->escape( $location );
		$user['registered_in'] 	= date( "Y-m-d H:i:s", time() );
		$user['verified']		= 1;
		
		// Register the user
		$registrar = new Registrar( $db );
		$user_id = $registrar->registerUser( $user );
		
		if ( $user_id ) {
			
			// Disable email verification
			// // Registration successfull - Send the email verification link
			// if ( $registrar->sendVerificationEmail( $user_id, $email ) ) 
			// 	$result = array( 'success' => true );
			// else
			// 	$result = array( 'success' => false, 'error' => 'Unexpected error!' );
			
			$result = array( 'success' => true, 'verified' => true );

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
} else {
	header( 'HTTP/1.1 404 Not Found' );
}
?>