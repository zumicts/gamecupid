<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
					<a href="{!! url('/crew/create') !!}"><i class="ion-ios-people"></i></a>
					<a href="{!! url('/invite') !!}"><i class="ion-plus"></i></a>
					<a href="{!! url('/notifications') !!}" id="notificationsLink">
						@if(Auth::user()->rNotifications()->where('read', false)->count() > 0)
						<i class="ion-android-notifications orange-text" id="not-icon"></i>
						<span class="orange-text" id="u-not-read-count">{{ Auth::user()->rNotifications()->where('read', false)->count() }}</span>
						@else
						<i class="ion-android-notifications-none" id="not-icon"></i>
						<span class="orange-text" id="u-not-read-count"></span>
						@endif
					</a>
					<a href="{!! url('/gamer/' . Auth::user()->username) !!}"><span class="hide-for-small">{{ Auth::user()->username }}</span><span class="show-for-small"><i class="ion-person"></i></span> <span class="header-rep-count"><b>{{ Auth::user()->level() }}</b>:{{ Auth::user()->rep() }}</span></a>
					<a href="{!! url('/settings') !!}">Settings</a>
					<a href="{!! url('/logout') !!}"><i class="ion-power"></i></a>
					@else
					<a href="{!! url('/login') !!}">Login / Register</a>
					@endif
				</div>
			</div>
		</div>
	</nav>

	@yield('page')

	<footer class="footer">
		<div class="row">
			<div class="medium-12 columns">
				<h5 class="super-header">GameCupid</h5>
				<br><br>
				<script type="text/javascript" src="//www.redditstatic.com/button/button1.js"></script>
			</div>
		</div>
	</footer>

	{!! HTML::script('bower_components/jquery/dist/jquery.min.js') !!}
	{!! HTML::script('js/moment.js') !!}
	{!! HTML::script('js/livestamp.js') !!}
	{!! HTML::script('js/app.js') !!}
	{!! HTML::script('js/voter.js') !!}
	@if(Auth::check())
	{!! HTML::script('js/notifier.js') !!}
	@endif
	@yield('scripts')
</body>
</html>