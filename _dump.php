<?php
require( $_SERVER['DOCUMENT_ROOT'] . '/ts2/config/consts.php' );
session_start();
echo "<pre>";
var_dump($_SESSION);
var_dump($_COOKIE);
echo "</pre>";

echo '<a href="' . SITE_URL . '_logout.php">RESET</a>';
echo ' | <a href="'. SITE_URL . '_dump.php">REFRESH</a>';
echo ' | <a href="'. SITE_URL . '_test.php">TEST PAGE</a>';
?>