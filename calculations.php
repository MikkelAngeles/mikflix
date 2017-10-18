<?php

function calculateYdelse($price) {

	$boliglånsRente 				= 0.04;  	// 4%
	$boliglånsMånedligRente			= 0.0033; 	// 0.33%

	$realkreditlånsRente 			= 0.02;		// 2%
	$realkreditlånsMånedligRente	= 0.0023;	// 0.23%
	$bidragsSats					= 0.0074;	// 0.74%

	$afdragsFrihed					= 5;		// 5 år
	$boliglånsTerminer				= 20*12;	// 20 år
	$realkreditlånsTerminer			= 30*12;	// 30 år

	$boliglånsYdelse  = (0.15*$price)*($boliglånsMånedligRente/(1-pow((1+$boliglånsMånedligRente), (-$boliglånsTerminer))));

	$realkreditYdelse = (0.80*$price)*($realkreditlånsMånedligRente/(1-pow((1+$realkreditlånsMånedligRente), (-$realkreditlånsTerminer))));
	
	return intval(round($boliglånsYdelse+$realkreditYdelse));
}

function calculateHusleje($ydelse, $ejer) {
	return intval($ydelse)+intval($ejer);
}

function calculateOverflow($husleje, $income) {
	return round($income-($husleje/2));

}
function priceFormat($int) {
	return number_format($int, 0,',', '.')." kr.";
}
function incrementRows($i) {
	$rowLength = $i;	
}
function calculateSavings($months, $budgetID) {
	return $months*(returnTotalIncome(1,$budgetID)-returnTotalIncome(0,$budgetID));
}
?>