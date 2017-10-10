@extends('layouts.main')

@section('title')
My Profile
@stop
@section('page_title')
My Profile
@stop

@section('body')

<section id="content">
	<div class="container clearfix">
		
		<h2>Intro Video</h2>
		
		
		<h2>Profile</h2>
		<button type="button" onclick="window.location='{{ url("/edit-profile") }}'">edit</button>
		<div class="clear"></div>
		<table class="profile" cellspacing="0">
			<tr>
				<th>Name</th><td>{{ $user->name}}</td>
			</tr>
			<tr>
				<th>Email</th><td>{{ $user->email }}</td>
			</tr>
			<tr>
				<th>Current Position</th><td>{{ $user->profile->current_position }}</td>
			</tr>
			<tr>
				<th>Current Company</th><td>{{ $user->profile->current_company }}</td>
			</tr>
			<tr>
				<th>Current Location</th><td>{{ $user->profile->current_location }}</td>
			</tr>
			<tr>
				<th>Preferred Location</th><td>{{ $user->profile->preferred_location }}</td>
			</tr>
			<tr>
				<th>Years Experience</th><td>{{ $user->profile->years_experience }}</td>
			</tr>
			<tr>
				<th>Highest Degree</th><td>{{ $user->profile->highest_degree }}</td>
			</tr>
		</table>
		
	</div>
</section>
	
@stop