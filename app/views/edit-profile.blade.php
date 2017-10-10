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
		
		<h2>Profile</h2>
		
		<form action="/edit-profile" method="post" class="clearfix">
		<table class="profile" cellspacing="0">
			<tr>
				<th class="clearfix">Name</th><td>{{ $user->name }} <small style="float: right">(<a href="/account">Account Settings</a> page to edit this)</small></td>
			</tr>
			<tr>
				<th>Email</th><td>{{ $user->email }}</td>
			</tr>
			<tr>
				<th>Current Position</th><td><input type="text" name="current_position" value="{{ $user->profile->current_position }}" size="40"/></td>
			</tr>
			<tr>
				<th>Current Company</th><td><input type="text" name="current_company" value="{{ $user->profile->current_company }}" size="40"/></td>
			</tr>
			<tr>
				<th>Current Location</th><td><input type="text" name="current_location" value="{{ $user->profile->current_location }}" size="40"/></td>
			</tr>
			<tr>
				<th>Preferred Location</th><td><input type="text" name="preferred_location" value="{{ $user->profile->preferred_location }}" size="40"/></td>
			</tr>
			<tr>
				<th>Total Experience</th><td><input type="text" name="years_experience" value="{{ $user->profile->years_experience }}" size="40"/></td>
			</tr>
			<tr>
				<th>Highest Degree</th><td><input type="text" name="highest_degree" value="{{ $user->profile->highest_degree }}" size="40"/></td>
			</tr>
			<tr>
				<th>City</th><td><input type="text" name="city" value="{{ $user->profile->city }}" size="40"/></td>
			</tr>
		</table>
		<div class="clear"></div>
		<button id="do_update_profile" class="submit btn btn-primary" type="submit" name="do_update_profile">Update Profile</button>
	</form>
		
	</div>
</section>
	
@stop