<div id="close-overlay" style="position: fixed;top: 0;bottom: 0;left: 0;right: 0;background: #0006;z-index: 99; display:none;"></div>
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
				<a class="bal_nav" href="{{ route('look.index') }}">My Looks</a>
			</li>
			<li>
				<a class="bal_nav" href="{{ route('look.create') }}">Create new Look</a>
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
			@if( \App\User::isAdmin(Auth()->user()->id) )
				<li style="margin-top: 10px;">
					<a class="btn btn-success bal_nav" href="{{ route('dashboard.index') }}">Admin Dashboard</a>
				</li>
			@endif
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