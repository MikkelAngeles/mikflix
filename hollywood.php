<?php
session_start();
include 'connect.php';
include 'checkSession.php';
header('Content-Type: text/html; charset=utf-8');
header('Content-Type: text/html; charset=ISO-8859-15');

function setDirectoryBy($prefix) {
	return $_SESSION['globalSettings'][$prefix]['value'];;
}

function setTitleData($type) {
	$noError = true;
	try {
		$id 				= $_POST["titleId"];
		$titleId     	    = $_POST["titleId"];
		$originalTitle      = $_POST["originalTitle"];
		$genre    	        = $_POST["genre"];
		$overview    	    = $_POST["overview"];
		$adult    	        = $_POST["adult"];
		$releaseDate        = $_POST["releaseDate"];
		$language     		= $_POST["language"];
		$voteAverage        = $_POST["voteAverage"];
		$voteCount     	    = $_POST["voteCount"];
		$popularity         = $_POST["popularity"];
		$mediaType          = $_POST["mediaType"];
		$posterPath         = $_POST["posterPath"];
		$backdropPath       = $_POST["backdropPath"];
		$lastUpdate         = date('Y-m-d h:i:s');
	}
	catch(exception $e) {
		$noError = false;
		echo "Encoding error: ".$e;
	}

	//Insert
	if($type == 1 && $noError) {
		$rs = queryServer("
			INSERT INTO titledata
						(titleId,
						originalTitle,
						genre,
						overview,
						adult,
						releaseDate,
						language,
						voteAverage,
						voteCount,
						popularity,
						mediaType,
						posterPath,
						backdropPath,
						lastUpdate)
			VALUES ('$titleId',
				    '$originalTitle',
					'$genre',
					'$overview',
					'$adult',
					'$releaseDate',
					'$language',
					'$voteAverage',
					'$voteCount',
					'$popularity',
					'$mediaType',
					'$posterPath',
					'$backdropPath',
					'$lastUpdate')"
		);
	} 
	//Update
	elseif ($type == 0 && $noError) {
		$rs = queryServer("
			UPDATE titledata SET 
				titleId        = '$titleId',
				originalTitle  = '$originalTitle',
				genre          = '$genre',
				overview       = '$overview',
				adult          = '$adult',
				releaseDate    = '$releaseDate',
				language       = '$language',
				voteAverage    = '$voteAverage',
				voteCount      = '$voteCount',
				popularity     = '$popularity',
				mediaType      = '$mediaType',
				posterPath     = '$posterPath',
				backdropPath   = '$backdropPath',
				lastUpdate     = '$lastUpdate'
			WHERE titleId = '$id'
		");
	}
}

function submitUpload() {
	//Input data
	$published   =  $_POST["published"];
	$titleId 	 =  $_POST["titleId"];
	$title 	     =  $_POST["title"];
	$file  		 =  $_POST["file"];
	$size  		 =  $_POST["size"];
	$uploadedBy  =  $_POST["uploadedBy"];
	$uploaded    =  date('Y-m-d h:i:s');
	$movieCmp    =  setDirectoryBy('movieCmp');
	$movieTmp    =  setDirectoryBy('movieTmp');

	//0. Subtitle, 1. Movie
	$mainDir = $movieCmp.$title;
	$subDir  = $mainDir."/subs";

	//Creating the directory
	if(!file_exists($mainDir) && !is_dir($mainDir)) {
		mkdir($mainDir);
		//Submit to server
		if($success = rename($movieTmp.$uploadedBy."/".$file, $movieCmp.$title."/".$file)) {
			$rs = queryServer("
				INSERT INTO movies
							(titleId,
							published,
							title,
							file,
							size,
							uploadedBy,
							uploaded)
				VALUES ('$titleId',
				     	'$published',
					    '$title',
						'$file',
						'$size',
						'$uploadedBy',
						'$uploaded')"
			);
			setTitleData(1);
		}
	}
	if(!file_exists($subDir) && !is_dir($subDir)) {

		mkdir($subDir);

		$old = $movieTmp.$uploadedBy."/subs";
		$new = $movieCmp.$title."/subs";

		foreach(glob($old.'/*.*') as $file) {
			$newFile = str_replace($old."/", "", $new."/".$file);
			rename($file, $newFile);
		}
	}

}

//Uploads the file to a tmp folder.
function autoUpload($usr, $file, $type) {
	//Defining tmp name of file, and real name of file.
	$fileTmp  = $file['tmp_name'];
	$fileName = $file['name'];
	//$movieTmp = $_SESSION['globalSettings']['movieTmp']['value'];
	$movieTmp = setDirectoryBy('movieTmp');
	//0. Subtitle, 1. Movie
	$mainDir  = $movieTmp.$usr."/";
	$subDir   = $mainDir."subs/";
	
    //Controlling the file
	if(is_uploaded_file($fileTmp)) {

		//Ensuring the targeted directory exists
		if(!file_exists($mainDir) && !is_dir($mainDir)) {
			mkdir($mainDir);
		}
		if(!file_exists($subDir) && !is_dir($subDir) && $type == 0) {
			mkdir($subDir);
		}

		//Moves the file to tmp directory
		$srcPath  = $fileTmp;
		$tarlPath = $mainDir.$fileName;
		if($type == 0) $tarlPath = $subDir.$fileName;
		move_uploaded_file($srcPath, $tarlPath);
	}
}

//Remove directory and all files
function rrmdir($dir) { 
	if (is_dir($dir)) { 
		$objects = scandir($dir); 
		foreach ($objects as $object) { 
			if ($object != "." && $object != "..") { 
				if (is_dir($dir."/".$object))
				rrmdir($dir."/".$object);
			else
				unlink($dir."/".$object); 
			} 
		}
		rmdir($dir); 
	} 
}

function moveDir($old, $new) {
	foreach(glob($old.'/*.*') as $file) {
		$newFile = str_replace($old."/", "", $new."/".$file);
		rename($file, $newFile);
	}
}

//Eventlistener for auto-upload.
if(isset($_POST)) {
	if(!empty($_FILES['mediaFile'])) autoUpload($_SESSION["user"], $_FILES['mediaFile'], 1);
	if(!empty($_FILES['subtitleFile'])) autoUpload($_SESSION["user"], $_FILES['subtitleFile'], 0);
}

//Eventlistener for Ajax requests
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
	&& !empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
		&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	
	//Catch movie upload requests
	if(isset($_POST["authKey"]) && $_POST["authKey"] == "movie") {
		submitUpload($_POST);
	} 

	//Catch discard requests
	if(isset($_POST["authKey"]) && $_POST["authKey"] == "discard") {
		$usr = $_POST['user'];
		$dir = setDirectoryBy('movieTmp').$usr;	
		if(file_exists($dir) && is_dir($dir)) {
			rrmdir($dir);
		}
	}

	//Catch server queries for already existing titles
	//1, = Existing titles suggestions
	if(isset($_GET['authKey']) && $_GET["authKey"] == "getExistingTitle") {
		$query = $_GET['query'];
		getExistingTitles($query, 1);
	}
	//0, = Exact title validation
	if(isset($_GET['authKey']) && $_GET["authKey"] == "titleValidation") {
		$query = $_GET['query'];
		getExistingTitles($query, 0);
	}


}

if(isset($_GET['authKey']) && $_GET["authKey"] == "getExistingTitle") {
		//getExistingTitles($query, 1);
}

function getFileData($id) {
	queryServer("SELECT * FROM movies WHERE id = '$id'");
}

function getExistingTitles($s, $type) {
	//1, = Existing titles suggestions
	if($type == 1) $s = "SELECT * FROM movies WHERE title LIKE '%$s%'";
	//0, = Exact title validation
	if($type == 0) $s = "SELECT * FROM movies WHERE title = '$s'";

	$i = 0;
	$rs = queryServer($s);
	while($row = mysqli_fetch_assoc($rs)) {
		$arr[$i] = $row;
		$i++;
	}
	echo json_encode($arr); 
}

function moveById($type) {
	$user      = $_POST['user'];
    $mediaId   = $_POST['id'];
    $timestamp = date('Y-m-d h:i:s'); 
	$movieCmp  = setDirectoryBy('movieCmp');
	$movieArc  = setDirectoryBy('movieArc');

	//Dirty & hardcoded. Must update to dynamic access level later.
	if($user == 'admin') {
		try {
			$rs = queryServer("SELECT * FROM movies WHERE id = '$mediaId'");
			while($row = mysqli_fetch_assoc($rs)) $title = $row['title'];

			if($title) {

				//Restore, type 1. Move from archive to completed
				if($type == 1) {
					$oldMain = $movieArc.$title;
					$newMain = $movieCmp.$title;
				}

				//Archive, type 0. Move from completed to archive
				if($type == 0) {
					$oldMain =  $movieCmp.$title;
				    $newMain =  $movieArc.$title;
				}

				$oldSub  =  $oldMain."/subs";
				$newSub  =  $newMain."/subs";

				//Move main files to archive
				mkdir($newMain);
				moveDir($oldMain, $newMain);

				//Move sub files to archive
				mkdir($newSub);
				moveDir($oldSub, $newSub);

				//Remove dir from completed
				rrmdir($oldMain);

				//Update status by argument $type. 1 = active (completed), 0 = inactive (archive)
				queryServer("UPDATE movies SET status = '$type', modifiedBy ='$user',  modified ='$timestamp' WHERE id = '$mediaId'");
				
				//Until ajax implementation, redirect back
				header('location: videoadmin.php');
			}
		}
		catch(exception $e) {
			echo $e;
		}

	} 
}

if(isset($_POST["authKey"]) && $_POST["authKey"] == "delete") {
	moveById(0);
} 

if(isset($_POST["authKey"]) && $_POST["authKey"] == "restore") {
	moveById(1);
}

function getCinema($a, $b) {
	$arr = [];
	$rs = queryServer(
		"SELECT movies.titleId,
		        movies.file,
		        titledata.originalTitle,
		        titledata.genre,
		        titledata.overview,
		        titledata.adult,
		        titledata.releaseDate,
		        titledata.language,
		        titledata.voteAverage,
		        titledata.voteCount,
		        titledata.popularity,
		        titledata.posterPath
		FROM movies
		INNER JOIN titledata ON movies.titleId = titledata.titleId
		WHERE movies.published = 1 AND movies.status = 1
		ORDER BY movies.titleId DESC
		LIMIT $a, $b"
	);
	while($row = mysqli_fetch_assoc($rs)) {
		array_push($arr, $row);
	}
	echo json_encode($arr);
}

function queryServerReturnJson($query) {
	$arr = [];
	$rs = queryServer($query);
	while($row = mysqli_fetch_assoc($rs)) {
		array_push($arr, $row);
	}
	echo json_encode($arr);
}

if(isset($_GET["authKey"]) && $_GET["authKey"] == "getCinema") {
	getCinema($_GET['offset_a'], $_GET['offset_b']);
}
if(isset($_GET["authKey"]) && $_GET["authKey"] == "getRecentlyAdded") {
	$max = $_GET['max'];
	$query = ("SELECT 
				movies.id,
				movies.titleId,
		        movies.file,
		        titledata.originalTitle,
		        titledata.genre,
		        titledata.overview,
		        titledata.adult,
		        titledata.releaseDate,
		        titledata.language,
		        titledata.voteAverage,
		        titledata.voteCount,
		        titledata.popularity,
		        titledata.posterPath
		FROM movies
		INNER JOIN titledata ON movies.titleId = titledata.titleId
		WHERE movies.published = 1 AND movies.status = 1
		ORDER BY movies.id DESC
		LIMIT $max");
	queryServerReturnJson($query);
}

if(isset($_GET["authKey"]) && $_GET["authKey"] == "getTitleData") {
	$titleId = $_GET['titleId'];
	$query = ("SELECT 
				movies.id,
				movies.titleId,
		        movies.file,
		        titledata.originalTitle,
		        titledata.genre,
		        titledata.overview,
		        titledata.adult,
		        titledata.releaseDate,
		        titledata.language,
		        titledata.voteAverage,
		        titledata.voteCount,
		        titledata.popularity,
		        titledata.posterPath,
		        titledata.backdropPath
		FROM movies
		INNER JOIN titledata ON movies.titleId = titledata.titleId
		WHERE movies.titleId = '$titleId'
		LIMIT 1");
	queryServerReturnJson($query);
}


function getViewingHistory($userId, $status) {
	$conn = setConnection();
	$stmt = $conn->prepare("SELECT * FROM viewing_history WHERE userId = ? AND status = ?");
	//Bind parameters to statement
	$stmt->bind_param('ii', $userId, $status);	

	//Execute query
	$stmt->execute();

	//Close statement & connection
	$stmt->close();
	$conn->close();

	
	queryServerReturnJson($query);
}


/*//////////////////////////////////
When everything is tested and works correctly, fix all gets and posts into the below switch statement.
Right now every ajax request has their own function, and each one is redundant. All can be merged into one global function, based on authKey.
Secure all SQL querys into prepared procedures by binding parameters.

And verify authentication by user session, ip and verification through database attempts etc.


Status:  
	- Most functions are tested
	- The first 4 switch statements are working
	- Tested a few prepared procedures for posting
	- Need testing of get procedures

//////////////////////////////////*/

//Authentication key switch 
if(isset($_GET["authKey"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
	switch($_GET["authKey"]) {

		//Data from viewing_history table
		case 'getUnwatched':
			getViewingHistory($_GET['userId'], null);
			break;
		case 'getViewingHistory':
			getViewingHistory($_GET['userId'], 0);
			break;
		case 'getIncomplete':
			getViewingHistory($_GET['userId'], 1);
			break;
		case 'getCompleted':
			getViewingHistory($_GET['userId'], 2);
			break;

		//Return types of subtitles allowed
		case 'getSubtitleLabels':
			queryServerReturnJson("SELECT * FROM subtitle_labels ORDER BY ID ASC");
			break;

		//Data from movies & titleData
		case 'getCompleted':
			getViewingHistory($_GET['userId'], 2);
			break;

		case 'getUser':
			echo json_encode($_SESSION['user']);
			break;


		//Return error if nothing was found	
		default:	
	}
}

if(isset($_POST["authKey"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
	switch($_POST["authKey"]) {

		case 'submitMovie':
			//autoUpload($_SESSION["user"], $_FILES['subtitle'], 0);'
			//print_r($_FILES);
			//print_r($_POST);
			submitUpload();
			break;

		case 'postSubtitle':
			autoUpload($_SESSION["user"], $_FILES['subtitle'], 0);
			break;

		case 'clearTmp':
			$path = setDirectoryBy('movieTmp');
			$path = $path.$_SESSION['user'];
			rrmdir($path);
			break;

		case 'discardTmpFile':
			$path = setDirectoryBy('movieTmp');
			$path = $path.$_SESSION['user'];
			$file = $path.'/test.mp4';
			unlink($file);
			break;

		//Return error if nothing was found	
		default:	
	}
}

//Dev tool to generate test data.
function generateFake() {
	queryServer("insert into movies (titleId, title) values ('10201', 'Yes Man')");
	queryServer("insert into movies (titleId, title) values ('190250', 'Abe')");
	queryServer("insert into movies (titleId, title) values ('1726', 'Iron Man')");
	queryServer("insert into movies (titleId, title) values ('428497', 'Iron Man')");
	queryServer("insert into movies (titleId, title) values ('1726', 'Pop Aye')");
	queryServer("insert into movies (titleId, title) values ('597', 'Titanic')");
}
/*
if(isset($_GET['fake'])) {
	for($i = 0; $i < 10; $i++) generateFake();
}
*/


//Debugging
/*
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
	// handle request as AJAX
	echo "This is AJAX"; 
	exit;
} 
echo "This is not AJAX";
*//*
if(isset($_POST) && !empty($_FILES)) {
	$_FILES;
	echo $_FILES['autoUpload']['tmp_name'];
	//mkdir("haha");
}*/



?>