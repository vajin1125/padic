<!DOCTYPE html>
<html lang="en" style="height:100%;">

<head>
	<title>Padic</title>
	<!-- META TAGS -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- FAV ICON(BROWSER TAB ICON) -->
	<link rel="shortcut icon" href="images/fav.ico" type="image/x-icon">
	<!-- GOOGLE FONT -->
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link href="https://fonts.googleapis.com/css?family=Poppins%7CQuicksand:500,700" rel="stylesheet">
	<!-- FONTAWESOME ICONS -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- ALL CSS FILES -->
	<link href="{{URL::to('/')}}/template/css/materialize.css" rel="stylesheet">
	<link href="{{URL::to('/')}}/template/css/style.css" rel="stylesheet">
	<link href="{{URL::to('/')}}/template/css/bootstrap.css" rel="stylesheet" type="text/css" />
	<!-- RESPONSIVE.CSS ONLY FOR MOBILE AND TABLET VIEWS -->
	<link href="{{URL::to('/')}}/template/css/responsive.css" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>


<body data-ng-app="" style="height:100%;">
	<div id="preloader">
		<div id="status">&nbsp;</div>
	</div>
	
	<section class="tz-register" style="height:100%;">
		<div class="log-in-pop">
			<div class="log-in-pop-left">
				<ul>
					<li>&nbsp;</li>
					<li>&nbsp;</li>
				</ul>
				<h1>Padic Login</h1>
				<p>Don't have an account? Create your account. It takes less then a minute.</p>
				<ul>
					<li>&nbsp;</li>
					<li>&nbsp;</li>
				</ul>
			</div>
			<div class="log-in-pop-right">
				<!-- <a href="#" class="pop-close" data-dismiss="modal"><img src="images/cancel.png" alt="" /></a> -->
				<h4>Login</h4>
				<p>Don't have an account? Create your account. It takes less then a minute.</p>
				<form method="POST" action="{{ route('login') }}" class="s12">
					{{ csrf_field() }}
					<div>
						<div class="input-field s12">
							<input type="text" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus class="validate">
							<label>Email</label>                                
						</div>
						@if ($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
					<div>
						<div class="input-field s12">
							<input  id="password" type="password" class="form-control" name="password" required class="validate">
							<label>Password</label>
						</div>
						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>
					<div>
						<div class="input-field s4">
							<input type="submit" value="Login" class="waves-effect waves-light log-in-btn"> </div>
					</div>
					<div>
						<div class="input-field s12"> <a href="{{ route('password.request') }}">Forgot password</a> | <a href="{{ route('register') }}">Create a new account</a> </div>
					</div>
				</form>
			</div>
		</div>
	</section>
	
	<script src="{{URL::to('/')}}/template/js/jquery.min.js"></script>
	<script src="{{URL::to('/')}}/template/js/angular.min.js"></script>
	<script src="{{URL::to('/')}}/template/js/bootstrap.js" type="text/javascript"></script>
	<script src="{{URL::to('/')}}/template/js/materialize.min.js" type="text/javascript"></script>
	<script src="{{URL::to('/')}}/template/js/custom.js"></script>
</body>

</html>