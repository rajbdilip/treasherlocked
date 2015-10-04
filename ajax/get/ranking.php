<?php
require( $_SERVER['DOCUMENT_ROOT'] . '/ts2/config/consts.php' );
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

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
	
	$query = "	SELECT 
					u.*,
					@rank := @rank + 1 rank
				FROM
					( SELECT 
						t1.user_id user_id, 
						t2.username username, 
						t1.level, 
						t3.clear_time clear_time
					FROM 
						( SELECT 
							user_id, 
							max(level) level 
						FROM
							gameplay 
						GROUP BY 
							user_id
						) t1
					INNER JOIN 
						(users t2, gameplay t3)
					ON 
						t1.user_id = t2.id 
						AND t3.level = t1.level 
						AND t3.user_id = t1.user_id
					ORDER BY
						level DESC,
						clear_time ASC ) u
				JOIN
					( SELECT @rank := 0 ) r
			;";
	
	$rankings = $db->rawQuery( $query );
	
	if ( $rankings ) {
		
		$data = "";
		
		foreach( $rankings as $ranking ) {
			$user_id 	= $ranking['user_id'];
			$rank 		= $ranking['rank'];
			$level 		= $ranking['level'];
			$username 	= $ranking['username'];
			
			$level = $level + 1;
			
			if ( $level > NO_OF_LEVELS )
				$level = 'N/A';
			
			$data .= "<tr><td>$rank</td><td>$username</td><td>$level</td></tr>";
		}
		
		$ts = new Treasherlocked( $db );
		$userRank = $ts->getUserRank();
		
		$response->success();
		$response->add( 'userRank', $userRank );
		$response->add( 'data', $data );
	} else {
		$response->error( 'DB_ERROR: Unexpected error.' );
	}
	
	$response->send();
}
?>