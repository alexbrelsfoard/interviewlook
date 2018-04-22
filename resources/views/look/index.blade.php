@extends('layouts.welcome') @section('title', 'Home') @section('head_code')
<!--<script type="text/javascript">
	$(function () {
		let availableTitles = {
			{
				$available_titles
			}
		};
		$('#job_title_search').autocomplete({
			source: availableTitles,
			appendTo: ".search_input"
		});
	});
</script>-->
@stop @section('body')
<section id="title" class="page-title-sec landing">
	<div class="container">
		<img src="{{ asset('images/Interview-Look.png') }}" />
		<h1>Welcome to interviewLOOK</h1>
		<h3 class="subtitle">We help job-seekers land the perfect job.</h3>
		<div class="flash-message">
			@foreach (['danger', 'warning', 'success', 'info'] as $msg) @if(Session::has('alert-' . $msg))
			<p class="alert alert-{{ $msg }}">
				{{ Session::get('alert-' . $msg) }}
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			</p>
			@endif @endforeach
		</div>
	</div>
</section>
<section id="title" class="page-title-sec landing">
	<div class="container">
		<h3 class="section_h4">We are currently testing our beta, to get access please send your name and email</h3>
			<div class="cjfm-form  cjfm-login-form">
				<form class="form-inline" method="POST" action="{{ route('welcome.request') }}">
					{{ csrf_field() }}
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Name" name="user_name" value="{{ old('user_name') }}"/>
						@if ($errors->has('user_name'))
							<div class="error">
								<strong>{{ $errors->first('user_name') }}</strong>
							</div>
						@endif
					</div>
					<div class="form-group">
						<input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}"/>
						@if ($errors->has('email'))
							<div class="error">
								<strong>{{ $errors->first('email') }}</strong>
							</div>
						@endif
					</div>
					<div class="form-group">
						<button type="submit" name="submit" class="btn btn-primary">Submit</button>
						@if ($errors->has('name') || $errors->has('email'))
							<div class="error">
								<strong>&nbsp;</strong>
							</div>
						@endif
					</div>
				</form
			</div>
	</div>
</section>
@if(!auth()->check())
<section id="content" class="hidden">
	<div class="main-loginform">
		<h1>Login</h1>
		<div class="cjfm-form  cjfm-login-form  ">
			<div class="flash-message">
				@foreach (['danger', 'warning', 'success', 'info'] as $msg) @if(Session::has('alert-' . $msg))
				<p class="alert alert-{{ $msg }}">
					{{ Session::get('alert-' . $msg) }}
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				</p>
				@endif @endforeach
			</div>
			<form class="form-horizontal" method="POST" action="{{ route('login') }}">
				{{ csrf_field() }}
				<span class="cjfm-loading"></span>
				<div id="container-login_form_user_login" class="control-group textbox clearfix{{ $errors->has('email') ? ' has-error' : '' }}">
					<label class="control-label hidden" for="login_form_user_login">
						<span class="label-login_form_user_login">Email address:
							<span class="cjfm-required">*</span>
						</span>
					</label>
					<span class="cjfm-relative">
						<i class="fa fa-user"></i>
						<input id="email" type="email" class="form-control form-type-login login_form_user_login" name="email" value="{{ old('email') }}"
						    placeholder="Email Address" required autofocus> @if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
						@endif
					</span>
				</div>

				<div id="container-login_form_user_pass" class="control-group password clearfix{{ $errors->has('password') ? ' has-error' : '' }}">
					<label class="control-label hidden" for="login_form_user_pass">
						<span class="label-login_form_user_pass">Password:
							<span class="cjfm-required">*</span>
						</span>
					</label>
					<span class="cjfm-relative">
						<i class="fa fa-lock"></i>
						<input id="password" type="password" class="form-control form-type-login login_form_user_pass" placeholder="********" name="password"
						    required> @if ($errors->has('password'))
						<span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
						@endif
					</span>
				</div>

				<div class="control-group submit-button">
					<button type="submit" name="do_login" id="do_login" class="submit cjfm-btn cjfm-btn-default ">Login</button>
					<span class="cjfm-inline-block button-suffix">
						<label>
							<input name="remember" type="checkbox" {{ old( 'remember') ? 'checked' : '' }} /> Remember me </label>
					</span>
					<a class="button-suffix forgot-password-link" href="{{ route('password.request') }}">Forgot password?</a>
				</div>
				<div class="form-group">
					<label for="social" class="control-label"></label>
					<div class="col-md-12">
						<center>
							<a href="{{ route('social.facebook') }}">
								<img src="{{ asset('images/facebook.png') }}" />
							</a>
							<a href="{{ route('social.linkedin') }}">
								<img src="{{ asset('images/linkedin.png') }}" />
							</a>
						</center>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
@endif @stop
