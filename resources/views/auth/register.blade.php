<!DOCTYPE html>
<html lang="en">

<head>
	<title>Padic/Register</title>
	<!-- META TAGS -->
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<!-- FAV ICON(BROWSER TAB ICON) -->
	<link rel="shortcut icon" href="images/fav.ico" type="image/x-icon">
	<!-- GOOGLE FONT -->
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

<body data-ng-app="">
	<div id="preloader">
		<div id="status">&nbsp;</div>
	</div>	
	<section class="tz-register">
			<div class="log-in-pop">
				<div class="log-in-pop-left">
					<ul>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
					</ul>
					<h1>Padic Register<span></span></h1>
					<p>Don't have an account? Create your account. It takes less then a minute.</p>
					<ul>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
						<li>&nbsp;</li>
					</ul>
				</div>
				<div class="log-in-pop-right">
					<!-- <a href="#" class="pop-close" data-dismiss="modal"><img src="images/cancel.png" alt="" /></a> -->
					<h4>Create an Account</h4>
					<p>Don't have an account? Create your account. It takes less then a minute.</p>
					<form class="s12" method="POST" action="{{ route('register') }}">
                        {{csrf_field()}}
						<div class="">
						<div class="row">
							<div class="input-field col s3">
								<select size="10" id="role" name="role" onchange="sel_role()" required>
									<option value="physician" selected > Physician  </option>
									<option value="patient" > Patient </option>
									<option value="subAdmin" > Staff </option>
								</select>
							</div>
							<div id="spec" class="input-field col s9">
								<input type="text" name="spec" class="validate" >
								<label>Physician Speciality</label>
                            </div>
                            @if ($errors->has('spec'))
								<div class="input-field col s4">
									<span class="invalid-feedback" role="alert">
                                    	&nbsp;
                                	</span>
								</div>
								<div class="input-field col s4">
                                	<span class="invalid-feedback" role="alert">
                                    	<strong>{{ $errors->first('spec') }}</strong>
                                	</span>
								</div>
                            @endif
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input type="text" name="firstname" data-ng-model="name1" class="validate" required>
								<label>First Name</label>
                            </div>
                            @if ($errors->has('firstname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('firstname') }}</strong>
                                </span>
                            @endif
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input type="text" name="lastname" class="validate" required>
								<label>Last Name</label>
                            </div>
                            @if ($errors->has('lastname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('lastname') }}</strong>
                                </span>
                            @endif
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input type="email" name="email" class="validate" required>
								<label>Email Address</label>
                            </div>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
						</div>
						{{-- Phone number feilds --}}
						<div class="row">
							<div class="input-field col s12">
								<input type="tel" name="phone1" class="validate" required>
								<label>Phone Number 1</label>
                            </div>
                            @if ($errors->has('phone1'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone1') }}</strong>
                                </span>
                            @endif
							<div class="input-field col s12">
								<input type="tel" name="phone2" class="validate">
								<label>Phone Number 2</label>
                            </div>
							<div class="input-field col s12">
								<input type="tel" name="phone3" class="validate">
								<label>Phone Number 3</label>
                            </div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input type="password" name="password" class="validate" required>
                                <label>Password</label>                                
                            </div>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
						</div>
						<div class="row">
							<div class="input-field col s12">
								<input type="password" name="password_confirmation" class="validate" required>
								<label>Confirm password</label>
							</div>
                        </div>
						<div class="row">
							<div class="input-field col s3">
                                <input type="submit" value="Register" class="waves-effect waves-light log-in-btn">
                            </div>
						</div>
						<div>
							<div class="input-field col s12"> <a href="{{ route('login') }}">Are you a already member ? Login</a> </div>
						</div>
						</div>
					</form>
				</div>
			</div>
	</section>
	
	<section class="copy">
		<div class="container">
			<p>Padic © 2018 Developed by Team </p>
		</div>
	</section>
	
	<!--SCRIPT FILES-->
	<script src="{{URL::to('/')}}/template/js/jquery.min.js"></script>
	<script src="{{URL::to('/')}}/template/js/angular.min.js"></script>
	<script src="{{URL::to('/')}}/template/js/bootstrap.js" type="text/javascript"></script>
	<script src="{{URL::to('/')}}/template/js/materialize.min.js" type="text/javascript"></script>
	<script src="{{URL::to('/')}}/template/js/custom.js"></script>
</body>
</html>

<script>
	function sel_role() {
		var role = $("#role").val();
		if( role == 'physician'){ 
			$("#spec").css("display", "");
		}
		else { 
			$("#spec").css("display", "none");
		}
	}
</script>