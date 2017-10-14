<!DOCTYPE html>
<head>
	<title>InterviewLook - @yield('title')</title>
	@section('head')
	<link href="{{ URL::asset('css/jquery-ui.css') }}" rel="stylesheet"><!-- smoothness theme -->
	<link href="{{ URL::asset('css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/jquery.flexmenu.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/main.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	
    <script src="{{ URL::asset('js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
	<script src="{{ URL::asset('js/jquery-ui.min.js') }}" type="text/javascript" ></script>
	<script type="text/javascript" src="{{ URL::asset('js/interviewlook.js') }}"></script>
	@show
	@yield('head_code')
</head>
<body>
	<header>
		<a href="/"><img class="logo" src="/images/Interview-Look.png"></a>
		<img src="/images/menu.png" class="menu_icon"  onclick="IL.toggleMenu();"/>
		<h1>@yield('page_title')</h1>
	</header>
	<?php $menu = User::buildMenu(); ?>
	<nav>
		<a class="close" href="#" onclick="IL.toggleMenu();">X</a>
		<ul>
			<?php foreach ($menu as $page => $link) {?>
			<li><a href="<?= $link ?>"><?= $page ?></a></li>
			<?php } ?>
		</ul>
	</nav>

@yield('body')

<footer>
	<div id="credits">
		<div class="container-fluid text-center">
			<div class="row">
				<div class="col-md-9 footer-text">
	&nbsp;
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