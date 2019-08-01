<?php 
	include 'inc/header.php';
	include 'lib/User.php';
	Session::checkLogin();
	
	$user = new User();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
			$userLogin = $user->userLogin($_POST);
	}
?>
					
<div class="backgroundimg">
	
	<div class="login-container clear">
		<div class="login-box">
			<form action="" method="POST">
				<h2>Admin Login</h2>
				<?php if (isset($userLogin)) {
				echo $userLogin;
				} ?>
				<div class="form-group">
					<label for="email">Admin Email</label>
					<input type="text" id="email" name="email" class="form-control" >
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" id="password" name="password" class="form-control" >
				</div>
				<button type="submit" name="login" class="btn btn-success">Login</button>
			</form>
		</div>
	</div>

</div>

<?php include 'inc/footer.php'; ?>