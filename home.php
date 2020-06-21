<?php
// we will only start the session with session_start() IF the session isn't started yet //
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
	include("conn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<!-- SITE TITTLE -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> Homepage | Shoppa </title>

	<!-- FAVICON -->
	<link href="logo_image/favicon.png" rel="shortcut icon">
	<link rel="icon" href="image/smile.png" type="image/png" sizes="16x16">
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

<!--===============================
=            Hero Area            =
================================-->

<section class="hero-area bg-1 text-center overly">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- Header Contetnt -->
				<div class="content-block">
					<h1>Buy & Sell Near You </h1>
					<p>Join the millions who buy and sell from each other <br> everyday in local communities around the world</p>
					<div class="short-popular-category-list text-center">
						<h2>Popular Category</h2>
						<ul class="list-inline">
							<!--use PHP display category-->
							<?php
									$query = "SELECT * FROM category";
									$execquery = mysqli_query($db, $query);
									while($result = mysqli_fetch_array($execquery)){

							?>

							<li class="list-inline-item"><!--navigate to product + categorized product-->
								<a href="product.php?id=<?php echo $result['category_id']?>  ">
								<i class="fa fa-bed"></i> <?php echo $result['category_name']?></a>
							</li>
							<?php
									}
							?>


						</ul>
					</div>

				</div>
				<!-- Advance Search -->
				<div class="advance-search">
						<div class="container">
							<div class="row justify-content-center">
								<div class="col-lg-12 col-md-12 align-content-center">
										<form  > <!--action="process_product.php" method="POST"-->
											<div class="form-row">
												<div class="form-group col-md-8">
													<input name= "search_text" type="text" style="width:100%;" class="form-control my-2 my-lg-1" id="inputtext4" placeholder="What are you looking for">
												</div>
												<div class="form-group col-md-2 align-self-center">

												</div>
												<div class="form-group col-md-2 align-self-center">
													<input type="button" id="btnSearch" class="btn btn-primary" value="Search Now">
												</div>
											</div>
										</form>
									</div>
								</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- Container End -->
</section>

<!--===================================
=            Client Slider            =
====================================-->


<!--===========================================
=            Popular deals section            =
============================================-->

<section class="popular-deals section bg-gray">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title">
					<h2>Trending Products</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas, magnam.</p>
				</div>
			</div>
		</div>
		<div class="row">
			<!-- offer 01 -->
			<div class="col-lg-12"  >
				<div class="trending-ads-slide" id = "home_trending_product">
			
				</div>
			</div>
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
<<script src="plugins/tether/js/tether.min.js"></script>
<script src="plugins/raty/jquery.raty-fa.js"></script>
<!-- <script src="plugins/slick-carousel/slick/slick.min.js"></script> -->
<script src="plugins/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="plugins/fancybox/jquery.fancybox.pack.js"></script>
<script src="plugins/smoothscroll/SmoothScroll.min.js"></script>
<!-- google map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU&libraries=places"></script>
<script src="plugins/google-map/gmap.js"></script>
<!-- <script src="js/script.js"></script>  -->



<script>
	$(window).on("load", function(){	//run jqueery on page

		$.ajax({
			type: "POST",
			url: "process_product.php",
			data: {
				display_trending_product : 1,
			},
			success: function(respond){
				$("#home_trending_product").html(respond).show();



			}
		});

	});

	$("document").ready(function(){

		$("#btnSearch").click( function(){
			var search_name = $("#inputtext4").val().trim();

			if(search_name == ""){
				location.reload();
			}else{
				$.ajax({
					type: "POST",
					url: "process_product.php",
					data: {
						home_search_text : 1,
						product_name : search_name
					},
					success: function(respond){
						window.location.href = "product.php?pn=" + search_name;
					}
				});
			}
		});

	});


</script>



</body>

</html>


<?php
	mysqli_close($db);
	exit();
?>
