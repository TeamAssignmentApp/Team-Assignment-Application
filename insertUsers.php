<?php 
//USE THIS FILE TO MAKE THE MASTER ADMIN
$hashedPass = password_hash("321Testing", PASSWORD_BCRYPT);
$connection = mysql_connect("localhost", "root", "321Testing");
$db = mysql_select_db("TeamAssignmentApp", $connection);
$query = mysql_query("INSERT INTO User (email, fname, lname, password, isMaster) VALUES ('adamn@smu.edu', 'Adam', 'Nelson', '$hashedPass', 1)", $connection);

mysql_close($connection);
?>