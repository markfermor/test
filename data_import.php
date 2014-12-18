<?php
	// Get access to MySQL Class
	require_once(dirname(__FILE__).'/MySQL.class.php');

	// Get MySQL connection
	$conn = new MySQL('127.0.0.1','peoplecolour','root','ilovetocode');

	// Contents of file - should be better than array i presume and less memory?
	$handle = fopen("users.csv", "r");
	if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
        $table_field = array('email','lastname','firstname','fav_colours','dob');
		$values = str_getcsv($line);
		$values[4] = str_replace('/', "-", $values[4]);
		$time = strtotime($values[4]);
        $values[4] = date('Y-m-d',$time);

		var_dump($values);
        $conn->insert('people',$table_field,$values);
    }
	} else {
    	// error opening the file.
    	die('error opening file');
	} 
	fclose($handle);




?>