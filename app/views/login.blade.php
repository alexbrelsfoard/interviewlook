@extends('layouts.signup')

@section('title')
Login
@stop
@section('page_title')
Login
@stop

@section('body')


<section id="content">
		<div class="main-loginform">
			<h1>Login</h1>
			@if ($error)
			<p class="alert">Error: {{ $error }}
				<ul>
				<?php
					foreach ($errors as $message) {
					    echo "<li>$message</li>";
					}
				?>
				</ul>
			</p>
			@endif
			<div class="cjfm-form  cjfm-login-form  ">
				<form action="/login" method="post">
					<span class="cjfm-loading"></span>
					<div id="container-login_form_user_login" class="control-group textbox clearfix">
						<label class="control-label hidden" for="login_form_user_login">
							<span class="label-login_form_user_login">Username or Email address: <span class="cjfm-required">*</span></span>
						</label>
						<span class="cjfm-relative">
							<i class="fa fa-user"></i><input type="text" name="email" id="login_form_user_email" value=""  class="form-control form-type-login login_form_user_login"  placeholder="Email Address " >
						</span>
					</div>
					
					<div id="container-login_form_user_pass" class="control-group password clearfix">
						<label class="control-label hidden" for="login_form_user_pass"><span class="label-login_form_user_pass">Password: <span class="cjfm-required">*</span></span></label>
						<span class="cjfm-relative">
							<i class="fa fa-lock"></i><input type="password" name="password" id="login_form_user_pass" value=""  class="form-control form-type-login login_form_user_pass"  placeholder="********" >
						</span>
					</div>
					
					<div class="control-group submit-button">
						<button type="submit" name="do_login" id="do_login" class="submit cjfm-btn cjfm-btn-default " >Login</button>
						<span class="cjfm-inline-block button-suffix"><label><input name="remember_me" type="checkbox" /> Remember me </label></span>
						<a class="button-suffix forgot-password-link" href="http://interviewlook.com/recover-password/">Forgot password?</a>
					</div>
				</form>
			</div>
		</div>
</section>
	
@stop