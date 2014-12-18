<!DOCTYPE html>
<html>
<body>

	<?php
		// Get access to MySQL Class
		require_once(dirname(__FILE__).'/MySQL.class.php');

		// Get MySQL connection
		$conn = new MySQL('127.0.0.1','peoplecolour','root','ilovetocode');

		// Get Rows
		$query = 'select firstname,lastname,email,dob,fav_colours from people';
		$rows = $conn->getRows($query);
		/**
		print "<pre>";
		print_r($rows);
		print "</pre>";
		**/
	?>

	<!-- Create our Table -->
	<table border="0" cellspacing="2" cellpadding="2">
	<tr>
	<td>
	<font face="Arial, Helvetica, sans-serif">First Name</font>
	</td>
	<td>
	<font face="Arial, Helvetica, sans-serif">Last Name</font>
	</td>
	<td>
	<font face="Arial, Helvetica, sans-serif">Email</font>
	</td>
	<td>
	<font face="Arial, Helvetica, sans-serif">Date of Birth</font>
	</td>
	<td>
	<font face="Arial, Helvetica, sans-serif">Favourite Colours</font>
	</td>
	</tr>
	<?php
		foreach ($rows as $value) {
			echo "<tr><td>".$value['firstname']."</td><td>".$value['lastname']."</td><td>".$value['email']."</td><td>".$value['dob']."</td><td>".$value['fav_colours']."</td></tr>";
		}
	?>
	</table>
</body>
</html>