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
// page validation
if(isset($_POST['get_single_product'])){
  if ($_POST['product_id'] == "") {
  	ob_start();
  	// It will return to admin panel automatically //
  	echo "<script>alert('System Notice: Product ID undefined, please try again. Returning to Admin Panel now...');";
  	echo "window.location.href='admin_panel.php';</script>";
  	ob_end_flush();
  } else {
    $product_id = $_POST['product_id'];
    $LATESTPRODID = "SELECT * FROM product WHERE product_id = $product_id";
    $LATESTPRODIDQ = mysqli_query($db, $LATESTPRODID);
    if (mysqli_num_rows($LATESTPRODIDQ) < 1) {
      ob_start();
      // It will return to admin panel automatically //
    	echo "<script>alert('System Notice: Product ID not found within database, please try again. Returning to Admin Panel now...');";
    	echo "window.location.href='admin_panel.php';</script>";
    	ob_end_flush();
    } else {
    	// do nothing
    }
  }
}
if(isset($_POST["edit_product"])){
  if ($_POST['product_id'] == "") {
  	ob_start();
  	// It will return to admin panel automatically //
  	echo "<script>alert('System Notice: Product ID undefined, please try again. Returning to Admin Panel now...');";
  	echo "window.location.href='admin_panel.php';</script>";
  	ob_end_flush();
  } else {
    $product_id = $_POST['product_id'];
    $LATESTPRODID = "SELECT * FROM product WHERE product_id = $product_id";
    $LATESTPRODIDQ = mysqli_query($db, $LATESTPRODID);
    if (mysqli_num_rows($LATESTPRODIDQ) < 1) {
      ob_start();
      // It will return to admin panel automatically //
    	echo "<script>alert('System Notice: Product ID not found within database, please try again. Returning to Admin Panel now...');";
    	echo "window.location.href='admin_panel.php';</script>";
    	ob_end_flush();
    } else {
    	// do nothing
    }
  }
}
?>

<?php
	//Get single product detail
	if(isset($_POST['get_single_product'])){
		$uid = $_POST['product_id'];
		$query = "SELECT * FROM product WHERE product_id = '$uid'";
		$execquery = mysqli_query($db, $query);
		while($result = mysqli_fetch_array($execquery)){
			$c = $result['category_id'];
			$query2 = "SELECT category_name FROM category WHERE category_id = '$c'";
			$execquery2 = mysqli_query($db, $query2);
			while ($row2 = $execquery2->fetch_assoc()) {
				$categoryname = $row2['category_name'];
			}
			?>
			<div class="col-md-9">
				<div class="product-details">
					<h1 class="product-title"><?php echo $result['product_name'] ?></h1>
					<div class="product-meta">
						<ul class="list-inline">
							<li class="list-inline-item"><i class="fa fa-user-o"></i> By <a href="">Shoppa</a></li>
							<li class="list-inline-item"><i class="fa fa-folder-open-o"></i> Category<a href=""><?php echo $categoryname ?></a></li>
						</ul>
					</div>

					<!-- product slider -->
					<div style="margin-top:20px;">
							<img class="img-fluid w-100" src="<?php echo $result['product_image'] ?>" alt="">
					</div>
					<!-- product slider -->

					<div class="content mt-5 pt-5">
						<ul class="nav nav-pills  justify-content-center" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home"
								 aria-selected="true">Product Details</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact"
								 aria-selected="false">Reviews</a>
							</li>
						</ul>
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
								<h3 class="tab-title">Product Description</h3>
								<p style="text-align: justify;"><?php echo $result['product_description'] ?></p>

							</div>
							<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
								<h3 class="tab-title">Product Review</h3>
								<div class="product-review">
								<?php
								$query3 = "SELECT * FROM review WHERE product_id = '$uid'";
								$execquery3 = mysqli_query($db, $query3);
								while($result3 = mysqli_fetch_array($execquery3)){
									$user = $result3['user_id'];
									$rating = $result3['review_rating'];
									$query4 = "SELECT * FROM user WHERE user_id = '$user'";
									$execquery4 = mysqli_query($db, $query4);
									while($result4 = mysqli_fetch_array($execquery4)){
										$fname = $result4['user_fname'];
										$lname = $result4['user_lname'];
									}
									?>
									<div class="media">
										<!-- Avater -->
										<img src="image/user.png" alt="avater">
										<div class="media-body">
											<!-- Ratings -->
											<div class="ratings">
												<ul class="list-inline">
												<?php echo $rating ?>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												</ul>
											</div>
											<div class="name">
												<h5><?php echo $fname ?> <?php echo $lname ?></h5>
											</div>
											<div class="date">
												<p><?php echo $result3['review_date'] ?></p>
											</div>
											<div class="review-comment">
												<p style="text-align:justify;">
													<?php echo $result3['review_comment'] ?>
												</p>
											</div>
										</div>
									</div>
									<?php
								}
								?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="sidebar">
					<div class="widget price text-center">
						<h4>Price</h4>
						<p>$<?php echo $result['product_price'] ?></p><br>
					</div>
					<!-- Rate Widget -->
          <div class="widget rate">
						<!-- Heading -->
						<h5 class="widget-header text-center">Average Rating</h5>
						<!-- Rate -->
						<div class="starrr">
							<?php
								$AVGRATING = "SELECT SUM(review_rating) AS TOTALRATING, COUNT(*) AS TOTALREVIEW FROM review WHERE product_id = '$uid'";
								$AVGRATINGQ = mysqli_query($db, $AVGRATING);

								if (mysqli_num_rows($AVGRATINGQ) < 1) {
		              $totalrating = 0;
									$size = 0;
		            } else {
		              if ($row_rating = mysqli_fetch_array($AVGRATINGQ)) {
										$totalrating = $row_rating["TOTALRATING"];
										$size = $row_rating["TOTALREVIEW"];
		              }
		            }
								if (($totalrating > 0) || ($size > 0)) {
									$rating = ($totalrating / $size);
								  $ratingstar = floor($rating);
									$emptystar = (5 - $ratingstar);
								} else {
									$rating = 0;
									$ratingstar = 0;
									$emptystar = 5;
								}
								for ($n = 0; $n < $ratingstar; $n++) {
									echo '<i class="fa-star fa"></i>';
								}
								for ($n = 0; $n < $emptystar; $n++) {
									echo '<i class="fa-star-o fa"></i>';
								}
							?>
            </div>
						<br>
						<center><b><?php echo number_format((float)$rating, 2, '.', ''); ?> (<?php echo $size; ?>)</b></center>
					</div>
					<!-- Coupon Widget -->
					<div class="widget coupon text-center">
						<!-- Coupon description -->
						<p style="color:
						<?php
						if ($result['product_status'] == 0) {
							echo 'red';
						} else {
							echo '#59D659';
						}
						?>
						"><?php
						if ($result["product_status"] == 0) {
							echo 'Inactive';
						} else {
							echo 'Active';
						}
						?></p>
						<!-- Submit button -->
						<a href="admin_panel.php" class="btn btn-transparent-white">Back to Admin Panel</a>
					</div>
				</div>
			</div>
			<?php
		}
		exit();
	}
?>

<?php
if(isset($_POST["change_status_prod"])) {
  $productid = $_POST["prod_id"];
  $PRODUCTSTATUS = "SELECT * FROM product WHERE product_id = '".$productid."'";
  $PRODUCTSTATUSQ = mysqli_query($db, $PRODUCTSTATUS);

  if (mysqli_num_rows($PRODUCTSTATUSQ) < 1) {
    ob_start();
    // It will return to admin panel automatically //
    echo "<script>alert('System Notice: Product status undefined, please try again. Returning to Admin Panel now...');";
    echo "window.location.href='admin_panel.php';</script>";
    ob_end_flush();
  } else {
    if ($sqlrow = mysqli_fetch_array($PRODUCTSTATUSQ)) {
      $prodstatus= $sqlrow["product_status"];

      if ($prodstatus == 0) {
        $updatestatus = 1;
      } else {
        $updatestatus = 0;
      }

      $UPDATESTATUS = "UPDATE product SET product_status = '".$updatestatus."' WHERE product_id = '".$productid."'";
      if(mysqli_query($db, $UPDATESTATUS)) {
        if ($prodstatus == 0) {
          echo 'is activated. ('.$sqlrow["product_name"].')';
        } else {
          echo 'is deactivated. ('.$sqlrow["product_name"].')';
        }
    	}
    }
  }
  exit();
}
?>

<?php
if (isset($_FILES["product-image"]["name"])) {
  $imagelocation = "image/".basename($_FILES["product-image"]["name"]);
  $extension = pathinfo($imagelocation, PATHINFO_EXTENSION);

  if ($extension != "jpg" && $extension != "png" && $extension != "jpeg") {
    echo "System Notice: Unrecognized file format. Only files with JPG, PNG, and JPEG extension are allowed.";
  } else {
    if (move_uploaded_file($_FILES["product-image"]["tmp_name"], $imagelocation)) {
      $stmt = $db->prepare("INSERT INTO product (`product_name`, `product_description`, `product_image`, `product_price`, `product_status`, `category_id`, `product_compare`) VALUES (?,?,?,?,?,?,?)");
      $stmt->bind_param('sssdiii', $pName, $pDescription, $pImg, $pPrice, $pStatus, $pCategory, $pCompare);

      $pName = $_POST["product-name"];
      $pDescription = $_POST["product-description"];
      $pImg = $imagelocation;
      $pPrice = $_POST["product-price"];
      $pStatus = $_POST["active-selection"];
      $pCategory = $_POST["category-selection"];
      $pCompare = 0;

      // execute sql query and close connection
      $stmt->execute();
      $stmt->close();
      mysqli_close($db);

      echo "1";

    } else {
      echo "System Notice: Unable to register, please try again.";
    }
  }
  exit();
}
?>

<?php
if (isset($_POST["edit-product-id"])) {
  if (isset($_FILES["edit-product-image"]["name"])) {
    if (empty($_FILES["edit-product-image"]["name"])) {
      $stmt = $db->prepare("UPDATE product SET `product_name` = ?, `product_description` = ?, `product_price` = ?, `product_status` = ?, `category_id` = ? WHERE `product_id` = ?");
      $stmt->bind_param('ssdiii', $pName, $pDescription, $pPrice, $pStatus, $pCategory, $pID);

      $pName = $_POST["product-name"];
      $pDescription = $_POST["product-description"];
      $pPrice = $_POST["product-price"];
      $pStatus = $_POST["active-selection"];
      $pCategory = $_POST["category-selection"];
      $pID = $_POST["edit-product-id"];

      // execute sql query and close connection
      $stmt->execute();
      $stmt->close();
      mysqli_close($db);

      echo "1";
    } else {
      $imagelocation = "image/".basename($_FILES["edit-product-image"]["name"]);
      $extension = pathinfo($imagelocation, PATHINFO_EXTENSION);

      if ($extension != "jpg" && $extension != "png" && $extension != "jpeg") {
        echo "System Notice: Unrecognized file format. Only files with JPG, PNG, and JPEG extension are allowed.";
      } else {
        if (move_uploaded_file($_FILES["edit-product-image"]["tmp_name"], $imagelocation)) {
          $stmt = $db->prepare("UPDATE product SET `product_name` = ?, `product_description` = ?, `product_image` = ?, `product_price` = ?, `product_status` = ?, `category_id` = ? WHERE `product_id` = ?");
          $stmt->bind_param('sssdiii', $pName, $pDescription, $pImg, $pPrice, $pStatus, $pCategory, $pID);

          $pName = $_POST["product-name"];
          $pDescription = $_POST["product-description"];
          $pImg = $imagelocation;
          $pPrice = $_POST["product-price"];
          $pStatus = $_POST["active-selection"];
          $pCategory = $_POST["category-selection"];
          $pID = $_POST["edit-product-id"];

          // execute sql query and close connection
          $stmt->execute();
          $stmt->close();
          mysqli_close($db);

          echo "1";

        } else {
          echo "System Notice: Unable to register, please try again.";
        }
      }
    }
  } else {
    $stmt = $db->prepare("UPDATE product SET `product_name` = ?, `product_description` = ?, `product_price` = ?, `product_status` = ?, `category_id` = ? WHERE `product_id` = ?");
    $stmt->bind_param('ssdiii', $pName, $pDescription, $pPrice, $pStatus, $pCategory, $pID);

    $pName = $_POST["product-name"];
    $pDescription = $_POST["product-description"];
    $pPrice = $_POST["product-price"];
    $pStatus = $_POST["active-selection"];
    $pCategory = $_POST["category-selection"];
    $pID = $_POST["edit-product-id"];

    // execute sql query and close connection
    $stmt->execute();
    $stmt->close();
    mysqli_close($db);

    echo "1";
  }
  exit();
}
?>
