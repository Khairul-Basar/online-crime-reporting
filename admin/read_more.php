<?php 
	include 'lib/User.php'; 
	include 'inc/header.php'; 
	Session::checkSession();
	$sesID = Session::get("user_id");
	
	if (isset($_GET['fir_id'])) {
		$fir_id = (int)$_GET['fir_id'];
	}
	$sesID = Session::get("user_id");
	$user = new User();

	// if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])){
	// 		$createComment = $user->createComment($sesID,$fir_id,$_POST);
	// }

?>
	<div class="indeximg">
		<div class="profile-container">
		<div class="container">
			<div class="panel panel-info" style="margin-top: 70px;">
				<div class="panel-heading">
					<h2>Read_More FIR <span class="pull-right"><a class="btn btn-primary" href="index.php">Back</a></span></h2>
				</div>

				<div class="panel-body">
					<div style="max-width: 1200px; margin: 0 auto">
						
						<?php 
							$read_more = $user->getRead_More();

							if ($read_more) {
							foreach ($read_more as $sData) {
							if ($fir_id == $sData['fir_id']) {
								
							
						?>
						<div class="well">
								
							<h4><label> Crime Name: </label><span><?php echo $sData['crime']; ?></span></h4>
							<h4><label>Police Station: </label><span><?php echo $sData['police_station']; ?></span></h4>
							<h4><label>Criminals Name:</label>  <span><?php echo $sData['criminals']; ?></span></h4>

							<h4 class="blog-post-meta"><label><?php echo $user->formatDate( $sData['crime_date']);?></label> <span>By <?php echo $sData['username']; ?></span></h4>
							<!-- <p class="blog-post-meta"><label><?php echo $sData['crime_date']; ?> , By <?php echo $sData['username']; ?></label></p> -->

							<div class="details">
								<p>
									<?php echo $sData['crime_nature']; ?>
								</p>
							</div>
								

								
							
						</div>
						
						<?php } } } ?>

								
								
							<?php 

									$getComments = $user->getComments($fir_id);
									if ($getComments) {
									foreach ($getComments as $sData) {
								?>
								
								<div class="readmore-comment clear">
									<label><?php echo $sData['username']; ?></label>
									<p> <?php echo $sData['comment']; ?></p>
								</div>

								<!-- <div class="form-group well" style="margin-top: 10px;">
									<p><label><?php echo $sData['username']; ?></label>: <?php echo $sData['comment']; ?></p>
								</div> -->
							
							<?php } } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="index-footersection templete clear">
			<p>&copy; copyright Developed by Ripa Roy.</p>
		</div>
		</div>
	</div>