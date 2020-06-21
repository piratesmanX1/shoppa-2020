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
<title> Compare Product | Shoppa </title>
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

<section class="section bg-gray">
    <div class="container">
        <div class="row" id ="compare_details">
            <div class="col-lg-12">
                <div class="heading text-center pb-5">
                    <h2 class="font-weight-bold">Best Price Guaranteed</h2>
                </div>
            </div>


        </div>
    </div>
</section>
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
<script src="js/script.js"></script>

<script>

var pid;
    //Load all product while page on load
$(window).on("load", function(){	//run jqueery on page

    //load compare product
    $.ajax({
        type: "POST",
        url: "process_product.php",
        data: {
            display_compare : 1,

        },
        success: function(respond){
            $("#compare_details").html(respond).show();

        }
    });

});






</script>
</body>


</html>
