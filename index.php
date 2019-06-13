	<?php 
	$error='';
		include("config/db.php");
		if (isset($_POST['register'])) {
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			if ($username != '' && $email !='' && $password!=''){
				$pwd_hash = sha1($password);
				$sql = "INSERT INTO users (username,email,password,user_role) VALUES('$username','$email','$pwd_hash',1)";
				$query = $conn->query($sql);
				if ($query) {
					header('Location:login.php');
				}else{
					$error ='Failed to Register User!!';
				}
			}
			else{
				$error =  "Please fill all the details!";
			}
		}
	 ?>
	<?php include("inc/header.php"); ?>
	<div class="container">
		<form class="form-horizontal" action="index.php" method="POST">
		  <fieldset>
		    <legend>REGISTER USER</legend><hr/>

		    <div class="row">
		    	<div class="col-md-6">
		    		<div class="form-group " >
				      	<label for="username" class="col-sm-2 col-form-label ">UserName</label>
				      <div class=" col-lg-10 ">
				        	<input type="text" name="username" class="form-control" placeholder="username">
				      </div>
				    </div>
		    	</div>
		    </div>

		    

		    <div class="row">
		    	<div class="col-md-6">
		    		<div class="form-group">
				      	<label for="email" class="col-lg-2 col-form-label">Email</label>
				      <div class="col-lg-10">
				        	<input type="email" name="email" class="form-control" placeholder="Email">
				      </div>
				    </div>
		    	</div>
		    </div>



		     <div class="row">
		    	<div class="col-md-6">
		    		<div class="form-group">
				      	<label for="password" class="col-lg-2 col-form-label">Password</label>
				      <div class="col-lg-10">
				        	<input type="password" name="password" class="form-control" placeholder="Password">
				      </div>
				    </div>
		    	</div>
		    </div>


		    <div class="row">
		    	<div class="col-md-6">
		    		<div class="form-group">
				      <div class="col-lg-10">
				        	<input type="submit" name="register" value="Register" class="btn btn-primary" >
				        	<button type="reset" class="btn btn-primary" >Cancel</button>
				      </div>
				    </div>
		    	</div>
		    </div>
		    
		    <div class="row">
		    	<div class="form-group">
		    		<div class="col-lg-6">
			    		<?php if(isset($_POST['register'])): ?>
			    			<div class="alert alert-warning">
			    				<p><?php echo $error; ?></p>
			    			</div>
		    			<?php endif; ?>	
		    		</div>
		    	</div>
		    </div>
		    
		  </fieldset>
		</form>
	</div>

	
	<?php include("inc/footer.php"); ?>