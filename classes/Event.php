<?php
class Event {
	
	private $event_status;
	
	public function __construct() {
		$current_time = time();
		
		if ( $current_time < EVENT_START )
			$this->event_status = EVENT_NOT_STARTED;
		else if ( $current_time >= EVENT_START && $current_time < EVENT_END)
			$this->event_status = EVENT_STARTED;
		else
			$this->event_status = EVENT_CLOSED;
	}
	
	public function get_event_status() {
		return $this->event_status;
	}
	
}
?>