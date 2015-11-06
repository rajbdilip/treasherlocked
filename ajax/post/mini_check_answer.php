<?php

require( '../../config/consts.php' );
session_start();

require_once( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
require_once( DOCUMENT_ROOT . 'config/db.php' );
require( DOCUMENT_ROOT . 'classes/Mini.php' );
require( DOCUMENT_ROOT . 'classes/Response.php' );

// Create an instance of response class
$response = new Response();

/* Check if the user is logged in */
$loginHelper = new LoginHelper($db);

if ( !$loginHelper->IsLoggedIn() ) {
	$response->error( 'Not authorized!' );
	$response->send();
	exit;
}


if (  $_SERVER['REQUEST_METHOD'] == 'POST'
	&& isset( $_POST['spoof_proof'] ) 
	&& $_POST['spoof_proof'] == $_SESSION['spoof_proof']
	&& isset( $_POST['answer'] )
	&& isset( $_POST['level'] )
) {
		
	$mini = new Mini( $db );
	$level = $db->escape( $_POST['level'] );
	
	if ( $mini->isLevelAvailable( $level ) ) {
		$answer = preg_replace( '/[\s\.\'\",]+/i', '', strtolower( $_POST['answer'] ) );
		$answer = sha1( $answer );
		
		if ( $answer == $_SESSION['answer'] ) {
		
			$time = date( 'Y-m-d H:i:s', time() );
			
			if ( $db->insert( 'mini_gameplay', array( 'user_id' => $_SESSION['user_id'], 'level' => $mini->getTodaysLevel(), 'clear_time' => $time ) ) ) {
				$response->success();
			} else {
				$response->error( 'Unexpected error!' );
			}
			
			$response->send();
			exit;
			
		} else {
		
			$response->success( false );
			$response->send();
			exit;
			
		}
	} else {
		$response->error( 'Time Out!' );
		$resonse->add( 'timeOut', true );
		$response->send();
		exit;
	}
}

$response->send404();
exit;
?>