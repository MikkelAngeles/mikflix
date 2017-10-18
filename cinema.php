<?php include 'header.php'; ?>

	<div class="searchWrapper">
		<div class="srcBar">
		<div class="input-group">
	    <span class="input-group-addon">Search</span>
	    <input id="msg" type="text" class="form-control" name="msg" placeholder="Example: Iron Man, Titanic">
	</div>

	  </div>
	</div>

	<div id="cinemaContent"></div>


<script>
$(document).ready(function(){

	//@Description: Early version of dynamic loading for mikflix 2017 
	//@Version: 1.0
	//@Developed by Mikkel Helmersen

 	//Elements & collections
	var container = $("#cinemaContent");
	var cinemaResults = [];

	//Dynamic and relative item preload calculation by item dimensions
	var x = 160;
	var y = 225;
	var windowHeight = window.innerHeight;
	var windowWidth = window.innerWidth;
	var containerMargin = 80;
	var topMargin = 234;
	var initialItemsPerRow = (windowWidth-containerMargin)/x;
	var initialRows = (windowHeight-topMargin)/y;

	//System variables
 	var endOfItems = 0;
 	var scrollTimeout = 1;
	var incrementBy = Math.floor(initialRows*initialItemsPerRow*2);
	var offset_a = 0;
	var offset_b = Math.floor(initialRows*initialItemsPerRow*2.5);

	function fetchItems(a, b) {
		cinemaResults = [];
		if(!endOfItems) {
			var querySet = {
				'authKey': "getCinema",
				'offset_a': a,
				'offset_b': b,
			};

			request = $.ajax({
				type: 'GET', 
			    url: 'hollywood.php', 
			    data: querySet, 
			    dataType: 'json',
			    success: function (data) { 
			        $.each(data, function(k, v) {
			            cinemaResults.push(v);
			        });
			    }
			});

			request.done(function() {
				loadItems();
				scrollTimeout = 1;
			});
		}
	}

	function loadItems() {
		console.log(cinemaResults.length);
		if(cinemaResults.length > 0) {
			offset_a = offset_b;
			offset_b = offset_b+incrementBy;

			var item = "";
			$.each(cinemaResults, function(k, v) {
	            item = "";
	            item += '<div class="itemWrapper">';
	            item += '<div class="itemThumbnail" style="background-image: url(http://image.tmdb.org/t/p/w185'+v.posterPath+')">';
	            item += '</div>';
				item += '<div class="itemTitle">'+v.originalTitle+'<p>Item nr:'+k+'</p></div>';
				item += '</div>';
				container.append(item);
	        });
        } else {
        	endOfItems = 1;
        }
	}

	function triggerNewOffset() {
		if($(window).scrollTop()+ $(window).height() > $(document).height()-(y*3) && scrollTimeout > 0 && !endOfItems)  {
			scrollTimeout = 0;
			fetchItems(offset_a, offset_b);
		}
	}

	$(window).scroll(function() {	
		triggerNewOffset();
	});

	$(window).resize(function() {	
		triggerNewOffset();
	});

	//Force ini by pageload
	fetchItems(offset_a, offset_b);

	/*
	console.log(windowHeight);
	console.log(windowWidth);
	console.log("Initial Items Per Row: "+initialItemsPerRow);
	console.log("Initial Rows: "+initialRows);
	console.log("Total items required: "+Math.floor(initialRows*initialItemsPerRow*2));
	*/

});
</script>

