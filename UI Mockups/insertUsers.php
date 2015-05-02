<?php 
	$connection = mysql_connect("localhost", "root", "321Testing");
	$db = mysql_select_db("TeamAssignmentApp", $connection);
	$pass = "password";
	$hashedPass = password_hash($pass, PASSWORD_BCRYPT);
	echo $hashedPass;
	$query = mysql_query("INSERT INTO User (email, fname, lname, password, isMaster) VALUES ('jtigues@gmail.com', 'Jeffrey', 'Artigues', '$hashedPass', 1)", $connection);
	$query = mysql_query("INSERT INTO User (email, fname, lname, password, isMaster) VALUES ('joeschmoe@gmail.com', 'Joe', 'Schmoe', '$hashedPass', 0)", $connection);
	$query = mysql_query("INSERT INTO User (email, fname, lname, password, isMaster) VALUES ('jsmith@gmail.com', 'John', 'Smith', '$hashedPass', 0)", $connection);
	$query = mysql_query("INSERT INTO User (email, fname, lname, password, isMaster) VALUES ('adamn@gmail.com', 'Adam', 'N', '$hashedPass', 0)", $connection);
	mysql_close($connection);
?>