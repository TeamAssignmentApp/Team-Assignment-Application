<?php 
$hashedPass = password_hash("password", PASSWORD_BCRYPT);
$connection = mysql_connect("localhost", "root", "321Testing");
$db = mysql_select_db("TeamAssignmentApp", $connection);
$query = mysql_query("INSERT INTO User (email, fname, lname, password, isMaster) VALUES ('jtigues@gmail.com', 'Jeffrey', 'Artigues', '$hashedPass', 1)", $connection);

mysql_close($connection);