@extends('layouts.main') @section('title') Contact Us @stop @section('page_title') About Us @stop @section('body')

<section id="content">
	<div class="container">

		<div class="col-md-12">
			<div class="col-md-6">
				<h3>About Us</h3>
				<p>Welcome to interviewLook, thanks for stopping by. We are the easiest, fastest and simplest way for job-seekers to create,
					manage, and share video interviews or LOOKs - as we like to call them - with recruiters. Please feel free to leave a
					suggestion or comment, we appreciate all feedback. Thanks again and best of luck in your job hunt.</p>
				<p>For more information please contact us at
					<a href="mailto:info@interviewlook.com">info@interviewlook.com</a>, or simply complete the form on this page.</p>
				<p>
					<img class="alignnone size-medium" src="{{ asset('images/Mock-UI-photo-750x422.jpg') }}" style="height: auto; max-width: 100%;"
					/>
				</p>
			</div>
			<div class="col-md-4">
				<h3>Contact Us</h3>
				<div class="flash-message">
					@foreach (['danger', 'warning', 'success', 'info'] as $msg) @if(Session::has('alert-' . $msg))
					<p class="alert alert-{{ $msg }}">
						{{ Session::get('alert-' . $msg) }}
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					</p>
					@endif @endforeach
				</div>
				<form action="{{ route('look.contact.send') }}" method="post">
					{{ csrf_field() }}
					<p>
						<label>Your Name (Required)</label>
						<br>
						<input class="form-control" type="text" name="user_name" value="{{ old('user_name') }}" size="40" required/>
						<div class="error">
							@if ($errors->has('user_name')) {{ $errors->first('user_name') }} @endif
						</div>
					</p>
					<p>
						<label>Your Email (Required)</label>
						<br>
						<input class="form-control" type="email" name="email" value="{{ old('email') }}" size="40" required/>
						<div class="error">
							@if ($errors->has('email')) {{ $errors->first('email') }} @endif
						</div>
					</p>
					<p>
						<label>Subject</label>
						<br>
						<select class="form-control" name="subject">
							<option value="General Comment">General Comment</option>
							<option value="Technical Problem">Technical Problem</option>
							<option value="Other">Other</option>
						</select>
					</p>
					<p>
						<label>Message</label>
						<br>
						<textarea class="form-control" name="message" rows="10" cols="40" required>{{ old('message') }}</textarea>
						<div class="error">
							@if ($errors->has('message')) {{ $errors->first('message') }} @endif
						</div>
					</p>
					<p>
						<input type="submit" class="btn btn-primary" value="Send" />
					</p>

				</form>
			</div>
		</div>

	</div>
</section>

@stop