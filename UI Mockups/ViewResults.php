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
									'<h3>Team Members</h3>' +
									'<ul class="list-group">';
							/*$(value["majors"]).each(function(index,value){
								strToAdd += '<li class="list-group-item">' + value["number"] + ' ' + value["name"] + '</li>';
							});*/
							strToAdd += '</ul>' + 
									'<h3>Attachment</h3>';
							if(value["fileLink"] != "") {
								strToAdd += "<a href='" + value["fileLink"] + "'>Link</a>";
							}
							else strToAdd += "None";
							strToAdd += '</div>' +
							'</div>';		
							$("#results").append(strToAdd);
					});
				});
			})
		</script>
	</head>
	<body>
		<div class="container">
                        <div class="col-md-12" id="header" style="text-align:center">
                                <h1>SMU Lyle Multidisciplinary Senior Design</h1>
                        </div>
		</div>
		<div class="container" id="results" style="margin-top:50px">
			<!--<div class="col-md-12" id="resultsExplanation" style="text-align:center">
				<h3>Teams have been selected. Results are below.</h3>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 1</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Group Members</h3>
					<ul class="list-group">
						<li class="list-group-item">Alex Russell</li>
						<li class="list-group-item">Nick Morris</li>
						<li class="list-group-item">Ian Cowley</li>
						<li class="list-group-item">Jeff Artigues</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 2</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Group Members</h3>
					<ul class="list-group">
						<li class="list-group-item">Alex Russell</li>
						<li class="list-group-item">Nick Morris</li>
						<li class="list-group-item">Ian Cowley</li>
						<li class="list-group-item">Jeff Artigues</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 3</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Group Members</h3>
					<ul class="list-group">
						<li class="list-group-item">Alex Russell</li>
						<li class="list-group-item">Nick Morris</li>
						<li class="list-group-item">Ian Cowley</li>
						<li class="list-group-item">Jeff Artigues</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 4</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Group Members</h3>
					<ul class="list-group">
						<li class="list-group-item">Alex Russell</li>
						<li class="list-group-item">Nick Morris</li>
						<li class="list-group-item">Ian Cowley</li>
						<li class="list-group-item">Jeff Artigues</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 5</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Group Members</h3>
					<ul class="list-group">
						<li class="list-group-item">Alex Russell</li>
						<li class="list-group-item">Nick Morris</li>
						<li class="list-group-item">Ian Cowley</li>
						<li class="list-group-item">Jeff Artigues</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 6</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Group Members</h3>
					<ul class="list-group">
						<li class="list-group-item">Alex Russell</li>
						<li class="list-group-item">Nick Morris</li>
						<li class="list-group-item">Ian Cowley</li>
						<li class="list-group-item">Jeff Artigues</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 7</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Group Members</h3>
					<ul class="list-group">
						<li class="list-group-item">Alex Russell</li>
						<li class="list-group-item">Nick Morris</li>
						<li class="list-group-item">Ian Cowley</li>
						<li class="list-group-item">Jeff Artigues</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 8</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Group Members</h3>
					<ul class="list-group">
						<li class="list-group-item">Alex Russell</li>
						<li class="list-group-item">Nick Morris</li>
						<li class="list-group-item">Ian Cowley</li>
						<li class="list-group-item">Jeff Artigues</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 9</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Group Members</h3>
					<ul class="list-group">
						<li class="list-group-item">Alex Russell</li>
						<li class="list-group-item">Nick Morris</li>
						<li class="list-group-item">Ian Cowley</li>
						<li class="list-group-item">Jeff Artigues</li>
					</ul>
				</div>
			</div>-->
		</div>
	</body>
</html>