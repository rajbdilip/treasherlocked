<?php
class Registrar {
	
	private $db;
	
	public function __construct( $db = null ) {
		$this->db = $db;
	}
	
	public function getHTML() {
		require( DOCUMENT_ROOT . 'includes/html/login/add_reg_info.php' );
	}
	
	public function registerTempUser( $tempUser ) {
		
		if ( array_key_exists( 'email', $tempUser ) ) {
			// Check if the email already exists in `users_temp`
			$this->db->where( 'email', $tempUser['email'] );
			$existingUser = $this->db->getOne( 'users_temp', 'id' );

			if ( $this->db->count > 0 ) {
				// Email already exists - update the existing record
				$this->db->where( 'id', $existingUser['id'] );
				unset($tempUser['email']);
				
				if ( $this->db->update( 'users_temp', $tempUser ) ) 
					$id = $existingUser['id'];
				else
					$id = false;
			} else {
				//  Email doesn't exist - create a new record
				$id = $this->db->insert( 'users_temp', $tempUser );
			}
		} else {
			$id = $this->db->insert( 'users_temp', $tempUser );
		}

		if ($id) {
			$_SESSION['registration_pending'] = true;
			$_SESSION['temp_user_id'] = $id;
			$_SESSION['oauth_type'] = $tempUser['oauth_type'];
			return true;
		}
		
		return false;
		
	}
	
	public function registerUser( $user ) {

		$id = $this->db->insert( 'users', $user );
		
		if ($id) {
			if (isset($_SESSION['location_received']))
				unset($_SESSION['location_received']);

			return $id;
		}
		else
			return false;
	}
	
	private function setAuthCode( $id ) {
		$auth_code = sha1( time() . chr( mt_rand( 97, 122 ) ) );
		$this->db->where( 'id', $id );
		
		if ( $this->db->update( 'users', array( 'auth_code' => $auth_code ) ) )
			return $auth_code;
		return false;
	}
	
	public function sendVerificationEmail( $id, $email ) {
	
		if ( $auth_code = $this->setAuthCode( $id ) ) {
			
			$message = '<!DOCTYPE HTML>'. 
				'<head>'. 
				'<meta http-equiv="content-type" content="text/html">'. 
				'<title>Email notification</title>'. 
				'</head>'. 
				'<body style="background-color: #f3f5f8;">'. 

				'<div id="outer" style="width: 80%;margin: 0 auto; margin-top: 10px; padding: 15px 10px; ">'.  
				   '<div id="inner" style="width: 78%; margin: 0 auto; font-family: Calibri, Open Sans,Arial,sans-serif;font-size: 15px;font-weight: normal;line-height: 1.4em;color: #5f6061; margin-top: 10px;">'. 
					   '<p><h2>Congratulations!</h2></p>'. 
					   '<p>Congratulations on signing up for Treasherlocked 2.0. Please click the link below or copy to your browser\'s address bar in order to complete the registration.</p>'. 
					   '<p><a href="http://localhost/ts2/verify.php?id=' . $id . '&auth_code=' . $auth_code . '">http://localhost/ts2/verify.php?id=' . $id .'&auth_code=' . $auth_code . '</a></p>'. 
					   '<p>Please contact us via <a href="https://www.facebook.com/Treasherlocked">Facebook</a> or drop us a mail at <a href="mailto:support@microsoftcampusclub.in">support@microsoftcampusclub.in</a> on persistence of any problem.</p>'.  
				   '</div>'.
				'</div>'. 

				'<div id="footer" style="font-family: Calibri, Open Sans,Arial,sans-serif;font-size: 14px; color: #fff; width: 80%;height: 40px;margin: 0 auto;text-align: center;padding: 10px; background-color: #16a085;">'. 
				   '2013 - 2014 &copy; <a style="color: #fff;" href="http://www.microsoftcampusclub.in">Microsoft Campus Club</a> (based in <a style="color: #fff;" href="http://nitrkl.ac.in">National Institute of Technology Rourkela</a>)'. 
				'</div>'. 
				'</body>';   

			$to      = $email;
			$subject = 'Treasherlocked 2.0 Email Verification'; 
			$from    = 'do-not-reply@treasherlocked.in';

			$headers  = "From: " . $from . "\r\n"; 
			$headers .= "MIME-Version: 1.0\r\n"; 
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 

			if( !mail( $to, $subject, $message, $headers) ) { 
				return false;
			}
		}
		
		return true;
	}
	
	/*
		* Prepares a user for a password reset
	*/
	public function sendResetEmail( $id, $email ) {
		
		if ( $auth_code = $this->setAuthCode( $id ) ) {
			
			$message = '<!DOCTYPE HTML>'. 
				'<head>'. 
				'<meta http-equiv="content-type" content="text/html">'. 
				'<title>Email notification</title>'. 
				'</head>'. 
				'<body style="background-color: #f3f5f8;">'. 

				'<div id="outer" style="width: 80%;margin: 0 auto;margin-top: 10px;">'.  
				   '<div id="inner" style="width: 78%; margin: 0 auto; font-family: Calibri, Open Sans,Arial,sans-serif;font-size: 13px;font-weight: normal;line-height: 1.4em;color: #5f6061; margin-top: 10px;">'. 
					   '<p><h2>How to reset your password</h2></p>'. 
					   '<p>We have recieved a request from you to reset your password. Please click the link below or copy it to your browser\'s address bar in order to reset the password.</p>'. 
					   '<p><a href="http://localhost/ts2/forgot-password/reset/?id=' . $id . '&auth_code=' . $auth_code . '">http://localhost/ts2/forgot-password/reset/?id=' . $id .'&auth_code=' . $auth_code . '</a></p>'. 
					   '<p>Please contact us via <a href="https://www.facebook.com/Treasherlocked">Facebook</a> or drop us a mail at <a href="mailto:support@microsoftcampusclub.in">support@microsoftcampusclub.in</a> on persistence of any problem.</p>'.  
					   '<p>If you didn\'t reqeust us to reset your password please ignore this email.</p>'.  
				   '</div>'.
				'</div>'. 

				'<div id="footer" style="font-family: Calibri, Open Sans,Arial,sans-serif;font-size: 14px; color: #fff; width: 80%;height: 40px;margin: 0 auto;text-align: center;padding: 10px; background-color: #16a085;">'. 
				   '2013 - 2014 &copy; <a style="color: #fff;" href="http://www.microsoftcampusclub.in">Microsoft Campus Club</a> (based in <a style="color: #fff;" href="http://nitrkl.ac.in">National Institute of Technology Rourkela</a>)'. 
				'</div>'. 
				'</body>'; 

			$to      = $email;
			$subject = 'Treasherlocked 2.0 Email Verification'; 
			$from    = 'do-not-reply@treasherlocked.in';

			$headers  = "From: " . $from . "\r\n"; 
			$headers .= "MIME-Version: 1.0\r\n"; 
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 

			if( !mail( $to, $subject, $message, $headers) ) { 
				return false;
			}
		}
		
		return true;
	}
}
?>