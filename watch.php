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
	//General
	var player   = document.getElementById('player');
	var btn      = $('#play');
	var playing  = false;
	var updateDuration;
	player.removeAttribute("controls");

	var elem = document.getElementById("player");

	//Play/pause controller
	$('#play').click(function() {
		player.paused ? player.play() : player.pause();
		btn.html() == '<i class="fa fa-pause" aria-hidden="true"></i>' ? btn.html('<i class="fa fa-play" aria-hidden="true"></i>') : btn.html('<i class="fa fa-pause" aria-hidden="true"></i>');
		playing = !playing;
		if(playing) timeStamp();
		else clearTimeout(updateDuration);
		$("#duration").html(player.duration); 
	});

	function timeStamp() {
		if(playing) {
			updateDuration = setTimeout(function(){
				$("#current").html(player.currentTime); 
				timeStamp();
				setTrail(player.currentTime, player.duration);
			}, 100);
		}
	}

	//Timeline
	function setTrail() {
		var v = (player.currentTime / player.duration)*100;
		console.log(v);
		$("#trail").css("width", v+"%");
	}

	$("#trailDrag").hover(function() {
		$(this).append(player.currentTime);
	});

	//Sound controller	
	var dragBtn = $("#drag");
	dragBtn.draggable({ containment: "parent" });

	function setVolume(v) {
		v = 110-v;
		console.log("Player volume is now: " + v);
		player.volume = (v/100);
		console.log("Player volume is now: " + player.volume);
	}

	dragBtn.on( "dragstop", function() {
		dragPos = dragBtn.position();
		posTop = dragPos.top;
		console.log(posTop);
		setVolume(posTop);
	});

	var vp = $("#volumePop");
	vp.hide();
	$('#volume').click(function() {
		vp.fadeToggle("fast", "linear");
	});

	//Fullscreen mode
	$("#fullscreen").click(function() {
		toggleFullScreen();
		console.log("fire");
	});

	//Update for cross browsers later. Works in Chrome atm.
	//https://developer.mozilla.org/en-US/docs/Web/API/Fullscreen_API#Toggling_fullscreen_mode
	function toggleFullScreen() {
		if (!document.webkitFullscreenElement) document.documentElement.webkitRequestFullscreen();
		else document.webkitExitFullscreen(); 
	}



	//Subtitles
	var sw = $("#subsWrapper");
	sw.hide();
	$('#subtitles').click(function() {
		sw.fadeToggle("fast", "linear");
		//appendSubs("storage/movies/completed/iron man/subs/bbt.vtt");
	});
	
	function appendSubs(src) {
		s = '<track src="'+src+'" srclang="en" kind="subtitles" default="true">';
		$("#player").append(s);
	}
	
});
</script>
<div id="full">
	<div id="playerBack"><--</div>


	<video autobuffer autoloop loop controls id="player" controls="controls">
		<source src="<?php echo $id ?>">
	</video>

	<div id="timeline">
		<h1>Current:</h1>
		<p id="current"></p>
		<div id="trail">
			<div id="trailDrag"></div>
		</div>

		<p id="duration"></p>
	</div>

	<div id="playerControls">
		
		<div class="controlBlock left" id="play">
			<i class="fa fa-play" aria-hidden="true"></i>
		</div>

		<div class="controlBlock left" id="volume">
			<i class="fa fa-volume-up" aria-hidden="true"></i>
			<div id='volumePop'>
				<div id="dragContain"><div id="drag"></div></div>
			</div>
		</div>

		<div class="controlBlock right" id="subtitles">
			<i class="fa fa-cc" aria-hidden="true"></i>
			<div id='subsWrapper'>
				<div id="selectSub">Default</div>
			</div>
		</div>

		<div class="controlBlock right" id="fullscreen">
			<i class="fa fa-arrows-alt" aria-hidden="true"></i>
		</div>

		<div class="controlBlock title">
			Title TitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitleTitle
		</div>

	</div>

	
</div>



<script>

	var ele = $("#menu");
	ele.click(function() {
		ele.fadeToggle("slow", "linear");
	});


</script>