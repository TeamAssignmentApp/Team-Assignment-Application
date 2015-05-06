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
		$project = null;		
		
		$sql = 'SELECT projectID, projectName, projectDesc, fileLink FROM Project p where p.projectID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($project['projectID'], $project['projectName'], $project['projectDesc'], $project['fileLink']);
			while($stmt->fetch()){}			
		}
		
		$userArr = array();
		$user = null;	
		$sql = 'Select u.userID, email, fname, lname from Project p INNER JOIN InProject ip ON p.projectID = ip.projectID INNER JOIN User u ON u.userID = ip.userID WHERE p.projectID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($user['id'], $user['email'], $user['fname'], $user['lname']);
			while($stmt->fetch()) {
				$userArr[] = unserialize(serialize($user));
			}
			$project['users'] = $userArr;
		}
		
		$majorArr = array();
		$major = null;
		$sql = 'SELECT m.majorId, m.majorName, rm.number from Major m INNER JOIN RequiresMajor rm on m.majorId = rm.majorId INNER JOIN Project p on p.projectId = rm.projectId where p.projectId = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($major['id'], $major['name'], $major['number']);
			while($stmt->fetch()) {
				$majorArr[] = unserialize(serialize($major));
			}
			$project['majors'] = $majorArr;
		}
		
		$sql = 'SELECT classID from HasProject WHERE projectID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($project['classId']);
			while($stmt->fetch()) {}
		}
		
		echo json_encode($project, JSON_PRETTY_PRINT);
	}
	
	function handlePost($post) {	
		global $conn, $API_TOKEN;
		$token = '' . $post["token"];
		if ($token != $API_TOKEN) {
			throwError(401, "API Token is not valid.");
			return;
		}
		
		$projectName = $post["name"];
		$projectDescrip = $post["descrip"];
		$fileLink = $post["file"];
		$classId = $post["classId"];
		$skillsStr = $post["skills"];
		
		$majorsStr = $post["majors"];
		
		$isError = false;
		$message = "";
		if($projectName == null) {
			$isError = true;
			$message .= "name field was missing \n";
		}
		if($projectDescrip == null) {
			$isError = true;
			$message .= "descrip field was missing \n";
		}
		if($fileLink == null) {
			$isError = true;
			$message .= "file field was missing \n";
		}
		if($classId == null) {
			$isError = true;
			$message .= "classId field was missing \n";
		}
		if($majorsStr != null) {
			$majors = json_decode($majorsStr, true);
			if($majors == null) {
				$isError = true;
				$message .= "majors was not valid json \n";
			}
		} else {
			$isError = true;
			$message .= "majors field was missing \n";
		}
		if($skillsStr != null) {
			$skills = json_decode($skillsStr, true);
			if($skills == null) {
				$isError = true;
				$message .= "majors was not valid json \n";
			}
		} else {
			$isError = true;
			$message .= "majors field was missing \n";
		}
		if($isError) {
			throwError(500, $message);
			return;
		}
		
		$sql = 'INSERT into Project VALUES (0, ?, ?, ?)';
				
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("sss", $projectName, $projectDescrip, $fileLink);
			$stmt->execute();
			$stmt->fetch();
		}
		
		$sql = 'SELECT LAST_INSERT_ID()';
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$stmt->bind_result($projectId);
		while($stmt->fetch());
		
		
		$sql = 'INSERT into HasProject VALUES (?,?)';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("ii", $classId,$projectId);
			$stmt->execute();
			while($stmt->fetch());
		}

		$sql = 'INSERT into HasProject VALUES (?,?)';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("ii", $classId,$projectId);
			$stmt->execute();
			while($stmt->fetch());
		}	
		
		addProjectMajors($projectId, $majors);
		addProjectSkills($projectId, $skills);
	}
	
	function addProjectMajors($projectId, $majors) {
		global $conn;
		$sql = "DELETE from RequiresMajor where projectID = ?";
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $projectId);
			$stmt->execute();
			while($stmt->fetch());
		}

		$sql = "INSERT into RequiresMajor VALUES ";
		$paramStr = "";
		$args = array();
		for($i = 0; $i < sizeof($majors); $i++) {
			$sql .= "(?,?,?),";
			$args[] = intval($majors[$i]['majorId']);
			$args[] = intval($projectId);
			$args[] = intval($majors[$i]['amount']);
			$paramStr .= "iii";
		}
		$sql = substr($sql, 0, -1);
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param($paramStr, ...$args);
			$stmt->execute();
			if($stmt->affected_rows == 0) {
				throwError(500, "The project majors preferences could not be added");
				return false;
			}
		}
		return true;
	}
		function addProjectSkills($projectId, $skills) {
		global $conn;
		$sql = "DELETE from ProjectRequiresSkill where projectID = ?";
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $projectId);
			$stmt->execute();
			while($stmt->fetch());
		}

		$sql = "INSERT into ProjectRequiresSkill VALUES ";
		$paramStr = "";
		$args = array();
		for($i = 0; $i < sizeof($skills); $i++) {
			$sql .= "(?,?),";
			$args[] = intval($skills[$i]['skillId']);
			$args[] = intval($projectId);
			$paramStr .= "ii";
		}
		$sql = substr($sql, 0, -1);
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param($paramStr, ...$args);
			$stmt->execute();
			if($stmt->affected_rows == 0) {
				throwError(500, "The project skills preferences could not be added");
				return false;
			}
		}
		return true;
	}
	
	function handlePut($put) {
		global $conn, $API_TOKEN;
		$token = '' . $put["token"];
		if ($token != $API_TOKEN) {
			throwError(401, "API Token is not valid.");
			return;
		}
		
		$projectId = $put["id"];
		if($projectId == null) {
			throwError(500, "id field was missing");
		}
		
		$projectName = $put["name"];
		$projectDescrip = $put["descrip"];
		$fileLink = $put["file"];
		
		$sql = "UPDATE Project SET ";
		$paramStr = "";
		$args = array();
		if($projectName != null) {
			$sql .= "projectName=?,";
			$args[] = $projectName;
			$paramStr .= "s";
		}
		if($projectDescrip != null) {
			$sql .= "projectDesc=?,";
			$args[] = $projectDescrip;
			$paramStr .= "s";			
		}
		if($fileLink != null) {
			$sql .= "fileLink=?,";
			$args[] = $fileLink;
			$paramStr .= "s";
		}
		
		$sql = substr($sql, 0, -1);
		$sql .= " where projectID = ?";
		$paramStr .= "i";
		$args[] = $projectId;
		
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param($paramStr, ...$args);
			$stmt->execute();
			while($stmt->fetch());
		}		
	}
	
	function handleDelete($delete) {
		global $conn, $API_TOKEN;
		$token = '' . $delete["token"];
		if ($token != $API_TOKEN) {
			throwError(401, "API Token is not valid.");
			return;
		}		
		$id = $delete["id"];
		
		$sql = 'DELETE FROM Project where projectID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			if($stmt->affected_rows == 0) {
				throwError(500, "Project could not be deleted");
			}
		}
	}
	
	function throwError($errorCode, $errorMessage) {
		http_response_code($errorCode);
		echo $errorMessage;
	}
?>

