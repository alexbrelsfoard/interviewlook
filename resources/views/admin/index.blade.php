@extends('layouts.main')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('body')
<style type="text/css">
	footer{
		display: none;
	}
	.panel {
		border: none;
	}
	.panel a{
		color: #555;
		text-decoration: none;
		display: inline-block;
		width: 100%;
		margin: 0;
		border: 1px solid #d2d2d2;
	}
	.panel a:hover{
		color: #333;
		background: #fbfbfb;
		border: 1px solid #29acff;
	}
	.panel a i {
		display: block; font-size: 40px;
	}
	.panel a span {
		font-size: 16px;margin: 11px;display: block;text-transform: uppercase;
	}
</style>
<section id="content">
	<div class="container">
		
		<div class="row col-md-12">
			<div class="col-md-12 ">
				<ol class="breadcrumb">
				  <li class="active">Dashboard</li>
				</ol>			
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<a class="panel-body text-center" href="{{ route('dashboard.users') }}">
						<i class="glyphicon glyphicon-user"></i>
						<span>All Users</span>
					</a>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<a class="panel-body text-center" href="{{ route('dashboard.videos') }}">
						<i class="glyphicon glyphicon-facetime-video"></i>
						<span>All Videos</span>
					</a>
				</div>
			</div>
		</div>
		
	</div>
</section>
	
@endsection