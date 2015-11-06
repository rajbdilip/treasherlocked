<?php
/*	
	Database Configuratons 
	Requires 'consts.php' to be included
*/
define(	'HOST',		'localhost');
define( 'USERNAME',	'treasher_locked');
define( 'PASSWORD',	'treasherlocked!@#');
define( 'DATABASE',	'treasher_locked');

require( DOCUMENT_ROOT . 'classes/Database.php'	);
$db = new Database( HOST, USERNAME, PASSWORD, DATABASE );
?>