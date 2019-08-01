<?php 
	include 'inc/header.php';
	include 'lib/User.php';

	$user = new User();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
			$userRegi = $user->userRegistration($_POST);
	}
?>

			
		<div class="backgroundimg">
			<div class="profile-container">
				<div class="register-container clear">
					<div class="register-box">
						<form action="register.php" method="POST">
							<h2>User Registration</h2>
							<?php if (isset($userRegi)) {
							echo $userRegi;
							} ?>

							<div class="form-group">
								<label for="name">Your Name</label>
								<input type="text" id="name" name="name" class="form-control" placeholder="Full Name" >
							</div>

							<div class="form-group">
								<label for="username">User Name</label>
								<input type="text" id="username" name="username" class="form-control" placeholder="UserName">
							</div>

							<div class="form-group">
								<label for="email"></i>Email Address</label>
								<input type="text" id="email" name="email" class="form-control" placeholder="Email Address">
							</div>

							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" id="password" name="password" class="form-control" placeholder="Password" >
							</div>
							<div class="form-group">
								<label for="confirm_password">Confirm Password:</label>
								<input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Re-Type Password" >
							</div>

							<button type="submit" name="register" class="btn btn-success">Registration</button>
						</form>
						
					</div>
					
				</div>
			</div>
		</div>


<?php include 'inc/footer.php'; ?>