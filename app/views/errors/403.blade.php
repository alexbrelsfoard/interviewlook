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

			<h1>Restricted Access</h1>

			<h2>Server Error: 403 (Forbidden)</h2>

			<hr>

			<h3>What does this mean?</h3>

			<p>You're not supposed to be here. You've landed on a page that requires special access to view.</p>

			<p>Perhaps you would like to go to our <a href="{{{ URL::to('/') }}}">home page</a>?</p>
		</div>
	</div>
</section>
@stop
