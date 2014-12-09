<?php 
	require('database.php'); 
	/*header("Content-Type: application/json"); 
	*/
	session_start(); 
	$user = $_SESSION['user']; 
	$currentMonth = $_POST['month']; 
	//$currentMonth=11;
	//$user=1;
	$stmt = $mysqli->prepare("SELECT * FROM `events` WHERE month =? AND user_id=? order by day ASC, hour asc, minute asc");
	if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
	}
	//$stmt->bind_param('i',"1");
	
	$stmt->bind_param('ii', $currentMonth,$user);
	$stmt->execute();
	$stmt->bind_result($event_id,$eventName,$description,$user_id,$day,$hour,$minute,$month);
	
	$monthArray=array();
	$results=array();
	while($stmt->fetch()){
	
		$results[]=array("event_id"=>$event_id,"eventName"=>$eventName,"description"=>$description,"user_id"=>$user_id,"day"=>$day,"hour"=>$hour,"minute"=>$minute,"month"=>$month);
	}
	
	//var_dump($results);
	
	$currentDay=1;
	$numDays = cal_days_in_month(CAL_GREGORIAN, $currentMonth, 2014);
	while($currentDay<=$numDays){
	
		$weekday=date('l', strtotime( '2014-'.$currentMonth.'-'.$currentDay));
		$monthArray["_".$currentDay]=array("weekday"=>$weekday);

	$currentDay++;
	}
	$currentDay=1;
	$eventsOnDay=1;
	foreach ($results as $event) {	
	//echo json_encode($monthArray);
	//echo "<br>";
	if ($currentDay==$event["day"]){
	$timeSeperator=":";
	if ($event["minute"]<10){
		$timeSeperator=":0";
	}
	$monthArray["_".$currentDay]["Event".$eventsOnDay]=array("Title"=>$event["eventName"],"description"=>$event["description"],"Time"=>$event["hour"].$timeSeperator.$event["minute"],"id"=>$event["event_id"]);
	$eventsOnDay++;
	}
	else if($currentDay<intval($event["day"])){
	$eventsOnDay=1;
	$currentDay=$event["day"];
	$timeSeperator=":";
	if ($event["minute"]<10){
		$timeSeperator=":0";
	}
	$monthArray["_".$currentDay]["Event".$eventsOnDay]=array("Title"=>$event["eventName"],"description"=>$event["description"],"Time"=>$event["hour"].$timeSeperator.$event["minute"],"id"=>$event["event_id"]);
	$eventsOnDay++;
	}
	else{
	$currentDay++;
	$eventsOnDay=1;
	}
		}
		//var_dump($results);
	echo json_encode($monthArray);
	/*$query = mysql_query($sql); 
	$fetch = mysql_fetch_array($query); 
	$eventRows = mysql_fetch_assoc($query); 
	
	while($event = $eventRows) { 
		$events[] = $event; 
	}

	if($events != null) { 
		echo json_encode(array(
			"events" => $events
		));
		exit();
	}
	else {
		echo json_encode(array(
			"events" => $events, 
			"error" => 'event does not exist'
		)); 
		exit();
	}*/
?>