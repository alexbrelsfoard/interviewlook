@extends('layouts.main')

@section('title')
Questions
@stop
@section('page_title')
Questions
@stop

@section('body')

<section id="content">
	<div class="container">
		
		<div class="col-md-12">
			<div class="col-md-6">
				Content
			</div>
			<div class="col-md-6">
				<h3>Contact Us</h3>
				<form action="/send_message" method="post">
					<p>
						<label>Your Name (Required)</label><br>
						<input type="text" name="name" size="40"/>
					</p>
					<p>
						<label>Your Email (Required)</label><br>
						<input type="text" name="email" size="40"/>
					</p>
					<p>
						<label>Subject</label><br>
						<input type="text" name="subject" size="40"/>
					</p>
					<p>
						<label>Message</label><br>
						<textarea name="message" rows="10" cols="40"></textarea>
					</p>
					<p>
						<input type="submit" class="btn btn-primary" value="Send"/>
					</p>
					
				</form>
			</div>
		</div>
		
	</div>
</section>
	
@stop