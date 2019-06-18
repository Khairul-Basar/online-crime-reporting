<?php 
	include_once 'Session.php';
	include 'Database.php';

	
	class User
	{
		private $db;
		function __construct()
		{
			$this->db = new Database();
		}

		public function userRegistration($data){
			
			$name       = $data['name'];
			$username   = $data['username'];
			$email      = $data['email'];
			$password   = $data['password'];

			$checkEmail = $this->emailCheck($email);
			
			if ($name == "" OR $username =="" OR $email=="" OR $password=="") {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be empty</div>";
				return $msg;
			}

			if (strlen($username) < 4) {

				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>User name is too short!</div>";
				return $msg;
			}elseif (preg_match('/[^a-z0-9_-]+/i', $username)){

				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>User name must only containts alphanumeric,dashes and underscores! </div>";
				return $msg;
				
			}

			if (filter_var($email,FILTER_VALIDATE_EMAIL) === false) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is not valid! </div>";
				return $msg;
			}

			if ($checkEmail == true) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>This Email Address already exist</div>";
				return $msg;
			}

			$password   = md5( $data['password']);

			$sql = "INSERT INTO tbl_user(name,username,email,password) VALUES(:name,:username,:email,:password)";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':name',$name);
			$query->bindValue(':username',$username);
			$query->bindValue(':email',$email);
			$query->bindValue(':password',$password);
			$result = $query->execute();

			if ($result) {
				$msg = "<div class='alert alert-success'><strong>Your Registration Completed.</strong></div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger'><strong>Your has been problem inserting details.</strong></div>";
				return $msg;
			}

		}

		private function emailCheck($email)
		{
			$sql = "SELECT email FROM  tbl_user WHERE email= :email";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':email',$email);
			$query->execute();
			if ($query->rowCount() > 0) {
				return true;
			}else{
				return false;
			}

		}



		public function getLoginUser($email, $password){
			$sql = "SELECT * FROM  tbl_user WHERE email= :email AND password=:password  LIMIT 1";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':email',$email);
			$query->bindValue(':password',$password);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		}


		public function userLogin($data){
			$email      = $data['email'];
			$password   = md5( $data['password']);
			$checkEmail = $this->emailCheck($email);
			
			if ($email=="" OR $password=="") {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be empty</div>";
				return $msg;
			}

			if (filter_var($email,FILTER_VALIDATE_EMAIL) === false) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is not valid! </div>";
				return $msg;
			}

			if ($checkEmail == false) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>This Email Address not exist</div>";
				return $msg;
			}

			$result = $this->getLoginUser($email, $password);

			if ($result) {
				Session::init();
				Session::set('login',true);
				Session::set('user_id',$result->user_id);
				Session::set('name',$result->name);
				Session::set('username',$result->username);
				Session::set('loginmsg',"<div class='alert alert-success'><strong>Success  ! </strong>You Are Loged in</div>");
				header("Location: index.php");

			}else{
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Data not found!</div>";
				return $msg;
			}

		}


		public function getUserData()
		{
			$sql = "SELECT * FROM  tbl_user  ORDER BY user_id DESC";
			$query = $this->db->pdo->prepare($sql);
			$query->execute();
			$result = $query->fetchAll();
			return $result;
		}

		public function getUserID($userid)
		{
			$sql = "SELECT * FROM  tbl_user  WHERE user_id=:user_id LIMIT 1";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':user_id',$userid);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		}

		public function userUpdate($userid, $data)
		{
			$name       = $data['name'];
			$username   = $data['username'];
			$email      = $data['email'];
			
			if ($name == "" OR $username =="" OR $email=="") {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be empty</div>";
				return $msg;
			}

			if (strlen($username) < 4) {

				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>User name is too short!</div>";
				return $msg;
			}elseif (preg_match('/[^a-z0-9_-]+/i', $username)){

				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>User name must only containts alphanumeric,dashes and underscores! </div>";
				return $msg;
				
			}

			if (filter_var($email,FILTER_VALIDATE_EMAIL) === false) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is not valid! </div>";
				return $msg;
			}


			$sql = "UPDATE tbl_user SET 

				name     =:name,
				username =:username,
				email    =:email
				WHERE user_id =:user_id";

			$query = $this->db->pdo->prepare($sql);

			$query->bindValue(':name',$name);
			$query->bindValue(':username',$username);
			$query->bindValue(':email',$email);
			$query->bindValue(':user_id',$userid);
			$result = $query->execute();

			if ($result) {
				$msg = "<div class='alert alert-success'><strong>Profile data Updated Successfully.</strong></div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger'><strong>Profile Data not Updated.</strong></div>";
				return $msg;
			}
		}

		private function checkPassword($id,$old_pass)
		{
			$password = md5($old_pass);
			$sql = "SELECT password FROM  tbl_user WHERE id=:id AND password= :password";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':id',$id);
			$query->bindValue(':password',$password);
			$query->execute();
			if ($query->rowCount() > 0) {
				return true;
			}else{
				return false;
			}
		}

		public function passwordUpdate($id, $data)
		{
			$old_pass = $data['old_password'];
			$new_pass = $data['new_password'];
			$checkPassword = $this->checkPassword($id,$old_pass);

			if ($old_pass == "" OR $new_pass =="") {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be empty</div>";
				return $msg;
			}

			if ($checkPassword == false) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Old password not exist..!!</div>";
				return $msg;
			}

			if (strlen($new_pass) < 5) {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Password is too short..!!</div>";
				return $msg;
			}

			$password = md5($new_pass);

			$sql = "UPDATE tbl_user SET 
				password =:password
				WHERE id =:id";

			$query = $this->db->pdo->prepare($sql);

			$query->bindValue(':password',$password);
			$query->bindValue(':id',$id);

			$result = $query->execute();

			if ($result) {
				$msg = "<div class='alert alert-success'><strong>Password Updated Successfully.</strong></div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger'><strong>Password not Updated.</strong></div>";
				return $msg;
			}
		}

		public function getCrimeType()
		{
			$sql = "SELECT * FROM  tbl_crime_type  ORDER BY crime_id ASC";
			$query = $this->db->pdo->prepare($sql);
			$query->execute();
			$result = $query->fetchAll();
			return $result;
		}

		public function createReport($userid, $data)
		{
			$crime_type      = $data['crime_type'];
			$crime_nature    = $data['crime_nature'];
			$police_station  = $data['police_station'];
			$address         = $data['address'];
			$crime_date      = $data['crime_date'];
			
			if ($crime_type == "select" OR $crime_nature =="" OR $crime_nature=="" OR $address=="" OR $crime_date=="") {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be empty</div>";
				return $msg;
			}

			$sql = "INSERT INTO tbl_FIR(crime_id,crime_nature,police_station,address,crime_date) VALUES(:crime_id,:crime_nature,:police_station,:address,:crime_date)";

			$query = $this->db->pdo->prepare($sql);
			// $query->bindValue(':userid',$userid);
			$query->bindValue(':crime_id',$crime_type);
			$query->bindValue(':crime_nature',$crime_nature);
			$query->bindValue(':police_station',$police_station);
			$query->bindValue(':address',$address);
			$query->bindValue(':crime_date',$crime_date);
			$result = $query->execute();
			if ($result) {
				$msg = "<div class='alert alert-success'><strong>Report Submitted Successfully</strong></div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger'><strong>Report has been problem.</strong></div>";
				return $msg;
			}

		}

	}

 ?>