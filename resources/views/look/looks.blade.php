@extends('layouts.main')

@section('title')
LOOKs
@stop
@section('page_title')
LOOKs&trade;
@stop

@section('head_code')

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

							<div class="col-md-12 record_video bal_video_section">
								<input type="hidden" id="user_id" value="{{ auth()->id() }}"/>

							<div class="col-md-6 record_video" id="video_recorder">
								<input type="hidden" id="user_id" value="{{ $user->id }}"/>
								<input type="hidden" id="video_id" value="{{ $video_id }}"/>

								<div id="question_input">
									<h3>Record New Question</h3>
									<p id="no-question" class="warning" style="display:none;">Please Enter a Question</p>
									<b>Question: </b> <input type="text" id="question" size="40"  value=""/>
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

								<div id="hdfvr-content" class="recorder">
									<!-- begin video recorder code -->
									@include('look._record')

									<!-- end video recorder code -->
								</div>
							</div>
								<div id="compile" class="col-md-6 record_video" style="display:none">
									<h3>Compile New LOOK&trade;</h3>
									<div id="compile-list-for-looks">
										<div id="compile_questions_for_looks" class="questions-list">
											<ul class="sortable">

											</ul>
										</div>
									</div>
								</div>
							<div class="col-md-6" id="list_of_videos" style="height: 96%;">
								<h3 id="right-half-title">Saved Questions</h3>
									<div id="questions-list">
										<div id="list_of_questions" class="questions-list">
											<ul>
												@foreach($video_list as $videos)
													<li class="video-list">
														<div class="snapshot-image col-md-3">
															<img src="https://{{$videos->img_url}}" />
														</div>
														<div class="snapshot-name col-md-9">
															<p>{{$videos->title}}</p>
														</div>
													</li>
												@endforeach
											</ul>
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

@stop
