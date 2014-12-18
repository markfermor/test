<!DOCTYPE html>
<html>
<body>

	<?php
		// Get access to MySQL Class
		require_once(dirname(__FILE__).'/MySQL.class.php');

		// Get MySQL connection
		$conn = new MySQL('127.0.0.1','peoplecolour','root','ilovetocode');

		// Get Rows of people
		$query = 'select personid,firstname,lastname,email,dob from people2';
		$rows = $conn->getRows($query);

		// Get each persons Fav colours - Should be a function or a class to get colours..?
		foreach ($rows as $key => $value) {
			$query = "SELECT colour 
FROM colours AS t1 JOIN fav_colours AS t2 ON t1.colourid = t2.colourid
WHERE personid = ".$value['personid'];
			$colours = $conn->getRows($query);
			$rows[$key]['fav_colours'] = implode(', ', array_map(function ($entry) {
  				return $entry['colour'];
			}, $colours));
		}
		//print "<pre>";
		//print_r($rows);
		//print "</pre>";
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