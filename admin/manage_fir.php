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
	<div class="profile-container">
		<div class="container">

			<div class="panel panel-info" style="margin-top: 70px;">
				<div class="panel-heading">
					<h3><span class="fa fa-eye" aria-hidden="true"></span> View FIR 
						<div class="dropdown pull-right">
						  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Manage Crime Type and Post Type
						  <span class="caret"></span></button>
						  <ul class="dropdown-menu">
						   
						    <li><a href="pending_post.php">All_Pending_Posts</a></li>
						    <li><a href="active_post.php">All_Active_Posts</a></li>
						    <li><a href="deactive_post.php">All_Dective_Posts</a></li>
						  </ul>
						</div>
					</h3>
				</div>

				<div class="panel-body">
					<div style="max-width: 1200px; margin: 0 auto">
						
						<?php 
							$view_fir = $user->getView_FIR();

							if ($view_fir) {
							foreach ($view_fir as $sData) {
								 
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
								<h4><label>Police Station: </label><span><?php echo $sData['police_station']; ?></span></h4>
								<h4><label>Criminals Name:</label>  <span><?php echo $sData['criminals']; ?></span></h4>
								<h4 class="blog-post-meta"><label><?php echo $user->formatDate( $sData['crime_date']);?></label> <span>By <?php echo $sData['username']; ?></span></h4>
								<!-- <p class="blog-post-meta"><label><?php echo $user->formatDate($sData['crime_date']); ?> , By <?php echo $sData['username']; ?></label></p> -->
								<div class="details">
									<p><?php echo $user->text_Shorten($sData['crime_nature']); ?>
										<a class="btn btn-primary" href="readmore.php?fir_id=<?php echo $sData['fir_id']; ?>">Read More</a>
									</p>

								</div>

								

								

								
							
						</div>
						
							<?php  }  ?>
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
			
			



							

									

										