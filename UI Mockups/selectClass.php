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
						<?php/*
							$userId = $_SESSION['login_user'];
						    $url="http://ec2-52-11-229-124.us-west-2.compute.amazonaws.com/api/user.php?token=9164fe76dd046345905767c3bc2ef54&id=" + $userId;
						    $json = file_get_contents($url);
    						$data = json_decode($json, TRUE);
    						foreach($data['classIds'] as $item) {
    							$url2="http://ec2-52-11-229-124.us-west-2.compute.amazonaws.com/api/class.php?token=9164fe76dd046345905767c3bc2ef54&id=" + $item;
						    	$json2 = file_get_contents($url2);
    							$data2 = json_decode($json2, TRUE);
    							$className = $data2['name'];
    							*/?>
									<option value = "<?php echo $item;?>"><?/*php echo $className;*/?></option>
								<?php/*
								}
							}
						*/?>
					</select>
				</div>
				<button class="btn btn-primary" style="margin-bottom:10px">Enter Class</button>
			</div>
			<div class="col-md-3"></div>
		</div>
	</body>
</html>
