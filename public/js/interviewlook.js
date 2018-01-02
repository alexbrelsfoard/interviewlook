var IL = {
	lastVideoID : 0,
	jsready : 0,
	
	toggleMenu : function() {
		if ($('nav').is(':visible')) {
			$('nav').slideUp();
		}else {
			$('nav').slideDown();
		}
	},
	
	selectUserType : function() {
		var user_type = $('#user_type').val();
		if (user_type == 2) {
			$('#looker_details').slideDown();
		}else {
			$('#looker_details').slideUp();
			
		}
	},
	
	switchToIntros : function() {
		$('#transitionwindow').fadeIn('fast');
		setTimeout(function(){
		$('#questions-list').hide('fast');
		$('#list_of_looks').hide('fast');
		$('#new_look').hide('fast');
		$('#list_of_videos_for_look').hide('fast');
		$('#right-half-title').text('Saved Intros');
		$('#intros-list').fadeIn('fast');
		$('#video_recorder').fadeIn('fast');
		$('#list_of_videos').fadeIn('fast');
		$('#questions_tab_title').removeClass('active');
		$('#looks_tab_title').removeClass('active');
		$('#intros_tab_title').addClass('active');
		$('#question_input').hide('fast');
		$('#intro_header').show();
		$('#question').val('321~~intro~~123');
		IL.activateStartButton();
		setTimeout(function(){
		$('#transitionwindow').fadeOut('fast');
		}, 300);
		}, 300);
	},
	
	switchToQuestions : function() {
		$('#transitionwindow').fadeIn('fast');
		setTimeout(function(){
		$('#intros-list').hide('fast');
		$('#list_of_looks').hide('fast');
		$('#new_look').hide('fast');
		$('#list_of_videos_for_look').hide('fast');
		$('#intro_header').hide('fast');
		$('#hdfvr-content').hide('fast');
		$('#right-half-title').text('Saved Questions');
		$('#questions-list').fadeIn('fast');
		$('#video_recorder').fadeIn('fast');
		$('#list_of_videos').fadeIn('fast');
		$('#looks_tab_title').removeClass('active');
		$('#intros_tab_title').removeClass('active');
		$('#questions_tab_title').addClass('active');
		$('#question').val('');
		$('#question_input').show('fast');
		IL.activateStartButton();
		setTimeout(function(){
		$('#transitionwindow').fadeOut('fast');
		}, 300);
		}, 300);
	},
	
	switchToLooks : function() {
		$('#transitionwindow').fadeIn('fast');
		setTimeout(function(){
		$('#intros-list').hide('fast');
		$('#intro_header').hide('fast');
		$('#questions-list').hide('fast');
		$('#hdfvr-content').hide('fast');
		$('#right-half-title').text('Saved Questions');
		$('#looks-list').fadeIn('fast');
		$('#questions_tab_title').removeClass('active');
		$('#intros_tab_title').removeClass('active');
		$('#looks_tab_title').addClass('active');
		$('#question_input').hide('fast');
		$('#video_recorder').hide('fast');
		$('#list_of_videos').hide('fast');
		$('#list_of_looks').fadeIn('fast');
		$('#new_look').fadeIn('fast');
		$('#list_of_videos_for_look').fadeIn('fast');
		IL.activateStartButton();
		setTimeout(function(){
		$('#transitionwindow').fadeOut('fast');
		}, 300);
		}, 300);
	},
	
	checkForNewVideos : function() {
		// query the server to get a list of videos for this user
		$.get("/uservideos?li="+IL.lastVideoID, function(data){
			data = JSON.parse(data);
			// check to see if the last users_questions_id > IL.lastVideoID
			var latest_video_id = data.lastVideoID;
			// if so, rebuild the UL list of videos.
			if (latest_video_id > IL.lastVideoID) {
				// empty the list first.
				//$('#list_of_questions ul').empty();
				//loop through each video
				for(var i = 0; i < data.videos.length; i++) {
					//append to '#list_of_questions ul'
					$('#list_of_questions ul').prepend('<li><div class="screenshot" video-name="'+data.videos[i].video+'" style="background-image:url(\'/videos/'+data.videos[i].video+'.jpg\');"><img src="/images/play-video-triangle.png" onclick="IL.playVideo('+data.videos[i].id+');"></div><p>'+data.videos[i].question+'</p></li>');
					$('#list_of_questions_for_looks ul').prepend('<li class="draggable"><div video-name="'+data.videos[i].video+'" class="screenshot" style="background-image:url(\'/videos/'+data.videos[i].video+'.jpg\');"><img src="/images/play-video-triangle.png" onclick="IL.playVideo('+data.videos[i].id+');"></div><p>'+data.videos[i].question+'</p></li>');
				}
				IL.lastVideoID = latest_video_id;
				$( "li.draggable" ).draggable({ snap: "#new_look_collection, #questions-list-for-looks", helper: "clone" });
			}
		});
	},
	
	playVideo : function(id) {
		$.get("/getvideo?i="+id, function(video_name){
			if (video_name) {
				
				// update video source
				$('#video_dialog video source').attr('src','/videos/'+video_name+'.mp4');
				$("#video_dialog video")[0].load();
				// create modal dialog
				$('#modal').fadeIn();
				
			}
		});
	},
	
	closeVideoModal : function() {
		$('#modal').fadeOut();
		$('#video_dialog video source').attr('src','');
	},
	
	activateStartButton : function() {
		if (IL.jsready) {
			if ($('#question').val().length > 4) {
				$('#start_button').removeAttr("disabled");
				$('#start_button').removeClass('disabled');
				$('#start_button_intro').removeAttr("disabled");
				$('#start_button_intro').removeClass('disabled');
			}else {
				$('#start_button').attr('disabled','disabled');
				$('#start_button').addClass('disabled');
				$('#start_button_intro').attr('disabled','disabled');
				$('#start_button_intro').addClass('disabled');
			}
		}
	},
	
	saveLook : function() {
		if ($('#name_of_look').val().length > 3) {
			var videos = [];
			if ($("#new_look_collection UL li").length) {
				$("#new_look_collection UL li").each(function(idx, li) {
					var video_div = $(li).children().first();
					var video_name = video_div.attr('video-name');
					videos[idx] = video_name;
				});
				var videos_json = JSON.stringify(videos);
				var title = $('#name_of_look').val();
				$.post("/savelook?t="+title+'&l='+videos_json, function(response){
					if (response == 'OK') {
						// move LI items to videos list.
						// move title to left menu
						$('#looks ul').append($('<li>'+title+'</li>'));
					}
				});
			}
		}else {
			alert("Please provide a name for this LOOK");
		}
	}
};

function startVideoRecorder() {
	//flashvars = {qualityurl: "avq/480p.xml",accountHash:"33efd27e442b0196af00a0633f6587e0", eid:1, showMenu:"true", mrt:300,sis:0,asv:0,mv:1, payload:$('#user_id').val()+":"+$('#question').val()};
	//alert("Setting payload to: "+$('#user_id').val()+":"+$('#question').val());
// 	console.log("Setting payload to: "+$('#user_id').val()+":"+$('#question').val());
	var pipe = document.createElement('script'); 
	pipe.type = 'text/javascript'; 
	pipe.async = true;
	pipe.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 's1.addpipe.com/1.3/pipe.js';
	var s = document.getElementsByTagName('script')[0]; 
	s.parentNode.insertBefore(pipe, s);
}

function showRecorder() {
	$('div.recorder img#loading').show();
	flashvars.payload = $('#user_id').val()+":"+$('#question').val();
	var newString;
	for (var k in flashvars) {
		if (typeof newString != "undefined") {
			if(k == "payload"){
				newString += "&" + k + "=" + encodeURIComponent(flashvars[k]);
			}else{
				newString += "&" + k + "=" + flashvars[k];
			}
		}
		else{
			if(k== "payload"){
				newString = k + "=" + encodeURIComponent(flashvars[k]);
			}else{
				newString = k + "=" + flashvars[k];	
			}
		}
	}
	$('param[name=flashvars]').val(newString);
	
	var el = $('object#VideoRecorder');
	el.clone().appendTo(el.closest("div"));
	el.remove();
	$('.recorder object').show();
}

function onSaveOk(streamName, streamDuration, userId, cameraName, micName, recorderId, audioCodec, videoCodec, fileType, videoId) {
	$('#video-complete-message').fadeIn();
	$('#question').val('');
	removePipeRecorder();
	startVideoRecorder();
	$('.recorder object').hide();
}

function onRecorderInit(recorderId) {
	$('div.recorder img#loading').hide();
}
/*
function onUploadDone(streamName, streamDuration, userId, recorderId, audioCodec, videoCodec, fileType){
	$('#video-complete-message').fadeIn();
	$('#question').val('');
	removePipeRecorder();
	startVideoRecorder();
}
function onVideoUploadSuccess(filename,filetype,videoId){
	$('#video-complete-message').fadeIn();
	$('#question').val('');
	removePipeRecorder();
	startVideoRecorder();
}
*/
function onVideoUploadFailed(error){
	var args = Array.prototype.slice.call(arguments);
	alert("Failed to save video ("+args.join(', ')+")");
}