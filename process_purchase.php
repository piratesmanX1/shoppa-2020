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
	date_default_timezone_set('asia/kuala_lumpur');

	//Get purchase history from cart, cart item, product
	if(isset($_POST['get_purchase_history'])){
		$username = $_SESSION['username'];
		$sql = "SELECT user_id FROM user WHERE user_username = '$username'";
		$result = mysqli_query($db, $sql);
		while ($row = mysqli_fetch_array($result)){
			$uid = $row['user_id'];
		}

		$status = 1;
		$sql2 = "SELECT * FROM cart WHERE user_id = '$uid' AND cart_status = '$status'";
		$result2 = mysqli_query($db, $sql2);
		while ($row2 = mysqli_fetch_array($result2)){

			?>

			<tr>
				<td class="product-details">
					<span class="add-id"><strong>ID:</strong><?php echo $row2['cart_id'] ?></span>
					<span><strong>Ordered on: </strong><time><?php echo $row2['cart_date'] ?></time> </span>
					<span class="status active"><strong>Status:</strong>Paid</span>
				</td>
				<td class="product-category"><span class="categories">$ <?php echo $row2['cart_total_amount'] ?></span></td>
				<td class="action" data-title="Action">
					<div class="">
						<ul class="list-inline justify-content-center">
							<li class="list-inline-item">
								<a data-toggle="tooltip" data-placement="top" title="View" class="view" href="receipt.php?id=<?php echo $row2['cart_id'] ?>">
									<i class="fa fa-eye"></i>
								</a>
							</li>
						</ul>
					</div>
				</td>
			</tr>

			<?php
		}
		exit();
	}

	//Get product item inside a particular cart
	if(isset($_POST['get_purchase_item'])){
		$review = false;
		$username = $_SESSION['username'];
		$sql = "SELECT user_id FROM user WHERE user_username = '$username'";
		$result = mysqli_query($db, $sql);
		while ($row = mysqli_fetch_array($result)){
			$uid = $row['user_id'];
		}

		$cid = $_POST['cart_id'];
		$sql2 = "SELECT * FROM cart_item WHERE cart_id = '$cid'";
		$result2 = mysqli_query($db, $sql2);
		while ($row2 = mysqli_fetch_array($result2)){

			$pid = $row2['product_id'];
			$sql3 = "SELECT * FROM product WHERE product_id = '$pid'";
			$result3 = mysqli_query($db, $sql3);
			while ($row3 = mysqli_fetch_array($result3)){

				$catid = $row3['category_id'];
				$sql4 = "SELECT category_name FROM category WHERE category_id = '$catid'";
				$result4 = mysqli_query($db, $sql4);
				while ($row4 = mysqli_fetch_array($result4)){
					$category_name = $row4['category_name'];
				}

				$sql5 = "SELECT * FROM review WHERE user_id = '$uid' AND product_id = '$pid' AND cart_id = '$cid'";
				$result5 = mysqli_query($db, $sql5);
				if(mysqli_num_rows($result5) > 0){
					$review = false;
				}
				else{
					$review = true;
				}
				?>

				<tr>
					<td class="product-thumb">
						<img width="80px" height="auto" src="<?php echo $row3['product_image'] ?>" alt="image description"></td>
					<td class="product-details">
						<h3 class="title"><?php echo $row3['product_name'] ?></h3>
						<span class="add-id"><strong>Product ID:</strong><?php echo $row3['product_id'] ?></span>
						<span><strong>Price:</strong><time><?php echo $row3['product_price'] ?></time> </span>
						<span class="status active"><strong>Status</strong>Get</span>
					</td>
					<td class="product-category"><span class="categories"><?php echo $category_name ?></span></td>
					<td class="action" data-title="Action">
						<div class="">
							<ul class="list-inline justify-content-center">
							<?php

								if($review == false){

								}else{
									?>
									<li class="list-inline-item">
										<a data-toggle="tooltip" data-placement="top" title="Edit" class="edit" href="receipt_review.php?cid=<?php echo $cid ?>&pid=<?php echo $row3['product_id'] ?>">
											<i class="fa fa-pencil"></i>
										</a>
									</li>
									<?php
								}
							?>
							</ul>
						</div>
					</td>
				</tr>
				<?php
			}
		}
		exit();
	}

	//Review product based on cart id & product id
	if(isset($_POST['review_product'])){

		$username = $_SESSION['username'];
		$sql = "SELECT user_id FROM user WHERE user_username = '$username'";
		$result = mysqli_query($db, $sql);
		while ($row = mysqli_fetch_array($result)){
			$uid = $row['user_id'];
		}

		$pid = $_POST['pid'];
		$cid = $_POST['cid'];
		$rating = $_POST['rating'];
		$comment = $_POST['comment'];
		$date = date("Y-m-d");

		$stmt = $db -> prepare("INSERT INTO review(review_rating, review_comment, review_date, user_id, product_id, cart_id) VALUES (?,?,?,?,?,?) ");
		$stmt ->bind_param("ssssss", $rating, $comment, $date, $uid, $pid, $cid);

		$stmt->execute();
		$stmt->close();
		mysqli_close($db);

		echo "Review is given successfully!";
		exit();
	}
?>
