<?php
	ob_start();
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASSWORD", "");
    define("DB_DATABASE", "mikflix");
    $mysqli;
	$rs;
	$row;
	$userData = [];
	$topNav = []; 

    function queryServer($sql) {
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
		mysqli_set_charset($mysqli, 'utf-8');
		$rs  	= $mysqli->query($sql) or die ($mysqli->error);
		return $rs;
	}

	function returnCurrentUser() {
		session_start();
		return $_SESSION['user'];
	}
	function setSession($user) {
		session_start();

		$_SESSION['user'] = $user;
		$currentUser = $_SESSION['user'];
		$rs = queryServer("SELECT * FROM logindb WHERE user='$user'");
		while($row = mysqli_fetch_assoc($rs)) {
			$userData[0] = $row;
			$_SESSION['email'] = $row['email'];
			$_SESSION['created'] = $row['created'];
			$_SESSION['profileImg'] = $row['user'];
		}
	}	

	function setUserData() {
		$arr = []; 
		$user = $_SESSION['user'];
		$rs = queryServer("SELECT * FROM logindb WHERE user='$user'");
		while($row = mysqli_fetch_assoc($rs)) {
			$_SESSION['userData'] = $row;
		}
	}

	function setRestrictionLevels() {
		$arr = []; 
		$rs = queryServer("SELECT * FROM restrictionlevels ORDER BY rank ASC");
		while($row = mysqli_fetch_assoc($rs)) {
			array_push($arr, $row);
		}
		$_SESSION['restrictionLevels'] = $arr;
	}

	function setGlobalSettings() {
		$arr = []; 
		$rs = queryServer("SELECT * FROM globalsettings order by id asc");
		while($row = mysqli_fetch_assoc($rs)) {
			$_SESSION['globalSettings'][$row['prefix']] = $row;
		}
	}

	function setTopNav() {
		$arr = []; 
		$rs = queryServer("SELECT * FROM topnav ORDER BY rank ASC");
		while($row = mysqli_fetch_assoc($rs)) {
			array_push($arr, $row);
		}
		$_SESSION['topNav'] = $arr;
	}
	setUserData();
	setRestrictionLevels();
	setGlobalSettings();
	setTopNav();
?>