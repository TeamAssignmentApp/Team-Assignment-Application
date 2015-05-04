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
			$(document).ready(function(){
				$.get("api/class.php", {id:1, token:'9164fe76dd046345905767c3bc2ef54'}, function(data){
					console.log(data);
					var parsed = JSON.parse(data);
					var projects = parsed["projects"];
					
					$(projects).each(function(index,value){
						var strToAdd = "";
						strToAdd += ''+
							'<div class="col-md-4">' +
								'<div class="well">' +
									'<h2>' + value["name"] + '</h2>' +
									'<h3>Description</h3>' +
									'<p>' + value["description"] + '</p>' +
									'<h3>Required Majors</h3>' +
									'<ul class="list-group">';
							$(value["majors"]).each(function(index,value){
								strToAdd += '<li class="list-group-item">' + value["number"] + ' ' + value["name"] + '</li>';
							});
							// strToAdd += '</ul>' + 
							// 		'<h3>Attachment</h3>';
							// if(value["fileLink"] != "") {
							// 	strToAdd += "<a href='" + value["fileLink"] + "'>Link</a>";
							// }
							// else strToAdd += "None";
							strToAdd += '</div>' +
							'</div>';		
							$("#projectContainer").append(strToAdd);
					});
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
		<div class="container" id="projectContainer" style="margin-top:50px">
			
		</div>
	</body>
</html>