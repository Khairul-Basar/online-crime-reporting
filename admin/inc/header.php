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
		<script type="text/javascript" src="inc/jquery.min.js"></script>
		<script type="text/javascript" src="inc/bootstrap.min.js"></script>
		<script src="https://kit.fontawesome.com/3eb6bbba69.js"></script>
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
						<a class="navbar-brand" href="index.php"><i class="fa fa-paper-plane" aria-hidden="true"></i> Online Crime Reporting System</a>
					</div>
					<ul class="nav navbar-nav pull-right">

						<?php 

							$user_id = Session::get("user_id");
							$userlogin = Session::get("admin_login");
							if ($userlogin == true) {
								if ($user_id) {
						 ?>

						<li><a href="index.php"><span class="fa fa-home" aria-hidden="true"></span> Home</a></li>
						<li><a href="profile.php?user_id=<?php echo $user_id; ?>"><span class="fa fa-user" aria-hidden="true"></span> Admin_Profile</a></li>
						<li><a href="manage_user.php?user_id=<?php echo $user_id; ?>"><span class="fa fa-plus-square" aria-hidden="true"></span> Manage Users</a></li>
						<li><a href="manage_fir.php?user_id=<?php echo $user_id; ?>"><span class="fa fa-eye" aria-hidden="true"></span> Manage FIR</a></li>
						<li><a href="?action=logout"><span class="fa fa-sign-out" aria-hidden="true"></span> Logout</a></li>

							<?php }else{
								header("Location:../login.php");
							} ?>

						<?php }else{ ?>

						<li><a href="login.php"><i class="fa fa-id-badge fa-lg" aria-hidden="true"></i> Login</a></li>

						<?php } ?>

					</ul>
				</div>
			</nav>
