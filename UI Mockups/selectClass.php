<?php
	if(!isset($_SESSION['login_user'])){
		header("location: login.php");
	}
?>


<!doctype html>
<html>
	<head>
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
			<div class="col-md-6 well">
				<h3 style="margin-top:0px">Select a class...</h3>
				<div class="input-group">
					<span class="input-group-addon">Class</span>
					<select class="form-control">
						<?php
							$userId = $_SESSION['login_user'];
							$connection = mysql_connect("localhost", "root", "321Testing");
							$db = mysql_select_db("TeamAssignmentApp", $connection);
							$query = mysql_query("select Class.className AS className from InClass JOIN Class ON InClass.classId = Class.classId WHERE userId='$userId'", $connection);
							$rows = mysql_num_rows($query);
							if ($rows >= 1) {
								while ($result = mysql_fetch_array($query)){ ?>
									<option><?php echo $result['className'];?></option>
								<?php

								}
							}


						?>
						<option>Class 1</option>
						<option>Class 2</option>
						<option>Class 3</option>
						<option>Class 4</option>
					</select>
				</div>
				<button class="btn btn-primary" style="margin-bottom:10px">Enter Class</button>
			</div>
			<div class="col-md-3"></div>
		</div>
	</body>
</html>