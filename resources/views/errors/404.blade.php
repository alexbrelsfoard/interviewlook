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
			<?php $messages = array('We need a map.', 'I think we\'re lost.', 'We took a wrong turn.'); ?>
	
			<h2><?php echo $messages[mt_rand(0, 2)]; ?></h2>
	
			<h1>Server Error: 404 (Not Found)</h1>
	
			<hr>
	
			<h3>What does this mean?</h3>
	
			<p>We couldn't find the page you requested on our servers.</p>
	
			<p>Perhaps you would like to go to our <a href="{{{ URL::to('/') }}}">home page</a>?</p>
		</div>
	</div>
</section>
@stop
