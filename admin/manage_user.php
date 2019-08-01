<?php 
	include 'lib/User.php'; 
	include 'inc/header.php'; 
	Session::checkSession();

	
	if (isset($_GET['user_id'])) {
		$user_id = (int)$_GET['user_id'];
	}

	$user = new User();


?>
	<div class="indeximg">
		<div class="profile-container clear">
			<div class="profile-head clear">
				<h2><span class="fa fa-user-circle" aria-hidden="true"></span> Users List</h2>
			</div>
			<div class="userlist-box clear">
					<!-- <h2><span class="fa fa-user-circle" aria-hidden="true"></span> Users List</h2> -->
				

			
					<table>
						<tr>
							<th width="20%">Serial</th>
							<th width="20%">Name</th>
							<th width="20%">UserName</th>
							<th width="20%">Email</th>
							<th width="20%">Action</th>
						</tr>

						<?php 

							$userData = $user->getUserData();
							if ($userData) {
								$i = 0;
								foreach ($userData as $sData) {
									$i++;
									
						?>

						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $sData['name']; ?></td>
							<td><?php echo $sData['username']; ?></td>
							<td><?php echo $sData['email']; ?></td>
							<td>
								<a class="btn btn-primary" href="view_user.php?user_id=<?php echo $sData['user_id']; ?>">Edit</a>
							</td>
						</tr>

		<?php
		 	  	}
			}else{ ?>

				<tr><td colspan="5"><h2>No User Data Found</h2></td></tr>

			<?php } ?>
		

					</table>
			</div>
			<div class="userlist-footer clear">
				<p>&copy; copyright Developed by Ripa Roy.</p>
			</div>
		</div>

	</div>
				




							

									

										