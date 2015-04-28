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
        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>

	<script>
		$(document).ready(function(){
			//load the tables first
			var classTable = $("#displayClasses").DataTable();
			console.log("assigned object");	
			console.log(classTable);		
			var userTable = $("#displayUsers").DataTable();
			var projectTable = $("#displayProjects").DataTable();
			var adminTable = $("#displayAdmins").DataTable();
			$('#adminTabs a').click(function (e) {
				e.preventDefault()
				$(this).tab('show')
			});

			$.get("api/user.php", {id:1, token:'9164fe76dd046345905767c3bc2ef54'}, function(data){
				console.log("in user get");
				console.log(classTable);
				var parsedData = JSON.parse(data);
				var classes = parsedData["classIds"];
				var classArr = [];
				$(classes).each(function(index,classID){
					$.get("api/class.php", {id: classID, token:'9164fe76dd046345905767c3bc2ef54'}, function(classData){
						var parsedClassData = JSON.parse(classData);
						var allUsersAllProjects = parsedClassData["users"];
						var thisClassProjects = parsedClassData["projects"];
						$(allUsersAllProjects).each(function(index,user){
							//prevent adding duplicate classes
							if(classArr.indexOf(user["name"]) == -1) {
 								classArr.push(user["name"]);
 								console.log(user);
								classTable.row.add([user["name"], user["startTime"], user["endTime"], "a"]);
							}	
							$.get("api/user.php", {id: user["id"], token:'9164fe76dd046345905767c3bc2ef54'}, function(userData){
								userTable.row.add(userData["fname"] + " " + userData["lname"], userData["major"]["name"], userData["email"]);
							});
						});
						$(thisClassProjects).each(function(index,proj){
							projectTable.row.add([proj["name"], proj["description"],"",proj["fileLink"],""]);
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

			$("#reqPageSelect").change(function() {
				console.log('hi');
				if($(this).val() == "")
					$(".requestPageInput").attr("disabled","disabled");
				else {
					$(".requestPageInput").removeAttr("disabled");
				}

			});
		});
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
						<button class="btn btn-success btn-sm" id="addClassBtn" style="display:inline-block" data-toggle="modal" data-target="#crudModal"><span class="glyphicon glyphicon-plus"></span>Add Class</button>
						<table id="displayClasses" class="display">
							<thead>
								<tr>
									<th>Class Name</th>
									<th>Start Date</th>
									<th>End Date</th>
									<th>Administrators</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Senior Design</td>
									<td>January 1, 2015</td>
									<td>May 2, 2015</td>
									<td>Dona Mularkey, Don Evans, Carlos Davila</td>
								</tr>
								<tr>
									<td>First Year Design</td>
									<td>January 1, 2015</td>
									<td>May 2, 2015</td>
									<td>Mark Fontenot</td>
								</tr>
								<tr>
									<td>GUI</td>
									<td>January 1, 2015</td>
									<td>May 2, 2015</td>
									<td>Mark Fontenot, Harrison Jackson</td>
								</tr>
								<tr>
									<td>Databases</td>
									<td>January 1, 2015</td>
									<td>May 2, 2015</td>
									<td>Mark Fontenot</td>
								</tr>
							</tbody>
						</table>
					</div>
    				<div role="tabpanel" class="tab-pane" id="users">
    					<h3 style="margin-top:0; display:inline-block">Managing Users</h3>
    					<button class="btn btn-success btn-sm" id="addUserBtn" style="display:inline-block" data-toggle="modal" data-target="#crudModal"><span class="glyphicon glyphicon-plus"></span>Add User</button>
    					<table id="displayUsers" class="display">
							<thead>
								<tr>
									<th>Name</th>
									<th>Major</th>
									<th>Email</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Alex Russell</td>
									<td>Computer Engineering</td>
									<td>amrussell@smu.edu</td>
								</tr>
								<tr>
									<td>Nick Morris</td>
									<td>Computer Science</td>
									<td>nmorris@smu.edu</td>
								</tr>
								<tr>
									<td>Ian Cowley</td>
									<td>Computer Science</td>
									<td>icowley@smu.edu</td>
								</tr>
								<tr>
									<td>Jeffrey Artigues</td>
									<td>Computer Science</td>
									<td>jartigues@smu.edu</td>
								</tr>
							</tbody>
						</table>
    				</div>
    				<div role="tabpanel" class="tab-pane" id="projects">
    					<h3 style="margin-top:0; display:inline-block">Managing Projects</h3>
    					<button class="btn btn-success btn-sm" id="addProjectBtn" style="display:inline-block" data-toggle="modal" data-target="#crudModal"><span class="glyphicon glyphicon-plus"></span>Add Project</button>
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
							<tbody>
								<tr>
									<td>Project 1</td>
									<td>Description</td>
									<td>5</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Project 2</td>
									<td>Description</td>
									<td>5</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Project 3</td>
									<td>Description</td>
									<td>5</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Project 4</td>
									<td>Description</td>
									<td>5</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Project 5</td>
									<td>Description</td>
									<td>5</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Project 6</td>
									<td>Description</td>
									<td>5</td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
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
    									<option value="1">Class 1</option>
    									<option value="2">Class 2</option>
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

		<!--modal display for CRUD-->
		<div class="modal fade" id="crudModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="crudTitle"></h4>
					</div>
					<div class="modal-body" id="crudBody"></div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</body>
</html>
