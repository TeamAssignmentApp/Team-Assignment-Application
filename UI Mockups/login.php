<?php
	include('loginCheck.php');
	session_start();
	if(isset($_SESSION['login_user'])){
		header("location: selectClass.php");
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
			</div>
		</div>
		<div class="container" style="margin-top:150px">
			<div class="col-md-3"></div>
			<form action = "loginCheck.php" method="post">
				<div class="col-md-6 well">
					<h3 style="margin-top:0px">Please log in.</h3>
					<div class="input-group" style="margin-bottom:10px">
						<span class="input-group-addon">
							Email
						</span>
						<input class="form-control" type="text" name = "email"/>
					</div>
					<div class="input-group" style="margin-bottom:10px">
						<span class="input-group-addon">
							Password
						</span>
						<input class="form-control" type="password" name = "password"/>
					</div>
					<button class="btn btn-primary" style="margin-bottom:10px" name="submit" type="submit">Log in</button>
					<!-- <a href="logout.php" class="btn btn-primary btn-sm" style="margin-bottom:10px" name="submit" type="submit">Forgot your</a> -->


					<p><a href="changepassword.php">Forgot your password?</a></p>
				</div>
			</form>
			<div class="col-md-3"></div>
		</div>
	</body>
</html>
