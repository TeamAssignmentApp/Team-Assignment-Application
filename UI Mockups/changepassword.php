<?php
	if (!isset($_POST['email'])){
		header("location: login.php");
	}
	
	$connection = mysql_connect("localhost", "root", "321Testing");
	$db = mysql_select_db("TeamAssignmentApp", $connection);

	$email = $_POST['email'];
	$password = $_POST['password'];
	$checkPassword = $_POST['checkPassword'];

	$email = stripslashes($email);
	$password = stripslashes($password);
	$email = mysql_real_escape_string($email);
	$password = mysql_real_escape_string($password);
	$checkPassword = stripslashes($checkPassword);
	$checkPassword = mysql_real_escape_string($checkPassword);

	$query = mysql_query($connection, "SELECT email FROM User WHERE (email = '$email' AND isMaster = 1) OR email IN (SELECT email FROM User JOIN AdminOf ON AdminOf.userID = User.userID WHERE User.email = '$email')");

	$rows = mysql_num_rows($query);

	if ($rows > 0){
		mysql_close($connection);
		header("location: login.php");
	}
	else if (strcmp($password,$checkPassword)==0){
		$hashedPass = password_hash($password, PASSWORD_BCRYPT);
		$insertQuery = mysql_query("UPDATE User SET password='$hashedPass' WHERE email='$email'");
		$check = mysql_affected_rows($connection);
		echo "UPDATE User SET password='$hashedPass' WHERE email='$email'||| ROWS: " . $check;
	}
	mysql_close($connection);

?>