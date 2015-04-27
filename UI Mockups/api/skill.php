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
		$skill = null;		
		
		$sql = 'SELECT skillID, skillName, userCreated FROM Skill s where s.skillID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($skill['id'], $skill['name'], $skill['isUserCreated']);
			while($stmt->fetch()){}			
		}
		
		echo json_encode($skill, JSON_PRETTY_PRINT);
	}
	
	function handlePost($post) {	
		global $conn, $API_TOKEN;
		$token = '' . $post["token"];
		if ($token != $API_TOKEN) {
			throwError(401, "API Token is not valid.");
			return;
		}
		
		$skillName = $post["name"];
		$isUserCreated = $post["isUserCreated"];
		$classId = $post["classId"];
		
		$isError = false;
		$message = "";
		if($skillName == null) {
			$isError = true;
			$message .= "name field was missing \n";
		}
		if($isUserCreated == null) {
			$isError = true;
			$message .= "isUserCreated field was missing \n";
		}
		if($classId == null) {
			$isError = true;
			$message .= "classId field was missing \n";
		}
		if($isError) {
			throwError(500, $message);
			return;
		}
		
		$sql = 'INSERT into Skill VALUES (0, ?, ?)';
				
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("si", $skillName, $isUserCreated);
			$stmt->execute();
			$stmt->fetch();
		}
		
		$sql = 'SELECT LAST_INSERT_ID()';
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$stmt->bind_result($skillId);
		while($stmt->fetch());
		
		
		$sql = 'INSERT into ClassHasSkill VALUES (?,?)';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("ii", $skillId, $classId);
			$stmt->execute();
			while($stmt->fetch());
		}
		
		$skill['id'] = $skillId;
		$skill['name'] = $skillName;
		$skill['isUserCreated'] = $isUserCreated;
		$skill['classId'] = $classId;
		echo json_encode($skill, JSON_PRETTY_PRINT);
	}
	
	function handlePut($put) {
		throwError(404, "PUT not valid for this endpoint.");		
	}
	
	function handleDelete($delete) {
		global $conn, $API_TOKEN;
		$token = '' . $delete["token"];
		if ($token != $API_TOKEN) {
			throwError(401, "API Token is not valid.");
			return;
		}		
		$id = $delete["id"];
		
		$sql = 'DELETE FROM Skill where skillID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			if($stmt->affected_rows == 0) {
				throwError(500, "Skill could not be deleted");
			}
		}
	}
	
	function throwError($errorCode, $errorMessage) {
		http_response_code($errorCode);
		echo $errorMessage;
	}
?>

