<?php
	// session_start();
	// if(!isset($_SESSION['login_user'])){
	// 	header("location: login.php");
	// }
?>

<!doctype html>
<html>
	<head>
		<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/styles.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

        <script>
        	$(document).ready(function(){
        		$("#submitChangedPassword").click(function() {
        			var error = false;
        			$(".changePasswordInput").each(function(i,input){
        				if($(this).val() == "")
        					error = true;
        			});
        			if(!error) {
        				$.post('changePassword.php', {email: $("#email").val(), password: $("#password").val(), checkPassword: $("#confirmPassword").val()}, function() {
        					window.location = "logout.php";
        				});
        			}
        		});
        	});
        </script>
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
					<h3 style="margin-top:0px">Change your password.</h3>
					<div class="input-group" style="margin-bottom:10px">
						<span class="input-group-addon">
							Email
						</span>
						<input class="form-control changePasswordInput" type="text" id="email" name = "email"/>
					</div>
					<div class="input-group" style="margin-bottom:10px">
						<span class="input-group-addon">
							New Password
						</span>
						<input class="form-control changePasswordInput" type="password" id="password"/>
					</div>
					<div class="input-group" style="margin-bottom:10px">
						<span class="input-group-addon">
							Confirm Password
						</span>
						<input class="form-control changePasswordInput" type="password" id="confirmPassword"/>
					</div>
					<p id="changePasswordError" style="display:none; color:red">All fields are required.</p>
					<a class="btn btn-primary btn-sm" id="submitChangedPassword">Submit New Password</a>
				</div>
			</form>
			<div class="col-md-3"></div>
		</div>

	</body>
</html>