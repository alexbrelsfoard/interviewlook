@extends('layouts.main') @section('title', $user->name) @section('page_title', 'Profile') @section('body')

<section id="content" class="profile">
	<div class="container">
		<div class="col-md-12">
			<div class="flash-message">
				@foreach (['danger', 'warning', 'success', 'info'] as $msg) @if(Session::has('alert-' . $msg))
				<p class="alert alert-{{ $msg }}">
					{{ Session::get('alert-' . $msg) }}
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				</p>
				@endif @endforeach
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-md-12">
			<div class="profile-body">
				<div class="profile-bio">
					<div class="row">
						<div class="col-md-4">
							<center>
								<div class="blue-frame-10">
									<div class="white-frame-10">
										<div class="blue-frame-5">
											<img class="img-responsive md-margin-bottom-10" src="{{ isset($user->profile->photo) && $user->profile->photo ? $user->profile->photo : $user->photo }}" alt="">
										</div>
									</div>
								</div>
							</center>
							<br/> @if($user->social)
							<center>
								@if($user->social->facebook)
								<a class="btn btn-info btn-xs" href="{{ $user->social->facebook }}" target="_blank">
									<i class="fa fa-facebook"></i>
								</a>
								@endif @if($user->social->twitter)
								<a class="btn btn-info btn-xs" href="{{ $user->social->twitter }}" target="_blank">
									<i class="fa fa-twitter"></i>
								</a>
								@endif @if($user->social->instagram)
								<a class="btn btn-info btn-xs" href="{{ $user->social->instagram }}" target="_blank">
									<i class="fa fa-instagram"></i>
								</a>
								@endif
							</center>
							@endif
						</div>
						<div class="col-md-8">
							<div class="cbp_tmlabel">
								@php($url = route('profile.edit'))
								<div class=" padding-10">
									<h2 class="color-blue">
										<strong>{{ $user->name }}</strong>
										{!! auth()->check() && $user->id == auth()->user()->id ? '
										<a class="btn btn-success margin-left-10" href="'.$url.'">Edit Profile</a>':'' !!}
									</h2>
								</div>
								<div class="blue-frame-2 margin-top-bottom-15 padding-10">
									<h3 class="color-blue">
										Industry Summary: <span class="color-dark-blue">{!! isset($user->privacy->industry_summary) && $user->privacy->industry_summary ? $user->profile->industry_summary:'
										<i>Private</i>' !!}</span>
									</h3>
								</div>
								<div class="blue-frame-2 margin-top-bottom-15 padding-10">
									<h3 class="color-blue">
										<strong>Experience: <span class="color-dark-blue">{!! isset($user->privacy->years_experience) && $user->privacy->years_experience ? $user->profile->years_experience.'
											years':'
											<i>Private</i>' !!}</span></strong>
									</h3>
								</div>
								<div class="blue-frame-2 margin-top-bottom-15 padding-10">
									<h3 class="color-blue">
										<strong>Education: <span class="color-dark-blue">@if(isset($user->privacy->highest_degree) && $user->privacy->highest_degree) @if($user->profile->highest_degree
											== 'hsd') High School Diploma @elseif($user->profile->highest_degree == 'sc') Some College @elseif($user->profile->highest_degree
											== 'ad') Associate's Degree @elseif($user->profile->highest_degree == 'bd') Bachelor's Degree @elseif($user->profile->highest_degree
											== 'md') Master's Degree @else {{ $user->profile->highest_degree }} @endif @else
											<i>Private</i>
											@endif
										</span>
									</h3>
								</div>
								<div class="blue-frame-2 margin-top-bottom-15 padding-10">
									<h3 class="color-blue">
										<strong>Skills: <span class="color-dark-blue">{!! isset($user->privacy->skills) && $user->privacy->skills ? $user->profile->skills:'
											<i>Private</i>' !!}
										</span>
										</strong>
									</h3>
								</div>
								<div class="blue-frame-2 margin-top-bottom-15 padding-10">
									<h3 class="color-blue">
										<strong>Current Position: <span class="color-dark-blue">{!! isset($user->privacy->current_position) && $user->privacy->current_position ? $user->profile->current_position:'
											<i>Private</i>' !!}
										</span>
										</strong>
									</h3>
								</div>
								<div class="blue-frame-2 margin-top-bottom-15 padding-10">
									<h3 class="color-blue">
										<strong>Location: <span class="color-dark-blue">{!! isset($user->privacy->current_location) && $user->privacy->current_location ? $user->profile->current_location:'
											<i>Private</i>' !!}
										</span>
										</strong>
									</h3>
								</div>
							</div>
							<div class="clearfix"></div>
							<br/>
						</div>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6 metrics-panel">
									<div class="metrics-content"># of views: {{ $metrics_count }}</div>
								</div>
								<div class="col-md-6 metrics-panel">
									<div class="metrics-content">Last viewed: {{ $latest_metric ? date('m/d/Y', strtotime($latest_metric->created_at)).' at '.date('h:ia', strtotime($latest_metric->created_at)):'' }}</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr/>
			</div>
		</div>

	</div>
</section>

@endsection @section('head_code')
<link href="{{ asset('css/profile.css') }}" rel="stylesheet"> @endsection
