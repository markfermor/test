<?php
	// Get access to MySQL Class
	require_once(dirname(__FILE__).'/MySQL.class.php');

	// Get MySQL connection
	$conn = new MySQL('127.0.0.1','peoplecolour','root','ilovetocode');

	// Contents of file - should be better than array i presume and less memory?
	$handle = fopen("users.csv", "r");
	if ($handle) {
	//read file line by line
    while (($line = fgets($handle)) !== false) {
        // set the column headings
        $table_field = array('email','lastname','firstname','fav_colours','dob');
        // Will nice get data correctly and encapsulate the strings in quotes
		$values = str_getcsv($line);
		// To make the DOB a european date
		$values[4] = str_replace('/', "-", $values[4]);
		$time = strtotime($values[4]);
		// Get the date into the correct format for insert to MySQL
        $values[4] = date('Y-m-d',$time);

        // Insert the data
        $conn->insert('people',$table_field,$values);
    }
	} else {
    	// error opening the file.
    	die('error opening file');
	} 
	fclose($handle);

?>