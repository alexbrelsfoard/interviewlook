@extends('layouts.main')

@section('title')
My Account
@stop
@section('page_title')
My Account
@stop

@section('body')

<section id="content">
	<div class="container">
		
		<div class="cjfm-form  cj-form-edit-profile">
			@if ($error)
			<p class="alert">Error: {{ $error }}
				<ul>
				<?php
					foreach ($errors->messages() as $message) {
					    echo "<li>$message</li>";
					}
				?>
				</ul>
			</p>
			@endif
			<form action="/profile" method="post">
				<div id="container-user_name" class="control-group name">
					<label class="control-label">Your Name (Required)</label>
					<input type="text" name="name" value="{{ $user->name }}" size="40"/>
				</div>
				<div id="container-user_email" class="control-group email">
					<label class="control-label">Your Email (Required)</label>
					<input type="text" name="email" value="{{ $user->email }}" size="40"/>
				</div>
				<div id="container-user_password" class="control-group password">
					<label class="control-label">Change Password</label>
					<input type="password" name="password" size="40"/>
				</div>
				<div id="container-user_password_confirm" class="control-group password">
					<label class="control-label">Confirm Password</label>
					<input type="password_confirm" name="password" size="40"/>
				</div>
				<div class="control-group submit-button">
					<button id="do_update_profile" class="btn btn-primary submit" type="submit" name="do_update_profile">Update Account</button>
				</div>
				
			</form>

		</div>
		
	</div>
</section>
	
@stop