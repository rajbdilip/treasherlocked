<?php
/*	This class assumes that 'session_start()' has been called and 'consts.php' included	*/
class LoginHelper {
	
	private $db;
	
	public function __construct( $db = null ) {
		$this->db = $db;
	}
	
	/*
		* Checks if any user is logged in at the moment
		* Verifies and logins the user if `presence` cookie is present
	*/
	public function IsLoggedIn() {
		if ( isset( $_SESSION['logged_in'] ) )
			return true;
		
		// The user might have asked to Remember Him/Her
		if ( isset( $_COOKIE['presence'] ) && isset( $_COOKIE['user'] ) ) {
			
			$presence 	= $this->db->escape( $_COOKIE['presence'] );
			$user_id 	= $this->db->escape( $_COOKIE['user'] );
			
			$this->db->where( 'id', $user_id )->where( 'presence', $presence );
			$user = $this->db->getOne( 'users', 'id' );
			
			if ( $this->db->count > 0 ) {
				$this->Login( $user['id'], OAUTH_DEFAULT, null, true );
			}
			
			return true;
		}
			
		return false;
	}
	
	/* 
		* Check if the user with particular OAUTH id has already logged in before
		* Returns user's ID if true
	*/
	public function IsRegistered( $oauth_type, $oauth_id ) {
		
		$this->db->where( 'oauth_type', $oauth_type )->where( 'oauth_id', $oauth_id );
		$user = $this->db->getOne('users', 'id');
		
		if ($this->db->count > 0)
			return $user['id'];
		
		return false;
		
	}
	
	/* 
		* Checks if a particular email address is already in use
		* Returns an array of corresspoding user's IDs if rue
	*/
	public function IsEmailRegistered( $email ) {

		$this->db->where( 'email', $email )->where( 'verified', '1' );
		$user = $this->db->getOne( 'users', 'id, oauth_type, oauth_id, verified');
		
		if ($this->db->count > 0) {
			return array(
				'id' => $user['id'],
				'oauth_type' => $user['oauth_type'],
				'oauth_id' => $user['oauth_id']
			);
		}
		
		return false;
	}
	
	/*
		* Checks if an username is available for new user to use
		* Returns true if available
	*/
	public function IsUsernameAvailable( $username ) {
		
		$this->db->where( 'username', $username );
		$user = $this->db->getOne( 'users' );
		
		if ($this->db->count > 0)
			return false;
			
		return true;
		
	}
	
	/*
		* Checks if a user has a verfied email address
		* Returns true if the user has a verfied email address
	*/
	public function IsVerified( $user_id ) {
		
		$this->db->where( 'id', $user_id );
		$user = $this->db->getOne( 'users' );		// TBD: Select only required columns
		
		if ( $user )
			return $user['verified'];
		
		return false;
		
	}
	
	/*
		* Feeds session necessary logged in user's parameters
		* This function is called after successfull validation of user credentials
	*/
	public function Login( $user_id, $oauth_type = null, $oauth_id = null, $remember = false ) {
	
		if ( $oauth_type == null && $oauth_id == null ) {
			$this->db->where( 'id', $user_id );
			$user = $this->db->getOne( 'users' );	// TBD: Select only required columns
			
			if ( $user ) {
				$oauth_type = $user['oauth_type'];
				$oauth_id = $user['oauth_id'];
			} else 
				return false;
		}
		
		$_SESSION['logged_in'] = true;
		$_SESSION['user_id'] = $user_id;
		$_SESSION['oauth_type'] = $oauth_type;
		$_SESSION['oauth_id'] = $oauth_id;
		
		// Check if DEFAULT user has asked to remember him/her
		if ( $oauth_type == OAUTH_DEFAULT && $remember ) {
			$this->updatePresence( $user_id );
		}
		
		if ( isset( $_SESSION['redirect_uri'] ) )
			$redirect_uri = $_SESSION['redirect_uri'];
		else
			$redirect_uri = SITE_URL;
		
		unset( $_SESSION['redirect_uri'] );
		return $redirect_uri;
	}
	
	/*
		Applies to OAUTH_DEFAULT users only - Update the `presence` values
	*/
	private function updatePresence( $user_id ) {
		// Generate presence code
		$presence = sha1( time() . chr( mt_rand( 97, 122 ) ) );

		$this->db->where( 'id', $user_id );
		if ( $this->db->update( 'users', array( 'presence' => $presence ) ) ) {
		
			// Set presence cookie
			setcookie( 'user', $user_id, time() + 2*365*24*3600, '/' );
			setcookie( 'presence', $presence, time() + 2*365*24*3600, '/' );
			
			return true;
		}
	}
	
	/*
		* Suppresses any pending registration if user switches to a different OpenID provider
	*/
	public function suppressRegistration( $oauth_type ) {
		
		if ( isset($_SESSION['registration_pending'])  ) {
		
			if ( $oauth_type != $_SESSION['oauth_type'] ) {
				// Suppress Registration
				unset( $_SESSION['registration_pending'] );
				unset( $_SESSION['oauth_type'] );
			} else {
				// !!! Redirect to verify.php
				if ( $oauth_type == OAUTH_FACEBOOK ) {
					$oauth = 'facebook';
				} elseif (  $oauth_type == OAUTH_TWITTER ) {
					$oauth = 'twitter';
				} elseif ( $oauth_type == OAUTH_GOOGLE ) {
					$oauth = 'google';
				}
				
				header('Location: ' . SITE_URL . 'oauth/' . $oauth .'/login.php');
				exit;
			}
			
		}
	}
}

?>