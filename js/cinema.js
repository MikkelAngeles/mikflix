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
	var x = 170; //Width of an item
	var y = 253; //Height of an item
	var windowHeight = window.innerHeight;

	console.log("back: "+sessionStorage.getItem("back"));

	if(sessionStorage.getItem("back") > 0 && sessionStorage.getItem("storedScrollTop") > window.innerHeight) {
		windowHeight = sessionStorage.getItem("storedScrollTop");
		checkPosition();
	}

	console.log("ScrollTop: "+sessionStorage.getItem("storedScrollTop"));
	console.log("Window h: "+windowHeight);

	var windowWidth = window.innerWidth;
	var containerMargin = 80;
	var topMargin = 234;
	var initialItemsPerRow = (windowWidth-containerMargin)/x;
	var initialRows = (windowHeight-topMargin)/y;

	console.log(initialItemsPerRow);
	console.log("Scroll top: "+sessionStorage.getItem("storedScrollTop"));
	//System variables
 	var endOfItems = 0;
 	var scrollTimeout = 1;
	var incrementBy = Math.floor(initialRows*initialItemsPerRow*2);
	var offset_a = 0;
	var offset_b = Math.floor(initialRows*initialItemsPerRow*2.5);
	var requestStatus = 0;
	var loaded = false;
	var preview = false;
	var stage = 1;


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
		if(requestStatus == 1) {
			loadItems(q, e);
			console.log("stage: "+ stage);
			stage++;
		}
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
			item += ''+k+'</div>';
			container.append(item);
        });
        if(stage == 3) checkPosition();
	}

	function triggerNewOffset() {
		if($(window).scrollTop()+$(window).height() > $(document).height()-(y*2) && scrollTimeout > 0 && !endOfItems)  {
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
		else {
			//console.log("scroll timeout");
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
			item += '<div id="previewWrapper">';
				if(arr[0].backdropPath.length > 0) 
				item += '<div class="row banner" style="background-image: url(http://image.tmdb.org/t/p/w1280/'+arr[0].backdropPath+')">';
				else			
				item += '<div class="row banner">';

				item += '<div class="playIco" data-src="storage/movies/completed/'+arr[0].originalTitle+'/'+arr[0].file+'"></div></div>';
				item += '<div class="row itemTitle" data-title-id="'+arr[0].titleId+'">'+arr[0].originalTitle+'</div>';
				item += '<div class="row overview"><p>'+arr[0].overview+'</p></div>';

				item += '<div class="row meta">';
					item += '<div class="col-md-2 tabs"><p>Rating: '+arr[0].voteAverage+'</p></div>';
					item += '<div class="col-md-2 tabs"><p>Votes: '+arr[0].voteCount+'</p></div>';
					item += '<div class="col-md-2 tabs"><p>Popularity: '+arr[0].popularity+'</p></div>';
					item += '<div class="col-md-2 tabs"><p>Language: '+arr[0].language+'</p></div>';
					item += '<div class="col-md-1 tabs"><p>Genre: '+arr[0].genre+'</p></div>';
					item += '<div class="col-md-2 tabs"><p>Release date: '+arr[0].releaseDate+'</p></div>';
					item += '<div class="col-md-1 tabs"><p>Adult: '+arr[0].adult+'</p></div>';
				item += '</div>';
			item += '</div>';
			$("#previewTitle").html(item);
			
		})
	}

	$("#previewTitle").hide();

	$('#cinemaContent').on('click', '.itemWrapper', function() {
		//$("#previewTitle").remove();
		//$("#previewTitle").show();
		displayPreview();
		var ele = $(this);
		var pos = ele.position();
		var h = ele.height();
		var id = ele.attr("data-title-id");
		generateDescription(id, ele);
	});

	
	$("html").click(function(evt) {
		if(evt.target.id == "previewTitle") {
			displayPreview();
		}
	});

	$(document).on('keyup',function(evt) {
	    if (evt.keyCode == 27) {
	       displayPreview();
	    }
	});

	function displayPreview() {
		var ele = $('#previewTitle');
		ele.fadeToggle( "fast", "linear" );
		if(!preview) $('body').css("overflow", "hidden");
		else $('body').css("overflow", "auto");
		preview = !preview;
		storeScrollTop();
	}

	$('#previewTitle').on('click', '.playIco', function() {
		var path = $(this).attr("data-src");
		$('body').css('opacity', 0);
		var redirectEvent = setTimeout(function() {
			window.location.href ="watch.php?"+path;
		}, 300);
	});



	//Scroll position listener
	function storeScrollTop() {
		sessionStorage.setItem("storedScrollTop", $(window).scrollTop());
		//console.log("Session scrollTop: "+sessionStorage.getItem("storedScrollTop"));
	}
	

	function scrollToStoredPos() {
		$(document).scrollTop(sessionStorage.getItem("storedScrollTop"));
	}

	var checkCount = 0;
	var pos;
	function checkPosition() {
		if($(window).scrollTop() < sessionStorage.getItem("storedScrollTop")-80) {
			pos = setTimeout(function() {
				console.log("position is: " + $(window).scrollTop());
				scrollToStoredPos();
				checkPosition();
				y++;
			}, 1000);
		} else {
			sessionStorage.setItem("back", 0);
			sessionStorage.setItem("storedScrollTop", 0);
			clearTimeout(pos);
		}
		if(checkCount > 50) clearTimeout(pos);
	}
	
});
