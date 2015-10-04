<?php
require_once( DOCUMENT_ROOT . 'oauth/google/Google/Client.php' );
require_once( DOCUMENT_ROOT . 'oauth/google/Google/Service/Oauth2.php' );

class Google {
	
	private $client;
	
	public function __construct( $appName, $clientID, $clientSecret, $scopes, $redirectURI ) {
		$client = new Google_Client();
		$client->setApplicationName( $appName );
		$client->setClientId( $clientID );
		$client->setClientSecret( $clientSecret );
		$client->setScopes( $scopes );	
		$client->setRedirectUri( $redirectURI );
		
		// Check for access token
		if (isset($_SESSION['access_token']) && $_SESSION['access_token'])
			$client->setAccessToken($_SESSION['access_token']);
		
		$this->client = $client;
	}
	
	public function authenticate( $code ) {
		$this->client->authenticate( $code );
	}
	
	public function getAccessToken() {
		return $this->client->getAccessToken();
	}
	
	public function IsAuthenticated() {
		if($this->client->isAccessTokenExpired()) {
			header( "Location: ". $this->getLoginURL() );
			exit;
		} else {
			return true;
		}
	}
	
	public function getLoginURL() {
		return $this->client->createAuthUrl();
	}
	
	public function getUserProfile() {
		$plus = new Google_Service_Oauth2($this->client);
		$userinfo = $plus->userinfo;
		
		return $userinfo->get();	
	}
}

?>