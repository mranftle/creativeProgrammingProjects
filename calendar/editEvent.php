<?php
	
	require(database.php); 
	header("Content-Type: application/json"); 

	session_start(); 
	$user = $_SESSION['user']; 

	$eventName = mysql_real_escape_string(htmlentities($_POST['eventName']); 
	$category = mysql_real_escape_string(htmlentities($_POST['category']); 
	$month = mysql_real_escape_string(htmlentities($_POST['month']); 
	$day = mysql_real_escape_string(htmlentities($_POST['day']); 
	$hour = mysql_real_escape_string(htmlentities($_POST['hour']); 
	$minute = mysql_real_escape_string(htmlentities($_POST['minute']); 

	$sqledit = "UPDATE events SET description = $category, month = $month, day = $day, hour = $hour, minute = $minute WHERE eventName = $eventName"; 

	$result = mysql_query($sqledit); 

	if($result){ 
		echo json_encode(array(
			"user" => $user, 
			"editSuccess" => true, 
			"event" => $eventName
		)); 
		exit(); 
	}
	else { 
		json_encode(array(
			"errorMessage"=> "Error: Event could not be edited", 
			"editSuccess" => false
		)); 
		exit(); 
	}

?>