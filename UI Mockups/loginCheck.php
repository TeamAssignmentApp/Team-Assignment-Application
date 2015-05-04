<?php
	$error = '';
	if (isset($_POST['submit'])) {
		if (empty($_POST['email']) || empty($_POST['password'])) {
			$error = "Email or Password is invalid";
			header("location: login.php");
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

			$query = mysql_query("select userId, isMaster, password from User where email='$email'", $connection);

			$rows = mysql_num_rows($query);
			if ($rows == 1) {
				$result = mysql_fetch_row($query);
				if (password_verify($password, $result[2])){
					session_start();
					$_SESSION['login_user']=$result[0]; // Initializing Session
					$query2 = mysql_query("select * from AdminOf where userId = '$result[0]'", $connection);
					$rows2 = mysql_num_rows($query2);
					$isAdmin = 0;
					if ($rows2 >=1 || $result[1]==1){
						$isAdmin = 1;
					}
					if ($result[1]==1){
						$_SESSION['isMaster']=1;
					}
					$_SESSION['isAdmin']=$isAdmin;
					header("location: selectClass.php"); // Redirecting To Other Page
				}
				else {
					$error = "Username or Password is invalid";
					echo $error;
				}
			}
			else {
				$error = "No such user";
				echo $error;
				header("location: login.php");
			}
			mysql_close($connection); // Closing Connection
		}
	}
?>