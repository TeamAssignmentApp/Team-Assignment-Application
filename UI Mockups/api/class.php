<?php
	$DBServer = 'localhost';
	$DBUser   = 'root';
	$DBPass   = '321Testing';
	$DBName   = 'TeamAssignmentApp';
	$API_TOKEN = '9164fe76dd046345905767c3bc2ef54';
	
	$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
 
	if ($conn->connect_error) {
  		trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
	}
	
	$method = $_SERVER['REQUEST_METHOD'];
	if ($method == "GET") {
		handleGet($_GET);
	} else if ($method == "POST") {
		handlePost($_POST);
	} else if ($method == "PUT") {
		$params = null;
		parse_str(file_get_contents('php://input'), $params);
		handlePut($params);
	} else if ($method == "DELETE") {
		$params = null;
		parse_str(file_get_contents('php://input'), $params);
		handleDelete($params);
	}
	
	$conn->close();
	
	function handleGet($get) {
		global $conn, $API_TOKEN;
		$token = '' . $get["token"];
		if ($token != $API_TOKEN) {
			throwError(401, "API Token is not valid.");
			return;
		}		
		$id = $get["id"];
		$class = null;
		$class['id'] = $id;

		$userArr = array();
		$user = null;	
		$sql = 'Select u.userID, email, fname, lname, c.className, c.projectPreferences, c.teammatePreferences, c.startTime, c.endTime from Class c INNER JOIN InClass ic INNER JOIN User u ON u.userID = ic.userID WHERE c.classID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($user['id'], $user['email'], $user['fname'], $user['lname'], $class['name'], $class['numProjPrefs'], $class['numTeamPrefs'], $class['startTime'], $class['endTime']);
			while($stmt->fetch()) {
				$userArr[] = unserialize(serialize($user));
			}
			$class['users'] = $userArr;
		}
		
		$projectArr = array();
		$project = null;
		$sql = 'SELECT p.projectID, p.projectName, p.projectDesc, p.fileLink from Class c INNER JOIN HasProject hp INNER JOIN Project p ON p.projectID = hp.projectID WHERE c.classID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($project['id'], $project['name'], $project['description'], $project['fileLink']);
			while($stmt->fetch()) {
				$projectArr[] = unserialize(serialize($project));
			}
			for($i = 0; $i < sizeof($projectArr); $i++) {
				$projId = $projectArr[$i]['id'];
				$majorArr = array();
				$major = null;
				$sql = 'SELECT m.majorId, m.majorName, rm.number from Major m INNER JOIN RequiresMajor rm on m.majorId = rm.majorId INNER JOIN Project p on p.projectId = rm.projectId where p.projectId = ?';
				if($stmt = $conn->prepare($sql)) {
					$stmt->bind_param("i", $projId);
					$stmt->execute();
					$stmt->bind_result($major['id'], $major['name'], $major['number']);
					while($stmt->fetch()) {
						$majorArr[] = unserialize(serialize($major));
					}
					$projectArr[$i]['majors'] = unserialize(serialize($majorArr));
				}
			}
			$class['projects'] = $projectArr;
		}
		
		$skillArr = array();
		$skill = null;
		$sql = 'SELECT s.skillID, s.skillName from Class c INNER JOIN ClassHasSkill chs INNER JOIN Skill s ON s.skillID = chs.skillID WHERE c.classID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($skill['id'], $skill['name']);
			while($stmt->fetch()) {
				$skillArr[] = unserialize(serialize($skill));
			}
			$class['skills'] = $skillArr;
		}
		
		echo json_encode($class, JSON_PRETTY_PRINT);
	}
	
	function handlePost($post) {	
		global $conn, $API_TOKEN;
		$token = '' . $post["token"];
		if ($token != $API_TOKEN) {
			throwError(401, "API Token is not valid.");
			return;
		}

		$className = $post["className"];		
		$numProjPrefs = $post["projPrefs"];
		$numTeamPrefs = $post["teamPrefs"];
		$startTime = $post["startTime"];
		$endTime = $post["endTime"];
		
		$isError = false;
		$message = "";

		if($className == null) {
			$isError = true;
			$message .= "className field was missing \n";
		}
		if($numProjPrefs == null) {
			$isError = true;
			$message .= "projPrefs field was missing \n";
		}
		if($numTeamPrefs == null) {
			$isError = true;
			$message .= "teamPrefs field was missing \n";
		}
		if($startTime == null) {
			$isError = true;
			$message .= "startTime field was missing \n";
		}
		if($endTime == null) {
			$isError = true;
			$message .= "endTime field was missing \n";
		}
		
		if($isError) {
			throwError(500, $message);
			return;
		}
		
		$sql = 'INSERT into Class VALUES (0, ?, ?, ?, ?, ?)';
		
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("siiss", $className, $numProjPrefs, $numTeamPrefs, $startTime, $endTime);
			if(!$stmt->execute()) {
				throwError(500, "Error creating class");
			}
		}		
	}
	
	function handlePut($put) {
		
	}
	
	function handleDelete($delete) {
		global $conn, $API_TOKEN;
		$token = '' . $delete["token"];
		if ($token != $API_TOKEN) {
			throwError(401, "API Token is not valid.");
			return;
		}		
		$id = $delete["id"];
		
		$sql = 'DELETE FROM Class where classID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			if($stmt->affected_rows == 0) {
				throwError(500, "Class could not be deleted");
			}
		}
	}
	
	function throwError($errorCode, $errorMessage) {
		http_response_code($errorCode);
		echo $errorMessage;
	}
?>

