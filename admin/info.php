<?php
session_start();

if ( !isset( $_SESSION['admin_logged_in'] ) ) {
	echo "Not Authorized";
	//header( 'HTTP/1.1 404 Not Found' );
	exit;
}
?>
<html>
<head><title>User Info</title></head>
<body>
	
	<div>
		<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="text" name="u" width="50" placeholder="Username" />
			<input type="submit" value="Get Info" />
		</form>
	</div>
	
	<?php
	if ( isset( $_GET['u'] ) ) {
			
			require( '../config/consts.php' );
			require( '../config/db.php' );
			
			$username = $db->escape( $_GET['u'] );
			$db->where( 'LCASE(username)', $username );
			$user = $db->getOne( 'users' );
			
			if ( $user ) {
				echo "<div><table>";
				
				foreach ( $user as $key => $value ) {
					echo "<tr><td>$key : </td><td>$value</td></tr>";
				}
				
				echo "</table></div>";
			}	
		}
	?>
</body>
</html>
