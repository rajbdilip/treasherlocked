<?php
session_start();

if ( $_POST['password'] ) {
	if ( $_POST['password'] == 'Nevermind!@#' ) {
		$_SESSION['admin_logged'] = true;
		header('Location:' . $_SERVER['PHP_SELF'] );
		exit;
	}
}

if ( $_SESSION['admin_logged'] ) 
?>