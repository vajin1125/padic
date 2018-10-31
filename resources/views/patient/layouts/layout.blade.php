<!DOCTYPE html>
<html lang="en">

<head>
	<title>padic</title>
	<!-- META TAGS -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- FAV ICON(BROWSER TAB ICON) -->
	<link rel="shortcut icon" href="{{URL::to('/')}}images/fav.ico" type="image/x-icon">
	<!-- GOOGLE FONT -->
	<link href="https://fonts.googleapis.com/css?family=Poppins%7CQuicksand:500,700" rel="stylesheet">

	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<!-- FONTAWESOME ICONS -->
	<link rel="stylesheet" href="{{URL::to('/')}}/template/css/font-awesome.min.css">
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
    <script src="{{URL::to('/')}}/template/js/jquery.min.js"></script>
</head>

<body>
	<div id="preloader">
		<div id="status">&nbsp;</div>
	</div>
	
	<!--== MAIN CONTRAINER ==-->
	<div class="container-fluid sb1">
		<div class="row">
			<!--== LOGO ==-->
			<!-- <div class="col-md-2 col-sm-3 col-xs-6 sb1-1"> <a href="#" class="btn-close-menu"><i class="fa fa-times" aria-hidden="true"></i></a> <a href="#" class="atab-menu"><i class="fa fa-bars tab-menu" aria-hidden="true"></i></a>
				<a href="index.html" class="logo"><img src="images/logo1.png" alt="" /> </a>
			</div>			 -->
			<!--== MY ACCCOUNT ==-->
			<div class="col-md-2 col-sm-3 col-xs-6 pull-right">
				<!-- Dropdown Trigger -->
				<a class='waves-effect dropdown-button top-user-pro' href='#' data-activates='top-menu'><img src="images/users/6.png" alt="" />My Account <i class="fa fa-angle-down" aria-hidden="true"></i> </a>
				<!-- Dropdown Structure -->
				<ul id='top-menu' class='dropdown-content top-menu-sty'>
					<li><a href="{{URL::to('/patient/profile')}}" class="waves-effect"><i class="fa fa-cogs"></i>Profile</a> </li>					
					<li>
						<!-- <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fa fa-sign-in" aria-hidden="true"></i>{{ __('Logout') }}
						</a> -->
						<a class="dropdown-item" href="{{URL::to('/logout')}}"><i class="fa fa-sign-in" aria-hidden="true"></i>Logout</a>
						<!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{csrf_field()}}
						</form> -->
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!--== BODY CONTNAINER ==-->
	<div class="container-fluid sb2">
		<div class="row">
			<div class="sb2-1">
				<!--== USER INFO ==-->
				<div class="tz-l-1">
					<ul>
						@php
							$photofile = Auth::user()->photofile;
							if($photofile == null) $photofile = 'user_photos/db-profile.jpg';
						@endphp
						<li><img src="{{URL::to('/')}}/{{$photofile}}" alt=""></li>
						<li></li>
					</ul>
				</div>
				<!--== LEFT MENU ==-->
				<div class="sb2-13">
					<ul class="collapsible" data-collapsible="accordion">
						<li><a href="{{URL::to('/patient/list')}}" class="menu-active"><i class="fa fa-users" aria-hidden="true"></i> Patient records.</a> </li>
						<li><a href="{{URL::to('/patient/edit')}}" class="menu-active"><i class="fa fa-user" aria-hidden="true"></i> Profile </a> </li>				
				</div>
			</div>
			<!--== BODY INNER CONTAINER ==-->
			<div class="sb2-2">
				<!--== breadcrumbs ==-->
				<div class="tz-2 tz-2-admin">
					<div class="tz-2-com tz-2-main">
                        @yield("content")
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--== BOTTOM FLOAT ICON ==-->
	<!-- <section>
	</section> -->
	<!--SCRIPT FILES-->
	<script src="{{URL::to('/')}}/template/js/jquery.min.js"></script>
	<script src="{{URL::to('/')}}/template/js/bootstrap.js" type="text/javascript"></script>
	<script src="{{URL::to('/')}}/template/js/materialize.min.js" type="text/javascript"></script>
	<script src="{{URL::to('/')}}/template/js/custom.js"></script>

	@stack('footer-script')
</body>

</html>