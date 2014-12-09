<?php
	require('database.php'); 
	//header("Content-Type: application/json"); 
	
	session_start(); 
	$user = $_SESSION['user']; 
	
	if ($_SESSION["token"]!=$_POST["token"]){
	exit;
	}
	
	var_dump($_POST);
	$event = htmlentities($_POST["id"]); 
	$stmt = $mysqli->prepare("DELETE FROM events WHERE user_id = ? AND event_id = ?;");
	if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
	}
	
	$stmt->bind_param('ii', $user,$event);
	$stmt->execute();
	
	/*$sqldelete = "DELETE FROM events WHERE user = '$user' AND event_id = '$event';"; 
	$result = mysql_query($sqldelete); 
	
	if ($result) { 
		echo json_encode(array(
			"deleteSuccess" => true, 
			"event" => $event,
			"user" => $user, 
		)); 
		exit();
	}
	else { 
		echo json_encode(array(
			"message" => "error: event could not be deleted", 
			"deleteSuccess" => false
		));
		exit(); 
	}*/
?>
