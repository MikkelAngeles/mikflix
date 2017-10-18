<?php
if(!isset($_SESSION['user'])) {
	header('location: login.php');
} else {
	$currentUser = $_SESSION['user'];
}
?>