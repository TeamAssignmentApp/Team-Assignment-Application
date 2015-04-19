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
		
		
		if($stmt = $conn->prepare($sql)) {
			if(sizeOf($args) == 1) {
				$stmt->bind_param($paramStr, $args[0], $projectId);
			} else if (sizeOf($args) == 2) {
				$stmt->bind_param($paramStr, $args[0], $args[1], $projectId);		
			} else if (sizeOf($args) == 3) {
				$stmt->bind_param($paramStr, $args[0], $args[1], $args[2], $projectId);
			}
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

