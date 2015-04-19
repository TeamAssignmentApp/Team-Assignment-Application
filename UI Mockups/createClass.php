<?php
	session_start();
	if(!isset($_SESSION['login_user'])){
		header("location: login.php");
	}
	else if ($_SESSION['isAdmin']==0){
		header("selectClass.php");
	}
?>

<div class="input-group" style="margin-bottom:10px">
			<span class="input-group-addon">Class Name</span>
			<input class="form-control" type="text" />
		</div>
		<div class="input-group" style="margin-bottom:10px">
			<span class="input-group-addon">Start Time</span>
			<input class="form-control" type="text" />
		</div>
		<div class="input-group" style="margin-bottom:10px">
			<span class="input-group-addon">End Time</span>
			<input class="form-control" type="text" />
		</div>
		<button class="btn btn-success" style="display:inline-block">Create Class</button>
		&nbsp;&nbsp;
		<button class="btn btn-danger" style="display:inline-block">Reset Form</button>