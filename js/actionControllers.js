function toggleUserMenu() {
	alert("A");
	var toggled = document.getElementByClassName(".userBlockToggled");
	var toggledOff = document.getElementByClassName(".userBlockToggledOff");
	if(toggledOff) {
		div.style.className += "userBlockToggled";
	} 
	else {
		div.style.className += "userBlockToggledOff";
	}
		
}