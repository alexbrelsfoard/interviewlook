@extends('layouts.main') 
@section('title', 'Reset Password') 
@section('page_title', 'Reset Password') 
@section('body')
<section id="content">
	<div class="main-loginform">
		<h1>Reset Password</h1>
		<div class="cjfm-form  cjfm-login-form  ">
			<form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
				{{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
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
						 placeholder="Email Address" required autofocus>
                         @if ($errors->has('email'))
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
						 required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
						@endif
					</span>
				</div>

				<div id="container-login_form_user_pass" class="control-group password clearfix{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
					<label class="control-label hidden" for="login_form_user_pass">
						<span class="label-login_form_user_pass">Confirm Password:
							<span class="cjfm-required">*</span>
						</span>
					</label>
					<span class="cjfm-relative">
						<i class="fa fa-lock"></i>
						<input id="password-confirm" type="password" class="form-control form-type-login login_form_user_pass" placeholder="********" name="password_confirmation"
						 required>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
						@endif
					</span>
				</div>
				<div class="control-group submit-button">
					<button type="submit" name="do_login" id="do_login" class="submit cjfm-btn cjfm-btn-default ">Reset Password</button>
					<span class="cjfm-inline-block button-suffix">
						<label>Already have account?</label>
					</span>
					<a class="button-suffix forgot-password-link" href="{{ route('login') }}">Sign In</a>
				</div>
			</form>
		</div>
	</div>
</section>
@endsection