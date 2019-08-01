<?php 
	
	include 'lib/User.php'; 
	include 'inc/header.php';
	Session::checkSession();
	$user = new User();

?>

<div class="indeximg">
	<div class="container">
		
	


			<div class="panel panel-success" style="margin-top: 70px;">
				<?php 

					$loginmsg = Session::get("loginmsg");
					if (isset($loginmsg)) {
						echo $loginmsg;
					}
					Session::set("loginmsg",NULL);
				?>
				<div class="panel-heading">
					
						<h2><span class="fa fa-home" aria-hidden="true"></span> Home <span class="pull-right">Welcome <strong>
							<?php 

								$name = Session::get("name");
								if (isset($name)) {
									echo $name;
								}

							 ?>
						</strong></span></h2>
					
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
							<h4><label> Crime Name: </label><span><?php echo $sData['crime']; ?></span></h4>
							<h4><label>Police Station: </label><span><?php echo $sData['police_station']; ?></span></h4>
							<h4><label>Criminals Name:</label>  <span><?php echo $sData['criminals']; ?></span></h4>
							<h4 class="blog-post-meta"><label><?php echo $user->formatDate( $sData['crime_date']);?></label> <span>By <a href="profile.php?user_id=<?php echo $sData['user_id']; ?>"><?php echo $sData['username']; ?></a></span></h4>

							<div class="details">
								<p><?php echo $user->text_Shorten($sData['crime_nature']); ?>
									<a class="btn btn-success" href="read_more.php?fir_id=<?php echo $sData['fir_id']; ?>">Read More</a>
								</p>

							</div>
							<!-- <div class="index-button">
								<a class="btn btn-success" href="read_more.php?fir_id=<?php echo $sData['fir_id']; ?>">Read More</a>
							</div>
 -->							

						</div>
								<?php } ?>
						<?php }
						} ?>
						
						
					</div>
				</div>
			</div>
	</div>
	<div class="index-footersection templete clear">
		<p>&copy; copyright Developed by Ripa Roy.</p>
	</div>
</div>

<?php include 'inc/footer.php'; ?>