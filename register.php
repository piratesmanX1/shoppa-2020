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
    ob_start();
  	// It will return to admin panel automatically //
  	echo "<script>alert('You have already logged in. You need to logout first if you wanted to register a new account.');";
  	echo "window.location.href='";
    if ($_SESSION["role"] == 0) {
      echo "index.php";
    } else {
      echo "admin_panel.php";
    }
    echo
    "';</script>";
  	ob_end_flush();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Sign Up | Shoppa </title>
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
    include "navigation_bar.php"
  ?>

<section class="login py-5 border-top-1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8 align-item-center">
                    <div class="border border">
                        <h3 class="bg-gray p-4">Register Now</h3>
                        <form>
                            <fieldset class="p-4">
								<input id="fname" type="text" placeholder="First Name*" class="border p-3 w-100 my-2" required=required>
								<input id="lname" type="text" placeholder="Last Name*" class="border p-3 w-100 my-2" required=required>
								<input id="icnum" type="text" placeholder="IC Number*" class="border p-3 w-100 my-2" required=required maxlength="10">
								<div id="msg2"></div>
								<input id="address" type="text" placeholder="Address*" class="border p-3 w-100 my-2" required=required>
								<input id="email" type="email" placeholder="Email*" class="border p-3 w-100 my-2" required=required>
								<div id="msg1"></div>
								<input id="username" type="text" placeholder="Username*" class="border p-3 w-100 my-2" required=required>
								<div id="msg3"></div>
								<input id="pass" type="password" placeholder="Password*" class="border p-3 w-100 my-2" required=required>
                                <input id="rpass" type="password" placeholder="Confirm Password*" class="border p-3 w-100 my-2" required=required>
                                <div class="loggedin-forgot d-inline-flex my-3">
                                        <input type="checkbox" id="registering" class="mt-1">
                                        <label for="registering" class="px-2">By registering, you accept our <a class="text-primary font-weight-bold" href="terms-condition.html">Terms & Conditions</a></label>
                                </div>
                                <button id="btnRegister" type="submit" class="d-block py-3 px-4 bg-primary text-white border-0 rounded font-weight-bold">Register Now</button>
								<div id="errormsg"></div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!--============================
=            Footer            =
=============================-->

<?php
  include "footer.php"
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

<!-- Ajax -->
<script>
	$("document").ready(function(){
		var username_state = false;
		var email_state = false;
		var icnumber_state = false;

		//Check email valid
		$("#email").blur(function(){
			var email_add = $("#email").val().trim();
			if(email_add == ""){
				email_state = false;
				return;
			}
			$.ajax({
				url: "process_user.php",
				type: "POST",
				data:{
					check_email : 1,
					email : email_add
				},
				success: function(response){
					if(response.trim() == "not_available"){
						email_state = false;
						$("#msg1").text("  Email is not available");
					}
					else if(response.trim() == "available"){
						email_state = true;
						$("#msg1").text("");
					}
				}
			});
		});

		//Check icnumber valid
		$("#icnum").blur(function(){
			var ic_num = $("#icnum").val();
			if(ic_num == ""){
				icnumber_state = false;
				return;
			}
			$.ajax({
				url: "process_user.php",
				type: "POST",
				data:{
					check_icnumber : 1,
					ic_number : ic_num
				},
				success: function(response){
					if(response.trim() == "not_available"){
						icnumber_state = false;
						$("#msg2").text("  IC number has been used!");
					}
					else if(response.trim() == "available"){
						icnumber_state = true;
						$("#msg2").text("");
					}
				}
			});
		});

		//Check username valid
		$("#username").blur(function(){
			var user_name = $("#username").val();
			if(user_name == ""){
				username_state = false;
				return;
			}
			$.ajax({
				url: "process_user.php",
				type: "POST",
				data:{
					check_username : 1,
					username : user_name
				},
				success: function(response){
					if(response.trim() == "not_available"){
						username_state = false;
						$("#msg3").text("  The username has been used! Please try others!");
					}
					else if(response.trim() == "available"){
						username_state = true;
						$("#msg3").text("");
					}
				}
			});
		});

		//Register user
		$("#btnRegister").click( function(){
			var fname = $("#fname").val();
			var lname = $("#lname").val();
			var ic_num = $("#icnum").val();
			var add_ress = $("#address").val();
			var e_mail = $("#email").val();
			var user_name = $("#username").val();
			var pass = $("#pass").val();
			var rpass = $("#rpass").val();

			if(pass != rpass){
				alert("Password unmatched! Please try again!");
			}
			else if(email_state == false){
				$("#errormsg").text(" Email Please fix the error!");
			}
			else if(icnumber_state == false){
				$("#errormsg").text(" icnum Please fix the error!");
			}
			else if(username_state == false){
				$("#errormsg").text(" username Please fix the error!");
			}
			else if($("#registering").prop("checked") == false){
				$("#errormsg").text("  Please check the T&C");
			}
			else{
				$("#errormsg").text("");

				$.ajax({
					url: "process_user.php",
					type: "POST",
					data:{
						register_user : 1,
						username : user_name,
						firstname : fname,
						lastname : lname,
						address : add_ress,
						email : e_mail,
						icnum : ic_num,
						password : pass
					},
					success: function(response){
						alert(response);
						$("#fname").val("");
						$("#lname").val("");
						$("#icnum").val("");
						$("#address").val("");
						$("#email").val("");
						$("#username").val("");
						$("#pass").val("");
						$("#rpass").val("");
            window.location.href = "login.php";
					}
				});
			}
		});

	});
</script>


</body>

</html>
