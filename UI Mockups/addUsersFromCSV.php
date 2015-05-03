<?php
	session_start();
	if(!isset($_SESSION['login_user'])){
		header("location: login.php");
	}
	if ($_SESSION['isAdmin'] == 0){
		header("location: selectClass.php");
	}
	else if (!isset($_GET['classID'])){
		header("location: AdminDash.php");
	}
	$target_dir = "csv/";
	$target_file = $target_dir . basename($_FILES["csvFile"]["name"]);
	$uploadOk = 1;
	//if(isset($_POST["submit"])) {
	if (isset($_GET['classID'])){
	    $file = fopen($_FILES["csvFile"]["tmp_name"]);
	}

	//REMOVE FILENAME LATER
	//$csvFile = $_GET['fileName'];
	$classID = $_GET['classID'];
	$majorID = $_GET['majorID'];
/*
	if (!isset($_SESSION['isMaster'])){
		$connection = mysql_connect("localhost", "root", "321Testing");
		$db = mysql_select_db("TeamAssignmentApp", $connection);
		$user = $_SESSION['login_user'];
		$query = mysql_query("SELECT * FROM AdminOf WHERE userID = '$user' AND classID = '$classID'");
		$rows = mysql_num_rows($query);
		if ($rows < 1){
			mysql_close($connection);
			header("location: AdminDash.php");
		}
		mysql_close($connection);
	}*/
	$file = fopen($csvFile,"r");
	//IGNORES FIRST LINE CONTAINING HEADERS
	$userInfo = fgetcsv($file);
	$DBServer = 'localhost';
	$DBUser   = 'root';
	$DBPass   = '321Testing';
	$DBName   = 'TeamAssignmentApp';

	$conn = mysqli_connect($DBServer, $DBUser, $DBPass, $DBName);

	while(! feof($file))
	{
		$userInfo = fgetcsv($file);
		$fullName = $userInfo[0];
		$email = $userInfo[1];
		$splitName = explode(',', $fullName);
		$lname = $splitName[0];
		$fname = explode(' ', $splitName[1]);
		$fname = $fname[0];
		echo print_r($userInfo);
		
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$passLength = 8;
    	$password = substr( str_shuffle( $chars ), 0, $passLength);
    	$password = password_hash($password, PASSWORD_BCRYPT);
    	mysqli_query($conn,"INSERT INTO User (fname, lname, email, password) VALUES ('$fname', '$lname', '$email', '$password')");
    	$userID = mysqli_insert_id($conn);
		mysqli_query($conn,"INSERT INTO IsMajor (userID, majorID) VALUES ('$userID', '$majorID')");
		mysqli_query($conn,"INSERT INTO InClass (userID, classID) VALUES ('$userID', '$classID')");
		//$splitName = explode(',', $fullName);

	}
	fclose($file);
?>