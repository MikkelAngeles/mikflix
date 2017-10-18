<?php
include 'connect.php';

//$_SESSION['user']= $currentUser = '1';
	if(isset(($_GET["id"]))) {
		//defineDb();
		$itemID = $_GET["id"];

		include('simple_html_dom.php');

		$html = new simple_html_dom(); 
		 
		$html->load_file($itemID);   

		// Find all names 
		foreach($html->find('<div [class=container-wrap--white]') as $article) {
			$itemID				= $itemID;
			$title	    		= $article->find('h1[class=title]', 0)->plaintext;

			$price				= $article->find('span[class=important c-primary]', 0)->plaintext;
			$price 				= preg_replace('/[^0-9]/', '', $price);

			$expenses 			= $article->find('li[class=paymentexpenses]', 0)->plaintext;
			$expenses 			= preg_replace('/[^0-9]/', '', $expenses);

			$salesPeriod 		= $article->find('li[class=salesperiod]', 0)->plaintext;
			$salesPeriod 		= preg_replace('/[^0-9]/', '', $salesPeriod);

			$areaPrice   		= $article->find('li[class=areapaymentcash]', 0)->plaintext;
			$areaPrice 			= preg_replace('/[^0-9]/', '', $areaPrice);

			$gardenSize			= $article->find('li[class=areaparcel]', 0)->plaintext;
			$gardenSize 		= preg_replace('/[^0-9]/', '', $gardenSize);

			$areaSize			= $article->find('li[class=area]', 0)->plaintext;
			$areaSize 			= preg_replace('/[^0-9]/', '', $areaSize);

			$url				= $article->find('div[class="btn-wrap"]', 0)->innertext;	
			$url				= preg_match('/href=(["\'])([^\1]*)\1/i', $url, $a);
			$url				= $a[2];
			$url				= strtok($url, '"');

			//$priceChange		= $article->find('table [class=table table--xs table--noborder table--key-value]', 0)->plaintext;
			//$priceChange 		= preg_replace('/[^0-9]/', '', $priceChange);
		}
		//print_r($link);
		
		if(!checkId($itemID)) {
			$rs = queryServer("
			INSERT INTO PropertyObject 
					(itemID, 
					title, 
					url,
					price, 
					expenses, 
					salesPeriod,
					areaPrice, 
					gardenSize, 
					areaSize) 

			VALUES ('$itemID', 
					'$title',
					'$url', 
					'$price', 
					'$expenses', 
					'$salesPeriod', 
					'$areaPrice', 
					'$gardenSize', 
					'$areaSize')");
		}
	}
	else { $itemID = ""; 
}

function checkId($id) {
	$rs = queryServer("SELECT * FROM PropertyObject WHERE itemID = '$id'");
	$row = mysqli_fetch_array($rs);
	if(sizeof($row)) { return true; } 
	else { return false; }
}

function returnRows() {
	$rs = queryServer("SELECT * FROM PropertyObject");
	while($row = mysqli_fetch_assoc($rs)) {
		echo $row['itemID'];
		echo $row['title'];
	}
}

function fetchBudget() {
	$rs = queryServer("SELECT * FROM budget WHERE type = '1'");

	echo "<div class='col-sm-12'>";
	while($row = mysqli_fetch_assoc($rs)) {
		//echo "</br>".$row['id'].$row['userID'].$row['title'].$row['value'].$row['type'];
		echo setBudgetRow($row['title']);
		echo setBudgetRow($row['value']);
	}
	echo "</div>";
}

function setBudgetRow($value) {
	echo "<input type='text' class='form-control rightRow' name='itemID' placeholder='".$value."'>";
}

function returnLength() {
	$rs = queryServer("SELECT id FROM budget ORDER BY id DESC LIMIT 1");

	while($row = mysqli_fetch_assoc($rs)) {
		$length = $row['id'];
		//echo $length;
	}
	return $length;
}
function returnTotalIncome($type, $budgetID) {
	$currentUser = $_SESSION['user'];
	$rs = queryServer("SELECT value FROM budget WHERE type='$type' AND userID='$currentUser' AND budgetID='$budgetID'");
	$value = 0; 
	while($row = mysqli_fetch_assoc($rs)) {
		$value = $value+intval($row['value']);
	}
	//echo $value;
	return $value;
}

if(isset($_GET['addRow'])) {
	$user = $_GET["addRow"];
	$type = $_GET["type"];
	$budgetID = $_GET["budgetID"];
	addRow($user, $type, $budgetID);
}
if(isset($_GET['delRow'])) {
	$user = $_GET["delRow"];
	$type = $_GET["type"];
	$budgetID = $_GET["budgetID"];
	removeRow($user, $type, $budgetID);
}


function addRow($user, $type, $budgetID) {
	$rs = queryServer("INSERT INTO budget (userID, type, budgetID) VALUES ('$user', '$type', '$budgetID')");
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
function removeRow($user, $type, $budgetID) {
	$rs = queryServer("DELETE FROM budget WHERE userID='$user' AND type='$type' AND budgetID='$budgetID' ORDER BY id DESC LIMIT 1");
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>

