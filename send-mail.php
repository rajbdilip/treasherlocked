<?php
require( 'config/consts.php' );
require( 'config/db.php' );

$message = '<!DOCTYPE HTML>'. 
	'<head>'. 
	'<meta http-equiv="content-type" content="text/html">'. 
	'<title>Treasherlocked has started</title>'. 
	'</head>'. 
	'<body style="background-color: #f3f5f8;">'. 

	'<div id="outer" style="width: 80%;margin: 0 auto; margin-top: 10px; padding: 15px 10px; ">'.  
	   '<div id="inner" style="width: 78%; margin: 0 auto; font-family: Calibri, Open Sans,Arial,sans-serif;font-size: 15px;font-weight: normal;line-height: 1.4em;color: #5f6061; margin-top: 10px;">'. 
			'<p><h2>Urgent Notice!</p>'. 
			'<p>We have been monitoring activities of all the users playing 10Kya.com Treasherlocked 2.0. It is very unfortunate that we are noticing some unfair means of play form some of the players. We would like to inform you that if such activities persists, players with unfair means of play shall be banned from the event website without any prior notice and with no explanation whatsoever.</p>'.
			'<p>We kindly request all the players to play fair.</p>'.
			'<p>&nbsp;</p>'.
			'<p>Regards,<br/>Team Treasherlocked</p>'.
	   '</div>'.
	'</div>'. 

	'<div id="footer" style="font-family: Calibri, Open Sans,Arial,sans-serif;font-size: 14px; color: #fff; width: 80%;height: 40px;margin: 0 auto;text-align: center;padding: 10px; background-color: #16a085;">'. 
	   '2013 - 2014 &copy; <a style="color: #fff;" href="http://www.microsoftcampusclub.in">Microsoft Campus Club</a> (based in <a style="color: #fff;" href="http://nitrkl.ac.in">National Institute of Technology Rourkela</a>)'. 
	'</div>'. 
	'</body>'; 

$con = mysqli_connect( HOST, USERNAME, PASSWORD, DATABASE );
$users = mysqli_query( $con, 'SELECT email FROM users' );


$to = 'rajb.dilip@gmail.com';
$subject = 'Urgent Notice!!!'; 
$from    = 'do-not-reply@treasherlocked.com';

$headers  = "From: " . $from . "\r\n"; 
$headers .= "MIME-Version: 1.0\r\n"; 
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 

var_dump( mail( $to, $subject, $message, $headers) ); exit;
foreach( $users as $user ) {
	$to =  $user['email'];
	
	if( mail( $to, $subject, $message, $headers) ) { 
		echo 'email ' . $to . ' done.<br/>';
		ob_flush();
		flush();
	}
}

?>