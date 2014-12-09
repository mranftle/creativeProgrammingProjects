<?php
	function mobile_user_agent_switch(){
		$device = '';
 
		if( stristr($_SERVER['HTTP_USER_AGENT'],'ipad') ) {
			$device = "ipad";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'iphone') || strstr($_SERVER['HTTP_USER_AGENT'],'iphone') ) {
			$device = "iphone";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'blackberry') ) {
			$device = "blackberry";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'android') ) {
			$device = "android";
		}
		else if (stristr($_SERVER['HTTP_USER_AGENT'],'phone'))
		{
			$device= "phone";//maybe windows phone
		}
 
		if( $device ) {
			return $device; 
		} return false; {
			return false;
		}
	}
if(mobile_user_agent_switch()=="android")
{


/*header("Content-Type: text/x-vCalendar");
header("Content-Disposition: attachment; filename=enrichment.vcs");*/
}
else
{
//echo "hello";


header("Content-Type: text/Calendar");
header("Content-Disposition: inline; filename=cal.ics");



//header('HTTP/1.0 200 OK', true, 200);
}
require("database.php");
session_start();
$user=1;
$stmt = $mysqli->prepare("SELECT * FROM `events` WHERE user_id=? order by month ASC, day ASC, hour asc, minute asc");
	if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
	}
	//$stmt->bind_param('i',"1");
	
	$stmt->bind_param('i',$user);
	$stmt->execute();
	$stmt->bind_result($event_id,$eventName,$description,$user_id,$day,$hour,$minute,$month);
	
	echo "BEGIN:VCALENDAR\n";
	$i=1;
	while($stmt->fetch()){
	$endHour=$hour+1;
	if ($minute<10){
		$minute="0".$minute;
	}
	if ($hour<10){
		$hour="0".$hour;
	}
	if ($endHour<10){
		$endHour="0".$endHour;
	}
	if($month<10){
		$month="0".$month;
	}
	if($day<10){
		$day="0".$day;
	}

echo "PRODID:-//Microsoft Corporation//Outlook 12.0 MIMEDIR//EN\n";
echo "VERSION:2.0\n";
echo "METHOD:PUBLISH\n";
echo "X-MS-OLK-FORCEINSPECTOROPEN:TRUE\n";
echo "BEGIN:VEVENT\n";
echo "CLASS:PUBLIC\n";

echo "UID: ".$i. "\n";
echo "DESCRIPTION:".$description."\n";

echo "DTSTART:2014".$month.$day."T".$hour.$minute."00\n";
echo "DTEND:2014".$month.$day."T".$endHour.$minute."00Z\n";
echo "PRIORITY:5\n";
echo "SEQUENCE:0\n";
echo "SUMMARY;LANGUAGE=en-us:".$eventName."\n";
echo "TRANSP:OPAQUE\n";

echo "X-MICROSOFT-CDO-BUSYSTATUS:BUSY\n";
echo "X-MICROSOFT-CDO-IMPORTANCE:1\n";
echo "X-MICROSOFT-DISALLOW-COUNTER:FALSE\n";
echo "X-MS-OLK-ALLOWEXTERNCHECK:TRUE\n";
echo "X-MS-OLK-AUTOFILLLOCATION:FALSE\n";
echo "X-MS-OLK-CONFTYPE:0\n";

echo "BEGIN:VALARM\n";
echo "TRIGGER:-PT05M\n";
echo "ACTION:DISPLAY\n";
echo "DESCRIPTION:Reminder\n";
echo "END:VALARM\n";
echo "END:VEVENT\n";
$i++;
	}
echo "END:VCALENDAR\n";




?>