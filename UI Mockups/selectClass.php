<?php
	session_start();
	if(!isset($_SESSION['login_user'])){
		header("location: login.php");
	}
	if ($_SESSION['isMaster'] == 1){
		header("location: masterAdminDash.php");
	}
	else if ($_SESSION['isAdmin'] == 1){
		header("location: AdminDash.php");
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

			<a href="logout.php" class="btn btn-danger" style="display:inline-block">Logout</a>

			
		</div>
		<div class="container" style="margin-top:150px">
			<div class="col-md-3"></div>
			<div class="col-md-6 well">
				<h3 style="margin-top:0px">Select a class...</h3>
				<div class="input-group">
					<span class="input-group-addon">Class</span>
					<select class="form-control" id="classSelect">
						<?php
							$userID = $_SESSION['login_user'];
							$connection = mysql_connect("localhost", "root", "321Testing");
							$db = mysql_select_db("TeamAssignmentApp", $connection);
							$query = mysql_query("select Class.classID, className from Class join InClass on Class.classID=InClass.classID where InClass.userID='$userID'", $connection);
							while ($row = mysql_fetch_row($query)) {
								$className = $row[1];
								$classID = $row[0];
								?>
								<option value = "<?php echo $classID?>"><?php echo $className;?></option>
								<?php
							}
							mysql_close($connection);
						?>
					</select>
				</div>
				<br/>
				<button class="btn btn-primary" style="margin-bottom:10px" id="enterClassBtn">Enter Class</button>
				<script>
					$("#enterClassBtn").click(function() {
						window.location = "userpage.php?id=" + $("#classSelect").val();
					});
				</script>
			</div>
			<div class="col-md-3"></div>
		</div>
	</body>
</html>

