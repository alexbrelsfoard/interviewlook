@extends('layouts.main') 
@section('title', 'Register') 
@section('page_title', 'Register') 
@section('body')
<section id="content">
	<div class="container">
		<div class="cjfm-form  cj-form-edit-profile">
			<h3 class="center">Please enter your details to register</h3>
			<form class="form-horizontal" method="POST" action="{{ route('register') }}">
				{{ csrf_field() }}
				<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					<label for="name" class="col-md-4 control-label">Your Name (<em>*</em>)</label>
					<div class="col-md-6">
						<input id="name" type="text" size="40" class="form-control" name="name" value="{{ old('name') }}" required autofocus> 
						@if ($errors->has('name'))
							<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					<label for="email" class="col-md-4 control-label">Your Email (<em>*</em>)</label>
					<div class="col-md-6">
						<input id="email" size="40" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
						@if ($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
					<label for="password" class="col-md-4 control-label">Password (<em>*</em>)</label>
					<div class="col-md-6">
						<input id="password" size="40" type="password" class="form-control" name="password" required>
						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group">
					<label for="password-confirm" class="col-md-4 control-label">Confirm Password (<em>*</em>)</label>
					<div class="col-md-6">
						<input id="password-confirm" size="40" type="password" class="form-control" name="password_confirmation" required>
					</div>
				</div>
				<div class="form-group">
				<label for="register" class="col-md-4 control-label"></label>
					<div class="col-md-6">
						<button type="submit" class="btn btn-primary">Register</button>
					</div>
				</div>
				<div class="form-group">
					<label for="social" class="col-md-4 control-label"></label>
					<div class="col-md-6">
						<a href="{{ route('social.facebook') }}"><img src="{{ asset('images/facebook.png') }}"/></a>
						<a href="{{ route('social.linkedin') }}"><img src="{{ asset('images/linkedin.png') }}"/></a>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
@endsection