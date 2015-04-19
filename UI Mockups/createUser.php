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
			<span class="input-group-addon">Class</span>
			<select class="form-control studentMajorSelection">
				<?php
					$query = mysql_query("select className from Class", $connection);
					$rows = mysql_num_rows($query);
					if ($rows >= 1) {
						while ($result = mysql_fetch_array($query)){ ?>
							<option><?php echo $result['className'];?></option>
						<?php
						}
					}
				?>
			</select>
		</div>
		<div class="input-group" style="margin-bottom:10px">
			<span class="input-group-addon">First Name</span>
			<input class="form-control" type="text" />
		</div>
		<div class="input-group" style="margin-bottom:10px">
			<span class="input-group-addon">Last Name</span>
			<input class="form-control" type="text" />
		</div>


		<div class="input-group" style="margin-bottom:10px">
			<span class="input-group-addon">Major</span>
			<input class="form-control" type="text" />
		</div>
		<div class="input-group" style="margin-bottom:10px">
			<span class="input-group-addon">Email Address</span>
			<input class="form-control" type="text" />
		</div>
		<button class="btn btn-success" style="display:inline-block">Create User</button>
		&nbsp;&nbsp;
		<button class="btn btn-danger" style="display:inline-block">Reset Form</button>
