<!DOCTYPE html>
<?php
// we will only start the session with session_start() IF the session isn't started yet //
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
	include("conn.php");
?>

<?php
if (isset($_SESSION["user_id"])) {
  // do nothing
} else {
  ob_start();
  // It will return to admin panel automatically //
  echo "<script>alert('System Notice: You need to login with an account to access this site, please try again.');";
  echo "window.location.href='login.php';</script>";
  ob_end_flush();
}
?>

<?php
$username = $_SESSION['username'];

$sql = "SELECT * FROM user WHERE user_username = '$username'";
$result = mysqli_query($db, $sql);

?>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Edit Profile | Shoppa </title>
  <link href="logo_image/favicon.png" rel="shortcut icon">
  <!-- PLUGINS CSS STYLE -->
  <!-- <link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet"> -->
  <!-- Bootstrap -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap-slider.css">
  <!-- Font Awesome -->
  <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- Owl Carousel -->
  <link href="plugins/slick-carousel/slick/slick.css" rel="stylesheet">
  <link href="plugins/slick-carousel/slick/slick-theme.css" rel="stylesheet">
  <!-- Fancy Box -->
  <link href="plugins/fancybox/jquery.fancybox.pack.css" rel="stylesheet">
  <link href="plugins/jquery-nice-select/css/nice-select.css" rel="stylesheet">
  <!-- CUSTOM CSS -->
  <link href="css/style.css" rel="stylesheet">


  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

<body class="body-wrapper">

  <?php
    include_once("navigation_bar.php");
  ?>
<!--==================================
=            User Profile            =
===================================-->

<section class="user-profile section">
	<div class="container">
		<div id="edit-detail" class="row">
			<?php while ($rows = mysqli_fetch_array($result)){ ?>
			<div class="col-md-10 offset-md-1 col-lg-3 offset-lg-0">
				<div class="sidebar">
					<!-- User Widget -->
					<div class="widget user">
						<!-- User Image -->
						<div class="image d-flex justify-content-center">
							<img src="image/user_profile.png" alt="" class="">
						</div>
						<!-- User Name -->
						<h5 id="editpage-user" class="text-center"><?php echo $rows['user_username'] ?></h5>
					</div>
					<!-- Dashboard Links -->
					<div class="widget dashboard-links">
						<ul>
							<li style="font-size:18px;"><a class="my-1 d-inline-block" href="user_profile.php">Back to Profile</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-10 offset-md-1 col-lg-9 offset-lg-0">
				<!-- Edit Profile Welcome Text -->
				<div class="widget welcome-message">
					<h2>Edit profile</h2>
					<p>Some of the information on your Shoppa profile will always be public. But you can choose what information you want to include in section. You may edit your password at here as well.</p>
				</div>
				<!-- Edit Personal Info -->
				<div class="row">
					<div id="form1" class="col-lg-6 col-md-6">
						<div class="widget personal-info">
							<h3 class="widget-header user">Edit Personal Information</h3>
							<form>
								<!-- First Name -->
								<div class="form-group">
									<label for="first-name">First Name</label>
									<input type="text" class="form-control" id="fi_name" value="<?php echo $rows['user_fname'] ?>">
								</div>
								<!-- Last Name -->
								<div class="form-group">
									<label for="last-name">Last Name</label>
									<input type="text" class="form-control" id="la_name" value="<?php echo $rows['user_lname'] ?>" >
								</div>
								<!-- IC Number -->
								<div class="form-group">
									<label for="comunity-name">IC Number</label>
									<input type="text" class="form-control" id="ic_numbe" value="<?php echo $rows['user_icnumber'] ?>" maxlength="10">
								</div>
								<!-- Address -->
								<div class="form-group">
									<label for="zip-code">Address</label>
									<input type="text" class="form-control" id="ad_dress" value="<?php echo $rows['user_address'] ?>">
								</div>
								<!-- Submit button -->
								<button id="btn_Save_Edit_1" class="btn btn-transparent">Save My Changes</button>
							</form>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<!-- Change Password -->
					<div class="widget change-password">
						<h3 class="widget-header user">Edit Password</h3>
						<form action="#">
							<!-- Current Password -->
							<div class="form-group">
								<label for="current-password">Current Password</label>
								<input type="password" class="form-control" id="current_password">
							</div>
							<!-- New Password -->
							<div class="form-group">
								<label for="new-password">New Password</label>
								<input type="password" class="form-control" id="new_password">
							</div>
							<!-- Confirm New Password -->
							<div class="form-group">
								<label for="confirm-password">Confirm New Password</label>
								<input type="password" class="form-control" id="confirm_password">
							</div>
							<!-- Submit Button -->
							<button id="btn_Save_Edit_2" class="btn btn-transparent">Change Password</button>
						</form>
					</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<!-- Change Email Address -->
					<div class="widget change-email mb-0">
						<h3 class="widget-header user">Edit Email Address</h3>
						<form action="#">
							<!-- Current Email -->
							<div class="form-group">
								<label for="current-email">Current Email</label>
								<input type="email" class="form-control" id="current_email" value="<?php echo $rows['user_email'] ?>" disabled>
							</div>
							<!-- New email -->
							<div class="form-group">
								<label for="new-email">New email</label>
								<input type="email" class="form-control" id="new_email">
							</div>
							<!-- Submit Button -->
							<button id="btn_Save_Edit_3" class="btn btn-transparent">Change email</button>
						</form>
					</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</section>

<?php
  include_once("footer.php");
?>

<!-- JAVASCRIPTS -->
<script src="plugins/jQuery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/popper.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap-slider.js"></script>
  <!-- tether js -->
<script src="plugins/tether/js/tether.min.js"></script>
<script src="plugins/raty/jquery.raty-fa.js"></script>
<script src="plugins/slick-carousel/slick/slick.min.js"></script>
<script src="plugins/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="plugins/fancybox/jquery.fancybox.pack.js"></script>
<script src="plugins/smoothscroll/SmoothScroll.min.js"></script>
<!-- google map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU&libraries=places"></script>
<script src="plugins/google-map/gmap.js"></script>
<script src="js/script.js"></script>

<!-- JQuery-->
<script>
$("document").ready(function(){
		var icnumber_state = false;
		var email_state = false;
		var password_state = false;

		//Check icnumber valid
		$("#ic_numbe").blur(function(){
			var ic_num = $("#ic_numbe").val();
			if(ic_num == ""){
				icnumber_state = false;
				return;
			}
			$.ajax({
				url: "process_user.php",
				type: "POST",
				data:{
					check_icnumber_update : 1,
					ic_number : ic_num
				},
				success: function(response){
					if(response.trim() == "not_available"){
						icnumber_state = false;
					}
					else if(response.trim() == "available"){
						icnumber_state = true;
					}
				}
			});
		});

		//Check password valid
		$("#current_password").blur(function(){
			var current = $("#current_password").val();
			if(current == ""){
				password_state = false;
				return;
			}
			$.ajax({
				url: "process_user.php",
				type: "POST",
				data:{
					check_password_update : 1,
					password : current
				},
				success: function(response){
					if(response.trim() == "not_available"){
						password_state = false;
					}
					else if(response.trim() == "available"){
						password_state = true;
					}
				}
			});
		});

		//Check for email format
		function isEmail(email) {
		  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		  return regex.test(email);
		}

		//Check email valid
		$("#new_email").blur(function(){
			var e_mail = $("#new_email").val().trim();
			var tempBool = false;

			if(e_mail == ""){
				email_state = false;
				return;
			}
			else if(tempBool == isEmail(e_mail)){
				email_state = false;
				return;
			}
			$.ajax({
				url: "process_user.php",
				type: "POST",
				data:{
					check_email_update : 1,
					email : e_mail
				},
				success: function(response){
					if(response.trim() == "not_available"){
						email_state = false;
					}
					else if(response.trim() == "available"){
						email_state = true;
					}
				}
			});
		});

		//Function for Save My Changes button
		$("#edit-detail").find("#btn_Save_Edit_1").click(function () {
			var first_name = $("#fi_name").val();
			var last_name = $("#la_name").val();
			var icnum = $("#ic_numbe").val();
			var add_ress = $("#ad_dress").val();

			if(first_name.trim() == "" || last_name.trim() == "" || icnum.trim() == "" || add_ress.trim() == ""){
				alert("Please make sure the form is filled");

			}
			else if(icnumber_state == false){
				alert("Please check your ic number!");
			}
			else{
				$.ajax({
					url : "process_user.php",
					type : "POST",
					data : {
						update_user_normal : 1,
						firstname : first_name,
						lastname : last_name,
						icnumber : icnum,
						address : add_ress
					},
					success: function(respond){
						alert(respond);
						location.reload();
					}
				});
			}
		});

		//Function for Change Password button
		$("#edit-detail").find("#btn_Save_Edit_2").click(function () {
			var latest = $("#new_password").val();
			var rlatest = $("#confirm_password").val();

			if(latest.trim() == "" || rlatest.trim() == ""){
				alert("Please make sure the form is filled");
			}
			else if(latest != rlatest){
				alert("Please make sure the new passwords are matched!");
			}
			else if(password_state == false){
				alert("Please make sure the old password is correct!");
			}else{
				$.ajax({
					url : "process_user.php",
					type : "POST",
					data : {
						update_user_password : 1,
						password : latest
					},
					success: function(respond){
						alert(respond);
						location.reload();
					}
				});
			}
		});

		//Function for Change Email button
		$("#edit-detail").find("#btn_Save_Edit_3").click(function () {
			var e_mail = $("#new_email").val().trim();

			if(e_mail.trim() == ""){
				alert("Please make sure the form is filled");
			}
			else if(email_state == false){
				alert("The email has been used by someone, or the email format is incorrect!");
			}else{
				$.ajax({
					url : "process_user.php",
					type : "POST",
					data : {
						update_user_email : 1,
						email : e_mail
					},
					success: function(respond){
						alert(respond);
						location.reload();
					}
				});
			}
		});


	});
</script>
</body>
</html>
