<?php
require( $_SERVER['DOCUMENT_ROOT'] . '/_treasherlocked/config/consts.php' );
session_start();
echo "<pre>";
var_dump($_SESSION);
var_dump($_COOKIE);
echo "</pre>";

echo '<a href="' . WEB_ROOT . 'logout.php">RESET</a>';
echo ' | <a href="'. WEB_ROOT . '">REFRESH</a>';
?>