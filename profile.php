<?php 
	include 'inc/header.php'; 
	Session::checkSession();
?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>User Profile <span class="pull-right"><a class="btn btn-primary" href="index.php">Back</a></span></h2>
				</div>

				<div class="panel-body">
					<div style="max-width: 400px; margin: 0 auto">
						<form action="" method="POST">

							<div class="form-group">
								<label for="name">Your Name</label>
								<input type="text" id="name" name="name" class="form-control" placeholder="Full Name" required="1">
							</div>

							<div class="form-group">
								<label for="username">User Name</label>
								<input type="username" id="username" name="username" class="form-control" placeholder="UserName" required="1">
							</div>

							<div class="form-group">
								<label for="email">Email Address</label>
								<input type="text" id="email" name="email" class="form-control" placeholder="Email Address" required="1">
							</div>

							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" id="password" name="password" class="form-control" placeholder="Password" required="1">
							</div>

							<button type="submit" name="update" class="btn btn-success">Update</button>
						</form>
					</div>
				</div>
			</div>


<?php include 'inc/footer.php'; ?>