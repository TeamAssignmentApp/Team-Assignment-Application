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
$query = mysqli_query($connection,"SELECT projectName FROM Project WHERE projectID = '$projectID'");
$row = mysqli_fetch_row($query);


$target_dir = "uploads/" . $row[0] . "/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //Success, connect to DB and update fileLink.
        $query = mysqli_query($connection,"UPDATE Project SET fileLink = '$target_file' WHERE projectID = '$projectID'");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
    mysqli_close($connnection);

?>