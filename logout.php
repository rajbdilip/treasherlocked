<?php
session_start();
session_destroy();

// Clear presence cookies
setcookie( 'user', '', time() - 3600, '/' );
setcookie( 'presence', '', time() - 3600, '/' );

header( 'Location: /' );
exit;
?>