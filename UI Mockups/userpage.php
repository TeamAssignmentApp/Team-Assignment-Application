<?php
	session_start();
	if(!isset($_SESSION['login_user'])){
		header("location: login.php");
	}
	else if ($_SESSION['isAdmin']==0){
		header("selectClass.php");
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
			<div class="col-md-6">
				<div class="well" style="padding-top:0px;">
					<h4>Prioritize your project requests.</h4>
				<div class="input-group">
					<span class="input-group-addon">Project Pick 1</span>
					<select class="form-control projectSelect">
						<option value="">--Please Select--</option>
					</select>
				</div>
				<br/>
				<div class="input-group">
					<span class="input-group-addon">Project Pick 2</span>
					<select class="form-control projectSelect">
						<option value="">--Please Select--</option>
					</select>
				</div>
				<br/>

				<div class="input-group">
					<span class="input-group-addon">Project Pick 3</span>
					<select class="form-control projectSelect">
						<option value="">--Please Select--</option>
					</select>
				</div>
				<br/>
				<div class="input-group">
					<span class="input-group-addon">Project Pick 4</span>
					<select class="form-control projectSelect">
						<option value="">--Please Select--</option>
					</select>
				</div>
				<br/>
				<div class="input-group">
					<span class="input-group-addon">Project Pick 5</span>
					<select class="form-control projectSelect">
						<option value="">--Please Select--</option>
					</select>
				</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="well" style="padding-top:0px">
					<h4>Prioritize your group member requests.</h4>
				<div class="input-group">
					<span class="input-group-addon">Team Member Request 1</span>
					<input type="text" placeholder="Start typing name..." class="form-control" />
				</div>
				<br/>
				<div class="input-group">
					<span class="input-group-addon">Team Member Request 2</span>
					<input type="text" placeholder="Start typing name..." class="form-control" />
				</div>
				<br/>
				<div class="input-group">
					<span class="input-group-addon">Team Member Request 3</span>
					<input type="text" placeholder="Start typing name..." class="form-control" />
				</div>

					
				</div>
			</div>
			<a class="btn btn-primary" id="projectButton">List of Projects</a>
			<div class="col-md-12">
				<div class="well" style="padding-top:0px">
					<h4>What skills do you have?</h4>
				<div class="input-group">
					<span class="input-group-addon">Skill</span>
					<select class="form-control">
						<option>Skill 1</option>
						<option>Skill 2</option>
					</select>
				</div>
				<br/>
				<div class="input-group">
					<span class="input-group-addon">Skill</span>
					<select class="form-control">
						<option>Skill 1</option>
						<option>Skill 2</option>
					</select>
				</div>
				<br/>
				<div class="input-group">
					<span class="input-group-addon">Skill</span>
					<select class="form-control">
						<option>Skill 1</option>
						<option>Skill 2</option>
					</select>
				</div>
				</div>

			</div>
			<div class="col-md-12">
				<div class="well">
					<div class="input-group">
						<label>Would you like to be the leader of your group?</label>
						&nbsp;<input type="checkbox" />
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="well">
					<a class="btn btn-primary">Save Changes</a>
					<p>All saved changes will be submitted automatically on the deadline.</p>
				</div>
			</div>
		</div>
	</body>
</html>
