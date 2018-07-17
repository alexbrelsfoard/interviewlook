@extends('layouts.main')

@section('title') Show Look @stop
@section('page_title') SHOW LOOK&trade; @stop

@section('body')
	<section id="content">
		<div class="container" style="margin-bottom: 50px;">
			<div class="row">
				<div class="col-md-12 ">
					<ol class="breadcrumb">
						<li class="">
							<a href="{{ route('look.index') }}">Looks</a>
					  	</li>
					 	<li class="active">
					 		{{ \App\Models\Interview::interviewTitle($id) }}
					 	</li>
					</ol>			
				</div>
			</div>
			@if(count($videosSaved) > 0)
		      <div class="video-player">
		         <div class="vidwrapper">
		            <video id="myvid" >
		               Your browser does not support the video tag.
		            </video>
		            <div class="topControl">
		               <div class="progress">
		                  <span class="bufferBar"></span>
		                  <span class="timeBar"></span>
		               </div>
		               <div class="time">
		                  <span class="current"></span> / 
		                  <span class="duration"></span> 
		               </div>
		            </div>
		            <div class="controllers">
		               <button class="btnPlay" title="Play/Pause video"></button>
		               <button class="prevvid disabled" title="Previous video"><i class="fa fa-step-forward fa-rotate-180"></i></button>
		               <button class="nextvid" title="Next video"><i class="fa fa-step-forward"></i></button>
		               <button class="sound sound2 btn" title="Mute/Unmute sound"></button>
		               <div class="volume" title="Set volume">
		                  <span class="volumeBar"></span>
		               </div>
		               <button class="btnFS " style="float:right" title="full screen"></button>
		               <button class="btnspeed " style="float:right" title="Video speed"><i class="fa fa-gear"></i></button>
		               <ul class="speedcnt">
		                  <li class="spdx50">1.5</li>
		                  <li class="spdx25">1.25</li>
		                  <li class="spdx1 selected">Normal</li>
		                  <li class="spdx050">0.5</li>
		               </ul>
		            </div>
		            <div class="bigplay" title="play the video"><i class="fa fa-play-circle-o"></i></div>
		            <div class="loading"><i class="fa fa-spinner fa-spin"></i></div>
		         </div>
		         <div class="videolist">
		            <div class="vids">
						@foreach($videosSaved as $video)
			               <a class="video-link" href="/uploads/videos/{{$video->video_id}}.webm">{{$video->title}}</a>
				    	@endforeach 
		            </div>
		         </div>
		      </div>
			@else
				<div class="row">
					<div class="col-md-12">
					<div class="well">
						<p style="margin-bottom: 20px">
							There is no Videos in this Look!
						</p>
						<p style="margin: 0;">
							You can still add videos from <a href="{{ route('look.edit', $id) }}">edit page</a>.
						</p>
					</div>
					</div>
				</div>
			@endif
		</div>
	</section>
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/video-player.js') }}"></script>
@stop
