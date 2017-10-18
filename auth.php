<?php
include 'connect.php';
if(isset($_POST)) {
	$usr = $_POST['user'];
	$pw  = $_POST['password'];

	$rs = queryServer("SELECT password FROM logindb WHERE user='$usr'");
	//$rs = queryServer("SELECT password FROM logindb WHERE user=:username");
	$realPw;
	while($row = mysqli_fetch_assoc($rs)) {
		$realPw = $row['password'];
	}

	if(isset($realPw)) {
		$checkpw = $realPw == $pw;
		if($realPw == $pw) {
			session_start();
			setSession($usr);
		    header('location: index.php');
		} else {
			header('Location: login.php?login_attempt=1');
		}
	}
	else {
		header('Location: login.php?login_attempt=1');
	}
}
?>