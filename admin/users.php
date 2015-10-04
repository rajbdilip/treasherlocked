<?php
session_start();

if ( !isset( $_SESSION['admin_logged_in'] ) ) {
	header( 'HTTP/1.1 404 Not Found' );
	exit;
}
?>
<html>
<head>
	<title>Treasherlocked Registrations</title>
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
<?php
	require( '../config/consts.php' );
	require( '../config/db.php' );
	
	$con = mysqli_connect( HOST, USERNAME, PASSWORD, DATABASE);
	
	$users = mysqli_query( $con, 'SELECT id, username, email, first_name, middle_name, last_name, gender, institute, location FROM users' );
	
	$count = mysqli_num_rows( $users );
	echo "<div>Registrations count: <strong>$count</strong></div>";
	
	echo "<div><table>";
	echo "<thead><tr>
			<th>ID</th>
			<th>username</th>
			<th>email</th>
			<th>first_name</th>
			<th>last_name</th>
			<th>gender</th>
			<th>institute</th>
			<th>location</th>
		</tr></thead>";
		
	echo "<tbody>";
		
	while ( $user = mysqli_fetch_assoc( $users ) ) {
			
		echo "<tr>";
		foreach ( $user as $key => $value ) {
			
			switch ( $key ) {
				
				case 'gender': {
					$gender = ( $value == 1 ) ? 'male' : 'female';
					echo "<td>$gender</td>";
					break;
				}
				
				default: { echo "<td>$value</td>"; }
			}
		}
		echo "</tr>";
		
	}
	echo "</tbody></table></div>";

?>
</body>
</html>