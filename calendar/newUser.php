<?php
echo "test";
session_start();

$mysqli = new mysqli('localhost', 'calendar', 'calendar', 'calendar');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
 if (preg_match('/^[\w_\-]+$/',$_POST['username'])){
 $post_username=$_POST['username'];
$post_password=$_POST['password'];
$crypt_pass=crypt($post_password,"salt n' pepper");

$stmt = $mysqli->prepare("INSERT INTO users (username,password) VALUES (?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}


$stmt->bind_param('ss', $post_username, $crypt_pass);
$stmt->execute();

header ("Location: main.html");

}
?>