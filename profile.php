<?php 
	
	include 'lib/User.php'; 
	include 'inc/header.php'; 
	Session::checkSession();
?>

<?php 

	if (isset($_GET['id'])) {
		$userid = (int)$_GET['id'];
	}

	$user = new User();

	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){
			$userUpdate = $user->userUpdate($userid, $_POST);
	}

 ?>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>User Profile <span class="pull-right"><a class="btn btn-primary" href="index.php">Back</a></span></h2>
				</div>

				<div class="panel-body">
					<div style="max-width: 400px; margin: 0 auto">

						<?php 
							if (isset($userUpdate)) {
								echo $userUpdate;
							}
						 ?>

						<?php 
							$userData = $user->getUserID($userid);
							if ($userData) {
						?>

						<form action="" method="POST">

							<div class="form-group">
								<label for="name">Profile Name</label>
								<input type="text" id="name" name="name" class="form-control" value="<?php echo $userData->name; ?>">
							</div>

							<?php 
								$sesID = Session::get("id");
								if ($userid == $sesID) {
							 ?>

							<div class="form-group">
								<label for="username">User Name</label>
								<input type="username" id="username" name="username" class="form-control" value="<?php echo $userData->username; ?>" >
							</div>

							<div class="form-group">
								<label for="email">Email Address</label>
								<input type="text" id="email" name="email" class="form-control" value="<?php echo $userData->email; ?>" >
							</div>
							
							<button type="submit" name="update" class="btn btn-success">Update</button>

							<a class="btn btn-primary" href="Changepassword.php?id=<?php echo $userid; ?>">Change Password</a>

						<?php } ?>
						</form>

					<?php } ?>

					</div>
				</div>
			</div>


<?php include 'inc/footer.php'; ?>