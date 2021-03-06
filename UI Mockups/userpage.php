<?php
	session_start();
	if(!isset($_SESSION['login_user'])){
		header("location: login.php");
	}
	else if (isset($_SESSION['isMaster'])){
		header("location: masterAdminDash.php");
	}
	else if ($_SESSION['isAdmin']==1){
		header("location: AdminDash.php");
	}
	else{
		if (!isset($_GET['id'])){
			header("location: selectClass.php");
		}
		else{
			$connection = mysql_connect("localhost", "root", "321Testing");
			$db = mysql_select_db("TeamAssignmentApp", $connection);
			$user = $_SESSION['login_user'];
			$class = $_GET['id'];
			$query = mysql_query("SELECT * FROM InClass WHERE InClass.userID='$user' AND InClass.classID = '$class'", $connection);
			if (mysql_num_rows($query) < 1){
				header("location: selectClass.php");
			}
			$datequery = mysql_query("SELECT endTime FROM Class WHERE classID = '$class'", $connection);
			$row = mysql_fetch_row($datequery);
			$endtime = strtotime($row[0]);
			$curDate = date("Y-m-d");
			if ($curDate > $endtime){
				header("location: ViewResults.php?classID=" . $class);
			}
			mysql_close($connection);
		}
	}
	$userID = $_SESSION['login_user'];
?>
<script language="javascript" type="text/javascript">

    var userid = "<?php echo $userID; ?>";

</script>



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
		$.get("api/class.php", {id:<?php echo $_GET['id']; ?>, token:'9164fe76dd046345905767c3bc2ef54'}, function(data){
			var parsed = JSON.parse(data);
			var projects = parsed["projects"];
			var skills = parsed["skills"];
			var users = parsed["users"];
			var numProjPrefs = parsed["numProjPrefs"];
			var numTeamPrefs = parsed["numTeamPrefs"];
			console.log("numProjPrefs");
			console.log(numProjPrefs);
			console.log("numTeamPrefs");
			console.log(numTeamPrefs);

			var userNames = [];

			var curIndex = 0;
			for(var i = 0; i < users.length; i++) {
				//if (users[i].id == userid){
					userNames[curIndex] = users[i].fname + " " + users[i].lname;
					if (users[i].id == userid){
						//userNames[curIndex] = '';
						userNames.splice(curIndex,1);
					}
					else{
						curIndex++;
					}
				//}
			}

			for(var i = 0; i < numProjPrefs; i++) {
				var newProjPref = "<div class='input-group'>" +
									"<span class='input-group-addon'>Project " + (i+1) + "</span>" +
									"<select class='form-control projectSelect' name = 'ProjectPreference" + (i+1) + "'>" +
										"<option value=''>--Please Select--</option>" +
									"</select>" +
								"</div>" +
								"<br/>";
				$("#projReqs").append(newProjPref);
			}

			for(var i = 0; i < numTeamPrefs; i++) {
				var newTeamPref = "<div class='input-group'>" +
									"<span class='input-group-addon'>Team Member Request " + (i+1) + "</span>" +
									"<select class='form-control teamReqInput' name = 'TeammatePreference" + (i+1) + "'></select>" +
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

			$.get("api/class.php", {token: '9164fe76dd046345905767c3bc2ef54', id: <?php echo $_GET['id']; ?>}, function(classData) {
				var parsedClassData = JSON.parse(classData);
				var thisClassUsers = parsedClassData["users"];
				$(thisClassUsers).each(function(i,usr) {
					$(".teamReqInput").append('<option value="' + usr["id"] + '"">' + usr["fname"] + ' ' + usr["lname"] + '</option>');
				});
			});
			
		});
		/*function updatePreferences(sameID, samePassword, projectPrefs, teammatePrefs, newSkills, wantsLead){
			if(){
				$.ajax({
		            url: "api/user.php",
		            type: 'PUT',    
		            data: {token:'9164fe76dd046345905767c3bc2ef54', id:sameID , password:samePassword, projectPreferences:projectPrefs, teammatePreferences:teammatePrefs, skills:newSkills, wantsToLead:wantsLead},
		            dataType: 'json',
		            success: function(result) {
		                alert("success?");
		            }
			    });
			}
		}*/
	});
	</script>



	</head>
	<body>
		<div class="container">
			<form action="completedForm.php" method="post">
				<div class="col-md-12" id="header" style="text-align:center">
					<img src="css/LyleLogo.png" alt="LyleLogo" height="100" width="800">
					<a href="logout.php" class="btn btn-danger" style="display:inline-block; float:right; margin-top:20px">Logout</a>
					<a href="changepasswordUI.php" class="btn btn-primary btn-sm" style="display:inline-block; float:right; margin-top:20px; margin-right:10px">Change Password</a>
				</div>

				<!-- <a href="logout.php" class="btn btn-danger" style="display:inline-block">Logout</a> -->

				<div class="col-md-6">
					<div class="well" style="padding-top:0px;" id="projReqs">
						<h4 style="display:inline-block">Prioritize your project requests.</h4>
						<a class="btn btn-primary btn-sm" style="display:inline-block; float:right" id="projectButton" onclick="window.open('http://ec2-52-11-229-124.us-west-2.compute.amazonaws.com/viewprojects.php')">List of Projects</a>
					</div>
				</div>
				<div class="col-md-6">
					<div class="well" style="padding-top:0px" id="teamReqs">
						<h4>Prioritize your team member requests.</h4>
					</div>
				</div>

				<!--<a class="btn btn-primary" id="projectButton" onclick="window.open('http://ec2-52-11-229-124.us-west-2.compute.amazonaws.com/viewprojects.php')">List of Projects</a>-->
				<div class="col-md-12" id="skillSet">
					<div class="well" style="padding-top:0px">
						<h4>What skills do you have?</h4>
					<div class="input-group">
						<span class="input-group-addon">Skill</span>
						<select class="form-control skillSelect" name = "Skill1">
							<option value="">--Please Select--</option>
						</select>
					</div>
					<br/>
					<div class="input-group">
						<span class="input-group-addon">Skill</span>
						<select class="form-control skillSelect" name = "Skill2">
							<option value="">--Please Select--</option>
						</select>
					</div>
					<br/>
					<div class="input-group">
						<span class="input-group-addon">Skill</span>
						<select class="form-control skillSelect" name = "Skill3">
							<option value="">--Please Select--</option>
						</select>
					</div>
					</div>

				</div>
				<div class="col-md-12">
					<div class="well">
						<div class="input-group">
							<label>Would you like to be the leader of your group?</label>
							&nbsp;<input type="checkbox" name="LeaderBox" />
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="well">
						<input type="hidden" name="classID" value="<?php echo $_GET['id']; ?>">
						<input type = "submit" class="btn btn-primary" value="Save Changes"/>
						<p>All saved changes will be submitted automatically on the deadline.</p>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
