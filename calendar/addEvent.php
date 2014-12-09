<?php

	require('database.php'); 
	//header("Content-Type: application/json"); 

	session_start(); 
	
	if ($_SESSION["token"]!=$_POST["token"]){
	exit;
	}
	$user = $_SESSION['user']; 
	
	$eventName = htmlentities($_POST['eventName']); 
	$description = htmlentities($_POST['description']); 
	$month = htmlentities($_POST['month']); 
	$day = htmlentities($_POST['day']); 
	$hour = htmlentities($_POST['hour']); 
	$minute = htmlentities($_POST['minute']); 
	
	/*
	
	$user=1;
	$eventName = htmlentities("testEVENT"); 
	$description = htmlentities("test"); 
	$month = htmlentities("11"); 
	$day = htmlentities("1"); 
	$hour = htmlentities("1"); 
	$minute = htmlentities("1"); 
	*/
	//$sqlentry = mysql_query("Insert INTO events(eventName, user, description, month, day, hour, minute) VALUES(?,?,?,?,?,?,?,?)"); 
	$stmt = $mysqli->prepare("Insert INTO events(eventName, user_id, description, month, day, hour, minute) VALUES(?,?,?,?,?,?,?)");
	if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
	}
	
	$stmt->bind_param('sisiiii', $eventName,$user,$description,$month,$day,$hour,$minute);
	$stmt->execute();
	echo "done";
	/*if($sqlentry) { 

		echo json_encode(array(
			"user" = $user, 
			"eventName" => $eventName, 
			"addSuccess" => true
		)); 
		exit(); 
	}
	else{ 
		echo json_encode(array(
			"errorMessage" => "Cannot create event", 
			"addSuccess" => false
		)); 
		exit(); 
	}
*/


?>