<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	@include('layouts.head')

	<body class="welcome">
		<img src="{{ asset('images/menu.png') }}" class="menu_icon"  onclick="IL.toggleMenu();"/>
		@include('layouts.nav')
		@yield('body')
		@include('layouts.footer')
	</body>
</html>