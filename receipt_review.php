<!DOCTYPE html>
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
  if (isset($_SESSION["user_id"])) {
		// do nothing
  } else {
    ob_start();
  	// It will return to admin panel automatically //
  	echo "<script>alert('System Notice: You need to login with an account to access this site, please try again.');";
  	echo "window.location.href='login.php';</script>";
  	ob_end_flush();
  }

  if (isset($_GET['pid'])) {
    // do nothing
  } else {
    ob_start();
  	// It will return to admin panel automatically //
  	echo "<script>alert('System Notice: Product ID is not defined, please try again.');";
  	echo "window.location.href='user_profile_purchase.php';</script>";
  	ob_end_flush();
  }
?>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Review | Shoppa </title>
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

  <!-- navigation bar -->
  <?php
    include_once("navigation_bar.php");
  ?>
<!--==================================
=            User Profile            =
===================================-->
<section class="dashboard section">
	<!-- Container Start -->
	<div class="container">
		<!-- Row Start -->
		<div class="row">
			<div class="col-md-10 offset-md-1 col-lg-4 offset-lg-0">
				<div class="sidebar">
					<!-- User Widget -->
					<div class="widget user-dashboard-profile">
						<!-- User Image -->
						<div class="profile-thumb">
							<img src="image/user_profile.png" alt="" class="rounded-circle">
						</div>
						<!-- User Name -->
						<h5 id="page-user-2" class="text-center"></h5>
						<p>All rights reserved</p>
						<a href="user_profile_edit.php" class="btn btn-main-sm">Edit Profile</a>
					</div>
					<!-- Dashboard Links -->
					<div class="widget user-dashboard-menu">
						<ul>
							<li>
								<a href="user_profile.php"><i class="fa fa-user"></i> My Profile</a></li>
							<li class="active">
								<a href="user_profile_purchase.php"><i class="fa fa-bookmark-o"></i> Purchase History</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-10 offset-md-1 col-lg-8 offset-lg-0">
				<div class="review-submission">
					<h3 class="tab-title">Submit your review</h3>
					<!-- Rate -->
					<div class="rate">
						<select name="" id="starrr" class="form-control w-300">
                                <option value="0">Stars?</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
								<option value="5">5</option>
                        </select>
						<br>
					</div>
					<div class="review-submit">
						<form action="#" class="row">
							<div class="col-12">
								<textarea name="review" id="review-comment" rows="10" class="form-control" placeholder="Message"></textarea>
							</div>
							<div class="col-12">
								<br>
								<button type="button" id="btnSubmitReview" class="btn btn-main">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Row End -->
	</div>
	<!-- Container End -->
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
	$(window).on('load', function() {
		var sessName = <?php echo json_encode($_SESSION['username']) ?>;
		$("#page-user-2").html(sessName).show();
	});

	$("document").ready(function(){

		$("#btnSubmitReview").click( function(){
			var cart_id = <?php echo json_encode($_GET['cid']) ?>;
			var product_id = <?php echo json_encode($_GET['pid']) ?>;
			var starrr = $("select#starrr").children("option:selected").val();
			var com_ment = $("#review-comment").val();

			alert(starrr);

			$.ajax({
			type : "POST",
			url : "process_purchase.php",
			data : {
				review_product : 1,
				cid : cart_id,
				pid : product_id,
				rating : starrr,
				comment : com_ment
			},
			success: function(response){
				alert(response);
				window.location.href = "user_profile_purchase.php";
			}
		});
		});

	});
</script>

</body>

</html>
