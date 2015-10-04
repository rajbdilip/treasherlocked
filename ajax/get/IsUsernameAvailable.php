<?php
/*	Checks if a particular username is available */

if ( isset($_GET['username']) ) {
	
	require( '../../config/consts.php' );
	require( DOCUMENT_ROOT . 'config/db.php' );
	
	$username = $db->escape( $_GET['username'] );
	
	$db->where('LCASE(username)', strtolower($username));
	$db->getOne('users');

	if ($db->count > 0)
		$result = array( 'available' => false );
	else
		$result = array( 'available' => true );
		
	header( 'Content-Type: application/json' );
	echo json_encode( $result );
	
} else {
	 http_response_code( 404 );
}
?>