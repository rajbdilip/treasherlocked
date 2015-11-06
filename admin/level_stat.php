<?php
session_start();

if ( !isset( $_SESSION['admin_logged_in'] ) ) {
	header( 'HTTP/1.1 404 Not Found' );
	exit;
}

if ( ! isset( $_GET['level'] ) ) {
?>
<html>
<head>
	<title>Level Stat</title>
</head>
<body>
	<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<input type="text" name="level"  placeholder="Level" />
	</form>
</body>
</html>
<?php
	exit;
}

$level = $_GET['level'];
?>
<html>
<head>
	<title>Level Stat</title>
	<style>
		table {
			width: 100%;
			border-collapse: collapse;
			letter-spacing: 1px;
			border-radius: 5px;
		}

		table tbody tr:nth-child(even) {
			background: #b5f2d8;
		}

		table thead tr {
			background: #16a085;
			color: #fff;
			border-radius: 10px;
		}

		table thead tr th {
			font-weight: 600;
			padding: 6px 0;
			margin-bottom: 10px;
		}

		table td {
			padding: 4px 0;
		}

	</style>
<body>
	<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<input type="text" name="level" value="<?php echo $level; ?>"  placeholder="Level" />
	</form>
<?php
	require( '../config/consts.php' );
	require( '../config/db.php' );
	
	$con = mysqli_connect( HOST, USERNAME, PASSWORD, DATABASE);
	
	$users = mysqli_query( $con, 'SELECT t1.user_id, t2.username, t2.first_name, t2.last_name, t2.institute, t1.clear_time, t1.attempts FROM gameplay t1 INNER JOIN users t2 ON t1.user_id = t2.id WHERE t1.level = ' . $level . ' ORDER BY clear_time ASC' ) or die( mysqli_error( $con ) );
	
	echo "<div><table>";
	echo "<thead><tr>
			<th>ID</th>
			<th>username</th>
			<th>first_name</th>
			<th>last_name</th>
			<th>institute</th>
			<th>clear_time</th>
			<th>attempts</th>
		</tr></thead>";
		
	echo "<tbody>";
		
	while ( $user = mysqli_fetch_assoc( $users ) ) {
			
		echo "<tr>";
		foreach ( $user as $key => $value ) {
			echo "<td>$value</td>";
		}
		echo "</tr>";
		
	}
	echo "</tbody></table></div>";

?>
</body>
</html>