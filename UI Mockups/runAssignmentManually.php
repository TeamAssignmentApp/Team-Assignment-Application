<?php

//This function gets the best score in the matrix, returns the project and user ids associated with the score
function getLowestScore($arr, $maxPrefs)
{
	$minVal = $maxPrefs+2;
	$minProjId = -1;
	$minUserId = -1;
   	foreach($arr as $key => $val)
   	{
      	foreach ($val as $key2 => $val2){
      		if ($val2 < $minVal){
      			$minVal = $val2;
      			$minUserId = $key;
      			$minProjId = $key2;
      		}
      	}
   	}
   	$array = array();
   	$array[0] = $minProjId;
   	$array[1] = $minUserId;
   	$array[2] = $minVal;

   return $array;
}
$classIDs = array();
$connection = mysql_connect("localhost", "root", "321Testing");
$db = mysql_select_db("TeamAssignmentApp", $connection);
//Check if being called manually or through cron job
if (isset($_POST['classID'])){
	$thisClass = $_POST['classID'];
	session_start();
	if(!isset($_SESSION['login_user'])){
		mysql_close($connection);
		header("location: login.php");
	}
	if ($_SESSION['isAdmin'] == 0){
		mysql_close($connection);
		header("location: userpage.php");
	}
	else if ($_SESSION['isMaster'] == 0){
		//check if non-master admin is admin of this class
		$adminID = $_SESSION['login_user'];
		$adminQuery = mysql_query("SELECT * FROM AdminOf WHERE userID = '$AdminID'AND classID = '$thisClass'", $connection);
		if (mysql_num_rows($adminQuery) < 1){
			mysql_close($connection);
			header("location: AdminDash.php");
		}
	}
	array_push($classIDs, $_POST['classID']);
}
else{
	//cron job, get classIDs with current date.
	if(!isset($_SERVER['SERVER_NAME']))
	{
	    $curDate = date("Y-m-d");
		echo "date: " . $curDate;
		$classQuery = mysql_query("SELECT classID FROM Class WHERE endTime = '$curDate'", $connection);
		while ($row = mysql_fetch_array($classQuery)){
			array_push($classIDs, $row[0]);
		}
	}
	else{
		mysql_close($connection);
		header("location: selectClass.php");
	}

}

//STEP 1: GET CLASS ID OF CLASS(es) RUNNING ASSIGNMENT

//FOREACH CLASSID IN $classID
foreach ($classIDs AS $value){
	$classID = $value;
	//STEP 1: GET CLASS ID OF CLASS THAT IS RUNNING ASSIGNMENT

	//Before Assigning, clear previous assignment data
	if (isset($_POST['classID'])){
		$clearQuery = "DELETE FROM InProject WHERE ProjectID IN (SELECT ProjectID from HasProject WHERE classID = '$classID')";
		mysql_query($clearQuery);
	}
	$scoreArray = array();

	$prefCountQuery = mysql_query("SELECT projectPreferences FROM Class WHERE classID = '$classID'", $connection);
	$countRow = mysql_fetch_row($prefCountQuery);
	$numPrefs = $countRow[0];

	// STEP 2: Obtain the list of Users for the class
	$query = mysql_query("SELECT User.userID FROM User JOIN InClass ON User.userID = InClass.userID WHERE InClass.classID = '$classID' AND User.userID NOT IN (SELECT InProject.userID FROM InProject JOIN InClass ON InProject.userID = InClass.userID WHERE InClass.classID = '$classID')", $connection);
	while ($row = mysql_fetch_assoc($query)) {
		$userValues = array();
		$userID = $row['userID'];

		//Step 3: Obtain projects the user has listed as being preferred
		$query2 = mysql_query("SELECT DISTINCT Project.projectID, WantsProject.rank from Project LEFT JOIN WantsProject ON Project.projectID=WantsProject.projectID JOIN HasProject ON HasProject.projectID = Project.projectID WHERE (WantsProject.userID = '$userID' OR WantsProject.userID IS NULL) AND HasProject.classID = '$classID'", $connection);
		while ($row2 = mysql_fetch_assoc($query2)) {
			$projID = $row2['projectID'];
			//Score = rank, otherwise if unranked project score = maximum project preferences for the class + 1
			if (is_null($row2['rank'])){
				$userValues[$projID] = $numPrefs + 1;
			}
			else{
				$userValues[$projID] = $row2['rank'];
			}

			$skillQuery = mysql_query("SELECT * FROM HasSkill JOIN ProjectRequiresSkill ON ProjectRequiresSkill.skillID = HasSkill.skillID WHERE HasSkill.userID = '$userID' AND ProjectRequiresSkill.projectID = '$projID' ", $connection);
			$count = mysql_num_rows($skillQuery);

			//GET SKILLS OF USER AND PROJECT, SUBTRACT .2 FOR EACH SHARED SKILL.
			$userValues[$projID] -= (.2 * $count);
			
		}
		$scoreArray[$row['userID']] = $userValues;
	}
	echo print_r($scoreArray);
	$numAssigned=0;
	$numUsers = mysql_num_rows($query);
	while ($numAssigned < $numUsers){
		$checkThis = getLowestScore($scoreArray, $numPrefs);
		$projID = $checkThis[0];
		$userID = $checkThis[1];

		if ( $checkThis[2] != $numPrefs+2){
			//Get number of students assigned to that project of that user's major, make sure that is less than the number of students required by that project.
			$allowedQuery = mysql_query("SELECT number FROM RequiresMajor JOIN IsMajor ON IsMajor.majorID = RequiresMajor.majorID WHERE RequiresMajor.projectID = '$projID' AND IsMajor.UserID = '$userID'", $connection);
			$takenQuery = mysql_query("SELECT count(*) AS count FROM InProject JOIN IsMajor ON IsMajor.userID = InProject.userID WHERE IsMajor.majorID IN (SELECT majorID FROM IsMajor WHERE IsMajor.userID='$userID') AND InProject.projectID = '$projID'", $connection);
			$row = mysql_fetch_array($allowedQuery);
			$numberAllowed = $row[0];
			$row2 = mysql_fetch_array($takenQuery);
			$numberTaken = $row2[0];
			if ($numberTaken < $numberAllowed){
				// ADD USER TO PROJECT, REMOVE ROW FROM TABLE
				//echo 'user ' . $userID . ' can be added to project ' . $projID;
				$leaderCheck = mysql_query("SELECT InClass.wantsToLead FROM InClass WHERE userID = '$userID' && classID = '$classID'");
				$leaderrow = mysql_fetch_array($leaderCheck);
				$wantsToLead = $leaderrow[0];
				$leaderCheck2 = mysql_query("SELECT * FROM InProject WHERE isLeader = 1 AND projectID='$projID'");
				$rowcount = mysql_num_rows($leaderCheck2);
				if ($rowcount < 1 && $wantsToLead == 1){
					$isLeader = 1;
				}
				else{
					$isLeader = 0;
				}
				$sql = "INSERT INTO InProject (userID, projectID, isLeader) VALUES ('$userID', '$projID', '$isLeader')";

				mysql_query($sql);

				unset($scoreArray[$userID]);
				$numAssigned++;
			}
			else{
				//Project is full, set the score to maximum project preferences + 2 to prevent choosing this option in the next iteration.
				$scoreArray[$userID][$projID] = $numPrefs + 2;
			}
		}

	}
}
mysql_close($connection);
header("location: selectClass.php");
?>