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
			
			$name       	  = $data['name'];
			$username   	  = $data['username'];
			$email      	  = $data['email'];
			$password   	  = $data['password'];
			$confirm_password = $data['confirm_password'];

			$checkEmail = $this->emailCheck($email);
			
			if ($name == "" OR $username =="" OR $email=="" OR $password=="") {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be empty</div>";
				return $msg;
			}

			if ($password != $confirm_password) {
				$msg = "<div class='alert alert-danger'><strong>Error ! Those passwords didn't match. Try again. </strong></div>";
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

		private function checkPassword($user_id,$old_pass)
		{
			$password = md5($old_pass);
			$sql = "SELECT password FROM  tbl_user WHERE user_id=:user_id AND password= :password";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':user_id',$user_id);
			$query->bindValue(':password',$password);
			$query->execute();
			if ($query->rowCount() > 0) {
				return true;
			}else{
				return false;
			}
		}

		public function passwordUpdate($user_id, $data)
		{
			$old_pass = $data['old_password'];
			$new_pass = $data['new_password'];
			$checkPassword = $this->checkPassword($user_id,$old_pass);

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
				WHERE user_id =:user_id";

			$query = $this->db->pdo->prepare($sql);

			$query->bindValue(':password',$password);
			$query->bindValue(':user_id',$user_id);

			$result = $query->execute();

			if ($result) {
				$msg = "<div class='alert alert-success'><strong>Password Updated Successfully.</strong></div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger'><strong>Password not Updated.</strong></div>";
				return $msg;
			}
		}

		

		public function createReport($user_id, $data)
		{
			// $user_id      	 = $data['user_id'];
			$crime      	 = $data['crime'];
			$crime_nature    = $data['crime_nature'];
			$police_station  = $data['police_station'];
			$criminals       = $data['criminals'];
			$address         = $data['address'];
			$crime_date      = $data['crime_date'];
			$activity        = 'Pending';
			
			if ($crime == "" OR $crime_nature =="" OR $police_station=="" OR $criminals=="" OR $address=="" OR $crime_date == "") {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be empty</div>";
				return $msg;
			}

			$sql = "INSERT INTO tbl_FIR(user_id,crime,crime_nature,police_station,criminals,address,crime_date,activity) VALUES(:user_id,:crime,:crime_nature,:police_station,:criminals,:address,:crime_date,:activity)";

			$query = $this->db->pdo->prepare($sql);

			$query->bindValue(':user_id',$user_id);
			$query->bindValue(':crime',$crime);
			$query->bindValue(':crime_nature',$crime_nature);
			$query->bindValue(':police_station',$police_station);
			$query->bindValue(':criminals',$criminals);
			$query->bindValue(':address',$address);
			$query->bindValue(':crime_date',$crime_date);
			$query->bindValue(':activity',$activity);
			$result = $query->execute();

			if ($result) {
				$msg = "<div class='alert alert-success'><strong>Report Submitted Successfully</strong></div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger'><strong>Report has been problem.</strong></div>";
				return $msg;
			}
		}

		public function getView_FIR()
		{
			$sql = "SELECT tbl_FIR.user_id,tbl_FIR.fir_id,tbl_user.username,tbl_FIR.crime,tbl_FIR.criminals,tbl_FIR.crime_nature,tbl_FIR.police_station,tbl_FIR.address,tbl_FIR.crime_date,tbl_FIR.activity
			 FROM  tbl_FIR  
			 INNER JOIN tbl_user
			 ON tbl_FIR.user_id = tbl_user.user_id
			 ORDER BY tbl_FIR.fir_id DESC";

			$query = $this->db->pdo->prepare($sql);
			$query->execute();
			$result = $query->fetchAll();
			return $result;
		}

		

		public function getRead_More()
		{
			$sql = "SELECT tbl_FIR.fir_id,tbl_user.user_id,tbl_user.username,tbl_FIR.crime,tbl_FIR.criminals,tbl_FIR.crime_nature,tbl_FIR.police_station,tbl_FIR.address,tbl_FIR.crime_date,tbl_FIR.activity
			 FROM  tbl_FIR  
			 INNER JOIN tbl_user
			 ON tbl_FIR.user_id = tbl_user.user_id
			 ORDER BY tbl_FIR.fir_id DESC ";

			$query = $this->db->pdo->prepare($sql);
			$query->execute();
			$result = $query->fetchAll();
			return $result;
		}


		public function createComment($user_id,$fir_id,$data)
		{
			
			$comment  = $data['text_comment'];
			
			
			if ($comment == "") {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be empty</div>";
				return $msg;
			}

			$sql = "INSERT INTO tbl_comments(user_id,fir_id,comment) VALUES(:user_id,:fir_id,:comment)";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':user_id',$user_id);
			$query->bindValue(':fir_id',$fir_id);
			$query->bindValue(':comment',$comment);
			$result = $query->execute();
			if ($result) {
				$msg = "<div class='alert alert-success'><strong>comment Submitted Successfully</strong></div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger'><strong>comment has been problem.</strong></div>";
				return $msg;
			}
		}


		public function getComments($fir_id)
		{
			$sql = "SELECT tbl_user.username,tbl_comments.comment,tbl_FIR.fir_id
			 FROM  tbl_comments  
			 INNER JOIN tbl_user
			 ON tbl_comments.user_id = tbl_user.user_id
			 INNER JOIN tbl_FIR
			 ON tbl_comments.fir_id = tbl_FIR.fir_id
			 WHERE tbl_comments.fir_id = $fir_id
			 ORDER BY tbl_comments.comment_id  DESC ";

			$query = $this->db->pdo->prepare($sql);
			$query->execute();
			$result = $query->fetchAll();
			return $result;
		}

		public function pagination()
		{
			$sql = "SELECT * FROM tbl_FIR";

			$query = $this->db->pdo->prepare($sql);
			$query->execute();
			$result = $query->rowCount();
			
			return $result;
		}

		public function getActivePost()
		{
			$activity ='Active';
			$sql = "SELECT tbl_FIR.user_id,tbl_FIR.fir_id,tbl_user.username,tbl_FIR.crime,tbl_FIR.criminals,tbl_FIR.crime_nature,tbl_FIR.police_station,tbl_FIR.address,tbl_FIR.crime_date,tbl_FIR.activity
			 FROM  tbl_FIR  
			 INNER JOIN tbl_user
			 ON tbl_FIR.user_id = tbl_user.user_id
			 ORDER BY tbl_FIR.fir_id DESC";

			$query = $this->db->pdo->prepare($sql);
			$query->execute();
			$result = $query->fetchAll();
			// $result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		}

		public function formatDate($date)
		{
			return date('F j - Y', strtotime($date));
		}

		public function text_Shorten($text, $limit = 200)
		{
			$text = $text." ";
			$text = substr($text, 0 ,$limit);
			$text = substr($text, 0 ,strrpos($text, ' '));
			$text = $text.".....";
			return $text;
		}

	}

 ?>