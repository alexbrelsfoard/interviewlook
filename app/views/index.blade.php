@extends('layouts.welcome')

@section('title')
Home
@stop

@section('body')

<section id="title" class="page-title-sec">
	<div class="container">
		<img src="/images/Interview-Look.png" />
		<h1>Welcome to interviewLOOK</h1>
	</div>
</section>


<section id="content">
	<div class="container">
		<div class="guest_user_home_search_main">
			<form id="form" action="/search" method="post">
				<div class="search_input">
					<select class="postform" name="search_by" id="fields_by_role">
						<option value="looker">Looker</option>
						<option value="lookie">Lookie</option>
					</select>
					<input type='text' id='ser_designation_looker' name="nser_designation_looker" placeholder="Job Title" value="" class="postform auto_com_desi">
					<input type='text' id='ser_location_looker' name="ser_location_looker" placeholder='Location' value="" class="postform auto_com_location">
					<select name="job_type" id="job_type" class="postform">
						<option value="">Select Job Type</option>
						<option value='Freelance'>Freelance</option>
						<option value='Full Time'>Full Time</option>
						<option value='Internship'>Internship</option>
						<option value='Part Time'>Part Time</option>
						<option value='Temporary'>Temporary</option>         
					</select>
					<input class="search_icon" type="image" src="/images/search-icon.png" />
				</div>
			</form>
		</div>
	</div>
</section>
	
@stop