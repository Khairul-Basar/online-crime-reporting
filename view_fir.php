<?php 
	include 'lib/User.php'; 
	include 'inc/header.php'; 
	Session::checkSession();

	
	if (isset($_GET['user_id'])) {
		$userid = (int)$_GET['user_id'];
	}

	$user = new User();
	$db = new Database();
?>


	<div class="indeximg">
		<div class="container">
			<div class="panel panel-info" style="margin-top: 70px;">

				<div class="panel-heading">
					<h2><span class="fa fa-eye" aria-hidden="true"></span> View FIR</h2>
				</div>

				<div class="panel-body">
					<div style="max-width: 1200px; margin: 0 auto">
						
						<?php 
							$view_fir = $user->getView_FIR();
							$sesID = Session::get("user_id");
							if ($view_fir) {
							foreach ($view_fir as $sData) {
								 if ($userid == $sData['user_id']) {
								 	if ($userid == $sesID) {
						?>
						<div class="well">
								
								<?php if ($sData['activity'] == 'Pending') { ?>
									<p class="alert alert-danger pull-right"><?php echo $sData['activity']; ?></p>
								<?php }elseif ($sData['activity'] == 'Active') { ?>
									<p class="alert alert-success pull-right"><?php echo $sData['activity']; ?></p>
								<?php }elseif ($sData['activity'] == 'Deactive') { ?>
									<p class="alert alert-info pull-right"><?php echo $sData['activity']; ?></p>
								<?php } ?>

								<h4><label> Crime Name: </label><span><?php echo $sData['crime']; ?></span></h4>

								<!-- <h4>Crime Name: <label>__<?php echo $sData['crime']; ?>__</label></h4> -->
								<h4><label>Police Station: </label><span><?php echo $sData['police_station']; ?></span></h4>
								<h4><label>Criminals Name:</label>  <span><?php echo $sData['criminals']; ?></span></h4>
								<h4 class="blog-post-meta"><label><?php echo $user->formatDate( $sData['crime_date']);?></label> <span>By <?php echo $sData['username']; ?></span></h4>

								<!-- <p class="blog-post-meta"><label><?php echo $user->formatDate($sData['crime_date']); ?> , By <?php echo $sData['username']; ?></label></p> -->

								<div class="details">
									<p><?php echo $user->text_Shorten($sData['crime_nature']); ?>
										<a class="btn btn-info" href="readmore.php?fir_id=<?php echo $sData['fir_id']; ?>&&user_id=<?php echo $userid; ?>">Read More</a>
									</p>

								</div>

								<!-- <p><?php echo $user->text_Shorten($sData['crime_nature']); ?></p> -->

								

								
							
						</div>
						
						<?php } } }  ?>
					
					</div>
				</div>
			</div>
		</div>
		<div class="index-footersection templete clear">
			<p>&copy; copyright Developed by Ripa Roy.</p>
		</div>
	</div>
			
			<?php } ?>



							

									

										