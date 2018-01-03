<nav>
	<a class="close" href="#" onclick="IL.toggleMenu();">X</a>
	<ul>
		<li>
			<a href="{{ route('welcome') }}">Home</a>
		</li>
		<li>
			<a href="{{ route('look.about') }}">About Us</a>
		</li>
		@if(auth()->check())
		<li>
			<a href="{{ route('user.profile', auth()->user()->username) }}">My Profile</a>
		</li>
		<li>
			<a href="{{ route('look.looks') }}">Create a look</a>
		</li>
		<li>
			<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				Logout
			</a>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				{{ csrf_field() }}
			</form>
		</li>
		@else
		<li>
			<a href="{{ route('login') }}">Login</a>
		</li>
		<li>
			<a href="{{ route('register') }}">Register</a>
		</li>
		<li>
			<a href="{{ route('look.demos') }}">Demos</a>
		</li>
		@endif
	</ul>
</nav>