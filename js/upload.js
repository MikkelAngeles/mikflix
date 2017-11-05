$(document).ready(function(){
	//Global variables
	var uploadStatus     = false;

	var title 			 = "";
	var titleStatus      = 0;

	var file;
	var fileStatus       = 0;

	var subtitleStatus   = 0;

	var subFile;
	var fileCollection   = [];
	var size;
	var published        = 0;
	var subSize;
	var status 			 = $('#status');
	var user 			 = sessionStorage.getItem('user');

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
	//$("#videoPreview").hide();
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

	
	function submitStatus() {
		if(fileStatus + titleStatus + subtitleStatus > 3) {
			uploadStatus = true;
			$.elementCursor("#submitUpload", "default");
			console.log(fileStatus+titleStatus+subtitleStatus);
			return true;
		}
		else { 	
			uploadStatus = false;
			$.elementCursor("#submitUpload", "not-allowed");
			console.log(fileStatus+titleStatus+subtitleStatus);
			return false;
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
			fileStatus = 1;
			submitStatus();
			if(!$("#uploadTitle").val() > 0) suggestImdb(fileName);
			$("#fileName").html(file);
			$("#selectedFile #fileSize").html(parseFloat((size/1000000)).toFixed(2) + " MB");
			$("#selectedFile").show();
			$("#labelWrapper").hide();
			$.autoUpload("#fileForm", ".fileProgress");
			sessionStorage.setItem('tmpFolderStatus', 1);
			console.log(sessionStorage.getItem('tmpFolderStatus'));
		} else {
			$.toggleProgress('.progress', false);
			fileStatus = 0;
			submitStatus();
		}
	});

	function buildUploadItemRow(type, id, label) {
	    this.type 		= type;
	    this.id 		= id;
	    this.label   	= label;

		s  =  '<div class="uploadItemRow mRow" data-upload-type="'+type+'" data-type-id="'+id+'">';
		s +=  	'<h2 id="title">'+label+'</h2>';
		s +=  	'<input type="file" data-label="'+label+'" name="'+type+'_input_'+id+'" id="'+type+'_input_'+id+'" data-type-id="'+id+'" class="displayNoneUltra '+type+'">';
		s +=  	'<label for="'+type+'_input_'+id+'" class="uploadIcon" ><i class="fa fa-plus-circle" aria-hidden="true"></i></label>';
		s +=  	'<div class="previewSubtitle" data-label="'+label+'" title="Preview" alt="Preview"><p id="selected"></p><i class="fa fa-file-text" aria-hidden="true"></i></div>';
		s +=  '</div>';

		return s;
	}

	//Functions to run the content
	function buildSubtitleList(data) {
		var parent = $("#subtitlesForm");
		$.each(data,function(k,v) {
			parent.append(buildUploadItemRow(v.kind, v.id, v.label));
			fileCollection.push({'id': v.id, 'label': v.label, 'file': '' ,'status': 0});
		});
		console.log(fileCollection);
	}

	//Ajax runs last
	var subsData = {'authKey': "getSubtitleLabels" };
	var subtitlesAvailable = fetchData(subsData);
	$.when(subtitlesAvailable).then(function(data){
		buildSubtitleList(data);
	});

	function toggleSubtitleStatus(element) {
		element.closest('.uploadItemRow').find('.uploadIcon').html('<i class="fa fa-check-circle" aria-hidden="true"></i>');
		console.log(element.closest('.uploadItemRow').find('.uploadIcon'));
	}

	function getFileExtension(s) {
		var length    = s.length;
		var index     = s.lastIndexOf(".");
		var extension = s.substring(index+1, length);
		return extension;
	}

	//Automatically upload subs to tmp
	$("#uploadWrapper").on('change', '.subtitles', function() {
		var selected = $(this);
		var label 	 = selected.attr('data-label');
		var id 	 	 = selected.attr('data-type-id');
		var formData = new FormData();
		var file     = selected[0].files[0];
		var fileName = file.name;

		var legalType = "vtt"; //Hardcoded until more subtitles are supported.
		formData.append('subtitle', selected[0].files[0], label+'.vtt'); //Hardcoded until more subtitles are supported.
		formData.append('label', label);
		formData.append('authKey', 'postSubtitle');

		console.log(getFileExtension(fileName));

		if(file && legalType == getFileExtension(fileName)) {
			var postSubtitle = $.ajax({
				type: 'POST',
				url: 'hollywood.php',
				processData: false, 
				contentType: false, 
				dataType : 'json',
				data: formData,
				complete: function(xhr) {
					subtitleStatus ++;
					submitStatus();
					var objIndex = fileCollection.findIndex((obj => obj.id == id));
					fileCollection[objIndex].status = 1;
					fileCollection[objIndex].file = label+'.vtt';
					sessionStorage.setItem('tmpFolderStatus', 1);
					$.reloadVideoPreview();
					toggleSubtitleStatus(selected);	
				}
		     });
		}
	});

	$("#uploadWrapper").on('click', '.previewSubtitle', function() {
		console.log($(this).attr("data-label"));
		var target = $(this).attr("data-label");
        window.open("storage/movies/tmp/admin/subs/"+target+".vtt", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,width=400,height=400");
	});

	
	//Reload preview & subs
	$.reloadVideoPreview = function() {
		var source = '<video width="100%" height="100%" controls id="previewPlayer">'; 
		if(uploadStatus) {
			//fileCollection = [{name: 'English', file: 'uploadedBy_admin_bbt.vtt'}];
			//console.log(fileCollection[0].name);
			source    += '<source src="storage/movies/tmp/'+user+'/'+file+'" type="video/mp4" id="sourcePreview">';
			for(i = 0; i < fileCollection.length; i++) {
				if(fileCollection[i].status > 0) source += '<track label="'+fileCollection[i].label+'" kind="subtitles" srclang="en" src="storage/movies/tmp/'+user+"/subs/"+fileCollection[i].file+'">';
			}
			source += '</source>';
			source += '</video>';
			console.log(source);
			$("#videoPreview").html(source);
		} 
		else {
			source += '</video>';
			$("#videoPreview").html(source);
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
			titleStatus = 1;
			submitStatus();
			suggestImdb(query);

			qData = {
				'authKey': "getExistingTitle",
				'query': query,
			};
			/*
			if(inputCount > 0) clearTimeout(executeQuery);

			executeQuery = setTimeout(function() {
				$.ajaxRequest("hollywood.php", "get", qData);
				jsonStatus(existingTitles, submitStatus);
				inputCount = 0;
			}, 500);
			
			inputCount++;*/
		} else {
			titleStatus = 0;
			submitStatus();
			clearTimeout(executeQuery);
			$.dynamicOutput("#existingTitles", "#content", 0, 0);
			$("#poster").css("background-image", "");
        	$("#title").html("No results found");
        	$("#titleId").html("");
        	$("#overview").html("");
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
			        	$("#poster").css("background-image", "url(http://image.tmdb.org/t/p/w185/"+v[0].poster_path+")");
			        	$("#title").html(v[0].title);
			        	$("#titleId").html(v[0].id);
			        	$("#overview").html(v[0].overview);
			        	$("video").attr("poster", "http://image.tmdb.org/t/p/w185/"+v[0].backdrop_path);
			        });
		        }
		        else {
		        	$("#poster").css("background-image", "");
		        	$("#title").html("No results found");
		        	$("#titleId").html("");
		        	$("#overview").html("");
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

	
	$('[data-toggle="popover"]').popover(); 

	function appendError(element, title, msg) {
		var body  = '<div class="appendError alert alert-danger">';
		body 		+= '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
		body    	+= '<strong>'+title+'!</strong>  '+msg;
		body 	 += '</div>'
		var target = element;
		element.after(body);
	}
	//Upload finalizer
	$("#submitUpload").click(function() {

		title = $("#uploadTitle").val();
		published = $("#published").prop("checked");
		if(published) published = 1;
		else published = 0;

		if(submitStatus()) {
			var postData = {
				'authKey':        "submitMovie",
				'mediaType': 	  "Movie",
				'file': 		  file,
				'size': 		  size,
				'uploadedBy':     user,
				'published': 	  published,
				'title': 		  suggetCollection[0][0].title,
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
				'posterPath': 	  suggetCollection[0][0].poster_path,
				'backdropPath':   suggetCollection[0][0].backdrop_path,
			};
			console.log(postData);
			$.ajaxRequest("hollywood.php", "post", postData);
			//window.location.replace("upload.php");
		}
		else { 
			if(!titleStatus) {
				appendError($("#previewMode").find(".mHeader"), "Error", "You must select a title!");
			}
			if(!fileStatus) {
				//console.log($("#fileTitle"));
				appendError($("#files").find(".mHeader"), "Error", "You must upload a file first!");
			}
			if(!subtitleStatus) {
				//console.log($("#subtitleTitle"));
				appendError($("#subtitles").find(".mHeader"), "Error", "You must upload both subtitles!");
			}
		}
	});

	$("#cancelUpload").click(function() {
		window.location.replace("cinema.php");
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

	$.discardTmpFile = function(mediaType) {
		var postData = {
			'authKey': "discardTmpFile",
			'mediaType': mediaType,
			'user': user,
		};
		$.ajaxRequest("hollywood.php", "post", postData);
	}

	/*$("#discard").click(function() {
		$("#selectedFile").hide();
		$("#labelWrapper").show();
		$.clearFileInput('#mediaFile');
	});*/

	$("#discard").click(function() {
		if(requests < 5) {
			$.discardTmpFile('movie');
			$.clearFileInput('#mediaFile');
			$("#selectedFile").hide();
			$("#labelWrapper").show();
			uploadStatus = false;
			$.reloadVideoPreview();
			$.toggleProgress(".fileProgress", false);
			requests++;
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
	}
	$.confirmExit();

	/*
	console.log(uploadStatus);
	if(uploadStatus) {
		console.log(uploadStatus);
		$.confirmExit(); 
	}*/

	$(window).on("unload", function(e) {
	    /*if(sessionStorage.getItem('tmpFolderStatus') == 1) {
			var clearSet = {
				'authKey': 'clearTmp'
			}
			var clearTmpFolder = $.ajax({
				type: 'POST',
				url: 'hollywood.php',
				dataType : 'json',
				data: clearSet,
				complete: function(xhr) {
					console.log("tmp folder should be clear now");
					sessionStorage.setItem('tmpFolderStatus', 0);
				}
		    });
		}*/
		alert("LOL");
	});

	window.onbeforeunload = function(e) {
		if(fileStatus+subtitleStatus > 0) {
			var dialogText = 'All data will be lost';
			e.returnValue = dialogText;
			return dialogText;
		}
	}
	
	var getUser = fetchData({'authKey': "getUser" });
	$.when(getUser).then(function(data){
		sessionStorage.setItem('user', data);
	});
});
