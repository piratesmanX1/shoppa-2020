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
    if ($_SESSION["role"] != 1) {
      ob_start();
    	// It will return to admin panel automatically //
    	echo "<script>alert('System Notice: You are not authorized to access this domain.');";
    	echo "window.location.href='index.php';</script>";
    	ob_end_flush();
    }
  } else {
    ob_start();
  	// It will return to admin panel automatically //
  	echo "<script>alert('System Notice: You need to login with an authorized account to access here, please try again.');";
  	echo "window.location.href='login.php';</script>";
  	ob_end_flush();
  }
?>

<?php
// get the number of products within the database
$TOTALPRODUCT = "SELECT COUNT(*) AS QUANTITY from product";
$TOTALPRODUCTQ = mysqli_query($db, $TOTALPRODUCT);

// get the number of sales report within the database
$TOTALSREPORT = "SELECT COUNT(*) AS QUANTITY FROM
                 (SELECT * FROM monthly_report GROUP BY product_category_id, month_report, year_report
                 ORDER BY year_report DESC) src";
$TOTALSREPORTQ = mysqli_query($db, $TOTALSREPORT);

// get the number of customer report that yet responded within the database
$TOTALCREPORT = "SELECT COUNT(*) AS QUANTITY from contact WHERE contact_status = 0";
$TOTALCREPORTQ = mysqli_query($db, $TOTALCREPORT);

// assigning the numbers to specific variable
// products
if ($row = mysqli_fetch_array($TOTALPRODUCTQ)) {
  $totalproduct = $row["QUANTITY"];
}

// sales report
if ($row = mysqli_fetch_array($TOTALSREPORTQ)) {
  $totalsreport = $row["QUANTITY"];
}
// customer report
if ($row = mysqli_fetch_array($TOTALCREPORTQ)) {
  $totalcreport = $row["QUANTITY"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Admin Panel | Shoppa </title>
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
							<img src="image/user_profile.png" alt="profile-picture" class="rounded-circle">
						</div>
						<!-- User Name -->
						<h5 class="text-center"><?php echo $_SESSION['user_fname'].' '.$_SESSION['user_lname']; ?></h5>
						<p>Admin</p>
						<a href="user_profile_edit.php" class="btn btn-main-sm">Edit Profile</a>
					</div>
					<!-- Dashboard Links -->
					<div class="widget user-dashboard-menu">
						<ul>
							<li class="tablink active" id="admin_dashboard">
								<a><i class="fa fa-television"></i>Dashboard</a></li>
							<li class="tablink" id="admin_product">
								<a id="product-noti"><i class="fa fa-shopping-cart"></i> Products<span><?php echo $totalproduct ?></span></a>
							</li>
							<li class="tablink" id="admin_sales_report">
								<a id="sreport-noti"><i class="fa fa-bar-chart-o"></i>Sales Report<span><?php echo $totalsreport ?></span></a>
							</li>
							<li class="tablink" id="admin_customer_report">
								<a id="creport-noti"><i class="fa fa-edit"></i>Customer Report<span><?php echo $totalcreport ?></span></a>
							</li>
							<li class="tablink">
								<a href="logout.php"><i class="fa fa-power-off"></i> Logout</a>
							</li>
						</ul>
					</div>

					<!-- delete-account modal -->
								<!-- delete account popup modal start-->
                <!-- Modal -->
                <div class="modal fade" id="deleteaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                  aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header border-bottom-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body text-center">
                        <img src="images/account/Account1.png" class="img-fluid mb-2" alt="">
                        <h6 class="py-2">Are you sure you want to change the status of this product?</h6>
                        <p>The status changes on the selected product will caused a significant change to the entire database.</p>
                      </div>
                      <div class="modal-footer border-top-0 mb-3 mx-5 justify-content-lg-between justify-content-center">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="change-status" data-dismiss="modal" value="">Confirm</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- delete account popup modal end-->
					<!-- delete-account modal -->

				</div>
			</div>
			<div class="col-md-10 offset-md-1 col-lg-8 offset-lg-0">
				<!-- Contents -->
        <span id="result"></span>
        <div class="admin_content" id="admin_content">
            <!-- including functions -->
            <?php
              include_once('admin_dashboard.php');
            ?>
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

<script type="text/javascript">
  // if click on the li will get the value, which contain the name of the page
  $('.tablink').click(function() {
		 xmlhttp=new XMLHttpRequest();
     $('.tablink').removeClass("active");
     $(this).addClass("active");
		 var page = this.id;
		 // then put into it to refresh it //
		 xmlhttp.open("POST", page +'.php',false);
		 xmlhttp.send(null);
		 document.getElementById('admin_content').innerHTML=xmlhttp.responseText;
	});
</script>
<script type="text/javascript">
  // reload the charts if the user choose the open dashboard
  document.getElementById("admin_dashboard").addEventListener("click", function(e) {
    reloadBar();
    reloadDonut();
  });
</script>
<!-- Changing content of Product List to the related Category  -->
<script type="text/javascript">
	function categoryFilter() {
	// take the value of the link clicked //
		var filter = document.getElementById("category-type").value;
		xmlhttp=new XMLHttpRequest();
		// then put into it to refresh it //
		xmlhttp.open("GET", "admin_product.php?category=" + filter,false);
		xmlhttp.send(null);
		document.getElementById('admin_content').innerHTML=xmlhttp.responseText;
	}
</script>
<!-- Changing content of Product List to the related page  -->
<script type="text/javascript">
	function productTable(number) {
	  // take the value of the link clicked //
		var page_count = number.getAttribute('value');
    var categoryfilt = number.getAttribute('id');
		xmlhttp=new XMLHttpRequest();
		// then put into it to refresh it //
    // if categoryfilt aka category more than 0, then it means the page is viewing a specific category product
    if (categoryfilt > 0) {
      xmlhttp.open("GET", "admin_product.php?page=" + page_count + "&category=" + categoryfilt ,false);
    } else {
    // else its viewing all product
      xmlhttp.open("GET", "admin_product.php?page=" + page_count ,false);
    }
		xmlhttp.send(null);
		document.getElementById('admin_content').innerHTML=xmlhttp.responseText;
	}
</script>
<script type="text/javascript">
	// update the number of notification number every 5 seconds //
  // product's notification number
	setInterval(function() {
		$('#product-noti').load('product-notification.php');
	}, 5000);
  // sreport's notification number
  setInterval(function() {
		$('#sreport-noti').load('sreport-notification.php');
	}, 5000);
  // creport's notification number
  setInterval(function() {
		$('#creport-noti').load('creport-notification.php');
	}, 5000);
</script>
<!-- Search function in Admin Product List section-->
<script>
  var pagenumb = 1;
  $(".page-item").click(function(){
      pagenumb = $(this).children('.page-link').attr('value');
  });
  function searchProduct() {
    var prodName = $("#admin-search-product").val();
    $(".page-item").click(function(){
        pagenumb = $(this).children('.page-link').attr('value');
        if (prodName == "") {
          pagenumb = 1;
          $.ajax({
            type: "POST",
            url: "admin_search_product.php",
            data: {
              search_prod: 0,
            },
            success: function(respond) {
              $("#admin_content").html(respond).show();
              $("#admin-search-product").focus().val('').val(prodName);
            }
          });
        } else {
          $.ajax({
            type: "POST",
            url: "admin_search_product.php",
            data: {
              search_prod: 1,
              searchName: prodName,
              pagenumb: pagenumb
            },
            success: function(respond) {
              $("#admin_content").html(respond).show();
              $("#admin-search-product").focus().val('').val(prodName);
            }
          });
        }
    });
    if (prodName == "") {
      pagenumb = 1;
      $.ajax({
        type: "POST",
        url: "admin_search_product.php",
        data: {
          search_prod: 0,
        },
        success: function(respond) {
          $("#admin_content").html(respond).show();
          $("#admin-search-product").focus().val('').val(prodName);
        }
      });
    } else {
      $.ajax({
        type: "POST",
        url: "admin_search_product.php",
        data: {
          search_prod: 1,
          searchName: prodName,
          pagenumb: pagenumb
        },
        success: function(respond) {
          $("#admin_content").html(respond).show();
          $("#admin-search-product").focus().val('').val(prodName);
        }
      });
    }
}
</script>
<!-- Transfer the product ID into modal for function conveniency -->
<script type="text/javascript">
  function productID(number) {
    var pid = number.getAttribute('id');
    $("#change-status").val(pid);
  }
</script>
<!-- disable the product accordingly -->
<script type="text/javascript">
  // if click on the li will get the value, which contain the name of the page
  $('#change-status').click(function() {
     var pid = this.getAttribute('value');
     $.ajax({
       type: "POST",
       url: "process_admin_product.php",
       data: {
         change_status_prod: 1,
         prod_id : pid
       },
       success: function(data) {
         $('#result').html("<div class='alert alert-success'> Product ID: "+ pid +" "+ data + "</div>");
         xmlhttp=new XMLHttpRequest();
         // then put into it to refresh it //
         xmlhttp.open("POST", 'admin_product.php',false);
         xmlhttp.send(null);
         document.getElementById('admin_content').innerHTML=xmlhttp.responseText;
         reloadBar();
         reloadDonut();
       }
     });
  });
</script>
<!-- Changing content of Sales Report List to the related page  -->
<script type="text/javascript">
	function sreportTable(number) {
	  // take the value of the link clicked //
		var page_count = number.getAttribute('value');
    var month = number.getAttribute('name');
    var year = number.getAttribute('data-value');
		xmlhttp=new XMLHttpRequest();
		// then put into it to refresh it //
    // if date values more than 0, then it means the page is viewing a specific report list
    if ((month > 0) && (year > 0)) {
      xmlhttp.open("GET", "admin_sales_report.php?page=" + page_count + "&month=" + month + "&year=" + year ,false);
    } else {
    // else its viewing all product
      xmlhttp.open("GET", "admin_sales_report.php?page=" + page_count ,false);
    }
		xmlhttp.send(null);
		document.getElementById('admin_content').innerHTML=xmlhttp.responseText;
	}
</script>
<!-- Changing content of Product List to the related date selected  -->
<script type="text/javascript">
	function dateFilter(obj) {
	// take the value of the link clicked //
		var month = document.getElementById("sreport-type").value;
    var year = obj.options[obj.selectedIndex].getAttribute('data');
		xmlhttp=new XMLHttpRequest();
		// then put into it to refresh it //
		xmlhttp.open("GET", "admin_sales_report.php?month=" + month + "&year=" + year ,false);
		xmlhttp.send(null);
		document.getElementById('admin_content').innerHTML=xmlhttp.responseText;
	}
</script>
<!-- Changing content of Customer Report List to the related page  -->
<script type="text/javascript">
	function creportTable(number) {
	  // take the value of the link clicked //
		var page_count = number.getAttribute('value');
		xmlhttp=new XMLHttpRequest();
		// then put into it to refresh it //
    xmlhttp.open("GET", "admin_customer_report.php?page=" + page_count ,false);
		xmlhttp.send(null);
		document.getElementById('admin_content').innerHTML=xmlhttp.responseText;
	}
</script>
<!-- Search function in Admin Customer Report List section-->
<script>
  var pagenumb = 1;
  $(".page-item").click(function(){
      pagenumb = $(this).children('.page-link').attr('value');
  });
  function searchCReport() {
    var creportName = $("#admin-search-creport").val();
    $(".page-item").click(function(){
        pagenumb = $(this).children('.page-link').attr('value');
        if (reportName == "") {
          pagenumb = 1;
          $.ajax({
            type: "POST",
            url: "admin_customer_report.php",
            data: {
              search_report: 0,
            },
            success: function(respond) {
              $("#admin_content").html(respond).show();
              $("#admin-search-creport").focus().val('').val(creportName);
            }
          });
        } else {
          $.ajax({
            type: "POST",
            url: "admin_customer_report.php",
            data: {
              search_report: 1,
              searchName: creportName,
              pagenumb: pagenumb
            },
            success: function(respond) {
              $("#admin_content").html(respond).show();
              $("#admin-search-creport").focus().val('').val(creportName);
            }
          });
        }
    });
    if (creportName == "") {
      pagenumb = 1;
      $.ajax({
        type: "POST",
        url: "admin_customer_report.php",
        data: {
          search_report: 0,
        },
        success: function(respond) {
          $("#admin_content").html(respond).show();
          $("#admin-search-creport").focus().val('').val(creportName);
        }
      });
    } else {
      $.ajax({
        type: "POST",
        url: "admin_customer_report.php",
        data: {
          search_report: 1,
          searchName: creportName,
          pagenumb: pagenumb
        },
        success: function(respond) {
          $("#admin_content").html(respond).show();
          $("#admin-search-creport").focus().val('').val(creportName);
        }
      });
    }
}
</script>
</body>

</html>
