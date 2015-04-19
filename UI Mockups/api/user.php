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
		$user = null;		
		
		$sql = 'SELECT u.userID, email, fname, lname, m.majorName FROM User u INNER JOIN IsMajor im INNER JOIN Major m ON m.majorID = im.majorID WHERE u.userID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($user['userID'], $user['email'], $user['fname'], $user['lname'], $user['major']);
			while($stmt->fetch()){}		
		}
		
		$classIdArr = array();
		$classId = null;
		$sql = 'SELECT c.classID FROM Class c INNER JOIN InClass ic ON c.classID = ic.classID INNER JOIN User u ON u.userID = ic.userID WHERE u.userID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($classId);
			while($stmt->fetch()){
				$classIdArr[] = unserialize(serialize($classId));
			}
		}
		$user['classIds'] = $classIdArr;
		
		$sql = 'SELECT p.projectID FROM Project p INNER JOIN InProject ip INNER JOIN User u ON u.userID = ip.userID WHERE u.userID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($user['projectId']);
			while($stmt->fetch()){}
		}
		
		$skillArr = array();
		$skill = null;
		$sql = 'SELECT s.skillID, s.skillName from User u INNER JOIN HasSkill hs ON u.userID = hs.userID INNER JOIN Skill s ON s.skillID = hs.skillID WHERE u.userID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($skill['id'], $skill['name']);
			while($stmt->fetch()) {
				$skillArr[] = unserialize(serialize($skill));
			}
			$user['skills'] = $skillArr;
		}
		
		echo "<pre>" . json_encode($user, JSON_PRETTY_PRINT) . "</pre>";
	}
	
	function handlePost($post) {	
		global $conn, $API_TOKEN;
		$token = '' . $post["token"];
		if ($token != $API_TOKEN) {
			throwError(401, "API Token is not valid.");
			return;
		}
		$email = $post["email"];
		$fname = $post["fname"];
		$lname = $post["lname"];
		$password = $post["password"];
		$classId = $post["classId"];
		
		$isError = false;
		$message = "";
		if($email == null) {
			$isError = true;
			$message .= "email field was missing \n";
		}
		if($fname == null) {
			$isError = true;
			$message .= "fname field was missing \n";
		}
		if($lname == null) {
			$isError = true;
			$message .= "lname field was missing \n";
		}
		if($password == null) {
			$isError = true;
			$message .= "password field was missing \n";
		}
		if($classId == null) {
			$isError = true;
			$message .= "classId field was missing \n";
		}
		if($isError) {
			throwError(500, $message);
			return;
		}
		
		$sql = 'INSERT into User VALUES (0, ?, ?, ?, ?, 0)';
		
		$hashedPass = password_hash($password, PASSWORD_BCRYPT);
		
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("ssss", $email, $fname, $lname, $hashedPass);
			$stmt->execute();
			while($stmt->fetch());
		}
		
		$sql = 'SELECT LAST_INSERT_ID()';
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$stmt->bind_result($userId);
		while($stmt->fetch());
		
		
		$sql = 'INSERT into InClass VALUES (?,?)';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("ii", $userId,$classId);
			$stmt->execute();
			while($stmt->fetch());
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
		
		$sql = 'DELETE FROM User where userID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			if($stmt->affected_rows == 0) {
				throwError(500, "User could not be deleted");
			}
		}
	}
	
	function throwError($errorCode, $errorMessage) {
		http_response_code($errorCode);
		echo $errorMessage;
	}
?>

