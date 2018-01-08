@extends('layouts.welcome') @section('title', 'Home') @section('head_code')
<script type="text/javascript">
	$( function() {
		var availableTitles = {{  $available_titles }};
		$('#job_title_search').autocomplete({ source: availableTitles, appendTo: ".search_input" });
	});

</script>
@stop @section('body')
<section id="title" class="page-title-sec">
	<div class="container">
		<img src="{{ asset('images/Interview-Look.png') }}" />
		<h1>Welcome to interviewLOOK</h1>
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
@if(auth()->check())
<section id="content">
	<div class="container">
		<div class="guest_user_home_search_main">
			<form id="form" action="/search" method="get">
				<input type="hidden" name="search" value="1" />
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
						@for ($i=0; $i
						< sizeof($job_types); $i++) <option value='{{ $i }}'>{{ $job_types[$i] }}</option>
							@endfor
					</select>
					<input class="search_icon" type="image" src="{{ asset('images/search-icon.png') }}" />
				</div>
			</form>
		</div>
	</div>
</section>
@else
<section id="content">
	<div class="main-loginform">
		<h1>Login</h1>
		<div class="cjfm-form  cjfm-login-form  ">
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">
                            {{ Session::get('alert-' . $msg) }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </p>
                    @endif
            @endforeach
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
                            <a href="{{ route('social.facebook') }}"><img src="{{ asset('images/facebook.png') }}"/></a>
                            <a href="{{ route('social.linkedin') }}"><img src="{{ asset('images/linkedin.png') }}"/></a>
                        </center>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
@endif
@stop