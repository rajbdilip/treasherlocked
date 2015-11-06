<?php
session_start();
require( '../../config/consts.php' );
require_once( DOCUMENT_ROOT . 'classes/Response.php' );

$response = new Response();

if (  $_SERVER['REQUEST_METHOD'] == 'POST'
	&& isset( $_POST['spoof_proof'] ) 
	&& $_POST['spoof_proof'] == $_SESSION['spoof_proof'] 
) {

	require_once( DOCUMENT_ROOT . 'classes/Registrar.php' );
	require_once( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
	require_once( DOCUMENT_ROOT . 'config/db.php' );
	
	if ( isset( $_POST['email'] ) ) {
		
		// Email provided - Make and email a reset link to the user
		$email = $db->escape( $_POST['email'] );
		
		$db->where( 'email', $email )->where( 'oauth_type', 0 );
		$user = $db->getOne( 'users', 'id, email' );
					
		if  ( $db->count > 0 ) {
		
			// Email record exist - Send reset email
			$registrar = new Registrar( $db );
			
			if ( $registrar->sendResetEmail( $user['id'], $user['email'] ) ) {
				$response->success();
			} else {
				$response->error( 'Unexpected error: ERR_SND_RESET_EMAIL' );
			}
			
		} else {
			// Email record doesn't exist
			$response->error( 'No such email record exist in our database.' );
		}
		
	} elseif ( isset( $_POST['new_password'] ) && isset( $_SESSION['reset_verified'] ) && isset( $_SESSION['reset_id'] ) ) {
	
		$user_id 	= $_SESSION['reset_id'];
		$password 	= sha1( $db->escape( $_POST['new_password'] ) );
		
		$user = array();
		$user['password'] = $password;
		$user['auth_code'] = '';
		$user['verified'] = 1;
		
		$db->where( 'id', $user_id );
		
		if ( $db->update( 'users', $user ) ) {
			// Password update successfull
			$loginHelper = new LoginHelper( $db );
			$loginHelper->Login( $user_id );
			$response->success();
		} else {
			$response->error( 'Unexpected Error: ERR_UPDATE_PSSWD' );
		}
		
	} else {
		$response->error( 'Email not provided' );
	}
	
	$response->send();
	exit;
} else {
	$response->send404();
	exit;
}
?>