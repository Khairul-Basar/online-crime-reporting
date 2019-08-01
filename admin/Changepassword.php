<?php 
	
	include 'lib/User.php'; 
	include 'inc/header.php'; 
	Session::checkSession();
?>

<?php 

	if (isset($_GET['user_id'])) {
		$userid = (int)$_GET['user_id'];
	}

	$user = new User();

	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['passwordUpdate'])){
			$passwordUpdate = $user->passwordUpdate($userid, $_POST);
	}

 ?>
 	<div class="indeximg">
		<div class="profile-container clear">
			<div class="profile-head clear">
				<h2><span class="fa fa-user-circle" aria-hidden="true"></span> Change Password </h2>
				<a class="btn btn-primary" href="profile.php?user_id=<?php echo $userid; ?>">Back</a>
			</div>
			<div class="profile-box">
			

						<?php 
							if (isset($passwordUpdate)) {
								echo $passwordUpdate;
							}
						 ?>

						<form action="" method="POST">

							<div class="form-group">
								<label for="old_password">Old Password</label>
								<input type="password" id="old_password" name="old_password" class="form-control">
							</div>

							

							<div class="form-group">
								<label for="new_password">New Password</label>
								<input type="password" id="new_password" name="new_password" class="form-control" >
							</div>
							
							<button type="submit" name="passwordUpdate" class="btn btn-success">Update</button>

						</form>

					</div>
					<div class="changePassword-footersection clear">
						<p>&copy; copyright Developed by Ripa Roy.</p>
					</div>
		</div>
	</div>


<?php include 'inc/footer.php'; ?>