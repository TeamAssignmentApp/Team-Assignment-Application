var numPrefs = [];


$(document).ready(function(){
	//load the tables first
	var classTable = $("#displayClasses").DataTable();
	var userTable = $("#displayUsers").DataTable({
		"language" : {
			"zeroRecords": "Please select a class from the dropdown above."
		}
	});
	var projectTable = $("#displayProjects").DataTable({
		"language" : {
			"zeroRecords": "Please select a class from the dropdown above."
		}
	});
	//var adminTable = $("#displayAdmins").DataTable();
	var skillTable = $("#displaySkills").DataTable({
		"language" : {
			"zeroRecords": "Please select a class from the dropdown above."
		}
	});
	$('#adminTabs a').click(function (e) {
		e.preventDefault()
		$(this).tab('show')
	});

	$.get("api/user.php", {id: getThisUserID(), token:'9164fe76dd046345905767c3bc2ef54', isAdmin: 1}, function(data){
		var parsedData = JSON.parse(data);
		console.log("parsedData");
		console.log(parsedData)
		var classes = parsedData["classIds"];
		var classArr = [];
		var allMajors = parsedData["allMajors"];
		$(allMajors).each(function(i,major){
			$(".studentMajorSelection").append('<option value="' + major["majorID"] + '">' + major["majorName"] + '</option>');
		});
		$(classes).each(function(index,classID){
			$.get("api/class.php", {id: classID, token:'9164fe76dd046345905767c3bc2ef54'}, function(classData){
				console.log('classData');
				console.log(classData);
				var parsedClassData = JSON.parse(classData);
				console.log("parsedClassData");
				console.log(parsedClassData);
				var allUsersAllProjects = parsedClassData["users"];
				var thisClassProjects = parsedClassData["projects"];
				var thisClassSkills = parsedClassData["skills"];
				console.log(allUsersAllProjects);
				if(allUsersAllProjects.length == 0) {
					console.log('going to insert to the class table');
					classArr.push(parsedClassData["name"]);
					var convertedStartDate = convertDate(parsedClassData["startTime"]);
					var convertedEndDate = convertDate(parsedClassData["endTime"]);
					var prettyStartDate = dateToString(convertedStartDate);
					var prettyEndDate = dateToString(convertedEndDate);

					//add this class to the dropdown for letting the admin select which class to manipulate (users, projects, skills)
					$(".classDropdown").append("<option value='" + classID + "'>" + parsedClassData["name"] + "</option>");

					var actionButtons = '<a class="btn-info btn-xs btn" onclick="addUsersFromCSV(' + parsedClassData["id"] + ')">CSV</a>&nbsp;' +
										'<a class="btn-default btn-xs btn" onclick="runTeamAssignment(' + parsedClassData["id"] + ')">Team Assignment</a>';
					if(parsedClassData["adminIds"].length == 0) {
							classTable.row.add([parsedClassData["name"], prettyStartDate, prettyEndDate, "None", actionButtons]).draw();
						}
						else {
							var commaSepAdminNames = '';
							var numAdmins = parsedClassData["adminIds"].length;
							$(parsedClassData["adminIds"]).each(function(ind, adminId) {
								$.get("api/user.php", {id: adminId, token:'9164fe76dd046345905767c3bc2ef54', isAdmin:1}, function(adminData) {
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
				else{
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

							//add this class to the dropdown for letting the admin select which class to manipulate (users, projects, skills)
							$(".classDropdown").append("<option value='" + classID + "'>" + parsedClassData["name"] + "</option>");

							var actionButtons = '<a class="btn-info btn-xs btn" onclick="addUsersFromCSV(' + parsedClassData["id"] + ')">CSV</a>&nbsp;' +
									'<a class="btn-default btn-xs btn" onclick="runTeamAssignment(' + parsedClassData["id"] + ')">Team Assignment</a>&nbsp;';
							if(parsedClassData["adminIds"].length == 0) {
								classTable.row.add([parsedClassData["name"], prettyStartDate, prettyEndDate, "None", actionButtons]).draw();
							}
							else {
								classTable.row.add([parsedClassData["name"], prettyStartDate, prettyEndDate, '<span id="adminNames-' + classID + '"></span>', actionButtons]).draw();
								var numAdmins = parsedClassData["adminIds"].length;
								$(parsedClassData["adminIds"]).each(function(ind, adminId) {
									console.log('getting admin ' + adminId);
									$.get("api/user.php", {id: adminId, token:'9164fe76dd046345905767c3bc2ef54', isAdmin:1}, function(adminData) {
										var parsedAdminData = JSON.parse(adminData);
										$("#adminNames-" + classID).append(parsedAdminData["fname"] + ' ' + parsedAdminData["lname"] + ', ');
										if(ind == (numAdmins - 1)) {
											//trim off the last comma-space
											setTimeout(function(){
												var namesFromTable = $("#adminNames-" + classID).text();
												$("#adminNames-" + classID).text(namesFromTable.substring(0, namesFromTable.length - 2));		
											}, 3000);
																				
										}											
									});
								});
								
							}
							$("#reqPageSelect").append('<option value="' + parsedClassData["id"] + '">' + parsedClassData["name"] + '</option>');
							numPrefs[parsedClassData["name"]] = {"numProjPrefs": parsedClassData["numProjPrefs"], "numTeamPrefs": parsedClassData["numTeamPrefs"]};
						}	
						$.get("api/user.php", {id: user["id"], token:'9164fe76dd046345905767c3bc2ef54', isAdmin:0}, function(userData){
							var parsedUserData = JSON.parse(userData);
							var userActionBtns = 	'<a class="btn btn-primary btn-sm" onclick="editUser(' + user["id"] + ')">Edit</a>' +
													'<a class="btn btn-danger btn-sm" onclick="deleteUser(' + user["id"] + ')">Delete</a>';
							userTable.row.add([parsedUserData["fname"] + " " + parsedUserData["lname"], user["major"]["name"], parsedUserData["email"], classID, userActionBtns]).draw();
						});
					});
				}
				$(thisClassProjects).each(function(index,proj){
					var thisProjectMajors = proj["majors"];
					var thisProjectNumMajors = thisProjectMajors.length;
					var majorReqStr = "";
					$(thisProjectMajors).each(function(majorInd,major){
						majorReqStr += major["name"] + ": " + major["number"];
						if(majorInd < (thisProjectNumMajors - 1)) {
							majorReqStr += ', ';
						}
					});
					var editProjectButton = '<a class="btn btn-info btn-xs editProjectBtn" data-toggle="modal" onclick="editProject(' + proj["id"] + ')">Edit</a>';
					var deleteProjectButton = '<a class="btn btn-danger btn-xs" onclick="deleteProject(' + proj["id"] + ')">Delete</a>';
					var projectActionButtons = editProjectButton + "&nbsp;" + deleteProjectButton;
					projectTable.row.add([proj["name"], proj["description"],proj["fileLink"],majorReqStr, classID, projectActionButtons]).draw();
				});

				$(thisClassSkills).each(function(index,skl){
					var deleteSkillButton = '<a class="btn btn-danger btn-sm" onclick="deleteSkill(' + skl["id"] + ')">Delete</a>';
					skillTable.row.add([skl["name"], classID, deleteSkillButton]);
				});
			});
		});
	});


	//Single CRUD modal is no longer a thing
	/*$("#crudModal").on("hidden.bs.modal", function() {
		$("#crudBody").empty();
	});

	$('#crudModal').on('show.bs.modal', function () {
	       $(this).find('.modal-body').css({
	              width:'auto', //probably not needed
	              height:'auto', //probably not needed 
	              'max-height':'100%'
	       });
	});*/

	//Asynchronous modal population is no longer a thing
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

	$("#editProjectModal").on("hidden.bs.modal", function() {
		$("#editProjMajorForEachStudent").empty();
	});

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
	$("#newProjectNumStudents").change(function(){
		$("#majorForEachStudent").empty();
		for(var i = 0; i < $("#newProjectNumStudents").val(); i++){
			$("#majorForEachStudent").append($("#newStudentMajorTemplate").html());
		}
	});

	//initialize datepickers for class start dates and end dates
	$("#newClassStartDate").datepicker();
	$("#newClassEndDate").datepicker();

	uuserTable.columns(3).search(-1,true,false).draw();
	projectTable.columns(4).search(-1,true,false).draw();
	skillTable.columns(1).search(-1,true,false).draw();

	//make it so that the class dropdowns will filter the user and project tables
	$("#userClassDropdown").change(function() {
		var searchReg = "^" + $(this).val() + "$";
		userTable.column(3).search(searchReg,true,false).draw();
	});
	$("#projectClassDropdown").change(function() {
		var searchReg = "^" + $(this).val() + "$";
		projectTable.column(4).search(searchReg,true,false).draw();
	});
	$("#skillClassDropdown").change(function() {
		var searchReg = "^" + $(this).val() + "$";
		skillTable.column(1).search(searchReg,true,false).draw();
	});

	$("#saveProjReqPageChanges").click(function(){
		editRequestPage();
	});
});
////////////////////////////
//END DOCUMENT READY
////////////////////////////

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function convertDate(dateStr) {
	var split = dateStr.split('-');
	var year = split[0];
	var month = split[1];
	var day = split[2];
	var date = new Date(year,month-1,day);
	return date;
}

function dateToString(date) {
	var strToRet = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
	//this results from a null PHP date
	if(strToRet == '11/30/1899')
		return "None";
	else
		return strToRet;
}

//CLASS FUNCTIONS
//GET THESE OUTTA HERE
//save these for master admindash
/*
function addClass() {
	console.log("creating new class");
	var error = false;
	$(".newClassField").each(function(i, field) {
		if($(this).val() == "")
			error = true;
	});
	if(!error) {
		$("#newClassError").hide();
		var name = $("#newClassName").val();
		var numProjPrefs = $("#newClassNumProjPrefs").val();
		var numTeamPrefs = $("#newClassNumTeammatePrefs").val();
		var startDate = $("#newClassStartDate").val();
		var endDate = $("#newClassEndDate").val();
		$.post("api/class.php", {
			id: classid, 
			token:'9164fe76dd046345905767c3bc2ef54',
			className: name,
			numProjectPrefs: numprojPrefs,
			numTeammatePrefs: numTeamPrefs,
			startTime: startDate,
			endTime: endDate
		});
	}

	else {
		$("#newClassError").show();
	}
}

function editClass(classid) {
	console.log('will edit class ' + classid);
	
}

function deleteClass(id){
	console.log('will delete class ' + id);
}*/

//USER FUNCTIONS
function addUser() {
	var error = false;
	$(".newUserInput").each(function(i, input) {
		if($(this).val() == "")
			error = true;
	});

	if(!error) {
		$("#newUserError").hide();
		var newUserClassSelect = $("#newUserClassSelect").val();
		var newUserFirstName = $("#newUserFirstName").val();
		var newUserLastName = $("#newUserLastName").val();
		var newUserMajor = $("#newUserMajor").val();
		var newUserEmail = $("#newUserEmail").val();
		var newUserMajor = $("#newUserMajor").val();
		$.post("api/user.php", {
			token:'9164fe76dd046345905767c3bc2ef54',
			email: newUserEmail,
			fname: newUserFirstName,
			lname: newUserLastName,
			password: 'password', //temporary. on first login user has to change it
			classId: newUserClassSelect,
			majorId: newUserMajor,
			isAdmin: 0
		}, function(){
			location.reload();
		});
	}

	else {
		$("#newUserError").show();
	}
}

function editUser(idToEdit) {
	$("#editUserModal").modal('show');
	$.get('api/user.php', {token: '9164fe76dd046345905767c3bc2ef54', id: idToEdit, isAdmin: 0}, function(userData) {
		var parsedUserData = JSON.parse(userData);
		var thisUserClasses = parsedUserData['classIds'];
		var thisUserFName = parsedUserData['fname'];
		var thisUserLName = parsedUserData['lname'];
		var thisUserMajor = parsedUserData['major'];
		var thisUserEmail = parsedUserData['email'];

		$(thisUserClasses).each(function(classInd, classId) {
			$("#editUserClassSelect option[value='" + classId + "']").prop("selected",true);
		});
		$("#editUserFirstname").val(thisUserFName);
		$("#editUserLastName").val(thisUserLName);
		$("#editUserEmail").val(thisUserEmail);
		$("#editUserMajor").val(thisUserMajor);
	});
	$("#editUserSubmit").click(function(){submitUserEdit(idToEdit)});
}

function submitUserEdit(idToEdit) {
	var error = false;
	$(".editUserInput").each(function(i, input) {
		if($(this).val() == "")
			error = true;
	});

	if(!error) {
		$("#editUserError").hide();
		var editUserClassSelect = $("#editUserClassSelect").val();
		var commaSepUserClasses = '';
		$(editUserClassSelect).each(function(i,selectVal) {
			commaSepUserClasses += selectVal + ',';
		});
		var editUserFirstName = $("#editUserFirstName").val();
		var editUserLastName = $("#editUserLastName").val();
		var editUserMajor = $("#editUserMajor").val();
		var editUserEmail = $("#editUserEmail").val();
		var editUserMajor = $("#editUserMajor").val();
		$.ajax({
			url: "api/user.php",
			type: 'PUT', 
			data: {
				token:'9164fe76dd046345905767c3bc2ef54',
				email: newUserEmail,
				fname: newUserFirstName,
				lname: newUserLastName,
				password: 'password', //temporary. on first login user has to change it
				classes: commaSepUserClasses,
				majorId: newUserMajor,
				id: idToEdit
			},
			success:function(){
				location.reload();
			});
		});
	}

	else {
		$("#editUserError").show();
	}
}

function deleteUser(idToDelete) {
	if(confirm('Are you sure you would like to delete this user?')) {
		$.ajax({
			url: "api/user.php",
			type: 'DELETE',
			data: {id: idToDelete, token: '9164fe76dd046345905767c3bc2ef54'},
			success: function(result) {
				location.reload();
			}
		});
	}
}

//PROJECT FUNCTIONS
function addProject() {
	var error = false;
	$(".newProjectInput:visible").each(function(i, input) {
		if($(this).val() == "")
			error = true;
	});
	if(!error) {
		$("#newProjectError").hide();
		var newProjectClassSelect = $("#newProjectClassSelect").val();
		var newProjectName = $("#newProjectName").val();
		var newProjectDescription = $("#newProjectDescription").val();
		//var newProjectNumStudents = $("#newProjectNumStudents").val();
		var newProjectFileLink = 'N/A';
		var majorsAndNumbers = [];

		$(".addProjectMajorSelect:visible").each(function(ind,majorSelec) {
			var thisSelec = $(majorSelec).val();
			var indexOfThisMajor = -1;
			$.each(majorsAndNumbers, function(j, obj) {
				if (obj["majorId"] == thisSelec) {
					indexOfThisMajor = j;
				}
			});

			if(indexOfThisMajor == -1) {
				majorsAndNumbers.push({"majorId":thisSelec, "amount":1});
			}
			else {
				majorsAndNumbers[indexOfThisMajor]["amount"]++;
			}
		});

		console.log('descrip');
		console.log(newProjectDescription);

		$.post("api/project.php", {
			token: '9164fe76dd046345905767c3bc2ef54',
			name: newProjectName,
			descrip: newProjectDescription,
			file: newProjectFileLink,
			classId: newProjectClassSelect,
			majors: JSON.stringify(majorsAndNumbers)
		}, function(){
			location.reload();
		});
	}
	else {
		$("#newProjectError").show();
	}
}

function editProject(idToEdit) {
	$("#editProjectModal").modal('show');
	//get the project's info first so that we can pre-populate the modal
	$.get("api/project.php",{id:idToEdit, token: '9164fe76dd046345905767c3bc2ef54'}, function(dataToEdit) {
		var parsedDataToEdit = JSON.parse(dataToEdit);
		var classIdToEdit = parsedDataToEdit['classId']; //this doesn't work
		var projectNameToEdit = parsedDataToEdit['projectName'];
		var allMajorsToEdit = parsedDataToEdit['majors'];
		var descriptionToEdit = parsedDataToEdit['projectDesc'];
		var totalNumStudents = 0;
		$(allMajorsToEdit).each(function(i, major) {
			totalNumStudents += major["number"];
			for(var j = 0; j < major["number"]; j++) {
				$("#editProjMajorForEachStudent").append($("#editStudentMajorTemplate").html());
				$("#editProjMajorForEachStudent .studentMajorSelection").last().val(major["id"]);
			}
		});
		$("#editProjectName").val(projectNameToEdit);
		$("#editProjectNumStudents").val(totalNumStudents);
		$("#editProjectClassSelect").val(classIdToEdit);
		$("#editProjectDescription").val(descriptionToEdit);
	});
	$("#submitProjectEditBtn").click(function(){submitProjectEdit(idToEdit)});
}

function submitProjectEdit(idToEdit) {
	var error = false;
	$(".editProjectInput:visible").each(function(i, input) {
		if($(this).val() == "")
			error = true;
	});
	if(!error) {
		$("#editProjectError").hide();
		var editProjectClassSelect = $("#editProjectClassSelect").val();
		var editProjectName = $("#editProjectName").val();
		var editProjectDescription = $("#editProjectDescription").val();
		//var newProjectNumStudents = $("#newProjectNumStudents").val();
		var editProjectFileLink = 'N/A';
		var majorsAndNumbers = [];

		$(".editProjectMajorSelection").each(function(ind,majorSelec) {
			var thisSelec = $(majorSelec).val();
			var indexOfThisMajor = -1;
			$.each(majorsAndNumbers, function(j, obj) {
				if (obj["majorId"] == thisSelec) {
					indexOfThisMajor = j;
				}
			});

			if(indexOfThisMajor == -1) {
				majorsAndNumbers.push({"majorId":thisSelec, "amount":1});
			}
			else {
				majorsAndNumbers[indexOfThisMajor]["amount"]++;
			}
		});

		$.ajax({
			url: 'api/project.php', 
			type: 'PUT',
			data: {
				token: '9164fe76dd046345905767c3bc2ef54',
				id: idToEdit,
				name: editProjectName,
				descrip: editProjectDescription,
				file: editProjectFileLink,
				classId: editProjectClassSelect,
				majors: JSON.stringify(majorsAndNumbers)
			}, 
			success: function(){
				location.reload();
			}
		});
	}
	else {
		$("#editProjectError").show();
	}
}

function deleteProject(idToDelete) {
	if(confirm("Are you sure you would like to delete this project?")) {
		$.ajax({
			url: "api/project.php",
			type: 'DELETE',
			data: {id: idToDelete, token: '9164fe76dd046345905767c3bc2ef54'},
			success: function(result) {
				location.reload();
			}
		});
	}
}

//SKILL FUNCTIONS
function addSkill() {
	var error = false;
	$(".newSkillInput").each(function(i, input) {
		if($(this).val() == "")
			error = true;
	});

	if(!error) {
		$("#newSkillError").hide();
		var newSkillClassSelect = $("#newSkillClassSelect").val();
		var newSkillName = $("#newSkillName").val();

		$.post("api/skill.php", {
			token: '9164fe76dd046345905767c3bc2ef54',
			isUserCreated: 0,
			name: newSkillName,
			classId: newSkillClassSelect
		}, function() {
			location.reload();
		});
	}
	else {
		$("#newSkillError").show();
	}
}

function deleteSkill(idToDelete) {
	if(confirm("Are you sure you would like to delete this skill?")) {
		$.ajax({
			url: "api/skill.php",
			type: 'DELETE',
			data: {id: idToDelete, token: '9164fe76dd046345905767c3bc2ef54'},
			success: function(result) {
				location.reload();
			}
		});
	}
}

//REQUEST PAGE FUNCTION
function editRequestPage() {
	var reqPageSelect = $("#reqPageSelect").val();
	var numTeamReqs = $("#numTeammateReqs").val();
	var numProjectReqs = $("#numProjects").val();
	if(reqPageSelect != "" && numTeamReqs != "" && numProjectReqs != "") {
		$.ajax({
			url: "api/class.php",
			type: 'PUT',
			data: {
				token: '9164fe76dd046345905767c3bc2ef54',
				id: reqPageSelect,
				numProjectPrefs: numProjectReqs,
				numTeammatePrefs: numTeamReqs
			},
			success: function(){
				location.reload();
			}
		});
	}
}

//UPLOAD CSV FUNCTION
function addUsersFromCSV(classid) {
	$("#uploadCSVModal").modal('show');
	$("#classID").val(classid);
}

//TEAM ASSIGNMENT FUNCTION
function runTeamAssignment(classid) {
	if(confirm("Are you sure you would like to run team assignment on this class?")) {
		$.post('runAssignmentManually.php', {classID: classid}, function() {
			location.reload();
		});
	}
}