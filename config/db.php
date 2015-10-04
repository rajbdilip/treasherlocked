<?php
/*	
	Database Configuratons 
	Requires 'consts.php' to be included
*/
define(	'HOST',		'localhost');
define( 'USERNAME',	'treasherlocked');
define( 'PASSWORD',	'treasherlocked');
define( 'DATABASE',	'treasherlocked');

require( DOCUMENT_ROOT . 'classes/Database.php'	);
$db = new Database( HOST, USERNAME, PASSWORD, DATABASE );
?>