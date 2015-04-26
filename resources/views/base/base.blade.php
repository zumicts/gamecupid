<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>GameCupid</title>
	{!! HTML::style('stylesheets/app.css') !!}
</head>
<body>
	<nav class="topnav">
		<div class="row">
			<div class="medium-12 columns">
				<div class="left">
					<a class="brand" href="{!! url('/') !!}">gamecupid</a>
				</div>
				<div class="right">
					@if(Auth::check())
					<a href="{!! url('/invite') !!}"><i class="ion-plus"></i></a>
					<a href="{!! url('/notifications') !!}"><i class="ion-android-notifications-none"></i></a>
					<a href="{!! url('/account') !!}">{{ Auth::user()->username }}:<span class="rep-count">{{ Auth::user()->rep() }}</span></a>
					<a href="{!! url('/logout') !!}">Logout</a>
					@else
					<a href="{!! url('/login') !!}">Login / Register</a>
					@endif
				</div>
			</div>
		</div>
	</nav>

	@yield('page')

	<footer class="footer"></footer>

	{!! HTML::script('bower_components/jquery/dist/jquery.min.js') !!}
	{!! HTML::script('js/app.js') !!}
	@if(Auth::check())
	{!! HTML::script('js/notifier.js') !!}
	@endif
</body>
</html>