@extends('layouts.main') @section('title', $user->name) @section('page_title', 'Profile') @section('body')

<section id="content" class="profile">
	<div class="container">

		<div class="col-md-12">
			<div class="profile-body">
				<div class="profile-bio">
					<div class="row">
						<div class="col-md-4">
							<div class="blue-frame-10">
								<div class="white-frame-10">
									<div class="blue-frame-5">
										<img class="img-responsive md-margin-bottom-10" src="{{ $user->photo }}" alt="">
									</div>
								</div>
							</div>
							<br/> @if($user->social)
							<center>
								<a class="btn btn-info btn-xs" href="{{ $user->social->facebook }}">
									<i class="fa fa-facebook"></i>
								</a>
								<a class="btn btn-info btn-xs" href="{{ $user->social->twitter }}">
									<i class="fa fa-twitter"></i>
								</a>
								<a class="btn btn-info btn-xs" href="{{ $user->social->instagram }}">
									<i class="fa fa-instagram"></i>
								</a>
							</center>
							@endif
						</div>
						<div class="col-md-8">
							<div class="cbp_tmlabel">
								@php($url = route('profile.edit'))
								<div class=" padding-10">
									<h2 class="color-blue">
										<strong>{{ $user->name }}</strong>
										{!! auth()->check() ? '
										<a class="btn btn-success margin-left-10" href="'.$url.'">Edit Profile</a>':'' !!}
									</h2>
								</div>
								<div class="blue-frame-2 margin-top-bottom-15 padding-10">
									<h3 class="color-blue">
										Industry Summary: {!! isset($user->privacy->industry_summary) && $user->privacy->industry_summary ? $user->profile->industry_summary:'
										<i>Private</i>' !!}
									</h3>
								</div>
								<div class="blue-frame-2 margin-top-bottom-15 padding-10">
									<h3 class="color-blue">
										<strong>Experience: {!! isset($user->privacy->years_experience) && $user->privacy->years_experience ? $user->profile->years_experience:'
											<i>Private</i>' !!}</strong>
									</h3>
								</div>
								<div class="blue-frame-2 margin-top-bottom-15 padding-10">
									<h3 class="color-blue">
										<strong>Education: {!! isset($user->privacy->highest_degree) && $user->privacy->highest_degree ? $user->profile->highest_degree:'
											<i>Private</i>' !!}</strong>
									</h3>
								</div>
								<div class="blue-frame-2 margin-top-bottom-15 padding-10">
									<h3 class="color-blue">
										<strong>Skills: {!! isset($user->privacy->skills) && $user->privacy->skills ? $user->profile->skills:'
											<i>Private</i>' !!}</strong>
									</h3>
								</div>
								<div class="blue-frame-2 margin-top-bottom-15 padding-10">
									<h3 class="color-blue">
										<strong>Current Position: {!! isset($user->privacy->current_position) && $user->privacy->current_position ? $user->profile->current_position:'
											<i>Private</i>' !!}</strong>
									</h3>
								</div>
								<div class="blue-frame-2 margin-top-bottom-15 padding-10">
									<h3 class="color-blue">
										<strong>Location: {!! isset($user->privacy->current_location) && $user->privacy->current_location ? $user->profile->current_location:'
											<i>Private</i>' !!}</strong>
									</h3>
								</div>
							</div>
							<div class="clearfix"></div>
							<br/>
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