@extends('layouts.main')

@section('title')
LOOKs
@stop
@section('page_title')
LOOKs&trade;
@stop

@section('head_code')
<script type="text/javascript">
var flashvars = {
		qualityurl: "avq/480p.xml",
		accountHash: "e1cacb83a1abc9814164437ad383ccbc",
		eid: 1,
		showMenu: "true",
		mrt: 300,
		sis: 0,
		asv: 0,
		mv: 1,
		payload: $('.bal_video_section').length ? $('#user_id').val() + ":" + $('#question').val() : ''
	};

	var collection = $('#new_look_collection');
	function addItemToCollection( $item ) {
		$item.fadeOut(function() {
			var list;
			if ($( "#new_look_collection ul" ).length) {
				list = $( "#new_look_collection ul");
			}else {
				list = $( '<ul class="sortable"/>' ).appendTo( $('#new_look_collection') );
				list.sortable();
			}

			$item.appendTo( list ).fadeIn();
		});
	}
	function returnItemToQueue( $item ) {
		$item.fadeOut(function() {
			var list;
			if ($( "#list_of_questions_for_looks ul" ).length) {
				list = $( "#list_of_questions_for_looks ul");
			}else {
				list = $( '<ul class="sortable"/>' ).appendTo( $('#list_of_questions_for_looks') );
				list.sortable();
			}

			$item.appendTo( list ).fadeIn();
		});
	}

	$( function() {
		var knownQuestions = {!! $knownQuestions !!};
		$('#question').autocomplete({
			source: knownQuestions,
			appendTo: "#question_input",
			open: function () {
				$(this).data("uiAutocomplete").menu.element.addClass("question_lookup_suggestion");
			},
			select: IL.activateStartButton()
		});
//<<<<<<< HEAD:resources/views/look/looks.blade.php

//=======
		
//>>>>>>> master:app/views/looks.blade.php
		// get the list of videos.
		IL.checkForNewVideos();
		// Check for new videos every 2 seconds.
		setInterval(function(){
			IL.checkForNewVideos();
		}, 5000);
		$('#new_look_collection').droppable({ accept: "li", tolerance: 'pointer', drop: function( event, ui ) { addItemToCollection(ui.draggable); } });
		$('#questions-list-for-looks').droppable({ accept: "li", tolerance: 'pointer', drop: function( event, ui ) { returnItemToQueue(ui.draggable); } });
	});
	$(document).ready(function() {
		IL.jsready = 1;
		IL.activateStartButton();
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
							<div class="col-md-2 hidden" id="list_of_looks">
								<h3>LOOKs&trade;</h3>
								<div id="looks">
									<ul>

									</ul>
									<img id="new_icon" src="/images/add-icon.png" />
								</div>
							</div>
							<div class="col-md-5 hidden" id="new_look">
								<div style="padding: 0px 0px 5px 0px;">Title: <input type="text" size="30" id="name_of_look"/> &nbsp; <button class="btn btn-primary" style="padding: 3px 20px;" onclick="IL.saveLook();">Save</button></div>
								<div id="new_look_collection" class="questions-list">

								</div>
							</div>
							<div class="col-md-5 hidden" id="list_of_videos_for_look">
								<h3>Available Videos</h3>
								<div id="questions-list-for-looks">
									<div id="list_of_questions_for_looks" class="questions-list">
										<ul class="sortable">

										</ul>
									</div>
								</div>
							</div>

							<div class="col-md-12 record_video bal_video_section" id="video_recorder">
								<input type="hidden" id="user_id" value="{{ auth()->id() }}"/>

							<div class="col-md-6 record_video" id="video_recorder">
								<input type="hidden" id="user_id" value="{{ $user->id }}"/>

								<div id="question_input">
									<h3>Record New Question</h3>
									<b>Question:</b> <input type="text" id="question" size="40" onkeyup="IL.activateStartButton();" />
									<button id="start_button" class="btn btn-primary" onclick="showRecorder();" disabled="disabled">Start</button>
								</div>
								<div id="intro_header" class="center hidden">
									<h3>Record New Intro</h3>
									<button id="start_button_intro" class="btn btn-primary center" onclick="showRecorder();" disabled="disabled">Start Recording New intro</button>
								</div>
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
									<!-- begin video recorder code -->
									<script type="text/javascript">
                                        var size = {width:440,height:400};
                                        var flashvars = {qualityurl: "avq/300p.xml",accountHash:"d1925da7e53d91eb3159d785f4dbad0a", eid:1, showMenu:"true", mrt:120,sis:0,asv:1,mv:0, dpv:0, ao:0, dup:1};
                                        (function() {var pipe = document.createElement('script'); pipe.type = 'text/javascript'; pipe.async = true;pipe.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 's1.addpipe.com/1.3/pipe.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(pipe, s);})();
									</script>
									<div id="hdfvr-content" ></div>
									<!-- end video recorder code -->
								</div>
							</div>
							<div class="col-md-6" id="list_of_videos" style="height: 96%;">
								<h3 id="right-half-title">Saved Questions</h3>

								<div id="questions-list">
									<div id="list_of_questions" class="questions-list">
										<ul>
											@foreach($video_list['videos'] as $videos)
												<li class="video-list">
													<div class="snapshot-image col-md-3">
														<img src="https://{{$videos['snapshotURL']}}" />
													</div>
													<div class="snapshot-name col-md-9">
														<p>{{$videos['name']}}</p>
													</div>
												</li>
											@endforeach
										</ul>
									</div>
								</div>


											
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
