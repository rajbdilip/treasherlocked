<?php

require( '../../config/consts.php' );
session_start();

require_once( DOCUMENT_ROOT . 'classes/LoginHelper.php' );
require_once( DOCUMENT_ROOT . 'config/db.php' );
require( DOCUMENT_ROOT . 'classes/Treasherlocked.php' );
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
	&& isset( $_POST['answer'] )
	&& isset( $_POST['level'] )
) {
		
	$ts = new Treasherlocked( $db );
	
	if ( $ts->getEventStatus() == EVENT_NOT_STARTED ) {
		$response->send404();
		exit;
	}
	
	$level = $db->escape( $_POST['level'] );
	
	if ( $level == $ts->getCurrentLevel() ) {
	
		// Update attempts
		$_SESSION['attempts'] = ++$_SESSION['attempts'];
		
		$answer = preg_replace( '/[\s\.\'\",]+/i', '', strtolower( $_POST['answer'] ) );
		$answer = sha1( $answer );
		
		if ( $answer == $_SESSION['answer'] ) {
		
			$time = date( 'Y-m-d H:i:s', time() );
			
			if ( $db->insert( 'gameplay', array( 'user_id' => $_SESSION['user_id'], 'level' => $level, 'clear_time' => $time, 'attempts' => $_SESSION['attempts'] ) ) ) {
				$ts->upgradeLevel( ++$_SESSION['level'] );
				
				if ( $_SESSION['level'] > NO_OF_LEVELS )
					$response->finished();
					
				$response->success();
				$response->correctAnswer();
			} else {
				$response->error( 'ERR_DB_INSRT: Unexpected error!' );
			}
			
			$response->send();
			exit;
			
		} else {
		
			$response->success();
			$response->correctAnswer( false );
			$response->send();
			exit;
			
		}
	} else {
		$response->error( 'Requested Level Not Authorized' );
		$response->send();
		exit;
	}
}

$response->send404();
exit;
?>