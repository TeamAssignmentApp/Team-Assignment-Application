<?php
	if(!isset($_SESSION['login_user'])){
    header("location: login.php");
}
if ($_SESSION['isAdmin'] == 0){
    header("location: selectClass.php");
}
else if (!isset($_SESSION['isMaster'])){
    $projectID = $_POST['projectID'];
    $userID = $_POST['userID'];

    $DBServer = 'localhost';
    $DBUser   = 'root';
    $DBPass   = '321Testing';
    $DBName   = 'TeamAssignmentApp';
    $adminID = $_SESSION['login_user'];

    $connection = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
    $query = mysqli_query($connection,"SELECT classID FROM AdminOf JOIN HasProject ON HasProject.classID = AdminOf.classID WHERE AdminOf.userID = '$adminID' AND HasProject.projectID = '$projectID'");
    $numRows = mysqli_num_rows($query);
    
    if ($numRows < 1){
    	mysqli_close($connnection);
        header("location: AdminDash.php");
    }

}
$query = mysqli_query($connection,"DELETE FROM InProject WHERE projectID = '$projectID' AND userID = '$userID'");

mysqli_close($connnection);
?>