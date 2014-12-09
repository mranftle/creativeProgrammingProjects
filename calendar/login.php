<?php
session_start();
if (isset($_GET['logout'])){
session_destroy();
header ("Location: login.html");
}

//session_destroy(); test if session_destroy() will end the session or just delete its variables
$mysqli = new mysqli('localhost', 'calendar', 'calendar', 'calendar');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}

$post_username=$_POST['username'];
$post_password=$_POST['password'];

$crypt_pass=crypt($post_password,"salt n' pepper");

$stmt = $mysqli->prepare("select user_id, username from users where username=? and password=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}


$stmt->bind_param('ss', $post_username, $crypt_pass);
$stmt->execute();
$stmt->bind_result($id,$username);
while($stmt->fetch()){
	if (isset($id)){//successful login
	$_SESSION['user']=$id;
	$_SESSION['token'] = substr(md5(rand()), 0, 10);
	header ("Location: main.php");
	}
}
if (empty($id)&&isset($_POST['username'])){
echo "invalid login";
}
?>