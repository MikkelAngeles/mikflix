<?php
	include 'header.php';
	$id =  $_SERVER['QUERY_STRING'];
?>
<script src="js/upload.js"></script>

<body>


<div class="row">
	<div class="uploadTitleWrap">
		<input id="uploadTitle" type="text" class="uploadTitle" placeholder="Search for title...">
	</div>
</div>

<div id="uploadWrapper" class="row">
	<div class="col-md-7">
		
			
		<div id="previewMode" class="mBlock">
			<div class="mHeader iconBefore icon-film">Title</div>
			<div class="mRow">
				<h1 id="Settings"></h1>
				<div id="poster"></div>
				<div id="meta">
					<div id="title"></div>
					<div id="overview"></div>
				</div>
				<div id="video"></div>
			</div>
		</div>

		<div id="files" class="mBlock" >
			<div class="mHeader iconBefore icon-upload">Upload</div>
			<form action="hollywood.php" method="post" name="fileForm" id="fileForm" enctype="multipart/form-data">

				<div id="labelWrapper" class="mRow">
					<label for="mediaFile">
						<i class="fa fa-upload" aria-hidden="true"></i>
						Click here to select a file
					</label>
					
			        <input type="file" name="mediaFile" id="mediaFile" class="displayNoneUltra">
				</div>

		        <div id="selectedFile" class="mRow">
		        	<div class="row">
			        	<div class="col-md-4">		        	
				        		<h1 id="fileName"></h1>
				        		<p id="fileSize"></p>
				        </div>	
			        	
			        	<div class="col-md-8">
			        		<div class="fileProgress">
						        <div class="bar progress-bar progress-bar-success progress-bar-striped active" role="progressbar"><div class="percent">0%</div ></div >
						       
						    </div> 
			        		<div id="discard"><i class="fa fa-trash-o" aria-hidden="true"></i></div>  	
			        	</div>
		        	</div>
		        </div>
		    </form>
		</div>
		
		<div class="mBlock" id="subtitles">
			<div class="mHeader iconBefore icon-subtitle">Subtitles</div>
			<form action="hollytest.php" method="post" name="subtitlesForm" id="subtitlesForm" enctype="multipart/form-data"></form>
		</div>
	</div>

	<div class="col-md-5">	
		<div class="mBlock">
			<div class="mHeader iconBefore icon-preview">Preview</div>
			<div class="mRow" id="videoPreview"><video width="100%" height="100%" controls id="previewPlayer"></video></div>
		</div>
		<div class="mBlock">
			<div class="mHeader iconBefore icon-settings">Settings</div>
			<div class="mRow">
				<div class="checkbox">
			  		<label><input type="checkbox" id="published">Published</label>
				</div>
			</div>

			<div class="mRow">
				<button type="button" id="submitUpload" class="btn btn-success">Complete</button>
				<button type="button" id="cancelUpload" class="btn btn-danger">Cancel</button>
			</div>
		</div>
	</div>


</div>

   <div class="errorAppend"></div>
</body>
<?php include 'footer.php' ?>
