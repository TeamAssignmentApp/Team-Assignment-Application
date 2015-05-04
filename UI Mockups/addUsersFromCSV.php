<?php
	session_start();
	if(!isset($_SESSION['login_user'])){
		header("location: login.php");
	}
	if ($_SESSION['isAdmin'] == 0){
		header("location: selectClass.php");
	}
	else if (!isset($_POST['classID'])){
		header("location: AdminDash.php");
	}
    $allowed =  array('csv');
	$filename = $_FILES['csvFile']['name'];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	if(!in_array($ext,$allowed) ) {
	    echo 'error';
	    header("location: selectClass.php");
	}
	$filePath = $_FILES["csvFile"]["tmp_name"];
	$file = fopen($filePath, "r");
	$classID = $_POST['classID'];
	$majorID = $_POST['majorID'];

	//IGNORES FIRST LINE CONTAINING HEADERS
	$userInfo = fgetcsv($file);
	$DBServer = 'localhost';
	$DBUser   = 'root';
	$DBPass   = '321Testing';
	$DBName   = 'TeamAssignmentApp';

	$conn = mysqli_connect($DBServer, $DBUser, $DBPass, $DBName);

	while(! feof($file))
	{
		//Parse CSV file
		$userInfo = fgetcsv($file);
		$fullName = $userInfo[0];
		$email = $userInfo[1];
		$splitName = explode(',', $fullName);
		$lname = $splitName[0];
		$fname = explode(' ', $splitName[1]);
		$fname = $fname[0];
		if (!empty($email)){
	
			$origPassword = strtolower($fname . substr($lname, 0, 1));
	    	$password = password_hash($origPassword, PASSWORD_BCRYPT);
			mysqli_query($conn,"INSERT INTO User (fname, lname, email, password) VALUES ('$fname', '$lname', '$email', '$password')");
	    	$success = mysqli_affected_rows($conn);
	    	if ($success < 1){
	    		$result = mysqli_query($conn,"SELECT userID FROM User WHERE email = '$email'");
	    		$row = mysqli_fetch_assoc($result);
	    		$userID = $row['userID'];
	    	}
	    	else{
		    	$userID = mysqli_insert_id($conn);
		    }
			mysqli_query($conn,"INSERT INTO IsMajor (userID, majorID) VALUES ('$userID', '$majorID')");
			mysqli_query($conn,"INSERT INTO InClass (userID, classID) VALUES ('$userID', '$classID')");
		}
	}
	fclose($file);
	header("location: AdminDash.php");
?>