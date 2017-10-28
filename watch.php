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
	console.log(sessionStorage.getItem("storedScrollTop"));
	var player   = document.getElementById('player');
	var btn      = $('#play');
	var playing  = false;
	var updateDuration;


	var drag   = $("#trailDrag");
	var trail =  $("#trail");
	var dragPos = drag.position();
	var l;
	var icoPercent = 0;
	var icoPercent = (drag.width()/drag.parent().width())*100;
	var scaleFactor = 100/(100-icoPercent);

	//var startFrom = sessionStorage.getItem("")
	player.removeAttribute("controls");

	var elem = document.getElementById("player");

	console.log("Cookies 1: " + Cookies.get('1'));
	console.log("Cookies volume: " + Cookies.get('volume'));

	try {
		player.currentTime = Cookies.get('1');
	}
	catch(e) {
		console.log(e);
	}
	try {
		player.volume 	   = Cookies.get('volume');
	}
	catch(e) {
		console.log(e);
	}
	finally {
		player.play();
	}

	function newPlayer(id, volume, currentTime) {
		var id = this.id;
		var volume = this.volume;
		var currentTime = this.currentTime;
		var mediaPath; 
		var subs;

		//Fetch media


	}

	//Display controls
	/*
	var mouseafk;
	$("#full").mousemove(function() {
		$("#full").css("opacity", 1);
		clearTimeout(mouseafk);
		if(!player.paused) {
			mouseafk = setTimeout(function() {
				$("#full").css("opacity", 0);
			}, 2000);
		}
		
	});*/

	$('#back').click(function() {
		sessionStorage.setItem("back", 1);
		window.location.href = "cinema.php";
	});

	//Play/pause controller
	$('#play').click(function() {
		player.paused ? player.play() : player.pause();
		
	});

	player.onplay = function() { togglePlay(); }
	player.onpause = function() { togglePlay(); }

	function togglePlay() {
		btn.html() == '<i class="fa fa-pause" aria-hidden="true"></i>' ? btn.html('<i class="fa fa-play" aria-hidden="true"></i>') : btn.html('<i class="fa fa-pause" aria-hidden="true"></i>');
		playing = !playing;
		if(playing) timeStamp();
		else clearTimeout(updateDuration);
		$("#duration").html("Duration: "+ player.duration); 
	}

	function timeStamp() {
		if(playing) {
			updateDuration = setTimeout(function(){
				timeStamp();
				Cookies.set('1', player.currentTime);
				setTrail();
				$("#trailHover").html((player.currentTime/60).toFixed(2));
			}, 1000);
		}
	}


	//Timeline
	function setTrail() {
		var v = (parseFloat(player.currentTime) / (parseFloat(player.duration)*scaleFactor))*100;
        drag.css("left", v+ "%");
        trail.css("width", v+ "%");
	}


	drag.draggable({
	    containment: 'parent',
	    snap: '.gridlines',
	    axis: 'x',
	    stop: function () {
	        /*l = ( 100 * (parseFloat($(this).position().left / parseFloat($(this).parent().width()))) ) + "%" ;
	        $(this).css("left", l);
	        trail.css("width", l);*/
	        player.play();
	    }
	});

	drag.on( "drag", function() {
		icoPercent = (drag.width()/drag.parent().width())*100;
		scaleFactor = 100/(100-icoPercent);
		l = ( 100 * parseFloat(drag.position().left / parseFloat(drag.parent().width())));
        drag.css("left", l+ "%");
        trail.css("width", l+ "%");
        
        scaledDuration = player.duration*scaleFactor;

        current  = (scaledDuration*l)/100;

        //$("#timedata").html("Real duration:  "+player.duration + " | Cursor pos: "+ l.toFixed(4) + " | Video actual pos: "+ current.toFixed(3));

		player.currentTime = current;
		player.pause();
		
		$("#trailHover").html((player.currentTime/60).toFixed(2));
		//console.log("Video should play at: "+player.duration + " / " +current);
	});




	/*
	$("#trailDrag").hover(function() {
		$(this).append(player.currentTime);
	});*/

	//Sound controller	
	var dragBtn = $("#drag");
	dragBtn.draggable({ containment: "parent" });

	function setVolume(v) {
		v = 110-v;
		console.log("Player volume is now: " + v);
		player.volume = (v/100);
		Cookies.set('volume', player.volume);
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
	<video autobuffer autoloop loop controls id="player" controls="controls">
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
	
</div>

