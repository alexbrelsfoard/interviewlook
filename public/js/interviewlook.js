var IL = {
	lastVideoID : 0,
	
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
		$('#questions-list').fadeOut('fast');
		$('#new_look').fadeOut('fast');
		$('#right-half-title').text('Saved Intros');
		$('#intros-list').fadeIn('fast');
		$('.record_video').fadeIn('fast');
		$('#questions_tab_title').removeClass('active');
		$('#looks_tab_title').removeClass('active');
		$('#intros_tab_title').addClass('active');
		$('#question_input').hide('fast');
		$('#question').val('321~~intro~~123');
		setTimeout(function(){
		$('#transitionwindow').fadeOut('fast');
		}, 300);
		}, 300);
	},
	
	switchToQuestions : function() {
		$('#transitionwindow').fadeIn('fast');
		setTimeout(function(){
		$('#intros-list').fadeOut('fast');
		$('#new_look').fadeOut('fast');
		$('#right-half-title').text('Saved Questions');
		$('#questions-list').fadeIn('fast');
		$('.record_video').fadeIn('fast');
		$('#looks_tab_title').removeClass('active');
		$('#intros_tab_title').removeClass('active');
		$('#questions_tab_title').addClass('active');
		$('#question').val('');
		$('#question_input').show('fast');
		setTimeout(function(){
		$('#transitionwindow').fadeOut('fast');
		}, 300);
		}, 300);
	},
	
	switchToLooks : function() {
		$('#transitionwindow').fadeIn('fast');
		setTimeout(function(){
		$('#intros-list').fadeOut('fast');
		$('#questions-list').fadeIn('fast');
		$('#right-half-title').text('Saved LOOKs');
		$('#looks-list').fadeIn('fast');
		$('#questions_tab_title').removeClass('active');
		$('#intros_tab_title').removeClass('active');
		$('#looks_tab_title').addClass('active');
		$('#question_input').hide('fast');
		$('.record_video').hide('fast');
		$('#new_look').fadeIn('fast');
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
				$('#list_of_questions ul').empty();
				//loop through each video
				for(var i = 0; i < data.videos.length; i++) {
					//append to '#list_of_questions ul'
					$('#list_of_questions ul').append('<li><div class="screenshot" style="background-image:url(\'/videos/'+data.videos[i].video+'.jpg\');"><img src="/images/play-video-triangle.png" onclick="IL.playVideo('+data.videos[i].id+');"></div><p>'+data.videos[i].question+'</p></li>');
				}
				IL.lastVideoID = latest_video_id;
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
	}
};

function startVideoRecorder() {
	var pipe = document.createElement('script'); 
	pipe.type = 'text/javascript'; 
	pipe.async = true;
	pipe.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 's1.addpipe.com/1.3/pipe.js';
	var s = document.getElementsByTagName('script')[0]; 
	s.parentNode.insertBefore(pipe, s);
}

function onSaveOk(streamName, streamDuration, userId, cameraName, micName, recorderId, audioCodec, videoCodec, fileType, videoId) {
	$('#video-complete-message').fadeIn();
	$('#question').val('');
	removePipeRecorder();
	startVideoRecorder();
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