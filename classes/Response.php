<?php
class Response {
	
	private  $response = array();
	
	public function add( $key, $value) {
		$this->response[$key] = $value;
	}
	
	public function success( $suc = true ) {
		$this->add( 'success', $suc );
	}
	
	public function correctAnswer( $correct = true ) {
		$this->add( 'correct', $correct );
	}
	
	public function finished() {
		$this->add( 'finished', true );
	}
	
	public function error( $message ) {
		$this->success( false );
		$this->add( 'error', $message );
	}
	
	public function send() {
		header( 'Content-Type: application/json' );
		echo json_encode( $this->response );
	}
	
	public function send404() {
		header( 'HTTP/1.1 404 Not Found' );
	}
}
?>