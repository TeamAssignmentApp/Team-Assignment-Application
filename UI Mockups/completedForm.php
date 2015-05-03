<?php
	session_start();
	if(!isset($_SESSION['login_user'])){
		header("location: login.php");
	}
	else if (isset($_SESSION['isMaster'])){
		header("location: masterAdminDash.php");
	}
	else if ($_SESSION['isAdmin']==1){
		header("location: AdminDash.php");
	}
	else if (!isset($_POST['classID'])){
		header("location: selectClass.php");
	}
	$userInfo = fgetcsv($file);

	$DBServer = 'localhost';
	$DBUser   = 'root';
	$DBPass   = '321Testing';
	$DBName   = 'TeamAssignmentApp';

	$conn = mysqli_connect($DBServer, $DBUser, $DBPass, $DBName);
	$classID = $_POST['classID'];
	$userID = $_SESSION['login_user'];

	$result = mysqli_query($conn,"SELECT projectPreferences, teammatePreferences FROM Class WHERE classID = '$classID'");
	$row = mysqli_fetch_assoc($result);
	$projPrefs = $row['projectPreferences'];
	$teamPrefs = $row['teammatePreferences'];


	// Set leadership preference
	//SUBJET TO CHANGE WITH DB
	if (isset($_POST['isLeader'])){
		mysqli_query($conn,"UPDATE InClass SET wantsToLead = 1 WHERE userID = '$userID' AND classID = '$classID'");
	}
	else{
		mysqli_query($conn,"UPDATE InClass SET wantsToLead = 0 WHERE userID = '$userID' AND classID = '$classID'");
	}
	for ($i = 1; $i < $projPrefs; $i++){
		$projID = $_POST["ProjectPreference".$i];
		mysqli_query($conn,"INSERT INTO WantsProject (userID, projectID, rank) VALUES ('$userID', '$projID', '$i')");

	}
	for ($i = 1; $i < $teamPrefs; $i++){
		$teammateID = $_POST["TeammatePreference".$i];
		mysqli_query($conn,"INSERT INTO WantsTeammate (userID, teammateID, rank) VALUES ('$userID', '$teammateID', '$i')");

	}
	for ($i = 1; $i < $teamPrefs; $i++){
		$teammateID = $_POST["TeammatePreference".$i];
		mysqli_query($conn,"INSERT INTO WantsTeammate (userID, teammateID, rank) VALUES ('$userID', '$teammateID', '$i')");

	}
	$i = 0;
	while (isset($_POST["Skill".$i])){
		$skillID = $_POST["Skill".$i];
		if (!empty($skillID)){
			mysqli_query($conn,"INSERT INTO HasSkill (userID, skillID) VALUES ('$userID', '$skillID')");
		}
		$i++;
	} 
?>