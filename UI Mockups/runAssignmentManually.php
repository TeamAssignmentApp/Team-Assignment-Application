<?php
	$connection = mysql_connect("localhost", "root", "321Testing");
	$db = mysql_select_db("TeamAssignmentApp", $connection);
	//STEP 1: GET CLASS ID OF CLASS THAT IS RUNNING ASSIGNMENT
	$classID = 1; //CHANGE THIS LATER
	echo $classID + '/n';

	$scoreArray = array();
	$userValues = array();

	// STEP 2: For each user in the specified class, obtain the IDs of the 
	$query = mysql_query("select User.userID, WantsProject.projectID, WantsProject.rank FROM User JOIN WantsProject ON User.userID = WantsProject.userID'", $connection);
	while ($row = mysql_fetch_row($query)) {
		$userValues[$row[1]] = $row2;
		$scoreArray[$row[0]] = $userValues;
	}
	//first check classes to determine 



?>