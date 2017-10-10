@extends('layouts.main')

@section('title')
Register
@stop
@section('page_title')
Register
@stop

@section('body')

<section id="content">
	<div class="container">
		
		<div class="cjfm-form  cj-form-edit-profile">
			<p class="center">Please enter your details to register</p>
			@if ($error)
			<p class="alert center">Error: {{ $error }}
				<ul class="center">
				<?php
					foreach ($errors->messages() as $message) {
					    echo "<li>$message</li>";
					}
				?>
				</ul>
			</p>
			@endif
			<form action="/register" method="post">
				<p>
					<label class="control-label" style="width: 200px; line-height: 42px;">Your Name (<em>*</em>)</label>
					<input type="text" name="name" value="" size="40"/>
				</p>
				<p>
					<label class="control-label" style="width: 200px; line-height: 42px;">Your Email (<em>*</em>)</label>
					<input type="text" name="email" value="" size="40"/>
				</p>
				<p>
					<label class="control-label" style="width: 200px; line-height: 42px;">Change Password (<em>*</em>)</label>
					<input type="password" name="password" size="40"/>
				</p>
				<p>
					<label class="control-label" style="width: 200px; line-height: 42px;">Confirm Password (<em>*</em>)</label>
					<input type="password" name="password_confirm	" size="40"/>
				</p>
				<p>
					<label class="control-label" style="width: 200px; line-height: 42px;">Acccount Type</label>
					<select id="user_type" name="type" style="width: 335px; padding: 0px 0px 0px 5px;" onchange="IL.selectUserType();">
						<option value="1" selected>LOOKie (employment-seeker)</option>
						<option value="2">LOOKer (employer/recruiter)</option>
					</select>
				</p>
				<div id="looker_details" class="hidden clearfix">
					<p>
						<label class="control-label" style="width: 200px; line-height: 42px;">Company Name (<em>*</em>)</label>
						<input type="text" name="company_name" size="40"/>
					</p>
					<p><label class="control-label" style="width: 200px; line-height: 42px;">Membership Level</label>
						<div class="float_left">
							<input type="radio" class="radio" name="membership" value="1" checked/> Basic (free)<br/>
							<input type="radio" class="radio" name="membership" value="2"/> Gold ($9.95/month)<br/>
							<input type="radio" class="radio" name="membership" value="3"/> Platinum ($29.95/month)<br/>
						</div>
					</p>
				</div>
<!--
				Lookie or Looker
				if Looker, what membership plan, what company name
-->
				
				<p>
					<input type="submit" class="btn btn-primary" value="Register"/>
				</p>
				
			</form>
		</div>
		
	</div>
</section>
	
@stop