<?php
session_start();
include 'connect.php';
include 'checkSession.php';
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: text/html; charset=ISO-8859-15');


	//Prepare server connection & query request
	$conn = setConnection();
	$stmt = $conn->prepare("INSERT INTO logindb (user, password, email, created) VALUES (?,?,?,?)");
	//Bind parameters to statement
	$stmt->bind_param('ssss', $user, $password, $email, $created);
	//Set parameters for statement
	$user		= 'Flæskesteg';
	$password 	= '12345';
	$email	 	= 'mikkel123@hotmail.com';
	$created 	=  date('Y-m-d h:i:s');

	//Execute query
	$stmt->execute();

	//Close statement & connection
	$stmt->close();
	$conn->close();


?>