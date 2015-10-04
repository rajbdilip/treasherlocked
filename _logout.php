<?php
	session_start();
	session_destroy();
	header("Location: _dump.php"); //OR navigate to the PROFILE page
?>