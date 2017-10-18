<?php
include 'fetcher.php';	
include 'calculations.php';

if(isset($_POST['submit'])) {
	
	$user = $_POST['input'];
	echo $user;
	session_destroy();
	ob_start();
	$_SESSION['user'] = 1337;
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>