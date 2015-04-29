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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
        <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="css/styles.css" />
        <link rel="stylesheet" href="css/jquery-ui.min.css" />
        <link rel="stylesheet" href="css/jquery-ui.structure.min.css" />
        <link rel="stylesheet" href="css/jquery-ui.theme.min.css" />
        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>

	<script>
		var numPrefs = [];
		$(document).ready(function(){
			//load the tables first
			var classTable = $("#displayClasses").DataTable();
			var userTable = $("#displayUsers").DataTable();
			var projectTable = $("#displayProjects").DataTable();
			var adminTable = $("#displayAdmins").DataTable();
			$('#adminTabs a').click(function (e) {
				e.preventDefault()
				$(this).tab('show')
			});

			$.get("api/user.php", {id:1, token:'9164fe76dd046345905767c3bc2ef54'}, function(data){
				var parsedData = JSON.parse(data);
				console.log("parsedData");
				console.log(parsedData)
				var classes = parsedData["classIds"];
				var classArr = [];
				$(classes).each(function(index,classID){
					$.get("api/class.php", {id: classID, token:'9164fe76dd046345905767c3bc2ef54'}, function(classData){
						console.log('classData');
						console.log(classData);
						var parsedClassData = JSON.parse(classData);
						console.log("parsedClassData");
						console.log(parsedClassData);
						var allUsersAllProjects = parsedClassData["users"];
						var thisClassProjects = parsedClassData["projects"];
						$(allUsersAllProjects).each(function(index,user){
							//prevent adding duplicate classes
							if(classArr.indexOf(user["name"]) == -1) {
 								classArr.push(user["name"]);
 								console.log("user");
 								console.log(user);
 								var convertedStartDate = convertDate(parsedClassData["startTime"]);
 								var convertedEndDate = convertDate(parsedClassData["endTime"]);
 								var prettyStartDate = dateToString(convertedStartDate);
 								var prettyEndDate = dateToString(convertedEndDate);

 								var actionButtons = '<a class="btn-primary btn-sm" href="#" onclick="editClass(' + parsedClassData["id"] + ')">Edit</a>&nbsp;' +
 													'<a class="btn-danger btn-sm" href="#" onclick="deleteClass(' + parsedClassData["id"] + ')">Delete</a>';
 								if(parsedClassData["adminIds"].length == 0) {
									classTable.row.add([parsedClassData["name"], prettyStartDate, prettyEndDate, "None", actionButtons]).draw();
								}
								else {
									var commaSepAdminNames = '';
									var numAdmins = parsedClassData["adminIds"].length;
									$(parsedClassData["adminIds"]).each(function(ind, adminId) {
										$.get("api/user.php", {id: adminId, token:'9164fe76dd046345905767c3bc2ef54'}, function(adminData) {
											var parsedAdminData = JSON.parse(adminData);
											commaSepAdminNames += parsedAdminData["fname"] + ' ' + parsedAdminData["lname"];
											if(ind < (numAdmins - 1))
												commaSepAdminNames += ', ';
										});
									});
									classTable.row.add([parsedClassData["name"], prettyStartDate, prettyEndDate, commaSepAdminNames, actionButtons]).draw();
								}
								$("#reqPageSelect").append('<option value="' + parsedClassData["id"] + '">' + parsedClassData["name"] + '</option>');
								numPrefs[parsedClassData["name"]] = {"numProjPrefs": parsedClassData["numProjPrefs"], "numTeamPrefs": parsedClassData["numTeamPrefs"]};
							}	
							$.get("api/user.php", {id: user["id"], token:'9164fe76dd046345905767c3bc2ef54'}, function(userData){
								var parsedUserData = JSON.parse(userData);
								userTable.row.add([parsedUserData["fname"] + " " + parsedUserData["lname"], parsedUserData["major"], parsedUserData["email"]]).draw();
							});
						});
						$(thisClassProjects).each(function(index,proj){
							projectTable.row.add([proj["name"], proj["description"],"",proj["fileLink"],""]).draw();
						});
					});
				});
			});

			$("#crudModal").on("hidden.bs.modal", function() {
				$("#crudBody").empty();
			});

			$('#crudModal').on('show.bs.modal', function () {
			       $(this).find('.modal-body').css({
			              width:'auto', //probably not needed
			              height:'auto', //probably not needed 
			              'max-height':'100%'
			       });
			});

			/*
			$("#addClassBtn").click(function() {
				$("#crudBody").html($("#loadingDisplay").html());
				$("#crudBody").load("createClass.php", function() {
					$("#crudTitle").html("Adding Class...");
				});
			});

			//bind click events to add buttons
			$("#addUserBtn").click(function() {
				$("#crudBody").html($("#loadingDisplay").html());
				$("#crudBody").load("createUser.php", function() {
					$("#crudTitle").html("Adding User...");
				});
			});

			$("#addProjectBtn").click(function() {
				$("#crudBody").html($("#loadingDisplay").html());
				$("#crudBody").load("CreateProject.php", function() {
					$("#crudTitle").html("Adding Project...");
				});
			});
*/

			$("#reqPageSelect").change(function() {
				if($(this).val() == "")
					$(".requestPageInput").attr("disabled","disabled");
				else {
					$(".requestPageInput").removeAttr("disabled");
					var selectedClassID = $(this).val();
					console.log(numPrefs);
					var prefsObj = numPrefs[$("#reqPageSelect option:selected").text()];
					$("#numTeammateReqs").val(prefsObj["numTeamPrefs"]);
					$("#numProjects").val(prefsObj["numProjPrefs"]);
				}

			});

			//brought these over from formerly remotely loaded modals
			$("#numStudents").change(function(){
				$("#majorForEachStudent").empty();
				for(var i = 0; i < $("#numStudents").val(); i++){
					$("#majorForEachStudent").append($("#studentMajorTemplate").html());
				}
			});

			//initialize datepickers for class start dates and end dates
			$("#newClassStartDate").datepicker();
			$("#newClassEndDate").datepicker();
		});

	function convertDate(dateStr) {
		var a=dateStr.split(" ");
		var d=a[0].split("-");
		var t=a[1].split(":");
		var date = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);
		return date;
	}

	function dateToString(date) {
		var strToRet = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
		if(strToRet == '11/30/1899')
			return "None";
		else
			return strToRet;
	}

	//CLASS FUNCTIONS
	function editClass(id) {
		console.log('will edit class ' + id);
	}

	function deleteClass(id){
		console.log('will delete class ' + id);
	}
	</script>
	</head>
	<body>
		<h1 style="text-align:center; color:white">SMU Lyle Multidisciplinary Senior Design</h1>
		<div class="container well" style="width:90%; height:650px">
			<h3 style="text-align:center">Senior Design Administrator Dashboard</h3>
			<div class="col-md-12" role="tabpanel">
				<ul class="nav nav-tabs" role="tablist" id="adminTabs">
					<li role="presentation" >
					<li role="presentation" class="active">
						<a href="#classes" aria-controls="classes" role="tab" data-toggle="tab">Classes</a>
					</li>
					<li role="presentation">
						<a href="#users" aria-controls="users" role="tab" data-toggle="tab">Users</a>
					</li>
					<li role="presentation">
						<a href="#projects" aria-controls="projects" role="tab" data-toggle="tab">Projects</a>
					</li>
					<li role="presentation">
						<a href="#requestpage" aria-controls="requestpage" role="tab" data-toggle="tab">Request Page</a>
					</li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="classes">
						<h3 style="margin-top:0; display:inline-block">Managing Classes</h3>
						<button class="btn btn-success btn-sm" id="addClassBtn" style="display:inline-block" data-toggle="modal" data-target="#addClassModal"><span class="glyphicon glyphicon-plus"></span>Add Class</button>
						<table id="displayClasses" class="display">
							<thead>
								<tr>
									<th>Class Name</th>
									<th>Start Date</th>
									<th>End Date</th>
									<th>Administrators</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
    				<div role="tabpanel" class="tab-pane" id="users">
    					<h3 style="margin-top:0; display:inline-block">Managing Users</h3>
    					<button class="btn btn-success btn-sm" id="addUserBtn" style="display:inline-block" data-toggle="modal" data-target="#addUserModal"><span class="glyphicon glyphicon-plus"></span>Add User</button>
    					<table id="displayUsers" class="display">
							<thead>
								<tr>
									<th>Name</th>
									<th>Major</th>
									<th>Email</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
    				</div>
    				<div role="tabpanel" class="tab-pane" id="projects">
    					<h3 style="margin-top:0; display:inline-block">Managing Projects</h3>
    					<button class="btn btn-success btn-sm" id="addProjectBtn" style="display:inline-block" data-toggle="modal" data-target="#addProjectModal"><span class="glyphicon glyphicon-plus"></span>Add Project</button>
						<table id="displayProjects" class="display">
							<thead>
								<tr>
									<th>Name</th>
									<th>Description</th>
									<th># Students</th>
									<th>File Link</th>
									<th>Required Majors</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
    				</div>
    				<div role="tabpanel" class="tab-pane" id="requestpage">
    					<h3 style="margin-top:0">Managing Project Request Page</h3>
    					<div class="container">
    						<div class="col-md-12">
    							<div class="input-group" style="width:400px">
    								<label for="reqPageToChange">Please Choose a Class to Edit Its Page</label>
    								<select class="form-control" id="reqPageSelect">
    									<option value="" selected>--Please Select--</option>
    								</select>
    							</div>
    							<hr />
    							<div class="input-group" style="width:400px">
    								<label for="numTeammateReqs">Number of Teammate Requests Allowed</label>
    								<input class="form-control requestPageInput" disabled type="number" min="2" max="8" value="2" id="numTeammateReqs"/>
    							</div>
    							<br/>
    							<div class="input-group" style="width:400px">
    								<label for="numSkills">Number of Skills Allowed</label>
    								<input class="form-control requestPageInput" disabled type="number" min="1" max="9" value="1" id="numSkills"/>
    							</div>
    							<br/>
    							<div class="input-group" style="width:400px">
    								<label for="numProjects">Number of Project Requests Allowed</label>
    								<input class="form-control requestPageInput" disabled type="number" min="2" max="9" value="2" id="numProjects"/>
    							</div>
    							<br/>
    							<button class="btn btn-success requestPageInput" disabled id="saveProjReqPageChanges">Save Changes</button>
    						</div>
    					</div>
				
    				</div>

				</div>
			</div>
		</div>

		<!--hidden div holding loading display when div is loading info-->
		<div id="loadingDisplay" style="display:none">
			<div style="text-align:center">
				<h3>Loading Form...</h3>
				<img src="images/ajax-loader.gif">
			</div>
		</div>

		<!--modal display for classes-->
		<div class="modal fade" id="addClassModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="addClassTitle">Adding Class...</h4>
					</div>
					<div class="modal-body" id="addClassBody">
						<div class="input-group" style="margin-bottom:10px">
							<span class="input-group-addon">Class Name</span>
							<input class="form-control" type="text" />
						</div>
						<div class="input-group" style="margin-bottom:10px">
							<span class="input-group-addon">Start Date</span>
							<input class="form-control" type="text" id="newClassStartDate" />
						</div>
						<div class="input-group" style="margin-bottom:10px">
							<span class="input-group-addon">End Date</span>
							<input class="form-control" type="text" id="newClassEndDate" />
						</div>
						<button class="btn btn-success" style="display:inline-block">Create Class</button>
						&nbsp;&nbsp;
						<button class="btn btn-danger" style="display:inline-block">Reset Form</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!--modal display for users-->
		<div class="modal fade" id="addUserModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="addUserTitle">Adding User...</h4>
					</div>
					<div class="modal-body" id="addUserBody">
						<div class="input-group" style="margin-bottom:10px">
							<span class="input-group-addon">Class</span>
							<select class="form-control studentMajorSelection">
								<?php
									$query = mysql_query("select className from Class", $connection);
									$rows = mysql_num_rows($query);
									if ($rows >= 1) {
										while ($result = mysql_fetch_array($query)){ ?>
											<option><?php echo $result['className'];?></option>
										<?php
										}
									}
								?>
							</select>
						</div>
						<div class="input-group" style="margin-bottom:10px">
							<span class="input-group-addon">First Name</span>
							<input class="form-control" type="text" />
						</div>
						<div class="input-group" style="margin-bottom:10px">
							<span class="input-group-addon">Last Name</span>
							<input class="form-control" type="text" />
						</div>


						<div class="input-group" style="margin-bottom:10px">
							<span class="input-group-addon">Major</span>
							<input class="form-control" type="text" />
						</div>
						<div class="input-group" style="margin-bottom:10px">
							<span class="input-group-addon">Email Address</span>
							<input class="form-control" type="text" />
						</div>
						<button class="btn btn-success" style="display:inline-block">Create User</button>
						&nbsp;&nbsp;
						<button class="btn btn-danger" style="display:inline-block">Reset Form</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!--modal display for projects-->
		<div class="modal fade" id="addProjectModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="addProjectTitle">Adding Project...</h4>
					</div>
					<div class="modal-body" id="addProjectBody">
						<div class="input-group" style="margin-bottom:10px">
							<span class="input-group-addon">Class</span>
							<select class="form-control studentMajorSelection">
								<option>Class 1</option>
								<option>Class 2</option>
								<option>Class 3</option>
								<option>Class 4</option>
							</select>
						</div>
						<div class="input-group" style="margin-bottom:10px">
							<span class="input-group-addon">Project Name</span>
							<input class="form-control" type="text" />
						</div>
						<label>Project Description</label><br/>
						<textarea class="form-control" style="margin-bottom:9px"></textarea>
						<div class="input-group" style="margin-bottom:10px">
							<span class="input-group-addon">Number of Students</span>
							<input type="number" min="2" max="10" value="2" id="numStudents" class="form-control" />
						</div>
						<span id="majorForEachStudent">
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Student Discipline</span>
								<select class="form-control studentMajorSelection">
									<option>Computer Science</option>
									<option>Computer Engineering</option>
									<option>Mechanical Engineering</option>
									<option>Electrical Engineering</option>
									<option>Civil Engineering</option>
									<option>Environmental Engineering</option>
								</select>
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Student Discipline</span>
								<select class="form-control studentMajorSelection">
									<option>Computer Science</option>
									<option>Computer Engineering</option>
									<option>Mechanical Engineering</option>
									<option>Electrical Engineering</option>
									<option>Civil Engineering</option>
									<option>Environmental Engineering</option>
								</select>
							</div>
						</span>
						<button class="btn btn-default" style="margin-bottom:10px">Upload Attachment</button>
						<br/>
						<button class="btn btn-success" style="display:inline-block">Submit</button>
						&nbsp;&nbsp;
						<button class="btn btn-danger" style="display:inline-block">Reset Form</button>
						<div id="studentMajorTemplate" style="display:none">
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Student Discipline</span>
								<select class="form-control studentMajorSelection">
									<option>Computer Science</option>
									<option>Computer Engineering</option>
									<option>Mechanical Engineering</option>
									<option>Electrical Engineering</option>
									<option>Civil Engineering</option>
									<option>Environmental Engineering</option>
								</select>
							</div>
						</div>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</body>
</html>
