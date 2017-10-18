function kvmIndicator(price, ele) {
	var ele = document.getElementById(ele);
	if(price < 20500 ) {
		ele.className += " green";
	} 
	if(price < 24000 && price > 20500) {
		ele.className += " yellow";
	}
	if(price > 24000) {
		ele.className += " red";
	}
}

