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
                <h1>SMU Lyle Multidisciplinary Senior Design</h1>
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
						<input class="form-control" type="text" name = "email"/>
					</div>
					<div class="input-group" style="margin-bottom:10px">
						<span class="input-group-addon">
							Confirm Password
						</span>
						<input class="form-control" type="password" name = "password"/>
					</div>
				</div>
			</form>
			<div class="col-md-3"></div>
		</div>

	</body>
</html>