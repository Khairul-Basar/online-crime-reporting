<?php 
	
	include 'lib/User.php'; 
	include 'inc/header.php';
	Session::checkSession();
	$user = new User();

?>

<div class="indeximg">
	<div class="profile-container">
		<div class="container">

			<div class="panel panel-success" style="margin-top: 70px;">
				
				<div class="panel-heading">
					<h2><span class="fa fa-home" aria-hidden="true"></span> All Active Posts </h2>
				</div>
				

				<div class="panel-body">
					<div style="max-width: 1200px; margin: 0 auto">
						
						<?php 

							$getActivePost = $user->getActivePost();
							if ($getActivePost) {
								foreach ($getActivePost as $sData) {
									if ($sData['activity'] == 'Active') {
						?>

						<div class="well">	

							<?php if ($sData['activity'] == 'Active') { ?>
								<p class="alert alert-success pull-right"><?php echo $sData['activity']; ?></p>
							<?php } ?>

							<h4><label> Crime Name: </label><span><?php echo $sData['crime']; ?></span></h4>
							<h4><label>Police Station: </label><span><?php echo $sData['police_station']; ?></span></h4>
							<h4><label>Criminals Name:</label>  <span><?php echo $sData['criminals']; ?></span></h4>
							<h4 class="blog-post-meta"><label><?php echo $user->formatDate( $sData['crime_date']);?></label> <span>By <?php echo $sData['username']; ?></span></h4>
							<!-- <p class="blog-post-meta"><label><?php echo $user->formatDate( $sData['crime_date']);?> , By <?php echo $sData['username']; ?> </label></p> -->

							<div class="details">
								<p><?php echo $user->text_Shorten($sData['crime_nature']); ?>
									<a class="btn btn-primary" href="readmore.php?fir_id=<?php echo $sData['fir_id']; ?>">Read More</a>
								</p>
							</div>
						</div>
						<?php
									} ?>

										
						<?php 		
								}
							}else{ ?>
									<h2 class="alert alert-warning text-center">No Active Data Approved By Admin.</h2>
							<?php } ?>	

							
		
						
					</div>
				</div>
			</div>
		</div>
		<div class="index-footersection templete clear">
			<p>&copy; copyright Developed by Ripa Roy.</p>
		</div>
	</div>
</div>