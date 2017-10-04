var IL = {
	
	toggleMenu : function() {
		if ($('nav').is(':visible')) {
			$('nav').slideUp();
		}else {
			$('nav').slideDown();
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