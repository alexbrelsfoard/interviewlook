<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.head')

<body>
	<header>
		<a href="{{ route('welcome') }}">
			<img class="logo" src="{{ asset('images/Interview-Look.png') }}">
		</a>
		<img id="nav-toggle" src="{{ asset('images/menu.png') }}" class="menu_icon" />
		<h1>@yield('page_title')</h1>
	</header>
	@include('layouts.nav') 
	@yield('body') 
	@include('layouts.footer')
</body>

</html>