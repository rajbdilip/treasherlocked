<?php
require( 'twitteroauth.php' );

class Twitter
{
	private $connection;
	private $token;
	private $user_profile;
	
	public function __construct( $consumer_key, $consumer_secret, $redirect_uri ) {
		
		if (isset($_SESSION['access_token']) 
			&& isset($_SESSION['access_token']['oauth_token']) 
			&& isset($_SESSION['access_token']['oauth_token_secret'])) {
		
			$access_token = $_SESSION['access_token'];
			$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);		
			
			$this->token = $_SESSION['access_token']['oauth_token'];

		} elseif ( isset($_REQUEST['oauth_verifier'] ) 
			&& isset($_SESSION['oauth_token']) 
			&& isset($_SESSION['oauth_token_secret'])) {			
		
			$connection = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
			$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

			$_SESSION['access_token'] = $access_token;

			unset($_SESSION['oauth_token']);
			unset($_SESSION['oauth_token_secret']);
			
		} else {
			
			$connection = new TwitterOAuth( $consumer_key, $consumer_secret);
			$temp_credentials = $connection->getRequestToken( $redirect_uri );
			
			$_SESSION['oauth_token'] = $this->token = $temp_credentials['oauth_token'];
			$_SESSION['oauth_token_secret'] = $temp_credentials['oauth_token_secret'];
			
		}
		
		$this->connection = $connection;
	}
	
	public function getLoginURL() {
		return $this->connection->getAuthorizeURL( $this->token );
	}
	
	public function IsAuthenticated() {
		
		if (isset($this->user_profile)) {
			return true;
		}
		
		$user_profile = $this->connection->get('account/verify_credentials');
		
		if ($this->connection->http_code == 200) {
			$this->user_profile = $user_profile;
			return true;
		}
		
		return false;
	}
	
	public function getUserProfile() {
		if ($this->IsAuthenticated()) {
			return $this->user_profile;
		}
		
		return null;
	}
}
?>