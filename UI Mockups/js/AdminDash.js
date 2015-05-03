var numPrefs = [];


$(document).ready(function(){
	//load the tables first
	var classTable = $("#displayClasses").DataTable();
	var userTable = $("#displayUsers").DataTable();
	var projectTable = $("#displayProjects").DataTable();
	//var adminTable = $("#displayAdmins").DataTable();
	var skillTable = $("#displaySkills").DataTable();
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
		$(classes).each(function(index,classID){
			$.get("api/class.php", {id: classID, token:'9164fe76dd046345905767c3bc2ef54'}, function(classData){
				console.log('classData');
				console.log(classData);
				var parsedClassData = JSON.parse(classData);
				console.log("parsedClassData");
				console.log(parsedClassData);
				var allUsersAllProjects = parsedClassData["users"];
				var thisClassProjects = parsedClassData["projects"];
				console.log(allUsersAllProjects);
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

							var actionButtons = '<a class="btn-primary btn-sm" onclick="editClass(' + parsedClassData["id"] + ')">Edit</a>&nbsp;' +
												'<a class="btn-danger btn-sm" onclick="deleteClass(' + parsedClassData["id"] + ')">Delete</a>';
							if(parsedClassData["adminIds"].length == 0) {
							classTable.row.add([parsedClassData["name"], prettyStartDate, prettyEndDate, "None", actionButtons]).draw();
						}
						else {
							var commaSepAdminNames = '';
							var numAdmins = parsedClassData["adminIds"].length;
							$(parsedClassData["adminIds"]).each(function(ind, adminId) {
								$.get("api/user.php", {id: adminId, token:'9164fe76dd046345905767c3bc2ef54', isAdmin: 1}, function(adminData) {
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
					$.get("api/user.php", {id: user["id"], token:'9164fe76dd046345905767c3bc2ef54', isAdmin:0}, function(userData){
						var parsedUserData = JSON.parse(userData);
						var deleteUserButton = '<a class="btn-danger btn-sm" onclick="deleteUser(' + user["id"] + ')">Delete</a>';
						userTable.row.add([parsedUserData["fname"] + " " + parsedUserData["lname"], parsedUserData["major"], parsedUserData["email"], classID, deleteUserButton]).draw();
					});
				});
				$(thisClassProjects).each(function(index,proj){
					var editProjectButton = '<a class="btn-info btn-sm editProjectBtn" onclick="editProject(' + proj["id"] + ')">Edit</a>';
					var deleteProjectButton = '<a class="btn-danger btn-sm" onclick="deleteProject(' + proj["id"] + ')">Delete</a>';
					var projectActionButtons = editProjectButton + "&nbsp;" + deleteProjectButton;
					projectTable.row.add([proj["name"], proj["description"],"",proj["fileLink"],"", classID, projectActionButtons]).draw();
				});
			});
			$.get('api/skill.php', {id: classID, token: '9164fe76dd046345905767c3bc2ef54'}, function(skillData) {
				var parsedSkillData = JSON.parse(skillData);
				$(parsedSkillData).each(function(skillIndex,theSkill) {
					var deleteSkillButton = '<a class="btn-danger btn-sm" onclick="deleteSkill(' + theSkill["id"] + ')">Delete</a>';
					skillTable.row.add([parsedSkillData["name"], classID, deleteSkillButton]);
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
			$("#majorForEachStudent").append($("#studentMajorTemplate").html());
		}
	});

	//initialize datepickers for class start dates and end dates
	$("#newClassStartDate").datepicker();
	$("#newClassEndDate").datepicker();

	userTable.columns(3).search(-1).draw();
	classTable.columns(5).search(-1).draw();

	//make it so that the class dropdowns will filter the user and project tables
	$("#userClassDropdown").change(function() {
		userTable.columns(3).search($(this).val()).draw();
	});
	$("#projectClassDropdown").change(function() {
		classTable.columns(5).search($(this).val()).draw();
	});
	$("#skillClassDropdown").change(function() {
		skillTable.columns(1).search($(this).val()).draw();
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
			isAdmin: false
		}, function(){
			location.reload();
		});
	}

	else {
		$("#newUserError").show();
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
	$(".newProjectInput").each(function(i, input) {
		if($(this).val() == "")
			error = true;
	});
	if(!error) {
		$("#newProjectError").hide();
		var newProjectClassSelect = $("#newProjectClassSelect").val();
		var newProjectName = $("#newProjectName").val();
		var newProjectDescription = $("#newProjectDescription").text();
		//var newProjectNumStudents = $("#newProjectNumStudents").val();
		var newProjectFileLink = 'N/A';

		$.post("api/project.php", {
			token: '9164fe76dd046345905767c3bc2ef54',
			name: newProjectName,
			descrip: newProjectDescription,
			file: newProjectFileLink,
			classId: newProjectClassSelect
		}, function(){
			location.reload();
		});
	}
	else {
		$("#newProjectError").show();
	}
}

function editProject(idToEdit) {
	//get the project's info first so that we can pre-populate the modal
	$.get("api/project.php",{id:idToEdit, token: '9164fe76dd046345905767c3bc2ef54'}, function(dataToEdit) {
		var parsedDataToEdit = JSON.parse(dataToEdit);
		var classIdToEdit = parsedDataToEdit['classId']; //this doesn't work
		var projectNameToEdit = parsedDataToEdit['name'];
		var allMajorsToEdit = parsedDataToEdit['majors'];
		var descriptionToEdit = parsedDataToEdit['projectDesc'];
		var totalNumStudents = 0;
		$(allMajorsToEdit).each(function(i, major) {
			totalNumStudents += major["number"];
			$("#editProjMajorForEachStudent").append($("#editStudentMajorTemplate").html());
			$("#editProjMajorForEachStudent .studentMajorSelection").last().val(major["id"]);
		});
		$("#editProjectName").val(projectNameToEdit);
		$("#editProjectNumStudents").val(totalNumStudents);
		$("#editProjectClassSelect").val(classIdToEdit);
		$("#editProjectDescription").text(descriptionToEdit);
	});
	$("#submitProjectEditBtn").click(function(){submitProjectEdit(idToEdit)});
}

function submitProjectEdit(idToEdit) {
	var error = false;
	$(".editProjectInput").each(function(i, input) {
		if($(this).val() == "")
			error = true;
	});
	if(!error) {
		$("#editProjectError").hide();
		var editProjectClassSelect = $("#editProjectClassSelect").val();
		var editProjectName = $("#editProjectName").val();
		var editProjectDescription = $("#editProjectDescription").text();
		var newProjectNumStudents = $("#newProjectNumStudents").val();
		var editProjectFileLink = 'N/A';

		$.ajax({
			url: 'api/project.php', 
			type: 'PUT',
			data: {
				token: '9164fe76dd046345905767c3bc2ef54',
				name: editProjectName,
				descrip: editProjectDescription,
				file: editProjectFileLink,
				classId: editProjectClassSelect
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

function deleteProject(id) {
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

		$.post("api/project.php", {
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