<?php
	session_start();
	if(!isset($_SESSION['login_user'])){
		header("Location: login.php");
	}
	else if (!isset($_SESSION['isMaster']) && $_SESSION['isAdmin'] == 0){
		header("Location: userpage.php");
	}
	else if (!isset($_SESSION['isMaster'])){
		header("Location: AdminDash.php");
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
		<script>function getThisUserID(){return <?php echo $_SESSION['login_user']; ?>};</script>
		<script src="js/masterAdminDash.js"></script>

	</head>
	<body>
		<div class="container">
			<div class="col-md-12" id="header" style="text-align:center">
				<img src="css/LyleLogo.png" alt="LyleLogo" height="100" width="800">
				<a href="logout.php" class="btn btn-danger" style="display:inline-block; float:right; margin-top:20px">Logout</a>
			</div>


			<div class="container well" style="width:90%; height:600px; margin-top:120px">
				<h3 style="text-align:center">Master Administrator Dashboard</h3>
				<div class="col-md-12" role="tabpanel">
					<ul class="nav nav-tabs" role="tablist" id="adminTabs">
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
							<a href="#skills" aria-controls="skills" role="tab" data-toggle="tab">Skills</a>
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
								<tbody>
								</tbody>
							</table>
						</div>
	    				<div role="tabpanel" class="tab-pane" id="users">
	    					<h3 style="margin-top:0; display:inline-block">Managing Users</h3>
	    					<button class="btn btn-success btn-sm" id="addUserBtn" style="display:inline-block" data-toggle="modal" data-target="#addUserModal"><span class="glyphicon glyphicon-plus"></span>Add User</button>
	    					<select class="classDropdown" id="userClassDropdown" style="display:inline-block">
	    						<option value="-1">--Please Select a Class To View--</option>
	    					</select>
	    					<table id="displayUsers" class="display">
								<thead>
									<tr>
										<th>Name</th>
										<th>Major</th>
										<th>Email</th>
										<th>Class ID</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
	    				</div>
	    				<div role="tabpanel" class="tab-pane" id="projects">
	    					<h3 style="margin-top:0; display:inline-block">Managing Projects</h3>
	    					<button class="btn btn-success btn-sm" id="addProjectBtn" style="display:inline-block" data-toggle="modal" data-target="#addProjectModal"><span class="glyphicon glyphicon-plus"></span>Add Project</button>
							<select class="classDropdown" id="projectClassDropdown" style="display:inline-block">
	    						<option value="-1">--Please Select a Class To View--</option>
	    					</select>
							<table id="displayProjects" class="display">
								<thead>
									<tr>
										<th>Name</th>
										<th>Description</th>
										<th>File Link</th>
										<th>Required Majors</th>
										<th>Class ID</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
	    				</div>
	    				<div role="tabpanel" class="tab-pane" id="skills">
	    					<h3 style="margin-top:0; display:inline-block">Managing Skills</h3>
	    					<button class="btn btn-success btn-sm" id="addSkillBtn" style="display:inline-block" data-toggle="modal" data-target="#addSkillModal"><span class="glyphicon glyphicon-plus"></span>Add Skill</button>
							<select class="classDropdown" id="skillClassDropdown" style="display:inline-block">
	    						<option value="-1">--Please Select a Class To View--</option>
	    					</select>
							<table id="displaySkills" class="display">
								<thead>
									<tr>
										<th>Name</th>
										<th>Class ID</th>
										<th>Delete</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
	    				</div>
	    				<div role="tabpanel" class="tab-pane" id="administrators">
	    					<h3 style="margin-top:0; display:inline-block">Managing Administrators</h3>
	    					<button class="btn btn-success btn-sm" id="addAdminBtn" style="display:inline-block" data-toggle="modal" data-target="#addAdminModal"><span class="glyphicon glyphicon-plus"></span>Add Administrator</button>
	    					<table id="displayAdmins" class="display">
								<thead>
									<tr>
										<th>Name</th>
										<th>Major</th>
										<th>Email</th>
										<th>Classes</th>
										<th>Delete</th>
									</tr>
								</thead>
								<tbody>
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
	    								</select>
	    							</div>
	    							<hr />
	    							<div class="input-group" style="width:400px">
	    								<label for="numTeammateReqs">Number of Teammate Requests Allowed</label>
	    								<input class="form-control requestPageInput" disabled type="number" min="0" max="8" value="0" id="numTeammateReqs"/>
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

			<!--modal display for classes for masteradmin only-->
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
								<input class="form-control newClassInput" type="text" id="newClassName" />
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon"># Project Requests</span>
								<input class="form-control newClassInput" type="text" id="newClassNumProjPrefs" />
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon"># Teammate Requests</span>
								<input class="form-control newClassInput" type="text" id="newClassNumTeammatePrefs" />
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Start Date</span>
								<input class="form-control newClassInput" type="text" id="newClassStartDate" />
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">End Date</span>
								<input class="form-control newClassInput" type="text" id="newClassEndDate" />
							</div>
							<p id="newClassError" style="display:none; text-color:red">All fields are required.</p>
							<button class="btn btn-success" style="display:inline-block" onclick="addClass()">Create Class</button>
							&nbsp;&nbsp;
							<button class="btn btn-danger" style="display:inline-block" onclick='$(".newClassInput").val("")'>Reset Form</button>
						</div>
					</div>
				</div>
			</div>

			<!--modal display for editing classes-->
			<div class="modal fade" id="editClassModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="addClassTitle">Editing Class...</h4>
						</div>
						<div class="modal-body" id="addClassBody">
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Class Name</span>
								<input class="form-control editClassInput" type="text" id="editClassName" />
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon"># Project Requests</span>
								<input class="form-control editClassInput" type="text" id="editClassNumProjPrefs" />
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon"># Teammate Requests</span>
								<input class="form-control editClassInput" type="text" id="editClassNumTeammatePrefs" />
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Start Date</span>
								<input class="form-control editClassInput" type="text" id="editClassStartDate" />
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">End Date</span>
								<input class="form-control editClassInput" type="text" id="editClassEndDate" />
							</div>
							<p id="editClassError" style="display:none; text-color:red">All fields are required.</p>
							<button class="btn btn-success" style="display:inline-block" id="submitClassEditBtn">Save Changes</button>
						</div>
					</div>
				</div>
			</div>

			<!--modal display for adding users-->
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
								<select class="form-control newUserInput classDropdown" id="newUserClassSelect">
									<option value="">--Please Select--</option>
								</select>
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">First Name</span>
								<input class="form-control newUserInput" id="newUserFirstName" type="text" />
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Last Name</span>
								<input class="form-control newUserInput" id="newUserLastName" type="text" />
							</div>


							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Major</span>
								<select class="form-control newUserInput studentMajorSelection" id="newUserMajor">
									<option value="">--Please Select--</option>
								</select>
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Email Address</span>
								<input class="form-control newUserInput" id="newUserEmail" type="text" />
							</div>
							<p id="newUserError" style="display:none; color:red">All fields are required.</p>
							<button class="btn btn-success" style="display:inline-block" id="newUserSubmit" onclick="addUser()">Create User</button>
							&nbsp;&nbsp;
							<button class="btn btn-danger" style="display:inline-block" id="newUserReset" onclick="$('.newUserInput').val('')">Reset Form</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<!--modal display for editing users-->
			<div class="modal fade" id="editUserModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="editUserTitle">Editing User...</h4>
						</div>
						<div class="modal-body" id="editUserBody">
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Class</span>
								<select class="form-control editUserInput classDropdown" multiple id="editUserClassSelect">
									<option value="">--Please Select--</option>
								</select>
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">First Name</span>
								<input class="form-control editUserInput" id="editUserFirstName" type="text" />
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Last Name</span>
								<input class="form-control editUserInput" id="editUserLastName" type="text" />
							</div>


							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Major</span>
								<select class="form-control editUserInput studentMajorSelection" id="editUserMajor">
									<option value="">--Please Select--</option>
								</select>
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Email Address</span>
								<input class="form-control editUserInput" id="editUserEmail" type="text" />
							</div>
							<p id="newUserError" style="display:none; color:red">All fields are required.</p>
							<button class="btn btn-success" style="display:inline-block" id="editUserSubmit">Save Changes</button>
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
								<select class="form-control newProjectInput classDropdown" id="newProjectClassSelect">
									<option value="">--Please Select--</option>
								</select>
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Project Name</span>
								<input class="form-control newProjectInput" id="newProjectName" type="text" />
							</div>
							<label>Project Description</label><br/>
							<textarea class="form-control" id="newProjectDescription" style="margin-bottom:9px"></textarea>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Number of Students</span>
								<input type="number" min="2" max="10" value="2" id="newProjectNumStudents" class="form-control newProjectInput" />
							</div>
							<span id="majorForEachStudent">
								<div class="input-group" style="margin-bottom:10px">
									<span class="input-group-addon">Student Discipline</span>
									<select class="form-control newProjectInput studentMajorSelection addProjectMajorSelect">
										<option value="">--Please Select--</option>
									</select>
								</div>
								<div class="input-group" style="margin-bottom:10px">
									<span class="input-group-addon">Student Discipline</span>
									<select class="form-control newProjectInput studentMajorSelection addProjectMajorSelect">
										<option value="">--Please Select--</option>
									</select>
								</div>
							</span>
							<button class="btn btn-default" style="margin-bottom:10px">Upload Attachment</button>
							<br/>
							<p id="newProjectError" style="display:none; color:red">All fields are required.</p>
							<button class="btn btn-success" style="display:inline-block" onclick="addProject()">Submit</button>
							&nbsp;&nbsp;
							<button class="btn btn-danger" style="display:inline-block" onclick='$(".newProjectInput:not(#newProjectNumStudents)").val(""); $("#newProjectDescription").empty()'>Reset Form</button>
							<div id="newStudentMajorTemplate" style="display:none">
								<div class="input-group" style="margin-bottom:10px">
									<span class="input-group-addon">Student Discipline</span>
									<select class="form-control newProjectInput studentMajorSelection addProjectMajorSelect">
										<option value="">--Please Select--</option>
									</select>
								</div>
							</div>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<!--modal display for editing projects-->
			<div class="modal fade" id="editProjectModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="editProjectTitle">Editing Project...</h4>
						</div>
						<div class="modal-body" id="editProjectBody">
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Class</span>
								<select class="form-control editProjectInput classDropdown" id="editProjectClassSelect">
									<option value="">--Please Select--</option>
								</select>
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Project Name</span>
								<input class="form-control editProjectInput" id="editProjectName" type="text" />
							</div>
							<label>Project Description</label><br/>
							<textarea class="form-control" id="editProjectDescription" style="margin-bottom:9px"></textarea>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Number of Students</span>
								<input type="number" min="2" max="10" value="2" id="editProjectNumStudents" class="form-control editProjectInput" />
							</div>
							<span id="editProjMajorForEachStudent"></span>
							<button class="btn btn-default" style="margin-bottom:10px">Upload Attachment</button>
							<br/>
							<p id="editProjectError" style="display:none; color:red">All fields are required.</p>
							<button class="btn btn-success" style="display:inline-block" id="submitProjectEditBtn">Submit</button>
							&nbsp;&nbsp;
							<div id="editStudentMajorTemplate" style="display:none">
								<div class="input-group" style="margin-bottom:10px">
									<span class="input-group-addon">Student Discipline</span>
									<select class="form-control studentMajorSelection editProjectMajorSelect">
										<option value="">--Please Select--</option>
									</select>
								</div>
							</div>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<!--modal display for adding users-->
			<div class="modal fade" id="addAdminModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="addAdminTitle">Adding Admin...</h4>
						</div>
						<div class="modal-body" id="addAdminBody">
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Class</span>
								<select class="form-control newAdminInput classDropdown" id="newAdminClassSelect">
									<option value="">--Please Select--</option>
								</select>
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">First Name</span>
								<input class="form-control newAdminInput" id="newAdminFirstName" type="text" />
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Last Name</span>
								<input class="form-control newAdminInput" id="newAdminLastName" type="text" />
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Email Address</span>
								<input class="form-control newAdminInput" id="newAdminEmail" type="text" />
							</div>
							<p id="newAdminError" style="display:none; color:red">All fields are required.</p>
							<button class="btn btn-success" style="display:inline-block" id="newAdminSubmit" onclick="addAdmin()">Create Administrator</button>
							&nbsp;&nbsp;
							<button class="btn btn-danger" style="display:inline-block" id="newAdminReset" onclick="$('.newAdminInput').val('')">Reset Form</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<div class="modal fade" id="editAdminModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="editAdminTitle">Adding Admin...</h4>
						</div>
						<div class="modal-body" id="editAdminBody">
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Class</span>
								<select class="form-control editAdminInput classDropdown" multiple id="editAdminClassSelect">
									<option value="">--Please Select--</option>
								</select>
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">First Name</span>
								<input class="form-control editAdminInput" id="editAdminFirstName" type="text" />
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Last Name</span>
								<input class="form-control editAdminInput" id="editAdminLastName" type="text" />
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Email Address</span>
								<input class="form-control editAdminInput" id="editAdminEmail" type="text" />
							</div>
							<p id="editAdminError" style="display:none; color:red">All fields are required.</p>
							<button class="btn btn-success" style="display:inline-block" id="editAdminSubmit">Save Changes</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<div class="modal fade" id="addSkillModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="addSkillTitle">Adding Skill...</h4>
						</div>
						<div class="modal-body" id="addSkillBody">
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Class</span>
								<select class="form-control newSkillInput classDropdown" id="newSkillClassSelect">
									<option value="">--Please Select--</option>
								</select>
							</div>
							<div class="input-group" style="margin-bottom:10px">
								<span class="input-group-addon">Skill Name</span>
								<input class="form-control newSkillInput" id="newSkillName" type="text" />
							</div>
							<br/>
							<p id="newSkillError" style="display:none; color:red">All fields are required.</p>
							<button class="btn btn-success" style="display:inline-block" onclick="addSkill()">Submit</button>
							&nbsp;&nbsp;
							<button class="btn btn-danger" style="display:inline-block" onclick="$('.newSkillInput').val('')">Reset Form</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<div class="modal fade" id="uploadCSVModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="uploadCSVTitle">Uploading CSV File...</h4>
						</div>
						<div class="modal-body" id="uploadCSVBody">
							<form action="addUsersFromCSV.php" method="post" enctype="multipart/form-data">
								<input type="text" name="classID" id="classID" style="display:none" />
								<div class="input-group" style="margin-bottom:10px">
									<span class="input-group-addon">Class</span>
									<select class="form-control uploadCSVInput studentMajorSelection" id="majorID" name="majorID">
										<option value="">--Please Select--</option>
									</select>
								</div>
								<input type="file" name="csvFile" id="csvFile">Upload File...</button>
								<br/>
								<p id="uploadCSVError" style="display:none; color:red">All fields are required.</p>
								<input type="submit" class="btn btn-success" style="display:inline-block">Submit</input>
							</form>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</div>
	</body>
</html>