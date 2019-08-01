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

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve'])) {
		$post_Approve = $user->post_Approve($fir_id);
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deactive'])) {
		$post_Deactivate = $user->post_Deactivate($fir_id);
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
		$post_Delete = $user->post_Delete($fir_id);
	}

?>

<div class="indeximg">
	<div class="profile-container">
		<div class="container">
			<div class="panel panel-info" style="margin-top: 70px;">
				<div class="panel-heading">
					<h2>Read_More FIR <span class="pull-right"><a class="btn btn-primary" href="manage_fir.php?user_id=<?php echo $sesID; ?>">Back</a></span></h2>
				</div>

				<div class="panel-body">
					<div style="max-width: 1200px; margin: 0 auto">
						
						<?php 
							$read_more = $user->getRead_More();

							if ($read_more) {
							foreach ($read_more as $sData) {
							if ($fir_id == $sData['fir_id']) {
								
							
						?>
						<form action="" method="POST">
						<div class="well">

								<?php if ($sData['activity'] == 'Pending') { ?>

									<button type="submit" name="approve" class="alert alert-success pull-right"  onclick="return confirm('Do You Want to Approve This Post..?');"> Approve.?</button>
									
								<?php }elseif ($sData['activity'] == 'Active') { ?>

									<button type="submit" name="deactive" class="alert alert-info pull-right" onclick="return confirm('Do You Want to Deactive This Post..?');">Deactive.?</button>
									<button type="submit" name="delete" class="alert alert-danger pull-right" onclick="return confirm('Do You Want to Delete This Post..?');">Delete.?</button>

								<?php }elseif ($sData['activity'] == 'Deactive') { ?>
									<button type="submit" name="approve" class="alert alert-success pull-right" onclick="return confirm('Do You Want to Active This Post again..?');">Active.?</button>
									<button type="submit" name="delete" class="alert alert-danger pull-right" onclick="return confirm('Do You Want to Delete This Post..?');">Delete.?</button>
								<?php } ?>
								
							<h4><label> Crime Name: </label><span><?php echo $sData['crime']; ?></span></h4>
							<h4><label>Police Station: </label><span><?php echo $sData['police_station']; ?></span></h4>
							<h4><label>Criminals Name:</label>  <span><?php echo $sData['criminals']; ?></span></h4>
							<h4 class="blog-post-meta"><label><?php echo $user->formatDate( $sData['crime_date']);?></label> <span>By <?php echo $sData['username']; ?></span></h4>

							<div class="details">
								<p>
									<?php echo $sData['crime_nature']; ?>
								</p>
							</div>
								

								
							
						</div>
						
						<?php } } } ?>

								</form>

							

							
								
								

							<?php 

									$getComments = $user->getComments($fir_id);
									if ($getComments) {
									foreach ($getComments as $sData) {
								?>
									
									<div class="readmore-comment clear">
										<label><?php echo $sData['username']; ?></label>
										<p> <?php echo $sData['comment']; ?></p>
									</div>
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