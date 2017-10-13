@extends('layouts.main')

@section('title')
My LOOKBook
@stop
@section('page_title')
My LOOKBook
@stop

@section('body')

<section id="content">
	<div class="container">
		
		<h3>My Documents:</h3>
		
		<form>
			<button class="submit btn btn-primary">Upload New File</button>
		</form>
		
		<div class="clear"></div>
		
		<hr>
		
		<h3>My LOOKs&trade;</h3>
		
		<form action="/looks" method="get">
			<button class="submit btn btn-primary">Create New LOOK&trade;</button>
		</form>
		
		<div class="clear"></div>
	</div>
</section>
	
@stop