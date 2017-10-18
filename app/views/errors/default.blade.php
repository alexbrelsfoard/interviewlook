@extends('layouts.main')

@section('title')
LOOKs
@stop
@section('page_title')
LOOKs&trade;
@stop

@section('body')

<section id="content">
	<div class="container">
		<div class="error-spacer"></div>
		<div role="main" class="main">
			<?php $messages = array('Ouch.', 'Oh no!', 'Whoops!'); ?>
	
			<h1><?php echo $messages[mt_rand(0, 2)]; ?></h1>
	
			<h2>Server Error: {{ $code }} ({{ $message }})</h2>
	
			<hr>
	
			<h3>What does this mean?</h3>
	
			<p>
				Something went wrong on our servers while we were processing your request.
				We're really sorry about this, and will work hard to get this resolved as
				soon as possible.
			</p>
	
			<p>
				Perhaps you would like to go to our <a href="{{{ URL::to('/') }}}">home page</a>?
			</p>
		</div>
	</div>
</section>
@stop
