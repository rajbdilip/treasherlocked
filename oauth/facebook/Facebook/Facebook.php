<?php
$path = DOCUMENT_ROOT . 'oauth/facebook/Facebook' . '/';

require_once( $path . 'FacebookSession.php' );
require_once( $path . 'FacebookRedirectLoginHelper.php' );
require_once( $path . 'FacebookRequest.php' );
require_once( $path . 'FacebookResponse.php' );
require_once( $path . 'FacebookSDKException.php' );
require_once( $path . 'FacebookRequestException.php' );
require_once( $path . 'FacebookPermissionException.php' );
require_once( $path . 'FacebookOtherException.php' );
require_once( $path . 'FacebookAuthorizationException.php' );
require_once( $path . 'GraphObject.php' );
require_once( $path . 'GraphSessionInfo.php' );
require_once( $path . 'HttpClients/FacebookHttpable.php' );
require_once( $path . 'HttpClients/FacebookCurl.php' );
require_once( $path . 'HttpClients/FacebookCurlHttpClient.php' );

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookPermissionException;
use Facebook\FacebookOtherException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphSessionInfo;
use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurl;
use Facebook\HttpClients\FacebookCurlHttpClient;

class Facebook {

	private $session;
	private $loginHelper;
	private $redirectURI;
	
	public $requested_scopes;
	public $granted_scopes;
	public $denied_scopes;
	
	public function __construct( $app_id, $app_secret, $redirectURI ) {
		FacebookSession::setDefaultApplication( $app_id, $app_secret );
		$this->loginHelper = new FacebookRedirectLoginHelper($redirectURI);
		
		// see if a existing session exists
		if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) {
			$session = new FacebookSession( $_SESSION['fb_token'] ); // create new session from saved access_token
			
			// validate the access_token to make sure it's still valid
			try {
				if ( !$session->validate() ) {
					$session = null;
				}
			} catch ( Exception $e ) {
				$session = null;
			}

		} else {	// no session exists
			try {
				$session = $this->loginHelper->getSessionFromRedirect();
			} catch( FacebookRequestException $ex ) {
				$session = null;
				var_dump( $ex );
			} catch( Exception $ex ) {
				$session = null;
				var_dump( $ex );
			}
		}
		
		// see if we have a session
		if (isset($session)) {
			$_SESSION['fb_token'] = $session->getToken();	// Save the token
			$session = new FacebookSession($session->getToken()); // create a session using saved token or the new one we generated at login
		} else {
			$session = null;
		}
		
		$this->session = $session;
	}
	
	public function setScopes( $scopes ) {
		$this->requested_scopes = $scopes;
	}
	
	// Verify if user has granted all the requested access
	public function verifyScopes( $scopes ) {
		$permissions = $this->get( '/me/permissions' );

		$grants = array();	// 	Granted permissions
		$denies = array();	//	Denied permissions
		foreach ($permissions as $permission) {
			if ($permission->status == 'granted')
				$grants[$permission->permission] = true;
		}

		foreach ($scopes as $scope) {
			if (!isset($grants[$scope])) {
				array_push($denies, $scope);
				$denied = true;
			}
		}
		
		$this->denied_scopes = $denies;
		$this->granted_scopes = $grants;
		
		if (isset($denied)) {
			return false;
		} else {
			return true;
		}
	}
	
	public function getSession() {
		return $this->session;
	}	
		
	public function IsAuthenticated() {
		if ($this->session == null) {
			return false;
		}
		return true;
	}
	
	public function get( $url ) {
		$request = new FacebookRequest( $this->session, 'GET', $url );
		$response = $request->execute();

		return $response->getGraphObject()->asArray();
	}
	
	public function getLoginURL( $scopes = null, $rerequest = false ) {
		if (!isset($scopes))
			$scopes = $this->requested_scopes;
			
		return $this->loginHelper->getLoginUrl( $scopes, $rerequest );
	}
	
	public function getUserProfile() {
		return $this->get( '/me' );
	}
}
?>