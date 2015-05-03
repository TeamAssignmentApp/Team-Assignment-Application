<?php
	session_start();
	if(!isset($_SESSION['login_user'])){
		header("location: login.php");
	}
?>




<!doctype html>
<html>
	<head>
		<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/styles.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
            <div class="col-md-12" id="header" style="text-align:center">
				<img src="css/LyleLogo.png" alt="LyleLogo" height="100" width="800">
				<a href="logout.php" class="btn btn-danger" style="display:inline-block; float:right; margin-top:20px">Logout</a>
			</div>
		</div>
		<div class="container" style="margin-top:150px">
			<div class="col-md-3"></div>
			<form action = "loginCheck.php" method="post">
				<div class="col-md-6 well">
					<h3 style="margin-top:0px">Change your password.</h3>
					<div class="input-group" style="margin-bottom:10px">
						<span class="input-group-addon">
							New Password
						</span>
						<input class="form-control" type="password" name = "password"/>
					</div>
					<div class="input-group" style="margin-bottom:10px">
						<span class="input-group-addon">
							Confirm Password
						</span>
						<input class="form-control" type="password" name = "password"/>
					</div>
					<button class="btn btn-primary" style="margin-bottom:10px" name="submit" type="submit">Submit New Password</button>
				</div>
			</form>
			<div class="col-md-3"></div>
		</div>

	</body>
</html>