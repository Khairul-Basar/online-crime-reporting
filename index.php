<?php 
	include 'inc/header.php';
	include 'lib/User.php'; 
	Session::checkSession();
	$user = new User();

?>

<?php 

	$loginmsg = Session::get("loginmsg");
	if (isset($loginmsg)) {
		echo $loginmsg;
	}
	Session::set("loginmsg",NULL);
 ?>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>User List <span class="pull-right">Welcome <strong>
						<?php 

							$name = Session::get("name");
							if (isset($name)) {
								echo $name;
							}

						 ?>
					</strong></span></h2>
				</div>

				<div class="panel-body">
					<table class="table table-striped">
						<tr>
							<th width="20%">Serial</th>
							<th width="20%">Name</th>
							<th width="20%">UserName</th>
							<th width="20%">Email</th>
							<th width="20%">Action</th>
						</tr>

						<tr>
							<td>01</td>
							<td>User Full Name</td>
							<td>User Name</td>
							<td>user1@gmail.com</td>
							<td>
								<a class="btn btn-primary" href="profile.php?id=1">View</a>
							</td>
						</tr>
						<tr>
							<td>02</td>
							<td>User Full Name</td>
							<td>User Name</td>
							<td>user2@gmail.com</td>
							<td>
								<a class="btn btn-primary"  href="profile.php?id=1">View</a>
							</td>
						</tr>
					</table>
				</div>
			</div>


<?php include 'inc/footer.php'; ?>