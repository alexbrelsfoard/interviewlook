@extends('layouts.main') @section('title', 'Edit Profile') @section('page_title', 'Edit Profile') @section('body')

<section id="content" class="profile">
	<div class="container">
		<div class="col-md-12">
			<div class="profile-body">
				<div class="profile-bio">
					<div class="flash-message">
						@foreach (['danger', 'warning', 'success', 'info'] as $msg) @if(Session::has('alert-' . $msg))
						<p class="alert alert-{{ $msg }}">
							{{ Session::get('alert-' . $msg) }}
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						</p>
						@endif @endforeach
					</div>
					<form class="form-horizontal privacy_buttons" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<center>
							<h3>Account Setting</h3>
						</center>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Profile Photo:</label>
							<div class="col-sm-10">
								<div class="blue-frame-10">
									<div class="white-frame-10">
										<div class="blue-frame-5">
											<img class="img-responsive md-margin-bottom-10" src="{{ $user->photo }}" alt="">
										</div>
									</div>
								</div>
								<br/>
								<input type="file" class="form-control" id="photo" name="photo">
								<div class="error">
									@if ($errors->has('photo')) {{ $errors->first('photo') }} @endif
								</div>
							</div>
						</div>
						<hr/>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Email Address:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="email" placeholder="me@example.com" name="email" value="{{ old( 'email') ?
									 old( 'email'): $user->email }}">
								<div class="error">
									@if ($errors->has('email')) {{ $errors->first('email') }} @endif
								</div>
							</div>
						</div>
						<hr/>
						<center>
							<h3>Edit Profile</h3>
						</center>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Industry Summary:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="industry_summary" placeholder="Industry Summary" name="industry_summary" value="{{
								 old( 'industry_summary') ? old( 'industry_summary'): (isset($user->profile->industry_summary) ? $user->profile->industry_summary : '') }}">
								<div class="error">
									@if ($errors->has('industry_summary')) {{ $errors->first('industry_summary') }} @endif
								</div>
								<label class="radio-inline">
									<input type="radio" value="1" name="industry_summary_privacy" {{ old( 'industry_summary_privacy')=='1' ? 'checked': (isset($user->privacy->industry_summary) && $user->privacy->industry_summary == '1' ? 'checked' : 'checked') }} >Public
								</label>
								<label class="radio-inline">
									<input type="radio" value="0" name="industry_summary_privacy" {{ old( 'industry_summary_privacy')=='0' ? 'checked': (isset($user->privacy->industry_summary) && $user->privacy->industry_summary == '0' ? 'checked' : '') }} >Private
								</label>
							</div>
						</div>
						<hr/>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Current Position:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="current_position" placeholder="Current Position" name="current_position" value="{{
								 old( 'current_position') ? old( 'current_position'): (isset($user->profile->current_position) ? $user->profile->current_position : '') }}">
								<div class="error">
									@if ($errors->has('current_position')) {{ $errors->first('current_position') }} @endif
								</div>
								<label class="radio-inline">
									<input type="radio" value="1" name="current_position_privacy" {{ old( 'current_position_privacy')=='1' ? 'checked': (isset($user->privacy->current_position) && $user->privacy->current_position == '1' ? 'checked' : '') }} >Public
								</label>
								<label class="radio-inline">
									<input type="radio" value="0" name="current_position_privacy" {{ old( 'industry_summary_privacy')=='0' ? 'checked': (isset($user->privacy->current_position) && $user->privacy->current_position == '0' ? 'checked' : '') }} >Private
								</label>
							</div>
						</div>
						<hr/>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Current Company:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="current_company" placeholder="Current Company" name="current_company" value="{{
								 old( 'current_company') ? old( 'current_company'): (isset($user->profile->current_company) ? $user->profile->current_company : '') }}">
								<div class="error">
									@if ($errors->has('current_company')) {{ $errors->first('current_company') }} @endif
								</div>
								<label class="radio-inline">
									<input type="radio" value="1" name="current_company_privacy" {{ old( 'current_company_privacy')=='1' ? 'checked': (isset($user->privacy->current_company) && $user->privacy->current_company == '1' ? 'checked' : '') }} >Public
								</label>
								<label class="radio-inline">
									<input type="radio" value="0" name="current_company_privacy" {{ old( 'current_company_privacy')=='0' ? 'checked': (isset($user->privacy->current_company) && $user->privacy->current_company == '0' ? 'checked' : '') }} >Private
								</label>
							</div>
						</div>
						<hr/>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Current Location:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="current_location" placeholder="Current Location" name="current_location" value="{{
								 old( 'current_location') ? old( 'current_location'): (isset($user->profile->current_location) ? $user->profile->current_location : '') }}">
								<div class="error">
									@if ($errors->has('current_location')) {{ $errors->first('current_location') }} @endif
								</div>
								<label class="radio-inline">
									<input type="radio" value="1" name="current_location_privacy" {{ old( 'current_location_privacy')=='1' ? 'checked': (isset($user->privacy->current_location) && $user->privacy->current_location == '1' ? 'checked' : '') }} >Public
								</label>
								<label class="radio-inline">
									<input type="radio" value="0" name="current_location_privacy" {{ old( 'current_location_privacy')=='0' ? 'checked': (isset($user->privacy->current_location) && $user->privacy->current_location == '0' ? 'checked' : '') }} >Private
								</label>
							</div>
						</div>
						<hr/>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Preferred Location:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="preferred_location" placeholder="Preferred Location" name="preferred_location"
								 value="{{
								 old( 'preferred_location') ? old( 'preferred_location'): (isset($user->profile->preferred_location) ? $user->profile->preferred_location : '') }}">
								<div class="error">
									@if ($errors->has('preferred_location')) {{ $errors->first('preferred_location') }} @endif
								</div>
								<label class="radio-inline">
									<input type="radio" value="1" name="preferred_location_privacy" {{ old( 'preferred_location_privacy')=='1' ? 'checked': (isset($user->privacy->preferred_location) && $user->privacy->preferred_location == '1' ? 'checked' : '') }} >Public
								</label>
								<label class="radio-inline">
									<input type="radio" value="0" name="preferred_location_privacy" {{ old( 'preferred_location_privacy')=='0' ? 'checked': (isset($user->privacy->preferred_location) && $user->privacy->preferred_location == '0' ? 'checked' : '') }} >Private
								</label>
							</div>
						</div>
						<hr/>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Experience:</label>
							<div class="col-sm-10">
								@php($experience = old( 'years_experience') ? old( 'years_experience'): (isset($user->profile->years_experience) ? $user->profile->years_experience
								: ''))
								<select class="form-control" name="years_experience">
									<option value="0-3" {{ $experience=='0-3' ? 'selected': '' }}>0-3 years</option>
									<option value="4-6" {{ $experience=='4-6' ? 'selected': '' }}>4-6 years</option>
									<option value="7-9" {{ $experience=='7-9' ? 'selected': '' }}>7-9 years</option>
									<option value="10+" {{ $experience=='10+' ? 'selected': '' }}>10+ years</option>
								</select>
								<div class="error">
									@if ($errors->has('years_experience')) {{ $errors->first('years_experience') }} @endif
								</div>
								<label class="radio-inline">
									<input type="radio" value="1" name="years_experience_privacy" {{ old( 'years_experience_privacy')=='1' ? 'checked': (isset($user->privacy->years_experience) && $user->privacy->years_experience == '1' ? 'checked' : '') }} >Public
								</label>
								<label class="radio-inline">
									<input type="radio" value="0" name="years_experience_privacy" {{ old( 'years_experience_privacy')=='0' ? 'checked': (isset($user->privacy->years_experience) && $user->privacy->years_experience == '0' ? 'checked' : '') }} >Private
								</label>
							</div>
						</div>
						<hr/>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Education:</label>
							<div class="col-sm-10">
								@php($highest_degree = old( 'highest_degree') ? old( 'highest_degree'): (isset($user->profile->highest_degree) ? $user->profile->highest_degree
								: ''))
								<select class="form-control" name="highest_degree">
									<option value="hsd" {{ $highest_degree=='hsd' ? 'selected': '' }}>High School Diploma</option>
									<option value="sc" {{ $highest_degree=='sc' ? 'selected': '' }}>Some College</option>
									<option value="ad" {{ $highest_degree=='ad' ? 'selected': '' }}>Associate's Degree</option>
									<option value="bd" {{ $highest_degree=='bd' ? 'selected': '' }}>Bachelor's Degree</option>
									<option value="md" {{ $highest_degree=='md' ? 'selected': '' }}>Master's Degree</option>
									<option value="dd" {{ $highest_degree=='dd' ? 'selected': '' }}>Doctoral Degree</option>
									<option value="other" {{ $highest_degree=='other' ? 'selected': '' }}>Other</option>
								</select>
								<br/>
								@php($degrees_array = ['hsd','sc','ad','bd','md','dd'])
								<label>Other</label>
								<input type="text" class="form-control" id="highest_degree_other" placeholder="Education" name="highest_degree_other" value="{{ old(
								 'highest_degree_other') ? old( 'highest_degree_other'): (isset($user->profile->highest_degree) && !in_array($user->profile->highest_degree, $degrees_array) ? $user->profile->highest_degree : '') }}">
								<div class="error">
									@if ($errors->has('highest_degree_other')) {{ $errors->first('highest_degree_other') }} @endif
								</div>
								<label class="radio-inline">
									<input type="radio" value="1" name="highest_degree_privacy" {{ old( 'highest_degree_privacy')=='1' ? 'checked': (isset($user->privacy->highest_degree) && $user->privacy->highest_degree == '1' ? 'checked' : '') }} >Public
								</label>
								<label class="radio-inline">
									<input type="radio" value="0" name="highest_degree_privacy" {{ old( 'highest_degree_privacy')=='0' ? 'checked': (isset($user->privacy->highest_degree) && $user->privacy->highest_degree == '0' ? 'checked' : '') }} >Private
								</label>
							</div>
						</div>
						<hr/>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Skills:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="skills" placeholder="Skills" name="skills" value="{{ old( 'skills') ? old(
								 'skills'): (isset($user->profile->skills) ? $user->profile->skills : '') }}">
								<div class="error">
									@if ($errors->has('skills')) {{ $errors->first('skills') }} @endif
								</div>
								<label class="radio-inline">
									<input type="radio" value="1" name="skills_privacy" {{ old( 'skills_privacy')=='1' ? 'checked': (isset($user->privacy->skills) && $user->privacy->skills == '1' ? 'checked' : '') }} >Public
								</label>
								<label class="radio-inline">
									<input type="radio" value="0" name="skills_privacy" {{ old( 'skills_privacy')=='0' ? 'checked': (isset($user->privacy->skills) && $user->privacy->skills == '0' ? 'checked' : '') }} >Private
								</label>
							</div>
						</div>
						<hr/>
						<center>
							<h3>Social Network</h3>
						</center>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Facebook:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="facebook" placeholder="https://www.facebook.com/username" name="facebook" value="{{ old( 'facebook') ?
								 old( 'facebook'): (isset($user->social->facebook) ? $user->social->facebook : '') }}">
								<div class="error">
									@if ($errors->has('facebook')) {{ $errors->first('facebook') }} @endif
								</div>
							</div>
						</div>
						<hr/>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Twitter:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="twitter" placeholder="https://www.twitter.com/username" name="twitter" value="{{ old( 'twitter') ? old(
								 'twitter'): (isset($user->social->twitter) ? $user->social->twitter : '') }}">
								<div class="error">
									@if ($errors->has('twitter')) {{ $errors->first('twitter') }} @endif
								</div>
							</div>
						</div>
						<hr/>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Instagram:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="instagram" placeholder="https://www.instagram.com/username" name="instagram"
								 value="{{ old( 'instagram')
								 ? old( 'instagram'): (isset($user->social->instagram) ? $user->social->instagram : '') }}">
								<div class="error">
									@if ($errors->has('instagram')) {{ $errors->first('instagram') }} @endif
								</div>
							</div>
						</div>
						<hr/>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-primary btn-lg">Update Profile</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection @section('head_code')
<link href="{{ asset('css/profile.css') }}" rel="stylesheet"> @endsection
