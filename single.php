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
<title> Product Content | Shoppa </title>
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

<!--===================================
=            Store Section            =
====================================-->
<section class="section bg-gray">
<!-- Container Start -->

    <div class="container">
        <div id="detail" class="row">
    <div><?PHP $a = "hailat";?></div>

    </div>

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

<!-- JQuery -->
<script>

var obj;
    $(window).on('load', function(){
        var url = window.location.href;
    var id = url.substring(url.lastIndexOf('=') + 1);

    // alert(gg);

    //load single product
        $.ajax({
            type: "POST",
            url: "process_product.php",
            data: {
                get_single_product : 1,
                product_id : id
            },
            success: function(respond){
                $("#detail").html(respond).show();
            }
    });

    //get product ID
    $.ajax({
        type: "POST",
        url: "process_product.php",
        data: {
            get_single_product_id : 1,
            product_id : id
        },
        success: function(respond){
            obj = $.parseJSON(respond);
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
