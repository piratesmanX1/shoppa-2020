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
// the id of the contact we will be receiving //
if (isset($_GET["id"])) {
  $id = $_GET["id"];
} else {
  // redirect user back to admin panel if its not defined
  ob_start();
  // It will return to admin panel automatically //
  echo "<script>alert('System Notice: Contact ID is not defined, please try again. Returning to Admin Panel now...');";
  echo "window.location.href='admin_panel.php';</script>";
  ob_end_flush();
}

// then start to validate whether the contact_id is existing from database or not
if ($_GET['id'] == "") {
  ob_start();
  // It will return to admin panel automatically //
  echo "<script>alert('System Notice: Contact ID is not defined, please try again. Returning to Admin Panel now...');";
  echo "window.location.href='admin_panel.php';</script>";
  ob_end_flush();
} else {
  $id = $_GET["id"];
  $FINDCONTACTID = "SELECT * FROM contact WHERE contact_id = $id";
  $FINDCONTACTIDQ = mysqli_query($db, $FINDCONTACTID);
  if (mysqli_num_rows($FINDCONTACTIDQ) < 1) {
    ob_start();
    // It will return to admin panel automatically //
    echo "<script>alert('System Notice: Contact ID not found within database, please try again. Returning to Admin Panel now...');";
    echo "window.location.href='admin_panel.php';</script>";
    ob_end_flush();
  } else {
    // do nothing
    if ($row = mysqli_fetch_array($FINDCONTACTIDQ)) {
      $status = $row["contact_status"];
      $contact_id = $row["contact_id"];
      $contact_date = $row["contact_date"];
      $contact_content = $row["contact_content"];
      $contact_user_id = $row["user_id"];

      $contact_title = preg_replace('/(.*?[?!.](?=\s|$)).*/', '\\1', $row["contact_content"]);

      if ($status == 0) {
        // do nothing
      } else {
        $contact_admin_title = preg_replace('/(.*?[?!.](?=\s|$)).*/', '\\1', $row["contact_admin_content"]);
        $contact_admin_content = $row["contact_admin_content"];
        $contact_admin_id = $row["user_admin_id"];

        $FINDADMINNAME = "SELECT * FROM user WHERE user_id = $contact_admin_id";
        $FINDADMINNAMEQ = mysqli_query($db, $FINDADMINNAME);

        if (mysqli_num_rows($FINDADMINNAMEQ) < 1) {
          $admin_name = "-";
        } else {
          if ($row = mysqli_fetch_array($FINDADMINNAMEQ)) {
            $admin_name = $row["user_fname"]." ".$row["user_lname"];
          }
        }
      }

      // find customer name in advance
      $FINDCUSTNAME = "SELECT * FROM user WHERE user_id = $contact_user_id";
      $FINDCUSTNAMEQ = mysqli_query($db, $FINDCUSTNAME);
      if (mysqli_num_rows($FINDCUSTNAMEQ) < 1) {
        $customer_name = "-";
      } else {
        // do nothing
        if ($row = mysqli_fetch_array($FINDCUSTNAMEQ)) {
          $customer_name = $row["user_fname"]." ".$row["user_lname"];
        }
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Customer Report | Shoppa </title>
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
				<h3>Contact ID: <?php echo $contact_id ?></h3>
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>
<!-- page title -->

<!-- contact us start-->
<section class="section">
    <div class="container">
      <?php
      if ($status == 1) {
        echo '<span id="result"><div class="alert alert-success">Contact ID: '.$contact_id.' has already been replied by Admin ID: '.$contact_admin_id.', '.$admin_name.'</div></span>';
      } else {
        echo '<span id="result"></span>';
      }
      ?>
        <div class="row">
            <div class="col-md-6">
                <div class="contact-us-content p-4">
                    <h5>Customer <i><?php echo $customer_name ?></i></h5>
                    <h1 class="pt-3" style="text-overflow: ellipsis!important; overflow:hidden!important;"><?php echo $contact_title ?></h1>
                    <p class="pt-3 pb-5" style="overflow:hidden!important;"><?php echo $contact_content ?></p>
                </div>
            </div>
            <?php
              if ($status == 0) {
                echo '
                <div class="col-md-6">
                  <form action="#">
                      <fieldset class="p-4">
                          <div class="form-group">
                              <div class="row">
                                  <div class="col-lg-12 py-2">
                                      <input type="text" placeholder="Name *" class="form-control" value="'.$_SESSION['user_fname'].' '.$_SESSION['user_lname'].'" disabled>
                                  </div>
                              </div>
                          </div>
                          <textarea name="admin-message" id="admin-reply"  placeholder="Reply *" class="border w-100 p-3 mt-3 mt-lg-4" required></textarea>
                          <span id="error-msg" style="color:red;"></span>
                          <div class="btn-grounp">
                              <button type="button" class="btn btn-primary mt-2 float-right" id="creport-update">SUBMIT</button>
                              <button type="button" class="btn btn-danger mt-2 float-left" onclick="cancel_action_admin()">CANCEL</button>
                          </div>
                      </fieldset>
                  </form>
                </div>
                ';
              } else {
                echo '
                <div class="col-md-6">
                    <div class="contact-us-content p-4">
                        <h5>Admin <i>'.$admin_name.'</i> replied:</h5>
                        <h1 class="pt-3" style="text-overflow: ellipsis!important; overflow:hidden!important;">'.$contact_admin_title.'</h1>
                        <p class="pt-3 pb-5" style="overflow:hidden!important;">'.$contact_admin_content.'</p>
                    </div>
                    <div class="btn-grounp">
                        <button type="button" class="btn btn-danger mt-2 float-right" onclick="return_admin()">RETURN</button>
                    </div>
                </div>
                ';
              }
            ?>

        </div>
    </div>
</section>
<!-- contact us end -->

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
function return_admin() {
  location.href='admin_panel.php';
}
</script>
<!-- reply the customer -->
<script type="text/javascript">
  $('#creport-update').click(function() {
     var admin_reply = $("#admin-reply").val();
     if (admin_reply == "") {
       document.getElementById("error-msg").innerHTML = "System Notice: Reply form is required."
       $("#admin-reply").focus();
     } else {
       $.ajax({
         type: "POST",
         url: "process_sales_report.php",
         data: {
           update_contact: 1,
           contact_id : <?php echo $contact_id ?>,
           admin_reply : admin_reply
         },
         success: function(data) {
           if (data == 1) {
             alert("System Notice: Contact ID: <?php echo $contact_id ?> is updated.");
             // then put into it to refresh it //
             location.href='customer_report_content.php?id=<?php echo $contact_id ?>';
           } else {
             alert("System Notice: Update failed, please try again.");
           }
         }
       });
     }
  });
</script>
</body>

</html>
