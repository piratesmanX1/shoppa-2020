<!DOCTYPE html>
<?php
// we will only start the session with session_start() IF the session isn't started yet //
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
// including the conn.php to establish connection with database //
  include "conn.php";
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
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Forget Password | Shoppa </title>
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

<section class="login py-5 border-top-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8 align-item-center">
                <div class="border">
                    <h3 class="bg-gray p-4">Forget Password</h3>
                    <form>
                        <fieldset class="p-4">
                            <input id="uname" type="text" placeholder="Username*" class="border p-3 w-100 my-2">
							<input id="email" type="text" placeholder="Email*" class="border p-3 w-100 my-2">
                            <input id="pass" type="password" placeholder="New Password*" class="border p-3 w-100 my-2">
							<input id="rpass" type="password" placeholder="Confirm Password*" class="border p-3 w-100 my-2">
                            <button id="btnRequest" type="button" class="d-block py-3 px-5 bg-primary text-white border-0 rounded font-weight-bold mt-3">Request to change</button>
                        </fieldset>
                    </form>
                </div>
            </div>
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

<!-- JQuery -->
<script>

	$("document").ready(function(){

		$("#btnRequest").click(function(){
			var uname = $("#uname").val();
			var email_add = $("#email").val();
			var pass = $("#pass").val();
			var rpass = $("#rpass").val();

			if(pass != rpass){
				alert("Please make sure the password typed are matched!");
			}
			else{
				$.ajax({
					url : "process_user.php",
					type : "POST",
					data : {
						forget_password : 1,
						username : uname,
						email : email_add,
						password : pass
					},
					success: function(response){
						alert(response);
						window.location.href = "index.php";
					}
				});
			}
		});

	});

</script>

</body>

</html>
