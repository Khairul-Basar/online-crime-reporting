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

	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){
			$userUpdate = $user->userUpdate($userid, $_POST);
	}

 ?>

	<div class="indeximg">
		<div class="profile-container clear">
			<div class="profile-head clear">
				<h2><span class="fa fa-user-circle" aria-hidden="true"></span> Admin Profile </h2>
				<a class="btn btn-primary" href="index.php">Back</a>
			</div>
			<div class="profile-box">	
				

						<?php 
							if (isset($userUpdate)) {
								echo $userUpdate;
							}
						 ?>

						<?php 
							$userData = $user->getAdminID($userid);
							if ($userData) {
						?>

						<form action="" method="POST">

							<div class="form-group">
								<label for="name">Admin Name</label>
								<input type="text" id="name" name="name" class="form-control" value="<?php echo $userData->name; ?>">
							</div>

							<?php 
								$sesID = Session::get("user_id");
								if ($userid == $sesID) {
							 ?>

							<div class="form-group">
								<label for="username">Admin User Name</label>
								<input type="username" id="username" name="username" class="form-control" value="<?php echo $userData->username; ?>" >
							</div>

							<div class="form-group">
								<label for="email">Admin Email</label>
								<input type="text" id="email" name="email" class="form-control" value="<?php echo $userData->email; ?>" >
							</div>
							
							<button type="submit" name="update" class="btn btn-success">Update</button>

							<a class="btn btn-primary" href="Changepassword.php?user_id=<?php echo $userid; ?>">Change Password</a>

						<?php } ?>
						</form>
					<?php } ?>

			</div>
			<div class="profile-footersection clear">
				<p>&copy; copyright Developed by Ripa Roy.</p>
			</div>
		</div>
	</div>


<?php include 'inc/footer.php'; ?>