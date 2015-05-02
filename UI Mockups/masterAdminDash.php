<?php
	session_start();
	if(!isset($_SESSION['login_user'])){
		header("location: login.php");
	}
	else if (!isset($_SESSION['isMaster']) && $_SESSION['isAdmin'] == 0){
		header("userpage.php");
	}
	else if (!isset($_SESSION['isMaster'])){
		header("adminDash.php");
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
			var classDisplay = $("#displayClasses").dataTable();			
			var usersDisplay = $("#displayUsers").dataTable();
			var projectsDisplay = $("#displayProjects").dataTable();
			var adminDisplay = $("#displayAdmins").dataTable();


			$.get("api/user.php", {id:1, token:'9164fe76dd046345905767c3bc2ef54'}, function(data){
				var userData = JSON.parse(data);
				
				$('displayUsers')({
					

				});
				
			});

			$.get("api/class.php", {id:1, token:'9164fe76dd046345905767c3bc2ef54'}, function(data){
				var classData = JSON.parse(data);
				var className = parsed('name');
				var classStart = parsed('startTime');
				var classEnd = parsed('endTime');
				var classAdmins = parsed(''); // need this still

				$('displayClasses')({
					

				});
			});


			$('#adminTabs a').click(function (e) {
				e.preventDefault()
				$(this).tab('show')
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

			$("#addAdminBtn").click(function() {
				$("#crudBody").html($("#loadingDisplay").html());
				$("#crudBody").load("createAdmin.php", function() {
					$("#crudTitle").html("Adding Administrator...");
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
		<div class="col-md-12" id="header" style="text-align:center">
			<img src="css/smulogo.png" alt="LyleLogo" height="100" width="800">
			<a href="logout.php" class="btn btn-danger" style="display:inline-block; float:right; margin-top:20px">Logout</a>
		</div>


		<div class="container well" style="width:90%; height:650px">
			<h3 style="text-align:center">Master Administrator Dashboard</h3>
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
						<a href="#administrators" aria-controls="administrators" role="tab" data-toggle="tab">Administrators</a>
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
								<?php
									$connection = mysql_connect("localhost", "root", "321Testing");
									$db = mysql_select_db("TeamAssignmentApp", $connection);
									$query = mysql_query("select Class.classID, Class.className, Class.startTime, Class.endTime from Class", $connection);
									while ($row = mysql_fetch_row($query)) {
										$className = $row[1];
										$classID = $row[0];
										$start = $row[2];
										$end = $row[3];
										$query2 = mysql_query("select User.fname, User.lname FROM AdminOf JOIN User ON User.userID = AdminOf.userID WHERE AdminOf.classID='$classID'", $connection);
								?>
									<tr>
									<td><?php echo $className;?></td>
									<td><?php echo $start;?></td>
									<td><?php echo $end;?></td>
									<td><?php 
									$numAdmins = mysql_num_rows($query2);
									while ($row2 = mysql_fetch_row($query2)) {
										echo $row2[0] + ' ' + $row2[1];
										$numAdmins--;
										if ($numAdmins>0){
											echo ", ";
										}
									}?></td>
								</tr>


								<?php

									}

								?>
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
								<?php
								$query = mysql_query("select User.userID, User.fname, User.lname, User.email, Major.majorName FROM User JOIN IsMajor ON User.userID = IsMajor.userID JOIN Major ON Major.majorID = IsMajor.majorID", $connection);
									while ($row = mysql_fetch_row($query)) {
										$userID = $row[0];
										$firstName = $row[1];
										$lastName = $row[2];
										$email = $row[3];
										$major = $row[4];?>
								<tr>
									<td><?php echo $firstName + ' ' + $lastName;?></td>
									<td><?php echo $major;?></td>
									<td><?php echo $email;?></td>
								</tr>
								<?php
									}
								?>
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
    				<div role="tabpanel" class="tab-pane" id="administrators">
    					<h3 style="margin-top:0">Managing Administrators</h3>
    					<button class="btn btn-success btn-sm" id="addAdminBtn" style="display:inline-block" data-toggle="modal" data-target="#crudModal"><span class="glyphicon glyphicon-plus"></span>Add Administrator</button>
    					<table id="displayAdmins" class="display">
							<thead>
								<tr>
									<th>Name</th>
									<th>Classes</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Don Evans</td>
									<td>Senior Design</td>
								</tr>
								<tr>
									<td>Dona Mularkey</td>
									<td>Senior Design</td>
								</tr>
								<tr>
									<td>Carlos Davila</td>
									<td>Senior Design</td>
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