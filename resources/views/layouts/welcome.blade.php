<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	@include('layouts.head')

	<body class="welcome">
	<img id="nav-toggle" src="{{ asset('images/menu.png') }}" class="menu_icon" />
		@include('layouts.nav')
		@yield('body')
		@include('layouts.footer')
	</body>
</html>