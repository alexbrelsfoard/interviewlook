@extends('layouts.main')

@section('title', 'Demos')
@section('page_title', 'Demos')

@section('body')

<section id="content">
	<div class="container">
		
		<div class="col-md-12">
			<div class="col-md-6">
				<h3>LOOKers Demo Video</h3>
				
				 <video width="525" height="295" controls>
					<source src="{{ asset('videos/LOOKers-Demo.mp4') }}" type="video/mp4">
					Your browser does not support the video tag.
				</video>
			</div>
			
			<div class="col-md-6">
				<h3>LOOKies Demo Video</h3>
				<video width="525" height="295" controls>
					<source src="{{ asset('videos/LOOKie-Demo.mp4') }}" type="video/mp4">
					Your browser does not support the video tag.
				</video>
			</div>
		</div>
		
	</div>
</section>
	
@endsection