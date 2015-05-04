<?php
	session_start();
	if(!isset($_POST['email']){
		header("location: login.php");
	}
		$DBServer = 'localhost';
	    $DBUser   = 'root';
	    $DBPass   = '321Testing';
	    $DBName   = 'TeamAssignmentApp';

	    $email = $_POST['email'];
	    $password = $_POST['password'];
	    $checkPassword = $_POST['checkPassword'];

	    if ($password != $checkPassword){
			header("location: login.php");
		}

		$password = stripslashes($password);
		$password = mysql_real_escape_string($password);
		$hashedPass = password_hash($password, PASSWORD_BCRYPT);

	    $connection = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
	    $query = mysqli_query($connection,"UPDATE User SET password = '$hashedPass' WHERE email = '$email'");
?>