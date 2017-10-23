<?php include 'header.php'; ?>

	<div class="searchWrapper">
		<div class="srcBar">
		<div class="input-group">
	    <span class="input-group-addon">Search</span>
	    <input id="msg" type="text" class="form-control" name="msg" placeholder="Example: Iron Man, Titanic">
	</div>

	  </div>
	</div>

	<div id="cinemaContent">
		<div class="cinemaRow row" id="continueWatching">
			<h1 class="cinemaRowTitle">Continue watching</h1>
		</div>
		<div class="cinemaRow row"  id="recentlyAdded">
			<h1 class="cinemaRowTitle">Recently added</h1>
		</div>
		<div class="cinemaRow row"  id="exploreTitles">
			<h1 class="cinemaRowTitle">Browse</h1>
		</div>
	</div>

<div id="previewTitle"></div>

<script src="js/cinema.js"></script>

