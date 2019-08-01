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

		

		private function emailCheck($email)
		{
			$sql = "SELECT email FROM  admin_user WHERE email= :email";
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
			$sql = "SELECT * FROM  admin_user WHERE email= :email AND password=:password  LIMIT 1";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':email',$email);
			$query->bindValue(':password',$password);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		}


		public function userLogin($data){
			$email      = $data['email'];
			$password   = $data['password'];
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
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>You are not Admin</div>";
				return $msg;
			}

			$result = $this->getLoginUser($email, $password);

			if ($result) {
				Session::init();
				Session::set('admin_login',true);
				Session::set('user_id',$result->user_id);
				Session::set('name',$result->name);
				Session::set('username',$result->username);
				Session::set('loginmsg',"<div class='alert alert-success'><strong>Success  ! </strong>Admin Loged in</div>");
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


			$sql = "UPDATE admin_user SET 

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
				$msg = "<div class='alert alert-success'><strong>Admin Profile Updated Successfully.</strong></div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger'><strong>Admin Profile not Updated.</strong></div>";
				return $msg;
			}
		}

		private function checkPassword($user_id,$old_pass)
		{
			$password = $old_pass;
			$sql = "SELECT password FROM  admin_user WHERE user_id=:user_id AND password= :password";
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

			$password = $new_pass;

			$sql = "UPDATE admin_user SET 
				password =:password
				WHERE user_id =:user_id";

			$query = $this->db->pdo->prepare($sql);

			$query->bindValue(':password',$password);
			$query->bindValue(':user_id',$user_id);

			$result = $query->execute();

			if ($result) {
				$msg = "<div class='alert alert-success'><strong>Admin Password Updated Successfully.</strong></div>";
				return $msg;
			}else{
				$msg = "<div class='alert alert-danger'><strong>Admin Password not Updated. Password has been problem..!!</strong></div>";
				return $msg;
			}
		}

		// this method for get crime type 
		public function getCrimeType()
		{
			$sql = "SELECT * FROM  tbl_crime_type  ORDER BY crime_id ASC";
			$query = $this->db->pdo->prepare($sql);
			$query->execute();
			$result = $query->fetchAll();
			return $result;
		}

		// Insert Crime Type
		public function insert_crime_type($data)
		{
			$crime_name = $data['crime_name'];

			if ($crime_name == "") {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be empty</div>";
				return $msg;
			}

			$sql = "INSERT INTO tbl_crime_type(crime_name) VALUES(:crime_name)";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':crime_name',$crime_name);
			$result = $query->execute();
			header("Location: add_crime_type.php");
			
		}

		public function createReport($userid, $data)
		{
			// $user_id      	 = $data['user_id'];
			$crime_type      = $data['crime_type'];
			$crime_nature    = $data['crime_nature'];
			$police_station  = $data['police_station'];
			$address         = $data['address'];
			$crime_date      = $data['crime_date'];
			$activity        = 'Active';
			
			if ($crime_type == "select" OR $crime_nature =="" OR $crime_nature=="" OR $address=="" OR $crime_date=="") {
				$msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be empty</div>";
				return $msg;
			}

			$sql = "INSERT INTO tbl_FIR(user_id,crime_id,crime_nature,police_station,address,crime_date,activity) VALUES(:user_id,:crime_id,:crime_nature,:police_station,:address,:crime_date,:activity)";

			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':user_id',$userid);
			$query->bindValue(':crime_id',$crime_type);
			$query->bindValue(':crime_nature',$crime_nature);
			$query->bindValue(':police_station',$police_station);
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
			$sql = "SELECT tbl_FIR.fir_id,tbl_user.username,tbl_FIR.crime,tbl_FIR.criminals,tbl_FIR.crime_nature,tbl_FIR.police_station,tbl_FIR.address,tbl_FIR.crime_date,tbl_FIR.activity
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


		// For Active Posts
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
			return $result;
		}

		// For Pending posts
		public function getPendingPost()
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


		// Next 3 Methods for delete user Comments, user Posts, Users

		public function delete_User_Comments($user_id)
		{
			$sql = "DELETE FROM  tbl_comments WHERE user_id = $user_id";
			$query = $this->db->pdo->prepare($sql);
			$query->execute();
		}

		public function delete_User_Post($user_id)
		{
			$sql = "DELETE FROM  tbl_FIR WHERE user_id = $user_id";
			$query = $this->db->pdo->prepare($sql);
			$query->execute();
		}

		public function user_Delete($user_id)
		{
			$sql = "DELETE FROM  tbl_user WHERE user_id = $user_id";
			$query = $this->db->pdo->prepare($sql);
			$query->execute();
			$this->delete_User_Post($user_id);
			$this->delete_User_Comments($user_id);
			header("Location: manage_user.php");
		}



		public function getAdminID($user_id)
		{
			$sql = "SELECT * FROM  admin_user  WHERE user_id=:user_id LIMIT 1";
			$query = $this->db->pdo->prepare($sql);
			$query->bindValue(':user_id',$user_id);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result;
		}



		public function post_Approve($fir_id)
		{
			$activity = 'Active';

			$sql = "UPDATE tbl_FIR SET 
				activity = :activity
				WHERE fir_id =:fir_id";

			$query = $this->db->pdo->prepare($sql);

			$query->bindValue(':activity',$activity);
			$query->bindValue(':fir_id',$fir_id);
			
			$query->execute();
		}


		public function post_Deactivate($fir_id)
		{
			$activity = 'Deactive';

			$sql = "UPDATE tbl_FIR SET 
				activity = :activity
				WHERE fir_id =:fir_id";

			$query = $this->db->pdo->prepare($sql);

			$query->bindValue(':activity',$activity);
			$query->bindValue(':fir_id',$fir_id);
			
			$query->execute();
		}

		// Next two Methods for delete posts and delete post Comments

		public function delete_post_Comments($fir_id)
		{
			$sql = "DELETE FROM  tbl_comments WHERE fir_id = $fir_id";
			$query = $this->db->pdo->prepare($sql);
			$query->execute();
		}

		public function post_Delete($fir_id)
		{
			$sql = "DELETE FROM  tbl_FIR WHERE fir_id = $fir_id";
			$query = $this->db->pdo->prepare($sql);
			$query->execute();
			$this->delete_post_Comments($fir_id);
			header("Location: manage_fir.php");
		}

	}

 ?>