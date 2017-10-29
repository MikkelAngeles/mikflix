<?php 
	session_start();
	include 'checkSession.php';
	include 'fetcher.php';	
	include 'calculations.php';
	include 'head.php'; 


	//$id = $_GET;
	$id =  $_SERVER['QUERY_STRING'];
?>

<script>
$(document).ready(function(){
	//Debug
	console.log(sessionStorage.getItem("storedScrollTop"));

	//Default general variables
	var player   = document.getElementById('player');
	var playing  = false;
	var updateDuration;

	//Default play button variables
	var playBtn  = $('#play');

	//Default timeline variables
	var trailDrag   	=  $("#trailDrag");
	var trail 	    	=  $("#trail");
	var trailPos;
	var trailPosLeft;
	var trailIconWidth  = (trailDrag.width()/trailDrag.parent().width())*100;
	var scaleFactor     = 100/(100-trailIconWidth);

	//Default sound variables
	var soundDrag 	 	 = $("#soundDrag");
	var soundDragPos 	 = soundDrag.position();
	var soundDragPosTop;
	var volume = 1;

	//Initialization of player
	player.removeAttribute("controls");

	//Attempt to start video from cookies
	try {
		player.currentTime = Cookies.get('1');
	}
	catch(e) {
		console.log(e);
	}

	//Attempt to set volume from cookies
	try {
		volume = Cookies.get('volume');
	}
	catch(e) {
		console.log(e);
	}
	finally {
		player.volume = volume;
		console.log(volume);
		soundDrag.css("top", (100-(volume*100))+"px");
		player.play();
	}


	//Create a new player based on input. NOT USED YET.
	function newPlayer(id, volume, currentTime) {
		var id = this.id;
		var volume = this.volume;
		var currentTime = this.currentTime;
		var mediaPath; 
		var subs;
	}


	/* -------------------- Controllers ------------------ */ 

	//////////////////
	//Play & Pause 
	//////////////////

	$('#play').click(function() { player.paused ? player.play() : player.pause(); });
	player.onplay  = function() { togglePlay(); }
	player.onpause = function() { togglePlay(); }

	function togglePlay() {
		playBtn.html() == '<i class="fa fa-pause" aria-hidden="true"></i>' ? playBtn.html('<i class="fa fa-play" aria-hidden="true"></i>') : playBtn.html('<i class="fa fa-pause" aria-hidden="true"></i>');
		playing = !playing;
		timeStamp();	
	}

	function timeStamp() {
		if(playing) {
			updateDuration = setTimeout(function(){
				var v = (parseFloat(player.currentTime) / (parseFloat(player.duration)*scaleFactor))*100;
		        trailDrag.css("left", v+ "%");
		        trail.css("width", v+ "%");
				Cookies.set('1', player.currentTime);
				timeStamp();
				$("#trailHover").html((player.currentTime/60).toFixed(2));
			}, 1000);
		}
		else { clearTimeout(updateDuration); }
	}



	//////////////////
	//Volume
	//////////////////

	soundDrag.draggable({ containment: "parent" });

	soundDrag.on("drag", function() {
		soundDragPos    = soundDrag.position();
		soundDragPosTop = soundDragPos.top;
		volume = ((110-soundDragPosTop)/100).toFixed(2);
		Cookies.set('volume', volume);
		player.volume = volume;
		console.log(volume);
	});

	var volumePump = $("#volumePump");

	$('#volume').click(function() {
		volumePump.fadeToggle("fast", "linear");
	});

	//////////////////
	//Fullscreen
	//////////////////

	var browser = 0;
	$("#fullscreen").click(function() {
		toggleFullScreen();
	});

	//Update for cross browsers later. Works in Chrome atm.
	//https://developer.mozilla.org/en-US/docs/Web/API/Fullscreen_API#Toggling_fullscreen_mode
	function toggleFullScreen() {
		if (!document.webkitFullscreenElement) document.documentElement.webkitRequestFullscreen();
		else document.webkitExitFullscreen(); 
	}


	//////////////////
	//Subtitles
	//////////////////

	var sw = $("#subsWrapper");
	sw.hide();
	$('#subtitles').click(function() {
		sw.fadeToggle("fast", "linear");
		//appendSubs("storage/movies/completed/iron man/subs/bbt.vtt");
	});
	
	function appendSubs(src) {
		s = '<track src="'+src+'" srclang="en" kind="subtitles" default="true" class="hover">';
		$("#player").append(s);
	}

	var subs = ['English', 'Danish'];
	subs.sort();

	var subsList = '<ul>'

	$.each(subs, function(v,k) {
		subsList += '<li>'+k+'</li>';
	});

	subsList += '</ul>'

	$("#selectSub").append(subsList);

	$("#selectSub").on('click', 'li', function() {
		console.log(this);
		s = '<track src="storage/movies/completed/iron man/subs/bbt.vtt" data-id="'+this+'" srclang="en" kind="subtitles" default="true" class="hover">';
		$("#player").html(s);
	});

	//////////////////
	//Timeline
	//////////////////

	trailDrag.draggable({
	    containment: 'parent',
	    snap: '.gridlines',
	    axis: 'x',
	    stop: function () {
	        player.play();
	        $("#trailHover").hide();
	    }
	});

	trailDrag.on("drag", function() {
		trailIconWidth = (trailDrag.width()/trailDrag.parent().width())*100;
		scaleFactor = 100/(100-trailIconWidth);
		trailPosLeft = ( 100 * parseFloat(trailDrag.position().left / parseFloat(trailDrag.parent().width())));
        trailDrag.css("left", trailPosLeft+ "%");
        trail.css("width", trailPosLeft+ "%");
        scaledDuration = player.duration*scaleFactor;
        current  = (scaledDuration*trailPosLeft)/100;
		player.currentTime = current;
		player.pause();
		$("#trailHover").html((player.currentTime/60).toFixed(2));
		$("#trailHover").show();
	});



	//////////////////
	//Back
	//////////////////

	$('#back').click(function() {
		sessionStorage.setItem("back", 1);
		window.location.href = "cinema.php";
	});



	//////////////////
	//Eventlisteners
	//////////////////

	//Display controls
	var mouseafk;
	$("#full").mousemove(function() {
		$("#full").css("opacity", 1).css("cursor", "default");
		player.css("")
		clearTimeout(mouseafk);
		if(!player.paused) {
			mouseafk = setTimeout(function() {
				$("#full").css("opacity", 0).css("cursor", "none");
			}, 3500);
		}	
	});

	//Pause player on space
	$(document).on('keyup',function(evt) {
	    if (evt.keyCode == 32) {
	       player.paused ? player.play() : player.pause();
	    }
	});
	
	
});
</script>



<video autobuffer controls id="player">
	<source src="<?php echo $id ?>">
</video>
<div id="full">
	<div id="playerBack">
		<i class="fa fa-arrow-circle-left" aria-hidden="true" id="back"></i>
		<div id="timedata"></div>
	</div>
	<div id="controlWrapper">	
		<div id="timeline">
			<div id="trailDrag"><div id="trailHover"></div></div>
			<div id="trail"></div>
			<div id="inner"></div>
		</div>
		<div id="playerControls">	
			<div class="controlBlock left" id="play">
				<i class="fa fa-play" aria-hidden="true"></i>
			</div>
			<div class="controlBlock left" id="volume">
				<i class="fa fa-volume-up" aria-hidden="true"></i>
				<div id='volumePump'>
					<div id="dragContain"><div id="soundDrag"></div></div>
				</div>
			</div>
			<div class="controlBlock right" id="fullscreen">
				<i class="fa fa-arrows-alt" aria-hidden="true"></i>
			</div>
			<div class="controlBlock right" id="subtitles">
				<i class="fa fa-cc" aria-hidden="true"></i>
				<div id='subsWrapper'>
					<div id="selectSub"></div>
				</div>
			</div>
			<div class="controlBlock title"></div>
		</div>
	</div>
</div>

