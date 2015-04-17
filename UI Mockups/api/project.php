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
		
		echo "<pre>" . json_encode($project, JSON_PRETTY_PRINT) . "</pre>";
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
		
		$sql = 'INSERT into Project VALUES (0, ?, ?, ?)';
				
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("sss", $projectName, $projectDescrip, $fileLink);
			$stmt->execute();
			$stmt->fetch();
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
		
		$sql = 'DELETE FROM Project where projectID = ?';
		if($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			// TODO: Add error for if the user did not exist.
			$stmt->fetch();
		}
	}
	
	function throwError($errorCode, $errorMessage) {
		http_response_code($errorCode);
		echo $errorMessage;
	}
?>

