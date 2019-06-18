<?php 
	include 'lib/User.php'; 
	include 'inc/header.php'; 
	Session::checkSession();

	
	if (isset($_GET['id'])) {
		$userid = (int)$_GET['id'];
	}

	$user = new User();

	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['report'])){
			$createReport = $user->createReport($userid,$_POST);
	}

?>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Report FIR</h2>
				</div>

				<div class="panel-body">
					<div style="max-width: 400px; margin: 0 auto">

						<?php 
							
							if (isset($createReport)) {
							echo $createReport;
							} 
						?>
						
						<form action="" method="POST">
							<?php 

								$sesID = Session::get("id");
								if ($userid == $sesID) {
							 ?>
							<div class="form-group">
								<?php 
									$crimeType = $user->getCrimeType();
								?>
								<label>Crime Type: </label>
								<select id="crime_type" name="crime_type" required="1">
									<option value="select">--Select--</option>
									<?php 

									if ($crimeType) {
									foreach ($crimeType as $sData) {

									?>
									<option value="<?php echo $sData['crime_id']; ?>"><?php echo $sData['crime_name']; ?></option>
									<?php 
										}
									}
									?>
								</select>
							</div>

							<div class="form-group">
								<label for="crime_nature">Crime Nature</label><br>
								<textarea class="form-control" name="crime_nature" cols="47" rows="4"></textarea>
							</div>

							<div class="form-group">
								<label for="police_station">Police Station</label>
								<input type="text" id="police_station" name="police_station" class="form-control">
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
				</div>
			</div>




							

									

										