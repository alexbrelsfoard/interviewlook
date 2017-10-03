@extends('layouts.main')

@section('title')
My Submitted LOOKs
@stop
@section('page_title')
My Submitted LOOKs
@stop

@section('body')

<section id="content">
	<div class="container">
		
		<table class="job_applications" cellspacing="0">
			<thead>
				<tr>
					<th>Position</th>
					<th>Company</th>
					<th>Date Applied</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>PHP Developer</td>
					<td>Toad Sprockets</td>
					<td>2017-01-01</td>
				</tr>
				<tr >
					<td>Lead Developer</td>
					<td>Toad Sprockets</td>
					<td>2017-01-01</td>
				</tr>
				<tr>
					<td>Python Developer</td>
					<td>Toad Sprockets</td>
					<td>2017-02-01</td>
				</tr>
				<tr>
					<td>Full Stack Developer</td>
					<td>Toad Sprockets</td>
					<td>2017-01-21</td>
				</tr>
				<tr>
					<td>PHP Egineer</td>
					<td>Toad Sprockets</td>
					<td>2017-03-11</td>
				</tr>
				<tr>
					<td>Senior PHP Developer</td>
					<td>Toad Sprockets</td>
					<td>2017-04-06</td>
				</tr>
				<tr>
					<td>Principle PHP Developer</td>
					<td>Toad Sprockets</td>
					<td>2017-03-07</td>
				</tr>
				<tr>
					<td>PHP Developer</td>
					<td>Toad Sprockets</td>
					<td>2017-07-11</td>
				</tr>
			</tbody>
		</table>
		
		<ul class="pagination">
			<li class="active">1</li>
			<li>2</li>
			<li>3</li>
		</ul>
		
		
	</div>
</section>
	
@stop