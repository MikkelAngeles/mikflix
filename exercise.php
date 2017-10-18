	<span id="elem1"></span>
	<span id="elem2"></span>
	
<?php
include 'header.php';
?>
<script>		
$(document).ready(function(){

	//Lazyloading

	$("#elem1").ready(function() {
		$("#elem1").html("<img src='http://girlslovetravel.org/wp-content/plugins/responsive-flipbook/assets/images/loader.gif' width='200px' height='auto'>");
		setTimeout(function(){
	        $("#elem1").load("test.php") ;
	    },0);
	});

	//Screensize detection.
	$("#elem2").ready(function() {
		var w = $(window).width();
		var h = $(window).height();
		$("#elem2").html("Initial size:"+w+"x"+h);
		var contentDimension = h*1.4;
	});

	$(window).scroll(function (event) {
	    var h = $(window).scrollTop();
	    $("#elem3").html("Scrollbar height:"+h);
	});

	$(window).resize(function() {
		var w = $(window).width();
		var h = $(window).height();
		$("#elem1").html("Resized:"+w+"x"+h);
	});



});
</script>


<span id="elem3"></span>
<div id="container">



	<div class="contentBlock" style="width: 500px; height: 250px; background: red; margin-top: 20px;"></div>
	<div class="contentBlock" style="width: 500px; height: 250px; background: red; margin-top: 20px;"></div>
	<div class="contentBlock" style="width: 500px; height: 250px; background: red; margin-top: 20px;"></div>
	<div class="contentBlock" style="width: 500px; height: 250px; background: red; margin-top: 20px;"></div>
	<div class="contentBlock" style="width: 500px; height: 250px; background: red; margin-top: 20px;"></div>

</div>