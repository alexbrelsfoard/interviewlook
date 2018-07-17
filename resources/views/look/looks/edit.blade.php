@extends('layouts.main')

@section('title') Edit Look @stop
@section('page_title') EDIT LOOK&trade; @stop

@section('head_code')
	<style>
		.ui-autocomplete {
			margin: 80px 0px 0px 77px;
		}
		.ui-autocomplete LI {
			border-bottom: 1px dashed #DDD;
		}
		#question_input h3,
		#right-half-title {
			font-size: 22px !important; 
			margin-bottom: 20px;
			margin-top: 6px;
		}
	</style>
@stop

@section('body')
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Edit Look</h4>
	      </div>
	      <div class="modal-body">
		    <label style="font-weight: bold; margin-bottom: 10px; display: block;">Look Title</label>
	      	<input class="form-control" placeholder="Look Title" id="interviewTitle" value="{{ $interview->title }}">
	      </div>
	      <div class="modal-footer">
	      	<button id="deleteLook" class="btn btn-danger">Delete Look</button>
	        <button id="editTitle" class="btn btn-green">Submit</button>
	      </div>
	    </div>
	  </div>
	</div>

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
			<div id="exTab1" style="margin-bottom: 10px;">
				<a href="{{ route('look.show', $interview->id) }}" class="btn btn-green pull-right" style="margin-left: 10px">Show</a>
				<button class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">Edit Look</button>
				<ul class="nav nav-pills">
					<li id="intros_tab_title" class="" >
						My Intro LOOKs&trade;
					</li>
					<li id="questions_tab_title" class="active">
						My Questions
					</li>
					<li id="looks_tab_title">
						Complete LOOK&trade;
					</li>
				</ul>
			</div>

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
								<div style="padding: 0px 0px 5px 0px;">Title:
									<input type="text" size="30" id="name_of_look"/> &nbsp;
									<button class="btn btn-primary" style="padding: 3px 20px;" onclick="IL.saveLook();">Save</button></div>

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
								<div class="col-md-12">
									<h3 style="text-align: center;" id="looktitle">{{ $interview->title }}</h3>
								</div>
								<div class="col-md-12 record_video bal_video_section">
									<input type="hidden" id="user_id" value="{{ auth()->id() }}"/>

									<div class="col-md-6 record_video" id="video_recorder">
										<input type="hidden" id="user_id" value="{{ $user->id }}"/>
										<input type="hidden" id="video_id" value="{{ $video_id }}"/>
										<input type="hidden" id="interview_id" value="{{ $interview->id }}"/>

										<div id="question_input">
											<h3>Record New Question</h3>
											<p id="no-question" class="warning" style="display:none;">Please Enter a Question</p>
											<b>Question: </b> 
											<input type="text" id="question" size="40"  value="" placeholder="Type your question here" />
											<button id="start_recording" class="btn btn-primary" style="vertical-align: top;height: 43px;">Start</button>
											<meta name="csrf-token" content="{{ csrf_token() }}" />
										</div>

										<div id="intro_input" style="display:none;">
											<h3>Record New Intro</h3>
											<p id="no-intro" class="warning" style="display:none;">Please Enter Intro Title</p>
											<b>Intoro Title: </b> <input type="text" id="intro-title" size="40"  value=""/>
											<button id="start_intro" class="btn btn-primary" >Start</button>
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

										<div id="hdfvr-content" class="">
											<!-- begin video recorder code -->
											@include('look._record')

											<!-- end video recorder code -->
										</div>
									</div>

									<div class="col-md-6" id="list_of_videos" style="height: 96%;">
										<div id="questions-list">
											<div id="list_of_questions" class="questions-list">
												<div class="list-view" id="app">
													<look-draggable :tasks-completed="{{ $videosCompiled }}" :tasks-not-completed="{{ $videosSaved }}"></look-draggable>
												</div> <!-- end app -->
											</div>
										</div>
									</div>

									<div id="list_of_intros" class="hidden col-md-6" style="height: 96%;">
										<h3 id="right-half-title">Saved Intros</h3>
										<div id="intros-list">
											<div id="list_of_intros" class="questions-list">
												<ul>
													<li class="video-list">
														<div class="snapshot-image col-md-3">

														</div>
														<div class="snapshot-name col-md-9">

														</div>
													</li>
												</ul>
											</div>
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
	<script src="{{ asset('js/app.js') }}"></script>
	<script type="text/javascript">
		$('#editTitle').on('click', function(){
	        $.ajax({
	            url: '/looks/edit-interview',
	            type: 'POST',
	            data: {
	                _token: $('meta[name="csrf-token"]').attr('content'),
	                id: $("#interview_id").val(),
	                title: $("#interviewTitle").val()
	            },
	            dataType: 'JSON'
	        });
			$('#myModal').modal('hide')
			$('#looktitle').text( $("#interviewTitle").val() );
		})
		$('#deleteLook').on('click', function(){
            var confirmation = confirm("Are you sure you want to remove this Look and its videos?");
            if (confirmation) {
		        $.ajax({
		            url: '/look/delete',
		            type: 'PUT',
		            data: {
		                _token: $('meta[name="csrf-token"]').attr('content'),
		                id: $("#interview_id").val()
		            },
		            dataType: 'JSON',
		        });
				window.location = '/looks';
            }
		})

	</script>
@stop
