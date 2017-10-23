$(document).ready(function(){
	//@Description: Early version of dynamic loading for mikflix 2017 
	//@Version: 1.0
	//@Developed by Mikkel Helmersen

 	//Elements & collections
	var conCollection = []; //Has continue watching items
	var recCollection = []; //Has recently added items
	var expCollection = []; //Has all items ranked by popularity
	var titleDataCollection = []; //Has title data 
	
	//Dynamic and relative item preload calculation by item dimensions
	var x = 160; //Width of an item
	var y = 225; //Height of an item
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
	var requestStatus = 0;
	var loaded = false;


	function fetchItems(q, arr) {
		requestStatus = 0;
		var request = $.ajax({
			type: 'get', 
		    url: 'hollywood.php', 
		    data: q, 
		    dataType: 'json',
		    success: function (data) { 
		        $.each(data, function(k, v) {
		            arr.push(v);
		        });
		    }
		});

		request.done(function () {
			requestStatus = 1;
			scrollTimeout = 1;
			if(!arr.length > 0) endOfItems = 1;	
		})
	}

	function loadItemsQueue(q, e) {
		if(requestStatus == 1) loadItems(q, e);
		else {
			setTimeout(function() {
				loadItemsQueue(q,e);	
			}, 100);
		}
	}

	function loadItems(arr, e) {
		var container = $(e);
		var item = "";
		$.each(arr, function(k, v) {
            item = "";
            item += '<div class="itemWrapper" data-row-id='+k+' data-title-id='+v.titleId+'>';
            item += '<div class="itemThumbnail" style="background-image: url(http://image.tmdb.org/t/p/w185'+v.posterPath+')">';
            item += '</div>';
			//item += '<div class="itemTitle" data-title-id='+v.titleId+'>'+v.originalTitle+'<p>Item nr:'+k+'</p></div>';
			item += '</div>';
			container.append(item);
        });
	}

	function triggerNewOffset() {
		if($(window).scrollTop()+ $(window).height() > $(document).height()-(y*2) && scrollTimeout > 0 && !endOfItems)  {
			scrollTimeout = 0;

			offset_a = offset_b;
			offset_b = offset_b+incrementBy;

			expCollection = [];

			q = {
				'authKey': "getCinema",
				'offset_a': offset_a,
				'offset_b': offset_b,
			}; 

			fetchItems(q, expCollection);
			loadItemsQueue(expCollection, '#exploreTitles');
		}
	}

	$(window).scroll(function() {	
		triggerNewOffset();
	});

	$(window).resize(function() {	
		triggerNewOffset();
	});

	function initializePage() {
		//Stage 1: Continue watching
		var q = {
			'authKey': 'getIncomplete',
			'userId': 6,
		};
		fetchItems(q, conCollection);
		loadItemsQueue(conCollection, '#continueWatching');

		//Stage 2: Recently added
		q = {
			'authKey': 'getRecentlyAdded',
			'max': Math.floor(initialItemsPerRow),
		};
		fetchItems(q, recCollection);
		loadItemsQueue(recCollection, '#recentlyAdded');

		//Stage 3: Explore
		q = {
			'authKey': "getCinema",
			'offset_a': offset_a,
			'offset_b': offset_b,
		}; 
		fetchItems(q, expCollection);
		loadItemsQueue(expCollection, '#exploreTitles');
	}

	initializePage();


	//Page functionality
	function generateDescription(id, ele) {
		var arr =  [];
		var q = {
			'authKey': 'getTitleData',
			'titleId': id,
		}
		var request = $.ajax({
			type: 'get', 
		    url: 'hollywood.php', 
		    data: q, 
		    dataType: 'json',
		    success: function (data) { 
		        $.each(data, function(k, v) {
		            arr.push(v);
		            console.log(k+" "+v.titleId);
		        });
		    }
		});
		request.done(function () {
			item = "";
			item += '<div class="row banner" style="background-image: url(http://image.tmdb.org/t/p/w1280/'+arr[0].backdropPath+')">';
			item += '<a href="storage/movies/completed/'+arr[0].originalTitle+'/'+arr[0].file+'"><div class="playIco"></div></a></div>';
			item += '<div class="row itemTitle" data-title-id="'+arr[0].titleId+'">'+arr[0].originalTitle+'</div>';
			item += '<div class="row overview"><p>'+arr[0].overview+'</p></div>';
			$("#previewTitle").html(item);
			
		})
	}
	$("#previewTitle").hide();
	$('#cinemaContent').on('click', '.itemWrapper', function() {
		//$("#previewTitle").remove();
		$("#previewTitle").show();
		var ele = $(this);
		var pos = ele.position();
		var h = ele.height();
		//$("#moveable").css("top", (pos.top+h));
		var id = ele.attr("data-title-id");
		generateDescription(id, ele);
	});

	$("#previewTitle").click(function() {
		$(this).hide();
	});

	$(document).on('keyup',function(evt) {
    if (evt.keyCode == 27) {
       $("#previewTitle").hide();
    }
});

});