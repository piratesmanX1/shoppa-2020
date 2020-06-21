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

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Edit Product | Shoppa </title>
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

<section class="ad-post bg-gray py-5"  id="edit-container">
  <?php
  if (isset($_GET["id"])) {
    $productid = $_GET["id"];
    $PRODUCTCONTENT = "SELECT * FROM product WHERE product_id = '".$productid."'";
    $PRODUCTCONTENTQ = mysqli_query($db, $PRODUCTCONTENT);
    // get all the value of category from the table within the database
    $ALLCATEGORY = "SELECT * FROM category";
    $ALLCATEGORYQ = mysqli_query($db, $ALLCATEGORY);

    if (mysqli_num_rows($PRODUCTCONTENTQ) < 1) {
      ob_start();
      // It will return to admin panel automatically //
      echo "<script>alert('System Notice: Product ID undefined, please try again. Returning to Admin Panel now...');";
      echo "window.location.href='admin_panel.php';</script>";
      ob_end_flush();
    } else {
      if ($sqlrow = mysqli_fetch_array($PRODUCTCONTENTQ)) {
        echo '
        <div class="container">
            <form id="editProduct">
                <!-- Post Your ad start -->
                <fieldset class="border border-gary p-4 mb-5">
                  <div class="col-lg-12">
                      <h3>Edit Product ('.$sqlrow["product_name"].')</h3>
                  </div>
                  <div class="choose-file text-center my-4 py-4 rounded">

                    <!-- Upload Image Section -->
                     <center class="" id="edit-info">
                       <div id="wrapper" class="img-container">
                        <img id="output_image" src="'.$sqlrow["product_image"].'" class="preview-img"/>
                        <div class="upload-text-container">
                          <div class="upload-text"><i class="fa fa-camera" aria-hidden="true"></i><br> Click here to Upload </div>
                        </div>
                        <input type="file" onchange="preview_image(event)" style="display: none;" name="edit-product-image" id="image-edit" value="'.$sqlrow["product_image"].'">
                       </div>
                       <br>
                       <span class="d-block" id="picture-name">'.basename($sqlrow["product_image"]).'</span>
                     </center>

                  </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <h6 class="font-weight-bold pt-4 pb-1">Product Name:</h6>
                                <input type="text" class="border w-100 p-2 bg-white text-capitalize" id="product-name" name="product-name" placeholder="Product Name Go There" value="'.$sqlrow["product_name"].'" required>
                                <h6 class="font-weight-bold pt-4 pb-1">Status:</h6>
                                <div class="row px-3">
                                    <div class="col-lg-4 mr-lg-4 my-2 rounded bg-white">
                                        <input type="radio" name="active-selection" value="1" id="active" required ';
                                        if ($sqlrow["product_status"] == 1) {
                                            echo 'checked';
                                        }
                                        echo
                                        '>
                                        <label for="personal" class="py-2">Active</label>
                                    </div>
                                    <div class="col-lg-4 mr-lg-4 my-2 rounded bg-white ">
                                        <input type="radio" name="active-selection" value="0" id="inactive" required ';
                                        if ($sqlrow["product_status"] == 0) {
                                            echo 'checked';
                                        }
                                        echo
                                        '>
                                        <label for="business" class="py-2">Inactive</label>
                                    </div>
                                </div>
                                <h6 class="font-weight-bold pt-4 pb-1">Product Description:</h6>
                                <textarea id="product-description" class="border p-3 w-100" rows="7" name="product-description" placeholder="Write details about your product" required>'.$sqlrow["product_description"].'</textarea>
                            </div>
                            <div class="col-lg-6">
                                <h6 class="font-weight-bold pt-4 pb-1">Select Category:</h6>
                                <select name="category-selection" id="category-selection" class="w-100" style="height:38.8px" required>
                                    <option value="0" disabled name="active-selection">Select Category</option>';
                                      $result = $db->query($ALLCATEGORY);
                                      if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                          echo '
                                          <option value="'.$row["category_id"].'" ';
                                          if ($sqlrow["category_id"] == $row["category_id"]) {
                                            echo 'selected ';
                                          }
                                          echo
                                          'name="active-selection">'.$row["category_name"].'</option>
                                          ';
                                        }
                                      }
                                    echo '
                                </select>
                                <div class="price">
                                    <h6 class="font-weight-bold pt-4 pb-1">Product Price ($ USD):</h6>
                                    <div class="row px-3">
                                        <div class="col-lg-4 mr-lg-4 rounded bg-white my-2 ">
                                            <input type="number" min="0.00" max="100000.00" step="0.01" name="product-price" class="border-0 py-2 w-100 price" placeholder="0.00" id="product-price" value="'.$sqlrow["product_price"].'" required>
                                        </div>
                                        <div class="col-lg-4 mr-lg-4 rounded bg-white my-2" style="display:none;">
                                            <input type="text" name="edit-product-id" class="border-0 py-2 w-100" placeholder="ID" id="product-id" value="'.$sqlrow["product_id"].'">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </fieldset>
                <!-- submit button -->
                <div class="checkbox d-inline-flex">
                    <input type="checkbox" id="terms-&-condition" value="1" name="t&cadd" required class="mt-1">
                    <label for="terms-&-condition" class="ml-2">By ticking this, you\'ve agreed with our
                        <span> <a class="text-success" href="#">Terms & Condition.</a></span>
                    </label>
                </div>
                <div style="position:relative">
                  <button type="button" class="btn btn-danger d-block mt-2" onclick="cancel_action_admin()">Cancel</button>
                  <button type="submit" id="edit-product" class="btn btn-primary d-block mt-2" style="position:absolute; left: 150px; bottom: 0.3px">Edit Product</button>
                </div>
                <div style="padding-top:10px"><span style="color:red;" id="error-msg"></span></div>
            </form>
        </div>
        ';
      }
    }
  } else {
    ob_start();
    // It will return to admin panel automatically //
    echo "<script>alert('System Notice: Product ID undefined, please try again. Returning to Admin Panel now...');";
    echo "window.location.href='admin_panel.php';</script>";
    ob_end_flush();
  }
  ?>
</section>

<?php
  include_once("footer.php");
?>

<style>
.no-display {
	display:none!important;
}
.img-container {
  position: relative;
  width: 50%;
  cursor: pointer;
}
.preview-img {
  opacity: 1;
  display: block;
  transition: .5s ease;
  backface-visibility: hidden;
  height:250px;
  width:250px;
  border-radius:50%;
}
.upload-text-container {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}
.img-container:hover .preview-img {
  opacity: 0.3;
}

.img-container:hover .upload-text-container {
  opacity: 1;
}

.upload-text {
  color: black;
  font-size: 16px;
  padding: 16px 32px;
  text-align:center;
}
</style>

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

<script type='text/javascript'>
  $(document).on('click', '.img-container', function () {
      // your function here
      document.getElementById("image-edit").click();
  });
</script>
<!-- Product List: Edit; Upload Image and Preview Script -->
<script type='text/javascript'>
function preview_image(event)
{
 var reader = new FileReader();
 reader.onload = function()
 {
  var output = document.getElementById('output_image');
  output.src = reader.result;
 }
 reader.readAsDataURL(event.target.files[0]);
 document.getElementById("picture-name").innerHTML = event.target.files[0].name;
}
</script>
<!-- Confirmation on returning back to Admin Panel -->
<script type='text/javascript'>
function cancel_action_admin() {
  var confirmation = confirm("System Notice: Are you sure to leave this page now? Any information you\'ve formed will be permanently lost.");
  if (confirmation == true) {
    location.href='admin_panel.php';
  } else {
    // do nothing
  }
}
</script>
<script>
$("document").ready(function(){
  $("#editProduct").on('submit',(function(e) {
    e.preventDefault();
    // validating information
    var pcategory = $(".option.selected").attr('data-value');
    var pprice = $("input[name='product-price']").val();

    if (((pcategory <= 0) || (pcategory == null)) || ((pprice <= 0) || (pprice == null))) {
      document.getElementById("error-msg").innerHTML = "System Notice: Form invalid, please try again.";
      return;
    }
    // obtain form input
    var formdata = new FormData(this);
    $.ajax({
        url:"process_admin_product.php",
        type:"POST",
        data: formdata,
        contentType: false,
        cache: false,
        processData: false,
        success: function(response) {
          if (response == 1) {
            alert("System Notice: Product edited. Returning to Admin Panel...");
            location.href='admin_panel.php';
          } else {
            alert(response);
            document.getElementById("image-edit").value = "";
            document.getElementById('output_image').src='image/e2.png';
            document.getElementById("picture-name").innerHTML = "Picture format: JPG, JPEG, PNG format only";
          }
        }
    });
    /*
    var pname = $("#product-name").attr('value');
    var pstatus = $("input[name='active-selection']:checked").val();
    var pdescription = $("#product-description").val();
    var pcategory = $(".option.selected").attr('data-value');
    var pprice = $("input[name='product-price']").val();
    var tac = $("input[name='t&cadd']:checked").val();

    // to get the picture name
    var fileInput;
    var ppic;

    if ((fileInput == "") || (fileInput == null)) {
      ppic = null;
    } else {
      ppic = fileInput.files[0].name;
    }
    */
  }));
});
</script>
</body>

</html>
