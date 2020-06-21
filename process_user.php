<?php
// we will only start the session with session_start() IF the session isn"t started yet //
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
// including the conn.php to establish connection with database //
  include "conn.php";
?>

<?php
	/* Check the validation for the input fields by user */
	/* Check if the email is existing while register */
	if(isset($_POST['check_email'])){
		$email = $_POST['email'];
		$sql = "SELECT * FROM user WHERE user_email = '$email'";
		$result = mysqli_query($db, $sql);
		if(mysqli_num_rows($result) > 0){
			echo "not_available";
		}
		else{
			echo "available";
		}
		exit();
	}

	/* Check if the username is existing while register */
	if(isset($_POST['check_username'])){
		$username = $_POST['username'];
		$sql = "SELECT * FROM user WHERE user_username = '$username'";
		$result = mysqli_query($db, $sql);
		if(mysqli_num_rows($result) > 0){
			echo "not_available";
		}
		else{
			echo "available";
		}
		exit();
	}

	/* Check if the ic number is existing while register */
	if(isset($_POST['check_icnumber'])){
		$icnumber = $_POST['ic_number'];
		$sql = "SELECT * FROM user WHERE user_icnumber = '$icnumber'";
		$result = mysqli_query($db, $sql);
		if(mysqli_num_rows($result) > 0){
			echo "not_available";
		}
		else{
			echo "available";
		}
		exit();
	}

	/* Insert new user into database */
	if(isset($_POST['register_user'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$icnumber = $_POST['icnum'];
		$address = $_POST['address'];
		$email = $_POST['email'];
		$username = $_POST['username'];
		$password = md5($_POST['password']);

		$stmt = $db -> prepare("INSERT INTO user(user_fname, user_lname, user_icnumber, user_address, user_email, user_username, user_password) VALUES (?,?,?,?,?,?,?) ");
		$stmt ->bind_param("sssssss", $firstname, $lastname, $icnumber, $address, $email, $username, $password);

		$stmt->execute();
		$stmt->close();
		mysqli_close($db);

		echo "Register Successfully!";
		exit();
	}

	/* Verify user and login */
	if(isset($_POST['login_user'])){
		$username = ($_POST['username']);
		$password = md5($_POST['password']);

		$stmt = $db->prepare("SELECT * FROM user WHERE user_username =? and user_password =?");
		$stmt->bind_param("ss",$username, $password);
		$stmt->execute();
		$result = $stmt->get_result();


		while ($row = $result->fetch_assoc()) {
			$_SESSION['username'] = $username;
			$_SESSION['role'] = $row["user_role"];
			$_SESSION['address'] = $row["user_address"];
			$_SESSION['user_id'] = $row["user_id"];
			$_SESSION['user_lname'] = $row["user_lname"];
			$_SESSION['user_fname'] = $row["user_fname"];
			$_SESSION['user_icnumber'] = $row["user_icnumber"];
			$_SESSION['user_address'] = $row["user_address"];
			$_SESSION['user_email'] = $row["user_email"];
		}

		$stmt->close();
		mysqli_close($db);

		if (isset($_SESSION['user_id'])) {
			echo $_SESSION['role'];
		} else {
			echo "Incorrect username/password";
		}
		exit();
	}

	/* Show user details */
	if(isset($_POST['get_detail'])){
		$username = $_SESSION['username'];

		$sql = "SELECT * FROM user WHERE user_username = '$username'";
		$result = mysqli_query($db, $sql);

		while ($rows = mysqli_fetch_array($result)){
			?>
			<ul style="font-size:15px;font-style: italic;color: grey;">
				Name:<li style="list-style-type:none;font-size: 20px;color: black;font-style: normal;"><?php echo $rows['user_fname'] ?>  <?php echo $rows['user_lname'] ?></li><br>
				Username:<li style="list-style-type:none;font-size: 20px;color: black;font-style: normal;"><?php echo $rows['user_username'] ?></li><br>
				IC Number:<li style="list-style-type:none;font-size: 20px;color: black;font-style: normal;"><?php echo $rows['user_icnumber'] ?></li><br>
				Home Address:<li style="list-style-type:none;font-size: 20px;color: black;font-style: normal;"><?php echo $rows['user_address'] ?></li><br>
				Email Address:<li style="list-style-type:none;font-size: 20px;color: black;font-style: normal;"><?php echo $rows['user_email'] ?></li><br>
			</ul>
			<?php
		}
		exit();
	}

	/* Logout user */
	if(isset($_POST['logout_user'])){
		$username = $_SESSION['username'];

		echo "You have logged out! Thank you '$username'";

		session_destroy();
	}

	/*Forget password*/
	if(isset($_POST['forget_password'])){
		$username = ($_POST['username']);
		$email = ($_POST['email']);
		$password = md5($_POST['password']);

		$sql = "SELECT * FROM user WHERE user_username = '$username' AND user_email = '$email'";
		$result = mysqli_query($db, $sql);
		if(mysqli_num_rows($result) > 0){

			$stmt = $db -> prepare("UPDATE user SET user_password=? WHERE user_username=?");
			$stmt->bind_param("ss",$password,$username);

			$stmt->execute();
			$stmt->close();
			mysqli_close($db);

			echo "Request Accepted! Please try login with your new password.";
			exit();
		}
		else{
			echo "Not such user!";
		}

	}

	/* Update User normal detail */
	if(isset($_POST['update_user_normal'])){
		$username = $_SESSION['username'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$icnumber = $_POST['icnumber'];
		$address = $_POST['address'];

		$stmt = $db -> prepare("UPDATE user SET user_fname=?,user_lname=?,user_icnumber=?,user_address=? WHERE user_username=?");
		$stmt->bind_param("sssss",$firstname,$lastname,$icnumber,$address,$username);

		$stmt->execute();
		$stmt->close();
		mysqli_close($db);

		echo "Update Successfully!";
		exit();
	}

	/* Update User email */
	if(isset($_POST['update_user_email'])){
		$username = $_SESSION['username'];
		$email = $_POST['email'];

		$stmt = $db -> prepare("UPDATE user SET user_email=? WHERE user_username=?");
		$stmt->bind_param("ss",$email,$username);

		$stmt->execute();
		$stmt->close();
		mysqli_close($db);

		echo "Update Email Successfully!";
		exit();
	}

	/* Update User password */
	if(isset($_POST['update_user_password'])){
		$username = $_SESSION['username'];
		$password = md5($_POST['password']);

		$stmt = $db -> prepare("UPDATE user SET user_password=? WHERE user_username=?");
		$stmt->bind_param("ss",$password,$username);

		$stmt->execute();
		$stmt->close();
		mysqli_close($db);

		echo "Update Password Successfully!";
		exit();
	}

	/* Check ic number while updating */
	if(isset($_POST['check_icnumber_update'])){
		$username = $_SESSION['username'];
		$icnumber = $_POST['ic_number'];

		$sql = "SELECT * FROM user WHERE user_icnumber = '$icnumber'";
		$result = mysqli_query($db, $sql);

		if(mysqli_num_rows($result) == 0){
			echo "available";
		}else{
			while ($rows = mysqli_fetch_array($result)){
				if($username == $rows['user_username']){
					echo "available";
				}else{
					echo "not_available";
				}
			}
		}
		exit();
	}

	/* Check password while updating */
	if(isset($_POST['check_password_update'])){
		$username = $_SESSION['username'];
		$password = md5($_POST['password']);

		$sql = "SELECT * FROM user WHERE user_username = '$username'";
		$result = mysqli_query($db, $sql);

		while ($rows = mysqli_fetch_array($result)){
			if($password == $rows['user_password']){
				echo "available";
			}else{
				echo "not_available";
			}
		}
		exit();
	}

	/* Check email while updating */
	if(isset($_POST['check_email_update'])){
		$username = $_SESSION['username'];
		$email = $_POST['email'];

		$sql = "SELECT * FROM user WHERE user_email = '$email'";
		$result = mysqli_query($db, $sql);

		if(mysqli_num_rows($result) == 0){
			echo "available";
		}else{
			while ($rows = mysqli_fetch_array($result)){
				if($username == $rows['user_username']){
					echo "available";
				}else{
					echo "not_available";
				}
			}
		}
		exit();
	}
?>
