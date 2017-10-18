<?php
session_start();
include 'connect.php';
include 'checkSession.php';

function editTopNav($i) {
	
	//Needs restriction levels later.
	if($i == 1) {
		$name = $_POST['name'];
		$target = $_POST['target'];
		$rank = $_POST['rank'];
		queryServer("INSERT INTO topnav (name, target, rank) VALUES ('$name', '$target', '$rank')");
	}
	elseif ($i == 0) {
		$id = $_POST['id'];
		queryServer("DELETE FROM topnav WHERE id = $id");
	}
	header('location: admin.php');
}

if(isset($_POST["authKey"]) && $_POST["authKey"] == "addTopNav") {
	editTopNav(1);
} 
if(isset($_POST["authKey"]) && $_POST["authKey"] == "delTopNav") {
	editTopNav(0);
} 


?>