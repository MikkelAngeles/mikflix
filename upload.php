<?php
	include 'header.php';
?>

<script>
	$(document).ready(function(){

		//Global variables
		var uploadStatus     = false;
		var titleValid 		 = 0;
		var title 			 = "";
		var file;
		var subFile;
		var fileCollection   = [];
		var size;
		var subSize;
		var status 			 = $('#status');
		var user  			 = "<?php echo $currentUser?>"

		//Global Ajax collections
		var jsonResults   = [];
		var jsonGetStatus = 0;

		//Security implementations
		var requests = 0;
		var blocked  = false;
		var strikes  = 0;

		$.antiSpam = function() {
			if(!blocked) {
				setTimeout(function() {
					requests--;
				}, 2000);	
			}
			if(requests >= 5 && !blocked) {
				blocked = true;
				strikes++;
				setTimeout(function() {
					blocked = false;
					requests--;
				}, 1000);
			}
			if(blocked) { 
				//alert("You're sending too many requests, slow down. Wait 10 seconds to continue."); 
			}
			if(strikes > 2) {
				window.location.replace("spam.php");
			}
		}
		//Security End

		//General control of interactions
		$.elementCursor = function(id, cursor) {
			$(id).css("cursor", cursor);
		}

		$.enableButton = function(id, status) {
			if(status) {
				$(id).prop('disabled', false);
				$.elementCursor(id, "default");
			} else {
				$(id).prop('disabled', true);
				$.elementCursor(id, "not-allowed");
			}
			
		}

		if(uploadStatus) {
			$.elementCursor("#submitUpload", "default");
		}
		if(!uploadStatus) {
			$.elementCursor("#submitUpload", "not-allowed");
		}


		//Visual events for uploading
		$.toggleProgress = function(id, toggle) {
			if(toggle) $(id).show();
			else $(id).hide();
		}

		$.toggleProgress('.fileProgress', false);
		$("#videoPreview").hide();
		$("#discardUpload").hide();


		//Reusable ajax request
		$.ajaxRequest = function(url, ajaxType, data) {

			if(ajaxType === 'post') {

				request = $.ajax( {
					url: url,
					scriptCharset: "utf-8" ,
    	            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
					type: 'POST',
					data: data
				});
				
				request.done(function (response, textStatus, jqXHR) {
					console.log("Success message: "+ textStatus);

				})

				request.fail(function (jqXHR, textStatus, errorThrown) {
					console.error("Error message: "+ textStatus, errorThrown);
				})
			}

			if(ajaxType === 'get') {
				jsonResults = [];
				request = $.ajax({
					type: 'GET', 
				    url: url,
				    scriptCharset: "utf-8" ,
    	            contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
				    data: data, 
				    dataType: 'json',
				    success: function (data) { 
				        $.each(data, function(k, v) {
				            jsonResults.push(v);
				        });
				    }
				});

				request.done(function (response, textStatus, jqXHR) {
					jsonGetStatus = 1;
					console.log("Done, json status:"+ jsonGetStatus);
				})

				request.fail(function (jqXHR, textStatus, errorThrown) {
					jsonGetStatus = 0;
					console.log("Error message: "+ textStatus, errorThrown);
				})
			}
		}

		//
		function submitStatus() {
			if(titleValid && uploadStatus) {
				$.elementCursor("#submitUpload", "default");
				console.log("(true) Status: "+ title.length + uploadStatus);
				return true;
			} else {
				$.elementCursor("#submitUpload", "not-allowed");
				return false;
				console.log("(false) Status: "+ title.length + uploadStatus);
			}
		}
		

		//Automatically upload file to tmp
		$("#mediaFile").change(function() {
			var selected = $(this);

			file = selected.val().replace(/C:\\fakepath\\/i, '');
			size = selected[0].files[0].size;
			fileName = selected[0].files[0].name;

			fileName = fileName.replace(/.mp4/g, " ");
			fileName = fileName.replace(/.mkv/g, " ");
			fileName = fileName.replace(/.flv/g, " ");
			fileName = fileName.replace(/.mov/g, " ");
			fileName = fileName.replace(/.webm/g, " ");
			fileName = fileName.replace(/\./g, " ");
			fileName = fileName.replace(/\,/g, " ");
			fileName = fileName.replace(/\_/g, " ");
			fileName = fileName.replace(/\-/g, " ");

			console.log(fileName);
			if(file) {
				//$("#fileForm").submit();
				uploadStatus = true;
				suggestImdb(fileName);
				$.autoUpload("#fileForm", ".fileProgress");
				console.log($("#fileForm"));
			} else {
				$.toggleProgress('.progress', false);
				uploadStatus = false;
			}
		});

		//Automatically upload subs to tmp
		$("#subtitleFile").change(function() {
			var selected = $(this);
			subFile = selected.val().replace(/C:\\fakepath\\/i, '');
			subSize = selected[0].files[0].size;
			$('#sourcePreview')

			if(subFile) {
				uploadStatus = true;
				var fileSet = {
					'name': "English",
					'file': subFile,
				}
				fileCollection.push(fileSet);
				$.autoUpload("#subtitlesForm", 0);
			} 
		});

		
		//Reload preview & subs
		$.reloadVideoPreview = function() {

			if(uploadStatus) {
				//fileCollection = [{name: 'English', file: 'uploadedBy_admin_bbt.vtt'}];
				//console.log(fileCollection[0].name);
				var source = '<video width="100%" height="auto" controls>'; 
				source    += '<source src="storage/movies/tmp/'+user+'/'+file+'" type="video/mp4" id="sourcePreview">';
				for(i = 0; i < fileCollection.length; i++) {
					source += '<track label="'+fileCollection[i].name+'" kind="subtitles" srclang="en" src="storage/movies/tmp/'+user+"/subs/"+fileCollection[i].file+'" default>';
				}
				source += '</source>';
				source += '</video>';
				console.log(source);
				$("#videoPreview").html(source);
			} 
			else {
				$("#videoPreview").html("");
			}
		}

		
			
	    //Automatically uploads file on input, then returns progress to inserted progress set
	    $.autoUpload = function(formId, loadId) {

	   		if(!loadId == 0) {
		    	//Determine progress set
		    	percent = $(loadId).find('.percent');
		    	bar     = $(loadId).find('.bar');
		    
		    	//Prepare to catch the submit, upload & return progress
				$(formId).ajaxForm({
				    beforeSend: function() {
				        status.empty();
				        var percentVal = '0%';
				        bar.width(percentVal)
				        percent.html(percentVal);
				        $.toggleProgress(loadId, true);
				    },
				    uploadProgress: function(event, position, total, percentComplete) {
				        var percentVal = percentComplete + '%';
				        bar.width(percentVal)
				        percent.html(percentVal);
				    },
				    success: function() {
				        var percentVal = '100%';
				        bar.width(percentVal)
				        percent.html(percentVal);
				    },
					complete: function(xhr) {
						$("#discardUpload").show();
						video = $("#videoPreview");
						submitStatus();
						$.reloadVideoPreview();
						video.show();
					}
				}); 
			} else {
				$(formId).ajaxForm({
					complete: function(xhr) {
						$.reloadVideoPreview();
					}
				});
			}

			//Submit form
	    	$(formId).submit();
		}

		//Preview Eventlistener

		var inputCount = 0;
		var executeQuery;
		var query = $("#uploadTitle").val();
		var qData;
		var s = "";
		var suggetCollection = [];

		$("#uploadTitle").on('input', function() {

			query = $("#uploadTitle").val();

			$(".previewTitle").html($(this).val());

			if(query.length > 0) {

				suggestImdb(query);

				qData = {
					'authKey': "getExistingTitle",
					'query': query,
				};

				if(inputCount > 0) clearTimeout(executeQuery);

				executeQuery = setTimeout(function() {
					$.ajaxRequest("hollywood.php", "get", qData);
					jsonStatus(existingTitles, submitStatus);
					inputCount = 0;
				}, 500);

				inputCount++;
			} else {
				clearTimeout(executeQuery);
				$.dynamicOutput("#existingTitles", "#content", 0, 0);
			}
		});

		function suggestImdb(s) {
			request = $.ajax({
				type: 'GET', 
			    url: 'https://api.themoviedb.org/3/search/movie', 
			    data: 'api_key=358880c8fe35414bfde1e7ed15ae13e9&query='+s+'&page=1', 
			    dataType: 'json',
			    success: function (data) { 
			    	suggetCollection = [];
			    	suggetCollection.push(data.results);
			    	console.log("Result size: "+suggetCollection[0].length);
			    	if(suggetCollection[0].length > 0) {
				        $.each(suggetCollection, function(k, v) {
				        	$(".itemThumbnail").css("background-image", "url(http://image.tmdb.org/t/p/w185/"+v[0].poster_path+")");
				        	$(".itemTitle").html(v[0].title);
				        	$(".itemRating").html(v[0].vote_average);
				        	$(".itemDescription").html(v[0].overview);
				        });
			        }
			        else {
			        	$(".itemThumbnail").css("background-image", "");
			        	$(".itemTitle").html("No results found");
			        	$(".itemRating").html("");
			        	$(".itemDescription").html("");
			        }
			    }
			});
		}

		function jsonStatus(fn1, fn2) {
			console.log(jsonGetStatus);
			if(jsonGetStatus == 1) {
				fn1();
				fn2();
				jsonGetStatus = 0;
			} else {
				setTimeout(function() {
					console.log("JSON Status: "+jsonGetStatus);
					jsonStatus(fn1, fn2);
				}, 100);
			}	
		}

		function existingTitles() {
			s = "";
			if(jsonResults.length > 0) {
				titleValid = 0;
				$.each(jsonResults, function(k, v) {
		            s += v.title+"<br>";
		        });
		        $.dynamicOutput("#existingTitles", "#content", s, 1);
		    } else {
		    	titleValid = 1;
		    	$.dynamicOutput("#existingTitles", "#content", 0, 0);	
		    }
		    
		}

		$.dynamicOutput = function(parentId, id, string, toggle) {
			if(toggle == 1) $(parentId).show().find(id).html(string);	
			else $(parentId).hide().find(id).html("");
		}

		

		//Upload finalizer
		$("#submitUpload").click(function() {

			title = $("#uploadTitle").val();

			if(submitStatus()) {
				var postData = {
					'authKey':        "movie",
					'title': 		  suggetCollection[0][0].title,
					'file': 		  file,
					'size': 		  size,
					'uploadedBy':     user,
					'titleId': 		  suggetCollection[0][0].id,
					'originalTitle':  suggetCollection[0][0].title,
					'overview':       suggetCollection[0][0].overview,
					'genre': 		  suggetCollection[0][0].genre_ids[0],
					'adult': 		  suggetCollection[0][0].adult,
					'releaseDate': 	  suggetCollection[0][0].release_date,
					'language': 	  suggetCollection[0][0].original_language,
					'voteAverage': 	  suggetCollection[0][0].vote_average,
					'voteCount': 	  suggetCollection[0][0].vote_count,
					'popularity': 	  suggetCollection[0][0].popularity,
					'mediaType': 	  "Movie",
					'posterPath': 	  suggetCollection[0][0].poster_path,
					'backdropPath':  suggetCollection[0][0].backdrop_path,
				};

				$.ajaxRequest("hollywood.php", "post", postData);
				//window.location.replace("upload.php");
			}
			else { 
				console.log("Empty title"); 
			}
		});

		$.clearFileInput = function(id) {
			$(id).val('');
		}

		$.discardUpload = function() {
			var postData = {
				'authKey': "discard",
				'user': user,
			};
			$.ajaxRequest("hollywood.php", "post", postData);
		}

		$("#discardUpload").click(function() {
			if(requests < 5) {
				$.clearFileInput('#mediaFile');
				$.clearFileInput('#subtitleFile');
				uploadStatus = false;
				$.reloadVideoPreview();
				$.toggleProgress(".fileProgress", false);
				$.discardUpload();
				requests++;
				console.log(requests);
				$("#discardUpload").hide();
			}
			$.antiSpam();
		});

		$.confirmExit = function() {
			//Status 0: Nothing uploaded
			//Status 1: File uploaded & activate event
			window.onbeforeunload = function (e) {
				if(uploadStatus) {
				    e = e || window.event;
				    // For IE and Firefox prior to version 4
				    if (e) { e.returnValue = 'Exit and discard your upload?';}
				    // For Safari
				    return 'Exit and discard your upload?';
				}
			    
			};
			$(window).on('unload', function(){
				$.discardUpload();
			});
		}
		$.confirmExit();

		/*
		console.log(uploadStatus);
		if(uploadStatus) {
			console.log(uploadStatus);
			$.confirmExit(); 
		}*/

	});
</script>
<body>


<div id="uploaderWrapper" class="row">
	<div class="col-md-6">
		<div class="well uploadTitleWrap">
			<input id="uploadTitle" type="text" class="uploadTitle" placeholder="Enter a title...">
		</div>

		<div class="well" id="existingTitles" hidden>
			<h1>Existing titles:</h1>
			<div id="content"></div>
		</div>

		<div class="well">	
			<form action="hollywood.php" method="post" name="fileForm" id="fileForm" enctype="multipart/form-data">
				<label for="mediaFile" class="uploadField" ></label>
				<p class="center">Select file to upload</p>
		        <input type="file" name="mediaFile" id="mediaFile" class="displayNone">

		        <input type="text" name="user" hidden value="<?php echo $currentUser ?>">        

			    <div class="fileProgress">
			        <div class="bar progress-bar-success"></div >
			        <div class="percent">0%</div >
			    </div> 

			    <a href="JavaScript:void(0)"  id="discardUpload" class="btn btn-danger">Discard</a>
		    </form>
		    
		    
	    </div>
	    <a href="JavaScript:void(0)"  id="submitUpload" class="btn btn-success">Submit upload!</a>
	    <div class="alert alert-success uploadAlert" hidden>
			<strong>Success!</strong> Your movie was successfully uploaded to MikFlix!
		</div>
	</div>
	<div class="col-md-6">
		<div class="well previewWrapper">
			<div class="itemWrapper">
				<div class="itemThumbnail"></div>
				<div class="itemTitle">Movie title..</div>
			</div>
			<div class="itemMeta">
				<div class="ratingIcon"><div class="itemRating">10</div></div>
				<div class="itemDescription">This is where the movie title goes.</div>
			</div>
		</div>

		<div class="well" id="videoPreview">
		</div>

		<div class="well">
			<form action="hollywood.php" method="post" name="subtitlesForm" id="subtitlesForm" enctype="multipart/form-data">
				<h1>Add subtitles</h1>
		        <input type="file" name="subtitleFile" id="subtitleFile">
		        <input type="text" name="user" hidden value="<?php echo $currentUser ?>">
		    </form>
		</div>

	</div>
</div>

   
</body>
<?php include 'footer.php' ?>
