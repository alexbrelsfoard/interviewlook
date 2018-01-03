<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>InterviewLook - @yield('title')</title>

	<!-- Styles -->
	<link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
	<!-- smoothness theme -->
	<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jquery.flexmenu.css') }}" rel="stylesheet">
	<link href="{{ asset('css/main.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	
	<script src="{{ asset('js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/jquery-ui.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script type="text/javascript" src="{{ asset('js/interviewlook.js') }}"></script>
	
	@yield('head_code')
</head>