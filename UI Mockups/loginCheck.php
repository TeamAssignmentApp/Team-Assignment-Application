<?php
	$error = '';
	if (isset($_POST['submit'])) {
		if (empty($_POST['email']) || empty($_POST['password'])) {
			$error = "Email or Password is invalid";
		}
		else
		{

			$email=$_POST['email'];
			$password=$_POST['password'];

			$connection = mysql_connect("localhost", "root", "321Testing");


			$email = stripslashes($email);
			$password = stripslashes($password);
			$email = mysql_real_escape_string($email);
			$password = mysql_real_escape_string($password);

			$db = mysql_select_db("TeamAssignmentApp", $connection);

			$query = mysql_query("select userId, isAdmin from User where password='$password' AND email='$email'", $connection);
			$rows = mysql_num_rows($query);
			if ($rows == 1) {
				$result = mysql_fetch_row($query);
				echo $result;
				session_start();
				echo $result[0];
				echo '/n';
				echo $result[1];
				$_SESSION['login_user']=$result[0]; // Initializing Session
				$_SESSION['isAdmin']=$result[1];
				//header("location: selectClass.php"); // Redirecting To Other Page
			}
			else {
				$error = "Username or Password is invalid";
				echo $error;
			}
			mysql_close($connection); // Closing Connection
		}
	}
?>