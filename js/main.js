var fetchData = function(d) {
    return $.ajax({
    	type: 'GET',
    	dataType: 'json',
    	scriptCharset: 'utf-8' ,
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
        data: d,   
        url: 'hollywood.php'   
    });
}
console.log("session tmp folder status: "+sessionStorage.getItem('tmpFolderStatus'));
if(sessionStorage.getItem('tmpFolderStatus') == 1) {
	var clearSet = {
		'authKey': 'clearTmp'
	}
	var clearTmpFolder = $.ajax({
		type: 'POST',
		url: 'hollywood.php',
		dataType : 'json',
		data: clearSet,
		complete: function(xhr) {
			console.log("tmp folder should be clear now");
			sessionStorage.setItem('tmpFolderStatus', 0);
		}
    });
}