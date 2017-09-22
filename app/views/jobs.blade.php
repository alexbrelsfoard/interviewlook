@extends('layouts.main')

@section('title')
Find a Job
@stop
@section('page_title')
Find a Job
@stop

@section('body')


<section id="content">
	<div class="container" role="main">
		<div class="job_listings" data-location="" data-keywords="" data-show_filters="true" data-show_pagination="false" data-per_page="10" data-orderby="featured" data-order="DESC" data-categories="">
			<form class="job_filters">
	
				<div class="search_jobs">
					
					<div class="search_keywords">
						<label for="search_keywords">Keywords</label>
						<input name="search_keywords" id="search_keywords" placeholder="Keywords" value="" type="text">
					</div>
			
					<div class="search_location">
						<label for="search_location">Location</label>
						<input name="search_location" id="search_location" placeholder="Location" value="" type="text">
					</div>
			
					
						</div>
			
					<ul class="job_types">
					<li><input name="filter_job_type[]" value="freelance" checked="checked" id="job_type_freelance" type="checkbox"><label for="job_type_freelance" class="freelance">Freelance</label></li>
					<li><label for="job_type_full-time" class="full-time"><input name="filter_job_type[]" value="full-time" checked="checked" id="job_type_full-time" type="checkbox"> Full Time</label></li>
					<li><label for="job_type_internship" class="internship"><input name="filter_job_type[]" value="internship" checked="checked" id="job_type_internship" type="checkbox"> Internship</label></li>
					<li><label for="job_type_part-time" class="part-time"><input name="filter_job_type[]" value="part-time" checked="checked" id="job_type_part-time" type="checkbox"> Part Time</label></li>
					<li><label for="job_type_temporary" class="temporary"><input name="filter_job_type[]" value="temporary" checked="checked" id="job_type_temporary" type="checkbox"> Temporary</label></li>
					</ul>
				<input name="filter_job_type[]" value="" type="hidden" />
			<div class="showing_jobs" style="display: none;"></div>
		</form>
	</div>
</section>
	
@stop