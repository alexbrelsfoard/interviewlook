@extends('layouts.main') 
@section('title', 'Reset Password') 
@section('page_title', 'Reset Password') 
@section('body')
<section id="content">
	<div class="main-loginform">
		<h1>Reset Password</h1>
		<div class="cjfm-form  cjfm-login-form  ">
             @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
			<form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
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
						 placeholder="Email Address" required autofocus>
                         @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
						@endif
					</span>
				</div>
				<div class="control-group submit-button">
					<button type="submit" name="do_login" id="do_login" class="submit cjfm-btn cjfm-btn-default ">Send Password Reset Link</button>
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