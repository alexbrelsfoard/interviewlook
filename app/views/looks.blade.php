@extends('layouts.main')

@section('title')
LOOKs
@stop
@section('page_title')
LOOKs&reg;
@stop

@section('head_code')
	<script type="text/javascript">
		// on page load:
		//  - populate the list of quetions and intros
		//  - save the last id of each questions and intros
		//  - start the repeatedly polling the server for new videos (anything new after saved last id?
		//      - should probably make sure that the API call returns the last id easily enough.
	</script>
<script type="text/javascript">
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
		}, 2000);
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

<section id="content">
	<div class="container">
		
		<div id="exTab1" class="">
			<ul class="nav nav-pills">
				<li id="intros_tab_title" class="" onclick="IL.switchToIntros();">
					My Intro LOOKs&reg;
				</li>
				<li id="questions_tab_title" class="active" onclick="IL.switchToQuestions();">
					My Questions
				</li>
				<li id="looks_tab_title" onclick="IL.switchToLooks();">
					Complete LOOK&reg;
				</li>
			</ul>
			<div class="tab-content clearfix">
				<div class="tab-pane active">
					<div class="row">
						<div class="col-md-12 record_video_main" style="overflow-y:hidden;">
							<div id="transitionwindow">&nbsp;</div>
							<div class="col-md-6 hidden" id="new_look">
								<h3>Compile New LOOK&reg;</h3>
							</div>
							<div class="col-md-6 record_video">
								<h3>Record New Question</h3>
								<div id="question_input"><b>Question:</b> <input type="text" id="question" size="40" /></div>
								<!-- begin video recorder code -->
								<script type="text/javascript">
								var size = {width:400,height:330};
								var flashvars = {qualityurl: "avq/480p.xml",accountHash:"33efd27e442b0196af00a0633f6587e0", eid:1, showMenu:"true", mrt:300,sis:0,asv:0,mv:1, payload:"{{ $user->id }}:"+$('#question').value};
								(
								function() {
									startVideoRecorder();
								})();
								
								</script>
								<div id="video-complete-message">
								  <p><span class="ui-icon ui-icon-info" style="float:left; margin:12px 12px 20px 0;"></span>You're video is now being saved.</p>
								  <p>Very shortly it will show up to the left of this recorder.</p>
								  <p>Once there you can edit the question, attach it to a LOOK&reg;, or delete the whole thing.</p>
								  <p>Meanwhile, fee free to answer this question again or start a new one.</p>
								  <button onclick="$('#video-complete-message').fadeOut();">OK</button>
								  <div class="clear"></div>
								</div>
								<div id="hdfvr-content" class="recorder"></div>
								<!-- end video recorder code -->
							</div>
							<div class="col-md-6" style="height: 96%;">
									<h3 id="right-half-title">Saved Questions</h3>
								<div id="questions-list">
<!-- 								Need to have some JS constantly checking for new videos for this section. -->
									<div id="list_of_questions">
										<ul>
											<li><div class="screenshot" style="background-image:url('http://brelsfoard.com/~interviewlook/videos/vs1506901506556_810.jpg');"><img src="/images/play-video-triangle.png"></div><p>Who Are You?</p></li>
											<li><div class="screenshot" style="background-image:url('http://brelsfoard.com/~interviewlook/videos/vs1506907196484_307.jpg');"><img src="/images/play-video-triangle.png"></div><p>Tell us a bit about yourself</p></li>
											<li><div class="screenshot" style="background-image:url('http://brelsfoard.com/~interviewlook/videos/vs1506903419655_587.jpg');"><img src="/images/play-video-triangle.png"></div><p>What is your favorite programming language, and why?</p></li>
											<li><div class="screenshot" style="background-image:url('http://brelsfoard.com/~interviewlook/videos/vs1506903378953_888.jpg');"><img src="/images/play-video-triangle.png"></div><p>Who Are You?</p></li>
											<li><div class="screenshot" style="background-image:url('http://brelsfoard.com/~interviewlook/videos/vs1506902909770_216.jpg');"><img src="/images/play-video-triangle.png"></div><p>Who Are You?</p></li>
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