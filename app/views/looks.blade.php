@extends('layouts.main')

@section('title')
LOOKs
@stop
@section('page_title')
LOOKs&trade;
@stop

@section('head_code')
<script type="text/javascript">
	var jsready = 0;
	function activateStartButton() {
		if (jsready) {
			if ($('#question').val().length > 4) {
				$('#start_button').removeAttr("disabled");
				$('#start_button').removeClass('disabled');
			}else {
				$('#start_button').attr('disabled','disabled');
				$('#start_button').addClass('disabled');
			}
		}
	}
	// Set vars for Pipe Video Recorder.
	var flashvars = {qualityurl: "avq/480p.xml",accountHash:"33efd27e442b0196af00a0633f6587e0", eid:1, showMenu:"true", mrt:300,sis:0,asv:0,mv:1, payload:$('#user_id').val()+":"+$('#question').val()};
	var size = {width:400,height:330};
	
	$( function() {
		var knownQuestions = <?php echo Question::getDistinctQuestions(); ?>;
		$('#question').autocomplete({ 
			source: knownQuestions, 
			appendTo: "#question_input",
			open: function () {
		        $(this).data("uiAutocomplete").menu.element.addClass("question_lookup_suggestion");
		    } 
		});
		// get the list of videos.
		IL.checkForNewVideos();
		// Check for new videos every 2 seconds.
		setInterval(function(){
			IL.checkForNewVideos();
		}, 5000);
	});
	$(document).ready(function() {
		jsready = 1;
		activateStartButton();
	});
</script>
<style>
	.ui-autocomplete {
		margin: 80px 0px 0px 77px;
	}
	.ui-autocomplete LI {
		border-bottom: 1px dashed #DDD;
	}
</style>
@stop

@section('body')
<div id="modal" class="modal">

	<!-- Modal content -->
	<div id="video_dialog">
		<img class="modal_close" src="/images/close.png" onclick="IL.closeVideoModal()"/>
		<video width="640" height="480" controls>
			<source src="" type="video/mp4">
			Your browser does not support the video tag.
		</video>
	</div>
</div>


<section id="content">
	<div class="container">
		
		<div id="exTab1" class="">
			<ul class="nav nav-pills">
				<li id="intros_tab_title" class="" onclick="IL.switchToIntros();">
					My Intro LOOKs&trade;
				</li>
				<li id="questions_tab_title" class="active" onclick="IL.switchToQuestions();">
					My Questions
				</li>
				<li id="looks_tab_title" onclick="IL.switchToLooks();">
					Complete LOOK&trade;
				</li>
			</ul>
			<div class="tab-content clearfix">
				<div class="tab-pane active">
					<div class="row">
						<div class="col-md-12 record_video_main" style="overflow-y:hidden;">
							<div id="transitionwindow">&nbsp;</div>
							<div class="col-md-6 hidden" id="new_look">
								<h3>Compile New LOOK&trade;</h3>
							</div>
							<div class="col-md-6 record_video">
								<input type="hidden" id="user_id" value="{{ $user->id }}"/>
								<h3>Record New Question</h3>
								<div id="question_input"><b>Question:</b> <input type="text" id="question" size="40" onkeyup="activateStartButton();" /><button id="start_button" class="btn btn-primary" onclick="showRecorder();" disabled="disabled">Start</button></div>
								<!-- store video recorder code -->
								<div id="video-complete-message">
								  <p><span class="ui-icon ui-icon-info" style="float:left; margin:12px 12px 20px 0;"></span>You're video is now being saved.</p>
								  <p>Very shortly it will show up to the right of this recorder.</p>
								  <p>Once there you can edit the question, attach it to a LOOK&trade;, or delete the whole thing.</p>
								  <p>Meanwhile, fee free to answer this question again or start a new one.</p>
								  <button onclick="$('#video-complete-message').fadeOut();">OK</button>
								  <div class="clear"></div>
								</div>
								<script type="text/javascript">
								(function() {
									startVideoRecorder();
								})();
								</script>
								<div id="hdfvr-content" class="recorder">
									<img src="/images/loading_blue_blocks.gif" id="loading"/>
								</div>
								<!-- end video recorder code -->
							</div>
							<div class="col-md-6" style="height: 96%;">
									<h3 id="right-half-title">Saved Questions</h3>
								<div id="questions-list">
<!-- 								Need to have some JS constantly checking for new videos for this section. -->
									<div id="list_of_questions">
										<ul>
											
										</ul>
									</div>
								</div>
								<div id="intros-list" class="hidden">
									<p>Will need to institute a limit of ~3 saved intros, and only one active one.</p>
									<div id="list_of_intros">
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</section>
	
@stop