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
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.css" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>

	<script>
	$(document).ready(function() {
		$.get("api/class.php", {id:1, token:'9164fe76dd046345905767c3bc2ef54'}, function(data){
			var parsed = JSON.parse(data);
			var projects = parsed["projects"];
			var skills = parsed["skills"];
			var users = parsed["users"];
			var numProjPrefs = parsed["numProjPrefs"];
			var numTeamPrefs = parsed["numTeamPrefs"];

			var userNames = [];

			for(var i = 0; i < users.length; i++) {
				userNames[i] = users[i].fname + " " + users[i].lname;
			}

			for(var i = 0; i < numProjPrefs; i++) {
				var newProjPref = "<div class='input-group'>" +
									"<span class='input-group-addon'>Project " + (i+1) + "</span>" +
									"<select class='form-control projectSelect'>" +
										"<option value=''>--Please Select--</option>" +
									"</select>" +
								"</div>" +
								"<br/>";
				$("#projReqs").append(newProjPref);
			}

			for(var i = 0; i < numTeamPrefs; i++) {
				var newTeamPref = "<div class='input-group'>" +
									"<span class='input-group-addon'>Team Member Request " + (i+1) + "</span>" +
									"<input type='text' placeholder='Start typing name...'' class='form-control teamReqInput' />" +
									"</div>" +
									"<br/>";
				$("#teamReqs").append(newTeamPref);
			}

			$(projects).each(function(index,value) {
				var newProjStr = "<option value='" + value["id"] + "'>" + value["name"] + "</option>";
				$(".projectSelect").append(newProjStr);
			});

			$(skills).each(function(index, value) {
				var newSkillStr = "<option value='" + value["id"] + "'>" + value["name"] + "</option>";
				$(".skillSelect").append(newSkillStr);
			});

			$(".teamReqInput").each(function(index,value) {
				$(this).autocomplete({
					source: userNames
				});
			});
		});
	});
	</script>



	</head>
	<body>
		<div class="container">
			<div class="col-md-12" id="header" style="text-align:center">
				<img src="images/LyleLogo.png" alt="LyleLogo" height="100" width="800">
			</div>
			<div class="col-md-6">
				<div class="well" style="padding-top:0px;" id="projReqs">
					<h4>Prioritize your project requests.</h4>
				</div>
			</div>
			<div class="col-md-6">
				<div class="well" style="padding-top:0px" id="teamReqs">
					<h4>Prioritize your group member requests.</h4>
				</div>
			</div>

			<a class="btn btn-primary" id="projectButton" onclick="window.open('http://ec2-52-11-229-124.us-west-2.compute.amazonaws.com/viewprojects.php')">List of Projects</a>
			<div class="col-md-12" id="skillSet">
				<div class="well" style="padding-top:0px">
					<h4>What skills do you have?</h4>
				<div class="input-group">
					<span class="input-group-addon">Skill</span>
					<select class="form-control skillSelect">
						<option value="">--Please Select--</option>
					</select>
				</div>
				<br/>
				<div class="input-group">
					<span class="input-group-addon">Skill</span>
					<select class="form-control skillSelect">
						<option value="">--Please Select--</option>
					</select>
				</div>
				<br/>
				<div class="input-group">
					<span class="input-group-addon">Skill</span>
					<select class="form-control skillSelect">
						<option value="">--Please Select--</option>
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
