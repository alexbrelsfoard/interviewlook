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

			<h1 style="margin-bottom: 40px;">Unauthorized Access</h1>

			<p>You're not supposed to be here. You've landed on a page that requires special access to view.</p>

			<p>Perhaps you would like to go to our <a href="{{{ URL::to('/') }}}">home page</a>?</p>
		</div>
	</div>
</section>
@stop
