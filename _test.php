<?php

require( 'config/consts.php' );
require( 'config/db.php' );
require( 'classes/LoginHelper.php' );

var_dump($_POST);

$string = "hello...world's first\" program";

echo preg_replace( '/[\s\.\'\",]+/i', '', $string );
echo '<br/>'. sha1( 'raw' );

echo $_SERVER['REQUEST_URI'];





/* NAV */

echo '<br/><br/>';
echo '<a href="'. SITE_URL . '_test.php">REFRESH</a>';
echo ' | <a href="'. SITE_URL . '_dump.php">DUMP PAGE</a>';


?>