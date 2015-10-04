<?php
/*	
	This page receives the sign up information (Sign up using Treasherlocked i.e Oauth_Default) 
	via an AJAX request. The page validates and completes the Oauth registration.
*/


require( $_SERVER['DOCUMENT_ROOT'] . '/ts2/config/consts.php' );
session_start();

if (  $_SERVER['REQUEST_METHOD'] == 'POST'
	&& isset( $_POST['spoof_proof'] ) 
	&& $_POST['spoof_proof'] == $_SESSION['spoof_proof'] 
) {

	require_once( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
	require_once( DOCUMENT_ROOT . 'classes/Registrar.php' );
	require_once( DOCUMENT_ROOT . 'config/db.php' );


	$name		= $db->escape( $_POST['username'] );
	$password	= sha1( $_POST['password'] );
	$remember	= ( isset( $_POST['remember'] ) ) ? true : false;
	
	$result = $db->rawQuery( "SELECT id
							FROM users 
							WHERE 
								( email = ? OR username = ? ) 
								AND oauth_type = ? 
								AND password = ?
								AND verified = ?
							",
							array(
								$name,
								$name,
								OAUTH_DEFAULT,
								$password,
								1
							)
				);
				
	if  ( $db->count > 0 ) {
		$user = $result[0];
		
		// Valid credentials
		$loginHelper = new LoginHelper( $db );
		$redirect_uri = $loginHelper->Login( $user['id'], OAUTH_DEFAULT, null, $remember );
		
		$result = array( 'success' => true, 'redirect_uri' => $redirect_uri );
		
	} else {
		// invalid credentails
		$result = array( 'success' => false );
	}
	
	header( 'Content-Type: application/json' );
	echo json_encode( $result );
	exit;
} else {
	header( 'HTTP/1.1 404 Not Found' );
}
?>