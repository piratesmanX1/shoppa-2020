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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Products | Shoppa </title>

  <!-- FAVICON -->
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
</head>
<body class="body-wrapper">

    <!-- navigation bar -->
    <?php
      include_once("navigation_bar.php");
    ?>

    <!-- search bar -->
    <section class="page-search" style="">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Advance Search -->
                    <div class="advance-search">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <input type="width:100%;"  type="text" class="form-control my-2 my-lg-0" id="inputtext4" placeholder="What are you looking for">
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="button" id="btnSearch" class="btn btn-primary" value="Search Now">
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="button" id="btnBack" class="btn btn-primary" value="Cancel">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- section -->

    <section class="section-sm">
        <div class="container">

            <div class="row">
                <div class="col-md-3">
                    <div class="category-sidebar">
                        <div class="widget category-list">
                            <h4 class="widget-header">All Category</h4>
                            <ul id = "catlist" class="category-list">

                                <!--use PHP display category-->
                                <?php
                                        $query = "SELECT * FROM category";
                                        $execquery = mysqli_query($db, $query);

                                        while($result = mysqli_fetch_array($execquery)){


                                ?>
                                    <li><input type="button" class="btnCategory" style="background-color: transparent;border:none;	padding: 8px 0;	text-decoration: none;	display: block;
                                    box-sizing: border-box;	transition: all .3s linear;" value="<?php echo $result['category_name'] ?>"></li>


                                </li>
                                <?php
                                        }
                                ?>

                            </ul>
                        </div>


                        <div class="widget filter">
                            <h4 class="widget-header">Show Produts</h4>
                            <select class="priceDesc">

                                <option value="low">Lowest Price</option>
                                <option value="high">Highest Price</option>
                            </select>
                        </div>

                        <div class="widget price-range w-100">
                            <h4 class="widget-header">Price Range</h4>
                            <div class="block">
                                <input id="slider1" class="range-track w-100" type="text" data-slider-min="0" data-slider-max="5000" data-slider-step="5"
                                data-slider-value="[0,5000]">
                                    <div class="d-flex justify-content-between mt-2">
                                        <?PHP
                                            //query to look for lowest price ***

                                            //query to look for highest price ***

                                        ?>
                                            <span class="value">$10<?PHP //echo lowest;?> - $5000<?PHP // echo lowest;?></span>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <input id="btnGet" type="button" class="btn btn-primary" value="Get">
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="category-search-filter">
                        <div class="row">
                            <div class="col-md-6">
                           
                            </div>
                            <div class="col-md-6">
                                <div class="view">
                                    <strong>Views</strong>
                                    <ul class="list-inline view-switcher">
                                        <li class="list-inline-item">
                                            <a  onclick="event.preventDefault();" class="text-info"><i class="fa fa-th-large"></i></a>
                                        </li>
    
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product-grid-list">
                        <div class="row mt-30">
                            <!--===============================
                            =            show Product           =
                            ================================-->
                            <div id="allProduct" class="row mt-30"></div>
                            <div id="filterProduct" class="row mt-30"></div>

                        </div>
                    </div>


                            <!--===============================
                            =            Page Number           =
                            ================================-->
                    <!-- <div class="pagination justify-content-center">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div> -->
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

    <script>

        $(window).on('load', function() {	//run jqueery on page

            var url = window.location.href;
            var id = url.substring(url.lastIndexOf('=') + 1);
            if ($.isNumeric(id)){

                $.ajax({
                    type: "POST",
                    url: "process_product.php",
                    data: {
                        category_id : id,
                        display_all_product : 0,
                    },
                    success: function(respond){
                        $("#filterProduct").html(respond).show();
                        $("#allProduct").hide();
                        $("#btnBack").hide();
                    }
                });
            }else if (typeof id == "string"){

                if (id != url) {
                    // alert("search load");
                    $.ajax({
                        type: "POST",
                        url: "process_product.php",
                        data: {
                            search_display_product : 1,
                            product_name : id,
                        },
                        success: function(respond){
                            $("#filterProduct").html(respond).show();
                            $("#allProduct").hide();
                            $("#btnBack").hide();
                        }
                        });
                }else{
                    //load search product name

                    $.ajax({
                        type: "POST",
                        url: "process_product.php",
                        data: {
                            display_all_product : 1,
                        },
                        success: function(respond){
                            $("#filterProduct").hide();
                            $("#allProduct").html(respond).show();
                            $("#btnBack").hide();
                        }
                    });

                }

            }else {

                $.ajax({
                    type: "POST",
                    url: "process_product.php",
                    data: {
                        display_all_product : 1,
                    },
                    success: function(respond){
                        $("#filterProduct").hide();
                        $("#allProduct").html(respond).show();
                        $("#btnBack").hide();
                    }
                });
            }



            });

        $("documnet").ready(function(){  //run code simultinouly when page loaded

            $("#btnSearch").click( function(){
                var search_name = $("#inputtext4").val().trim();

                if(search_name == ""){
                    location.reload();
                }else{
                    $.ajax({
                        type: "POST",
                        url: "process_product.php",
                        data: {
                            display_product : 1,
                            product_name : search_name
                        },
                        success: function(respond){
                            $("#btnBack").show();
                            $("#allProduct").hide();
                            $("#filterProduct").html(respond).show();
                        }
                    });
                }
            });


            $("#catlist").find(".btnCategory").click(function () {
                var catvalue = $(this).attr("value");

                $.ajax({
                    type: "POST",
                    url: "process_product.php",
                    data: {
                        get_product_with_category : 1,
                        cat_name : catvalue
                    },
                    success: function(respond){
                        $("#btnBack").show();
                        $("#allProduct").hide();
                        $("#filterProduct").html(respond).show();
                    }
                });
            });

            $("select.priceDesc").change(function(){
                var selecteddesc = $(this).children("option:selected").val();

                $.ajax({
                    type: "POST",
                    url: "process_product.php",
                    data: {
                        arrange_product : 1,
                        product_price : selecteddesc
                    },
                    success: function(respond){
                        $("#btnBack").show();
                        $("#allProduct").hide();
                        $("#filterProduct").html(respond).show();
                    }
                });

            });

            $('.slider').on('slide', function (ev) {
                console.log($('#slider1').val());
            });

            $("#btnBack").click( function(){
                location.reload();
                $("#btnBack").hide();
            });

            $("#btnGet").click( function(){
                var value = $('#slider1').val();

                $.ajax({
                    type: "POST",
                    url: "process_product.php",
                    data: {
                        get_product_with_price : 1,
                        product_price_range : value
                    },
                    success: function(respond){
                        $("#btnBack").show();
                        $("#allProduct").hide();
                        $("#filterProduct").html(respond).show();
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
