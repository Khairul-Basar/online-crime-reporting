<?php 
	include 'lib/User.php'; 
	include 'inc/header.php'; 
	Session::checkSession();

	
	if (isset($_GET['user_id'])) {
		$user_id = (int)$_GET['user_id'];
	}

	$user = new User();

	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['report'])){
			$createReport = $user->createReport($user_id,$_POST);
	}

?>

	<div class="indeximg">
		<div class="profile-container clear">
			<div class="profile-head clear">
				<h2><span class="fa fa-plus-square" aria-hidden="true"></span> Report FIR</h2>
				
			</div>
			<div class="profile-box">
					<!-- <h2><span class="fa fa-plus-square" aria-hidden="true"></span> Report FIR</h2> -->
				

				

						<?php 
							
							if (isset($createReport)) {
							echo $createReport;
							} 
						?>
						
						<form action="" method="POST">
							<?php 
								
								$sesID = Session::get("user_id");
								if ($user_id == $sesID) {
							 ?>

							<!--  <div class="form-group">

								<label for="user_id" name="user_id"  value="<?php echo $user_id; ?>" ></label>
							</div> -->

							<div class="form-group">
								<label for="crime">Crime</label><br>
								<input type="text" id="crime" name="crime" class="form-control">
							</div>

							<div class="form-group">
								<label for="crime_nature">Details</label><br>
								<textarea class="form-control" name="crime_nature" cols="47" rows="4"></textarea>
							</div>

							<div class="form-group">
								<label for="police_station">Police Station</label>
								<input type="text" id="police_station" name="police_station" class="form-control">
							</div>

							<div>
								<label for="criminals">Criminals</label>
								<input type="text" id="criminals" name="criminals" class="form-control">
							</div>

							<div class="form-group">
								<label for="address">Address</label>
								<input type="text" id="address" name="address" class="form-control">
							</div>

							<div class="form-group">
								<label for="date">Date</label>
								<input type="date" id="date" name="crime_date" class="form-control">
							</div>

							<button type="submit" name="report" class="btn btn-success">Create Report</button>
						<?php } ?>
						</form>
			</div>
				
			<div class="report-footersection clear">
					<p>&copy; copyright Developed by Ripa Roy.</p>
				</div>
		</div>
	</div>




							

									

										