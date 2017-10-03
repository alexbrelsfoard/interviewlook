@extends('layouts.main')

@section('title')
Home
@stop

@section('head_code')
<script type="text/javascript">
	$( function() {
		var availableTitles = <?php echo Job::getDistinctTitles(); ?>;
		$('#job_title_search').autocomplete({ source: availableTitles, appendTo: ".search_input" });
	});
</script>
@stop

@section('body')


<section id="content">
	<div class="container">
		<div class="guest_user_home_search_main">
			<form id="form" action="/search" method="get"><input type="hidden" name="search" value="1"/>
				<div class="search_input">
					<input type='text' id='job_title_search' name="job_title_search" placeholder="Job Title" value="" class="postform auto_com_desi">
					<select name="job_location" id="job_location" class="postform">
						<option value="">-- Please Select a State --</option>
						<option value="99">Remote</option>
						<option value="AL">Alabama</option>
						<option value="AK">Alaska</option>
						<option value="AZ">Arizona</option>
						<option value="AR">Arkansas</option>
						<option value="CA">California</option>
						<option value="CO">Colorado</option>
						<option value="CT">Connecticut</option>
						<option value="DE">Delaware</option>
						<option value="DC">District Of Columbia</option>
						<option value="FL">Florida</option>
						<option value="GA">Georgia</option>
						<option value="HI">Hawaii</option>
						<option value="ID">Idaho</option>
						<option value="IL">Illinois</option>
						<option value="IN">Indiana</option>
						<option value="IA">Iowa</option>
						<option value="KS">Kansas</option>
						<option value="KY">Kentucky</option>
						<option value="LA">Louisiana</option>
						<option value="ME">Maine</option>
						<option value="MD">Maryland</option>
						<option value="MA">Massachusetts</option>
						<option value="MI">Michigan</option>
						<option value="MN">Minnesota</option>
						<option value="MS">Mississippi</option>
						<option value="MO">Missouri</option>
						<option value="MT">Montana</option>
						<option value="NE">Nebraska</option>
						<option value="NV">Nevada</option>
						<option value="NH">New Hampshire</option>
						<option value="NJ">New Jersey</option>
						<option value="NM">New Mexico</option>
						<option value="NY">New York</option>
						<option value="NC">North Carolina</option>
						<option value="ND">North Dakota</option>
						<option value="OH">Ohio</option>
						<option value="OK">Oklahoma</option>
						<option value="OR">Oregon</option>
						<option value="PA">Pennsylvania</option>
						<option value="RI">Rhode Island</option>
						<option value="SC">South Carolina</option>
						<option value="SD">South Dakota</option>
						<option value="TN">Tennessee</option>
						<option value="TX">Texas</option>
						<option value="UT">Utah</option>
						<option value="VT">Vermont</option>
						<option value="VA">Virginia</option>
						<option value="WA">Washington</option>
						<option value="WV">West Virginia</option>
						<option value="WI">Wisconsin</option>
						<option value="WY">Wyoming</option>
					</select>
					<select name="job_type" id="job_type" class="postform">
						<option value="">-- Select Job Type --</option>
						<?php for ($i=0; $i < sizeof(Job::$types); $i++) {?>
							<option value='<?php echo $i; ?>'><?php echo Job::$types[$i]; ?></option>
						<?php } ?>
					</select>
					<input class="search_icon" type="image" src="/images/search-icon.png" />
				</div>
			</form>
		</div>
		
		@if ($results)
		<div class="search_results_container">
			
			<ul>
			<?php foreach ($results as $job): ?>
				<li>
					<h4>{{ $job->title; }}</h4>
					<p>{{ $job->company->name }} ({{ $job->company->location }})<img src="{{$job->company->logo}}" class="logo" alt="{{ $job->title; }} Logo" /></p>
					<p>Job Skills: <?php $list = []; foreach ( $job->skills as $jobskill) { $list[] = $jobskill->skill; } echo implode(', ', $list); ?></p>
					<p>Job Location: {{$job->location}}</p>
					<div class="clear"></div>
					<button id="job_{{ $job->id}}_more_button" class="" onclick="$('#job_{{ $job->id}}_details').show();$('#job_{{ $job->id}}_more_button').hide();">More Details</button>
					<div id="job_{{ $job->id}}_details" class="job_details">
						<button id="job_{{ $job->id}}_less_button" class="" onclick="$('#job_{{ $job->id}}_details').hide();$('#job_{{ $job->id}}_more_button').show();">Hide Details</button>
						@if ($job->salary_yearly)
						<p>Salary: ${{$job->salary_yearly}}/year</p>
						@endif
						@if ($job->salary_hourly)
						<p>Salary: ${{$job->salary_hourly}}/hour</p>
						@endif
						<p>{{$job->description}}</p>
						<p>Requested Questions:<br>
							<ul>
							@if ($job->questions)
							<?php $questions = []; foreach ($job->questions as $job_question) {$questions[] = $job_question->question->question;} echo implode("</li>\n<li>", $questions); ?>
							@else
							<li>No suggested questions provided for this position</li>
							@endif
							</ul>
						</p>
						
						<button class="btn btn-primary">Apply</button>
					</div>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
		@endif
	</div>
</section>
	
@stop