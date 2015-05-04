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

	    $query = mysqli_query($connection,"SELECT email FROM User WHERE (email = '$email' AND isMaster = 1) OR email in (SELECT email FROM User join AdminOf ON AdminOf.userID = User.userID WHERE User.email = '$email')");
	    if (mysqli_num_rows($query) > 0 || $password != $checkPassword){
			header("location: login.php");
		}

		$password = stripslashes($password);
		$password = mysql_real_escape_string($password);
		$hashedPass = password_hash($password, PASSWORD_BCRYPT);

	    $connection = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
	    $query = mysqli_query($connection,"UPDATE User SET password = '$hashedPass' WHERE email = '$email'");
?>