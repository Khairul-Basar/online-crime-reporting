<?php 

	$filepath = realpath(dirname(__FILE__));
	include_once $filepath.'/../lib/Session.php';
	Session::init();
 ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Online Crime Reporting System</title>
		<link rel="stylesheet" type="text/css" href="inc/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="inc/style.css">
		<link rel="stylesheet" href="inc/nivo-slider.css" type="text/css" media="screen" />

		<script type="text/javascript" src="inc/jquery.min.js"></script>
		<script type="text/javascript" src="inc/bootstrap.min.js"></script>
		<script src="https://kit.fontawesome.com/3eb6bbba69.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
		<script src="inc/jquery.nivo.slider.js" type="text/javascript"></script>
		<!-- <script src="inc/jquery.js" type="text/javascript"></script> -->

		<script type="text/javascript">
			$(window).load(function () {
				$('#slider').nivoSlider({
					effect: 'random',
					slices: 10,
					animSpeed: 500,
					pauseTime: 3000,
					startSlide: 0, //Set starting Slide (0 index)
					directionNav: false,
					directionNavHide: false, //Only show on hover
					controlNav: false, //1,2,3...
					controlNavThumbs: false, //Use thumbnails for Control Nav
					pauseOnHover: true, //Stop animation while hovering
					manualAdvance: false, //Force manual transitions
					captionOpacity: 0.8, //Universal caption opacity
					beforeChange: function () { },
					afterChange: function () { },
					slideshowEnd: function () { } //Triggers after all slides have been shown
					});
				});
		</script>
	</head>

	<?php 

		if (isset($_GET['action']) && $_GET['action'] == "logout") {
			Session::destroy();
		}
	 ?>

	<body>
		<!-- <div class="container"> -->
			<nav class="navbar navbar-inverse navbar-fixed-top">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="fontpage.php"><i class="fa fa-paper-plane" aria-hidden="true"></i> Online Crime Reporting System</a>
					</div>
					<ul class="nav navbar-nav pull-right">

						<?php 

							$user_id = Session::get("user_id");
							$userlogin = Session::get("login");
							if ($userlogin == true) {
						 ?>

						<li><a href="index.php"><span class="fa fa-home" aria-hidden="true"></span> Home</a></li>
						<li><a href="profile.php?user_id=<?php echo $user_id; ?>"><span class="fa fa-user" aria-hidden="true"></span> Profile</a></li>
						<li><a href="report_fir.php?user_id=<?php echo $user_id; ?>"><span class="fa fa-plus-square" aria-hidden="true"></span> Report FIR</a></li>
						<li><a href="view_fir.php?user_id=<?php echo $user_id; ?>"><span class="fa fa-eye" aria-hidden="true"></span> View FIR</a></li>
						<li><a href="?action=logout"><span class="fa fa-sign-out" aria-hidden="true"></span> Logout</a></li>

						<?php }else{ ?>

						<li><a href="login.php"><i class="fa fa-id-badge fa-lg" aria-hidden="true"></i> Login</a></li>
						<li><a href="register.php"><i class="fa fa-user-plus fa-lg" aria-hidden="true"></i> Register</a></li>

						<?php } ?>

					</ul>
				</div>
			</nav>
