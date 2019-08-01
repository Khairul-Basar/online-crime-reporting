<?php 
	
	include 'lib/User.php'; 
	include 'inc/header.php';
	Session::checkSession();
	$user = new User();

?>

<div class="indeximg">
	<div class="profile-container">
		<div class="container">

			<div class="panel panel-warning" style="margin-top: 70px;">
				
				<div class="panel-heading">
					<h2><span class="fa fa-home" aria-hidden="true"></span> All Deactive Posts </h2>
				</div>
				

				<div class="panel-body">
					<div style="max-width: 1200px; margin: 0 auto">
						
						<?php 

							$getPendingPost = $user->getPendingPost();
							if ($getPendingPost) {
								foreach ($getPendingPost as $sData) {
									if ($sData['activity'] == 'Deactive') {
						?>

						<div class="well">	

							<?php if ($sData['activity'] == 'Deactive') { ?>
								<p class="alert alert-info pull-right"><?php echo $sData['activity']; ?></p>
							<?php } ?>

							<h4><label> Crime Name: </label><span><?php echo $sData['crime']; ?></span></h4>
							<h4><label>Police Station: </label><span><?php echo $sData['police_station']; ?></span></h4>
							<h4><label>Criminals Name:</label>  <span><?php echo $sData['criminals']; ?></span></h4>
							<h4 class="blog-post-meta"><label><?php echo $user->formatDate( $sData['crime_date']);?></label> <span>By <?php echo $sData['username']; ?></span></h4>

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