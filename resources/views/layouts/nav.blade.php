<nav id="nav-right" class="bal_nav">
	<a id="nav-close" class="close" href="#">X</a>
	<ul>
		<li>
			<a class="bal_nav" href="{{ route('welcome') }}">Home</a>
		</li>
		@if(auth()->check())
		<li>
			<a class="bal_nav" href="{{ route('user.profile', auth()->user()->username) }}">My Profile</a>
		</li>
		<li>
			<a class="bal_nav" href="{{ route('look.looks') }}">Create a LOOK</a>
		</li>
		<li>
			<a class="bal_nav" href="{{ route('look.about') }}">About Us</a>
		</li>
		<li>
			<a class="bal_nav" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				Logout
			</a>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				{{ csrf_field() }}
			</form>
		</li>
		@else
		<li>
			<a class="bal_nav" href="{{ route('login') }}">Login</a>
		</li>
		<li>
			<a class="bal_nav" href="{{ route('register') }}">Register</a>
		</li>
		<li>
			<a class="bal_nav" href="{{ route('look.about') }}">About Us</a>
		</li>
		@endif
	</ul>
</nav>