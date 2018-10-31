<!DOCTYPE html>
<html lang="en" style="height:100%;">

<head>
	<title>Padic/Reset Password</title>
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
			<div class="log-in-pop-left" style="padding-top:100px;padding-bottom:200px;">
				<h1>Padic<span></span></h1>
				<p>Please enter your email address</p>
			</div>
			<div class="log-in-pop-right">
				<!-- <a href="#" class="pop-close" data-dismiss="modal"><img src="images/cancel.png" alt="" /></a> -->
				<h4</h4>
				<ul><li>&nbsp;</li></li>
				<p>Email Address</p>
				@if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status') }}
					</div>
				@endif
				<form class="s12" method="POST" action="{{ route('password.email') }}">
					{{csrf_field()}}
					<div>
						<div class="input-field s6">
							<input type="email" name="email" id="email" data-ng-model="name1" class="validate" value="{{ $email ?? old('email') }}" required title="email">
							<label>Email Address</label>
						</div>
						@if ($errors->has('email'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
					<div>
						<div class="input-field s4">
							<input type="submit" value="Send Password Reset Link" class="waves-effect waves-light log-in-btn">
						</div>
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