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

	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])){
			$user_Delete = $user->user_Delete($userid);
	}

 ?>


 	<div class="indeximg">
		<div class="profile-container clear">
			<div class="profile-head clear">
				<h2><span class="fa fa-user-circle" aria-hidden="true"></span> View User </h2>
				<a class="btn btn-primary" href="manage_user.php?user_id=1">Back</a>
			</div>
			<div class="userdetails-box clear">	
			
					<!-- <h2><span class="fa fa-user-circle" aria-hidden="true"></span> View User <span class="pull-right"><a class="btn btn-primary" href="manage_user.php?user_id=1">Back</a></span></h2> -->
				
				


						<?php 
							$userData = $user->getUserID($userid);
							if ($userData) {
						?>

						<form action="" method="POST">

							<table>

								<tr>
									<th width="20%">User Field</th>
									<th width="20%">User Data</th>
								</tr>
								<tr>
									<td>Name: </td>
									<td><?php echo  $userData->name; ?></td>
								</tr>
								<tr>
									<td>User Name: </td>
									<td><?php echo $userData->username; ?></td>
								</tr>
								<tr>
									<td>User Email: </td>
									<td><?php echo $userData->email; ?></td>
								</tr>
								
							</table>
							<button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are You Sure Delete this User..?');">Delete User</button>
						</form>
					<?php } ?>
			</div>
			<div class="userlist-footer clear">
				<p>&copy; copyright Developed by Ripa Roy.</p>
			</div>
		</div>
	</div>

					


<?php include 'inc/footer.php'; ?>