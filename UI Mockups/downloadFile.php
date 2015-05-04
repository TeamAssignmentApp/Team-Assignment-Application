<?php

if(!isset($_SESSION['login_user'])){
	header("location: login.php");
}
if ($_SESSION['isAdmin'] == 0){
	header("location: selectClass.php");
}
else if (!isset($_SESSION['isMaster'])){
	$projectID = $_POST['projectID'];
	$DBServer = 'localhost';
	$DBUser   = 'root';
	$DBPass   = '321Testing';
	$DBName   = 'TeamAssignmentApp';
	$userID = $_SESSION['login_user'];

	$connection = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
	$query = mysqli_query($connection,"SELECT classID FROM AdminOf JOIN HasProject ON HasProject.classID = AdminOf.classID WHERE AdminOf.userID = '$userID' AND HasProject.projectID = '$projectID'");
	$numRows = mysqli_num_rows($query);
	mysqli_close($connnection);
	if ($numRows < 1){
		header("location: AdminDash.php");
	}

}

$projectID = $_POST['projectID'];
$DBServer = 'localhost';
$DBUser   = 'root';
$DBPass   = '321Testing';
$DBName   = 'TeamAssignmentApp';

$connection = new mysqli($DBServer, $DBUser, $DBPass, $DBName);

mysqli_query($connection,"SELECT fileLink FROM Project WHERE projectID = '$projectID'");
$row = mysqli_fetch_row($query);
if (!empty($row[0])){
    header('Content-Disposition: attachment; filename=' . basename($row[0]));
    readfile($row[0]);
}
mysqli_close($connnection);
?>