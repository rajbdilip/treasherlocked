<?php
class Treasherlocked {

	private $db;

	public function __construct( $db = null ) {
		$this->db = $db;
	}
	
	/*
		Checks if the event has started
		Returns true if the event has started, false otherwise
	*/
	public function getEventStatus() {
		$current_time = time();

		if ( $current_time < EVENT_START )
			return EVENT_NOT_STARTED;
		else if ( $current_time >= EVENT_START && $current_time < EVENT_END )
			return EVENT_STARTED;
		else
			return EVENT_CLOSED;
	}

	/*
		Gets the current level of user and sets it to the session
		Returns current level of the user if record exists, 0 otherwise
	*/
	public function getCurrentLevel() {
		
		if ( isset( $_SESSION['admin_logged_in'] ) )
			return NO_OF_LEVELS + 1;
			
		if ( isset( $_SESSION['level'] ) ) {
			return $_SESSION['level'];
		} else {
			// Level hasn't been fetched from the database before.
			$this->db->where( 'user_id', $_SESSION['user_id'] );
			$user = $this->db->getOne( 'user_stats', 'level' );
			
			if ( $this->db->count > 0 ) {
				// Record exists
				$_SESSION['level'] = $user['level'];
				return $user['level'];
			} else {
				// Record doesn't exist - user hasn't started playing yet
				$_SESSION['level'] = 0;
				
				return 0;
			}
		}
		
	}
	
	/*
		Upgrades a user to the specified level
		Returns true if update succeeded, false otherwise
	*/
	public function upgradeLevel( $level ) {
		
		$user = array();
		$user['level'] = $level;
		
		// Check if user record exists
		$this->db->where( 'user_id', $_SESSION['user_id'] );
		$this->db->getOne( 'user_stats' );
		
		if ( $this->db->count > 0 ) {
			// Record exists already - Update		
			$this->db->where( 'user_id', $_SESSION['user_id'] );
			if ( $this->db->update( 'user_stats', $user ) ) {
				$_SESSION['level'] = $level;
				return true;
			}
		} else {
			// Record doesn't exist - create one
			$user['user_id'] = $_SESSION['user_id'];
			if ( $this->db->insert( 'user_stats', $user ) ) {
				$_SESSION['level'] = $level;
				return true;
			}
		}
		
		return false;
		
	}
	
	/*
		Get level ID from the url_mask
	*/
	public function getLevel( $url_mask ) {
		
		$this->db->where( 'url_mask', $url_mask );
		$user = $this->db->getOne( 'questions', 'level' );
		
		if ( $this->db->count > 0 )
			return $user['level'];
		
		return false;
		
	}
	
	/*
		Get URL Mask from level ID
	*/
	public function getURLMask( $level ) {
		
		$this->db->where( 'level', $level );
		$user = $this->db->getOne( 'questions', 'url_mask' );
		
		if ( $this->db->count > 0 )
			return $user['url_mask'];
		
		return false;
		
	}	
	
	/*
		Fetches the question for specicied level from the databse.
		`Answer` is saved to session to save the database cost
		Returns HTML of the question
	*/
	public function getQuestion( $level ) {
		
		$this->db->where( 'level', $level );
		$question = $this->db->getOne( 'questions' );
		
		$_SESSION['answer'] = $question['answer'];
		$_SESSION['attempts'] = 0;
		
		if ( $this->db->count > 0 )	
			return $question;
		
		return false;
		
	}
	
	public function getUserRank( $user_id = null ) {
		
		$user_id = ( $user_id == null ) ? $_SESSION['user_id'] : $user_id;
		
		$query = " 	SELECT 
						a.rank rank
					FROM 
						( SELECT 
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
						) a
					WHERE
						user_id = ?
				;";
		
		$user = $this->db->rawQuery( $query, Array( $user_id ) );
		
		if ( $user )
			return $user[0]['rank'];
			
		return false;
	}
}

?>