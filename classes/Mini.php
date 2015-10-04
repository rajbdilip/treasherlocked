<?php
class Mini {

	private $db;

	public function __construct( $db ) {
		$this->db = $db;
	}
	
	/**
		* Get the level a user in
		* Returns level the user in
	*/
	
	public function getTodaysLevel() {
		$diff = floor( ( time() - MINI_START_DATE )/( 24*3600 ) );
		return ++$diff;
	}
	
	public function isLevelAvailable( $level ) {
		
		if ( $level != $this->getTodaysLevel() )
			return false;
		
		$currentTime = date('H')*3600 + date('i')*60 + date('s'); 

		if (  $currentTime < MINI_START_TIME || $currentTime > MINI_END_TIME )
			return false;
		else
			return true;
		
	}
	
	/**
		* Get the question assigned to given level
		& @returns an array containg question's html and its answer
	*/
	public function getQuestion( $level ) {
		$this->db->where( 'level', $level );
		$question = $this->db->getOne( 'mini_questions', 'html, answer' );
		
		$_SESSION['answer'] = $question['answer'];
		
		if ( $this->db->count > 0 )
			return $question['html'];
		
		return false;
	}
	
	public function isAnswered() {
		$this->db->where( 'user_id', $_SESSION['user_id'] )->where( 'level', $this->getTodaysLevel() );
		$this->db->getOne( 'mini_gameplay' );
		
		if ( $this->db->count > 0 ) {
			// User has already answred
			return true;
		} else
			return false;
	}
}

?>