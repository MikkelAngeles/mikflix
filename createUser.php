<?php
include 'connect.php';
if(isset($_POST)) {
	$usr = $_POST['user'];
	$pw  = $_POST['password'];
	$pw2  = $_POST['password2'];
	$email  = $_POST['email'];
	$now = date("Y-m-d H:i:s");

	if($pw == $pw2) {
		$rs = queryServer("INSERT INTO logindb (user, password, email, created) VALUES ('$usr','$pw','$email','$now')");
		session_start();
		setSession($usr);
	    header('location: index.php');
	}
}
?>