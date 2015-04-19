<?php
	session_start();
	if(!isset($_SESSION['login_user'])){
		header("location: login.php");
	}
?>

<!doctype html>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/styles.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<style>
			
		</style>
	</head>
	<body>
		<div class="container">
            <div class="col-md-12" id="header" style="text-align:center">
                <h1>SMU Lyle Multidisciplinary Senior Design</h1>
            </div>
		</div>
		<div class="container" style="margin-top:50px">
			<div class="col-md-4">
				<div class="well">
					<h2>Project 1</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Required Majors</h3>
					<ul class="list-group">
						<li class="list-group-item">2 Computer Science</li>
						<li class="list-group-item">2 Mechanical Engineering</li>
						<li class="list-group-item">2 Electrical Engineering</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 2</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Required Majors</h3>
					<ul class="list-group">
						<li class="list-group-item">2 Computer Science</li>
						<li class="list-group-item">2 Mechanical Engineering</li>
						<li class="list-group-item">2 Electrical Engineering</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 3</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Required Majors</h3>
					<ul class="list-group">
						<li class="list-group-item">2 Computer Science</li>
						<li class="list-group-item">2 Mechanical Engineering</li>
						<li class="list-group-item">2 Electrical Engineering</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 4</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Required Majors</h3>
					<ul class="list-group">
						<li class="list-group-item">2 Computer Science</li>
						<li class="list-group-item">2 Mechanical Engineering</li>
						<li class="list-group-item">2 Electrical Engineering</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 5</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Required Majors</h3>
					<ul class="list-group">
						<li class="list-group-item">2 Computer Science</li>
						<li class="list-group-item">2 Mechanical Engineering</li>
						<li class="list-group-item">2 Electrical Engineering</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 6</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Required Majors</h3>
					<ul class="list-group">
						<li class="list-group-item">2 Computer Science</li>
						<li class="list-group-item">2 Mechanical Engineering</li>
						<li class="list-group-item">2 Electrical Engineering</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 7</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Required Majors</h3>
					<ul class="list-group">
						<li class="list-group-item">2 Computer Science</li>
						<li class="list-group-item">2 Mechanical Engineering</li>
						<li class="list-group-item">2 Electrical Engineering</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 8</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Required Majors</h3>
					<ul class="list-group">
						<li class="list-group-item">2 Computer Science</li>
						<li class="list-group-item">2 Mechanical Engineering</li>
						<li class="list-group-item">2 Electrical Engineering</li>
					</ul>
				</div>
			</div>
			<div class="col-md-4">
				<div class="well">
					<h2>Project 9</h2>
					<h3>Description</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at tortor non lacus congue lacinia. Nunc nulla ipsum, laoreet in augue id, pharetra hendrerit eros. Pellentesque dignissim luctus lacus at condimentum. Aenean vitae diam nec tellus pellentesque egestas. Aenean a aliquam lorem. Praesent accumsan finibus nisl, sed vestibulum nibh tristique in. Vivamus semper sed justo quis varius. Donec consectetur neque egestas risus ultricies vestibulum. Etiam finibus mi ac dui imperdiet, ut pharetra urna hendrerit. Duis sagittis nisl eu purus accumsan venenatis. Morbi ex diam, efficitur id egestas sit amet, euismod et purus.</p>
					<h3>Required Majors</h3>
					<ul class="list-group">
						<li class="list-group-item">2 Computer Science</li>
						<li class="list-group-item">2 Mechanical Engineering</li>
						<li class="list-group-item">2 Electrical Engineering</li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>