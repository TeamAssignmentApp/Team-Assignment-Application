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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/styles.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script>
			function getParameterByName(name) {
			    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
			    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			        results = regex.exec(location.search);
			    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
			}

			$(document).ready(function(){
				$.get("api/class.php", {id:getParameterByName('classID'), token:'9164fe76dd046345905767c3bc2ef54'}, function(data){
					console.log(data);
					var parsed = JSON.parse(data);
					var projects = parsed["projects"];
					var strToAdd = '';
					
					$(projects).each(function(index,value){
						if(index % 3 == 0)
							strToAdd += "<div class='row'";
						strToAdd += ''+
							'<div class="col-md-4">' +
								'<div class="well">' +
									'<h2>' + value["name"] + '</h2>' +
									'<h3>Description</h3>' +
									'<p>' + value["description"] + '</p>' +
									'<h3>Team Members</h3>' +
									'<ul class="list-group" id="studentList-' + value["id"] + '"">' +
									'</ul>' +
								'</div>' +
							'</div>';
							$.get('api/project.php', {id: value["id"], token:'9164fe76dd046345905767c3bc2ef54'}, function(projData) {
								var parsedProjData = JSON.parse(projData);
								var projStudents = parsedProjData["users"];
								if(parsedProjData.length == 0) {
									strToAdd += '<li class="list-group-item">None</li>';
								}
								else {
									$(projStudents).each(function(i,projStudent) {
										$("#studentList-" + value["id"]).append('<li class="list-group-item">' + projStudent["fname"] + ' ' + projStudent["lname"] + ' (' + projStudent["email"] + ')</li>');
									});
								}
							});
						if((index - 1) % 3) {
							strToAdd += '</div>';
						}
					});
					$("#results").append(strToAdd);
				});
			})
		</script>
	</head>
	<body>
		<div class="container">
            <div class="col-md-12" id="header" style="text-align:center">
				<img src="css/LyleLogo.png" alt="LyleLogo" height="100" width="800">
				<a href="logout.php" class="btn btn-danger" style="display:inline-block; float:right; margin-top:20px">Logout</a>
				<a href="changepasswordUI.php" class="btn btn-primary btn-sm" style="display:inline-block; float:right; margin-top:20px; margin-right:10px">Change Password</a>
			</div>

		</div>
		<div class="container" id="results" style="margin-top:50px">
		</div>
	</body>
</html>