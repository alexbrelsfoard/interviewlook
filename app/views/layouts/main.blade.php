<!DOCTYPE html>
<head>
	<title>InterviewLook - @yield('title')</title>
	@section('head')
	<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="stylesheet">
	<link href="{{ URL::asset('css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/jquery.flexmenu.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/main.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<script type="text/javascript" src="{{ URL::asset('js/flexmenu.min.js') }}">
	
	@show
</head>
<body>
@yield('body')

<footer>
	<div id="credits">
		<div class="container-fluid text-center">
			<div class="row">
				<div class="col-md-9 footer-text">
					<h5>
						Designed & Developed by
						<a href="http://www.clorida.com" target="_blank">CLORIDA</a>
					</h5>
				</div>
				<div class="col-md-3 footer-socialicon">
					<ul>
						<li>
							<i class="fa fa-facebook" aria-hidden="true"></i>
						</li>
						<li>
							<i class="fa fa-twitter" aria-hidden="true"></i>
						</li>
						<li>
							<i class="fa fa-google-plus" aria-hidden="true"></i>
						</li>
						<li>
							<i class="fa fa-instagram" aria-hidden="true"></i>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>
</body>
</html>