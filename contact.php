<?php
// we will only start the session with session_start() IF the session isn't started yet //
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    echo $_SESSION['user_id'];
}
?>

<?php
// including the conn.php to establish connection with database //
  include "conn.php";
?>

<?php
  if (isset($_SESSION["user_id"])) {
    // check if its admin or note
    if ($_SESSION["role"] == 1) {
      // if it is then redirect admin back to admin panel
      ob_start();
      // It will return to admin panel automatically //
      echo "<script>alert('System Notice: You are not allowed to view this section.');";
      echo "window.location.href='admin_panel.php';</script>";
      ob_end_flush();
    }
  } else {
    ob_start();
  	// It will return to admin panel automatically //
  	echo "<script>alert('System Notice: You need to login with an account to access this site, please try again.');";
  	echo "window.location.href='login.php';</script>";
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
  <title> Contact Admin | Shoppa </title>
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

<!-- page title -->
<!--================================
=            Page Title            =
=================================-->
<section class="page-title">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2 text-center">
				<!-- Title text -->
				<h3>Contact Us</h3>
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>
<!-- page title -->

<!-- contact us start-->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="contact-us-content p-4">
                    <h5>Contact Us</h5>
                    <h1 class="pt-3">Hello, what's on your mind?</h1>
                    <p class="pt-3 pb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla elit dolor, blandit vel euismod ac, lentesque et dolor. Ut id tempus ipsum.</p>
                </div>
            </div>
            <div class="col-md-6">
                    <form id="contactForm"> <!--FORM-->
                        <fieldset class="p-4">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6 py-2">
                                        <input id = "username" type="text" placeholder="Username *" class="form-control" required>
                                    </div>
                                    <div class="col-lg-6 pt-2">
                                        <input id = "email" type="email" placeholder="Email *" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <textarea name="message" id="message"  placeholder="Message *" class="border w-100 p-3 mt-3 mt-lg-4"></textarea>
                            <div class="btn-grounp">
                                <button id="btnSubmit" type="button" class="btn btn-primary mt-2 float-right">SUBMIT</button>
							</div>
							<div id="displayMessage"></div>
                        </fieldset>
                    </form>
            </div>
        </div>
    </div>
</section>
<!-- contact us end -->

<!--============================
=            Footer            =
=============================-->

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
<script src="js/script.js"></script> -->

<script>
	$("documnet").ready(function(){  //run code simultinouly when page loaded

		$("#btnSubmit").click( function(){
			// alert("CLICKED");

			var username = $("#username").val();
			var email = $("#email").val();
			var message = $("#message").val();

			$.ajax({
				type: "POST",
				url: "process_contact.php",
				data: {
					contact_admin : 1,
					email : email,
					username : username,
					message : message ,



				},
				success: function(respond){
          alert(respond);
					// $("#displayMessage").html(respond).show();
					// alert(response);
					$("#username").val("");
					$("#email").val("");
					$("#category").val("");
					$("#message").val("");

				}

			});

		});

	});
</script>

</body>

</html>


<?php
	mysqli_close($db);
	exit();
?>
