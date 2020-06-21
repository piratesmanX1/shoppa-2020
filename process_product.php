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
	//search product from home
	if(isset($_POST['home_search_text'])){
		$pn = trim($_POST['product_name']);
		echo $pn;
		//header('Location: product.php?pn='.$pn.'');
	}

	//display product with product name
	if(isset($_POST['search_display_product'])){

		$key=  $_POST['product_name'];
		$query = "SELECT * FROM product WHERE product_name LIKE '%$key%' AND product_status = 1";
		$execQuery = mysqli_query($db, $query);
		while($result = mysqli_fetch_array($execQuery)){
			$c = $result['category_id'];
			$query2 = "SELECT category_name FROM category WHERE category_id = '$c'";
			$execquery2 = mysqli_query($db, $query2);
			while ($row2 = $execquery2->fetch_assoc()) {
				$categoryname = $row2['category_name'];
			}
			?>
			<div class="col-sm-12 col-lg-4 col-md-6">
				<!-- product card -->
				<div class="product-item bg-light">
					<div class="card">
						<div class="thumb-content">
							<!-- <div class="price">$200</div> -->
							<a href="single.php?id=<?php echo $result['product_id'] ?>">
								<img class="card-img-top img-fluid" style="height:200px;" src="<?php echo $result['product_image'] ?>" alt="Card image cap">
							</a>
						</div>
						<div class="card-body">
							<h4 class="card-title"><a href="single.php?id=<?php echo $result['product_id'] ?>"><?php echo $result['product_name'] ?></a></h4>
							<ul class="list-inline product-meta">
								<li class="list-inline-item">
									<a href="single.php?id=<?php echo $result['product_id'] ?>"><i class="fa fa-folder-open-o"></i><?php echo $categoryname ?></a>
								</li>
							</ul>
							<p class="card-text">$ <?php echo $result['product_price'] ?></p>
							<div class="product-ratings">
								<ul class="list-inline">
								<?php
									$totalrating = 0;
									$productid = $result['product_id'];
									$query4 = "SELECT * FROM review WHERE product_id = '$productid'";
									$execquery4 = mysqli_query($db, $query4);
									$size = mysqli_num_rows($execquery4);
									while($result4 = mysqli_fetch_array($execquery4)){
										$totalrating = $totalrating + $result4['review_rating'];
									}
									if($size > 0){
										$rating = $totalrating / $size ;
										if($rating >= 1 && $rating < 2){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 2 && $rating < 3){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 3 && $rating < 4){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 4 && $rating < 5){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating == 5){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<?php
										}
									}else{
										?>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<?php
									}
								?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		exit();
	}

	// Get product searched
	if(isset($_POST['display_product'])){
		$key = $_POST['product_name'];
		$query = "SELECT * FROM product WHERE product_name LIKE '%$key%' AND product_status = 1";
		$execQuery = mysqli_query($db, $query);
		while($result = mysqli_fetch_array($execQuery)){
			$c = $result['category_id'];
			$query2 = "SELECT category_name FROM category WHERE category_id = '$c'";
			$execquery2 = mysqli_query($db, $query2);
			while ($row2 = $execquery2->fetch_assoc()) {
				$categoryname = $row2['category_name'];
			}
			?>
			<div class="col-sm-12 col-lg-4 col-md-6">
				<!-- product card -->
				<div class="product-item bg-light">
					<div class="card">
						<div class="thumb-content">
							<!-- <div class="price">$200</div> -->
							<a href="single.php?id=<?php echo $result['product_id'] ?>">
								<img class="card-img-top img-fluid" style="height:200px;" src="<?php echo $result['product_image'] ?>" alt="Card image cap">
							</a>
						</div>
						<div class="card-body">
							<h4 class="card-title"><a href="single.php?id=<?php echo $result['product_id'] ?>"><?php echo $result['product_name'] ?></a></h4>
							<ul class="list-inline product-meta">
								<li class="list-inline-item">
									<a href="single.php?id=<?php echo $result['product_id'] ?>"><i class="fa fa-folder-open-o"></i><?php echo $categoryname ?></a>
								</li>
							</ul>
							<p class="card-text">$ <?php echo $result['product_price'] ?></p>
							<div class="product-ratings">
								<ul class="list-inline">
								<?php
									$totalrating = 0;
									$productid = $result['product_id'];
									$query4 = "SELECT * FROM review WHERE product_id = '$productid'";
									$execquery4 = mysqli_query($db, $query4);
									$size = mysqli_num_rows($execquery4);
									while($result4 = mysqli_fetch_array($execquery4)){
										$totalrating = $totalrating + $result4['review_rating'];
									}
									if($size > 0){
										$rating = $totalrating / $size ;
										if($rating >= 1 && $rating < 2){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 2 && $rating < 3){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 3 && $rating < 4){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 4 && $rating < 5){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating == 5){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<?php
										}
									}else{
										?>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<?php
									}
								?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		exit();
	}

	if(isset($_POST['category_id'])){

		$c = $_POST['category_id'];


		$query_category_name = "SELECT * FROM category WHERE category_id = '$c'";
		$execquery_1 = mysqli_query($db, $query_category_name);
		while($row1 = mysqli_fetch_array($execquery_1)){
			$category_name = $row1['category_name'];

		}

		$query_category = "SELECT * FROM product WHERE category_id = $c ";
		$execquery = mysqli_query($db, $query_category);
			while ($row = $execquery->fetch_assoc()) {
				?>

			<div class="col-sm-12 col-lg-4 col-md-6">
				<!-- product card -->
				<div class="product-item bg-light">
					<div class="card">
						<div class="thumb-content">
							<!-- <div class="price">$200</div> -->
							<a href="single.php?id=<?php echo $row['product_id'] ?>">
								<img class="card-img-top img-fluid" style="height:200px;" src="<?php echo $row['product_image'] ?>" alt="Card image cap">
							</a>
						</div>
						<div class="card-body">
							<h4 class="card-title"><a href="single.php?id=<?php echo $row['product_id'] ?>"><?php echo $row['product_name'] ?></a></h4>
							<ul class="list-inline product-meta">
								<li class="list-inline-item">
									<a href="single.php?id=<?php echo $row['product_id'] ?>"><i class="fa fa-fol der-open-o"></i><?php echo $category_name; ?></a>
								</li>
							</ul>
							<p class="card-text">$ <?php echo $row['product_price'] ?></p>
							<div class="product-ratings">
								<ul class="list-inline">
								<?php
									$totalrating = 0;
									$productid = $row['product_id'];
									$query4 = "SELECT * FROM review WHERE product_id = '$productid'";
									$execquery4 = mysqli_query($db, $query4);
									$size = mysqli_num_rows($execquery4);
									while($result4 = mysqli_fetch_array($execquery4)){
										$totalrating = $totalrating + $result4['review_rating'];
									}
									if($size > 0){
										$rating = $totalrating / $size ;
										if($rating >= 1 && $rating < 2){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 2 && $rating < 3){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 3 && $rating < 4){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 4 && $rating < 5){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating == 5){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<?php
										}
									}else{
										?>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<?php
									}
								?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php
			}






		exit();
	}

	//Get all product
	if(isset($_POST['display_all_product'])){
		$query = "SELECT * FROM product WHERE product_status = 1";
		$execquery = mysqli_query($db, $query);
		while($result = mysqli_fetch_array($execquery)){
			$c = $result['category_id'];
			$query2 = "SELECT category_name FROM category WHERE category_id = '$c'";
			$execquery2 = mysqli_query($db, $query2);
			while ($row2 = $execquery2->fetch_assoc()) {
				$categoryname = $row2['category_name'];
			}
			?>
			<div class="col-sm-12 col-lg-4 col-md-6">
									<!-- product card -->
				<div class="product-item bg-light">
					<div class="card">
						<div class="thumb-content">
							<!-- <div class="price">$200</div> -->
							<a href="single.php?id=<?php echo $result['product_id'] ?>">
								<img class="card-img-top img-fluid" style="height:200px;" src="<?php echo $result['product_image'] ?>" alt="Card image cap">
							</a>
						</div>
						<div class="card-body">
							<h4 class="card-title"><a href="single.php?id=<?php echo $result['product_id'] ?>"><?php echo $result['product_name'] ?></a></h4>
							<ul class="list-inline product-meta">
								<li class="list-inline-item">
									<a href="single.php?id=<?php echo $result['product_id'] ?>"><i class="fa fa-folder-open-o"></i><?php echo $categoryname ?></a>
								</li>
							</ul>
							<p class="card-text">$ <?php echo $result['product_price'] ?></p>
							<div class="product-ratings">
								<ul class="list-inline">
								<?php
									$totalrating = 0;
									$rating = 0;
									$productid = $result['product_id'];
									$query4 = "SELECT * FROM review WHERE product_id = '$productid'";
									$execquery4 = mysqli_query($db, $query4);
									$size = mysqli_num_rows($execquery4);
									while($result4 = mysqli_fetch_array($execquery4)){
										$totalrating = $totalrating + $result4['review_rating'];
									}
									if($size > 0){
										$rating = $totalrating / $size ;
										if($rating >= 1 && $rating < 2){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 2 && $rating < 3){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 3 && $rating < 4){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 4 && $rating < 5){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating == 5){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<?php
										}
									}else{
										?>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<?php
									}
								?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		exit();
	}

	//Get category list
	if(isset($_POST['display_category'])){
		$query = "SELECT * FROM category";
		$execquery = mysqli_query($db, $query);
		while($result = mysqli_fetch_array($execquery)){
		?>

		<li><button class="btnCategory" style="background:none;border:none;margin:10px;" ><?php echo $result['category_name'] ?></button></li>

		<?php
		}
		exit();
	}

	//Arrange product based on price range
	if(isset($_POST['arrange_product'])){
		$key = $_POST['product_price'];

		if($key == "low"){
			$query = "SELECT * FROM product WHERE product_status = 1 ORDER BY product_price ASC";
			$execquery = mysqli_query($db, $query);
			while($result = mysqli_fetch_array($execquery)){
				$c = $result['category_id'];
				$query2 = "SELECT category_name FROM category WHERE category_id = '$c'";
				$execquery2 = mysqli_query($db, $query2);
				while ($row2 = $execquery2->fetch_assoc()) {
					$categoryname = $row2['category_name'];
				}
				?>
				<div class="col-sm-12 col-lg-4 col-md-6">
										<!-- product card -->
					<div class="product-item bg-light">
						<div class="card">
							<div class="thumb-content">
								<!-- <div class="price">$200</div> -->
								<a href="single.php?id=<?php echo $result['product_id'] ?>">
									<img class="card-img-top img-fluid" style="height:200px;" src="<?php echo $result['product_image'] ?>" alt="Card image cap">
								</a>
							</div>
							<div class="card-body">
								<h4 class="card-title"><a href="single.php?id=<?php echo $result['product_id'] ?>"><?php echo $result['product_name'] ?></a></h4>
								<ul class="list-inline product-meta">
									<li class="list-inline-item">
										<a href="single.php?id=<?php echo $result['product_id'] ?>"><i class="fa fa-folder-open-o"></i><?php echo $categoryname ?></a>
									</li>
								</ul>
								<p class="card-text">$ <?php echo $result['product_price'] ?></p>
								<div class="product-ratings">
									<ul class="list-inline">
									<?php
										$totalrating = 0;
										$rating = 0;
										$productid = $result['product_id'];
										$query4 = "SELECT * FROM review WHERE product_id = '$productid'";
										$execquery4 = mysqli_query($db, $query4);
										$size = mysqli_num_rows($execquery4);
										while($result4 = mysqli_fetch_array($execquery4)){
											$totalrating = $totalrating + $result4['review_rating'];
										}
										if($size > 0){
											$rating = $totalrating / $size ;
											if($rating >= 1 && $rating < 2){
												?>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<?php
											}
											else if($rating >= 2 && $rating < 3){
												?>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<?php
											}
											else if($rating >= 3 && $rating < 4){
												?>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<?php
											}
											else if($rating >= 4 && $rating < 5){
												?>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<?php
											}
											else if($rating == 5){
												?>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<?php
											}
										}else{
											?>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
									?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
		else if ($key == "high"){
			$query = "SELECT * FROM product WHERE product_status = 1 ORDER BY product_price DESC";
			$execquery = mysqli_query($db, $query);
			while($result = mysqli_fetch_array($execquery)){
				$c = $result['category_id'];
				$query2 = "SELECT category_name FROM category WHERE category_id = '$c'";
				$execquery2 = mysqli_query($db, $query2);
				while ($row2 = $execquery2->fetch_assoc()) {
					$categoryname = $row2['category_name'];
				}
				?>
				<div class="col-sm-12 col-lg-4 col-md-6">
										<!-- product card -->
					<div class="product-item bg-light">
						<div class="card">
							<div class="thumb-content">
								<!-- <div class="price">$200</div> -->
								<a href="single.php?id=<?php echo $result['product_id'] ?>">
									<img class="card-img-top img-fluid" style="height:200px;" src="<?php echo $result['product_image'] ?>" alt="Card image cap">
								</a>
							</div>
							<div class="card-body">
								<h4 class="card-title"><a href="single.php?id=<?php echo $result['product_id'] ?>"><?php echo $result['product_name'] ?></a></h4>
								<ul class="list-inline product-meta">
									<li class="list-inline-item">
										<a href="single.php?id=<?php echo $result['product_id'] ?>"><i class="fa fa-folder-open-o"></i><?php echo $categoryname ?></a>
									</li>
								</ul>
								<p class="card-text">$ <?php echo $result['product_price'] ?></p>
								<div class="product-ratings">
									<ul class="list-inline">
									<?php
										$totalrating = 0;
										$rating = 0;
										$productid = $result['product_id'];
										$query4 = "SELECT * FROM review WHERE product_id = '$productid'";
										$execquery4 = mysqli_query($db, $query4);
										$size = mysqli_num_rows($execquery4);
										while($result4 = mysqli_fetch_array($execquery4)){
											$totalrating = $totalrating + $result4['review_rating'];
										}
										if($size > 0){
											$rating = $totalrating / $size ;
											if($rating >= 1 && $rating < 2){
												?>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<?php
											}
											else if($rating >= 2 && $rating < 3){
												?>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<?php
											}
											else if($rating >= 3 && $rating < 4){
												?>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<?php
											}
											else if($rating >= 4 && $rating < 5){
												?>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<?php
											}
											else if($rating == 5){
												?>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
												<?php
											}
										}else{
											?>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
									?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
		exit();
	}

	//Get product within price range
	if(isset($_POST['get_product_with_price'])){
		$mix = $_POST['product_price_range'];
		$range = explode(",", $mix);
		$smallest = $range[0];
		$highest = $range[1];

		$query = "SELECT * FROM product WHERE product_status = 1 AND product_price >= '$smallest' AND product_price <= '$highest' ORDER BY product_price ASC";
		$execquery = mysqli_query($db, $query);
		while($result = mysqli_fetch_array($execquery)){
			$c = $result['category_id'];
			$query2 = "SELECT category_name FROM category WHERE category_id = '$c'";
			$execquery2 = mysqli_query($db, $query2);
			while ($row2 = $execquery2->fetch_assoc()) {
				$categoryname = $row2['category_name'];
			}
			?>
			<div class="col-sm-12 col-lg-4 col-md-6">
									<!-- product card -->
				<div class="product-item bg-light">
					<div class="card">
						<div class="thumb-content">
							<!-- <div class="price">$200</div> -->
							<a href="single.php?id=<?php echo $result['product_id'] ?>">
								<img class="card-img-top img-fluid" style="height:200px;" src="<?php echo $result['product_image'] ?>" alt="Card image cap">
							</a>
						</div>
						<div class="card-body">
							<h4 class="card-title"><a href="single.php?id=<?php echo $result['product_id'] ?>"><?php echo $result['product_name'] ?></a></h4>
							<ul class="list-inline product-meta">
								<li class="list-inline-item">
									<a href="single.php?id=<?php echo $result['product_id'] ?>"><i class="fa fa-folder-open-o"></i><?php echo $categoryname ?></a>
								</li>
							</ul>
							<p class="card-text">$ <?php echo $result['product_price'] ?></p>
							<div class="product-ratings">
								<ul class="list-inline">
								<?php
									$totalrating = 0;
									$rating = 0;
									$productid = $result['product_id'];
									$query4 = "SELECT * FROM review WHERE product_id = '$productid'";
									$execquery4 = mysqli_query($db, $query4);
									$size = mysqli_num_rows($execquery4);
									while($result4 = mysqli_fetch_array($execquery4)){
										$totalrating = $totalrating + $result4['review_rating'];
									}
									if($size > 0){
										$rating = $totalrating / $size ;
										if($rating >= 1 && $rating < 2){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 2 && $rating < 3){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 3 && $rating < 4){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 4 && $rating < 5){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating == 5){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<?php
										}
									}else{
										?>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<?php
									}
								?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		exit();
	}

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
					<div class="widget price text-center" style="border-radius: 15px;">
						<h4>Price</h4>
						<p>$<?php echo $result['product_price'] ?></p><br>

            <?php
			if(isset($_SESSION["role"])){
				
				if ($_SESSION["role"] == 0) { //ONLY CUSTOMER CAN HAVE BUTTON
					echo '
					<button  id= "btnCart" class="btn btn-transparent-white-single" value="'.$result["product_id"].'" >Add to Cart</button>
					<button  id= "btnCompare" class="btn btn-transparent-white-single" >Add to Compare</button>
					';
				}
			}
              
            ?>
            
					</div>
				</div>
			</div>

			<script>
					$("document").ready(function(){

						//btnCompare
						$("#btnCompare").click(function () {

							$.ajax({
								type: "POST",
								url: "process_product.php",
								data: {
								product_compare: 1,
								product_id : obj


								},
								success: function(success){
									alert(success);
								}
							});
						});

						//btnCompare
						$("#btnCart").click(function () {

							$.ajax({
								type: "POST",
								url: "process_product.php",
								data: {
								add_to_cart: 1,
								product_id : obj


								},
								success: function(respond){
									alert(respond);
								}
							});
						});

					});


			</script>
			<?php
		}
		exit();
	}


	// SELECT * FROM cart
	// 				INNER JOIN cart_item ON cart_item.cart_id = cart.cart_id
	// 				WHERE cart.cart_status = '0'
	//ADD PRODUCT TO CART
	if(isset($_POST['add_to_cart'])){

		$product_id = $_POST['product_id'];

		//SEARCH IF INCOMPLETE CART ID EXIST --> GET CART_ID
		$query1 = " SELECT * FROM cart
					WHERE cart.cart_status = '0'  ";
		$execquery1 = mysqli_query($db, $query1);

        if(mysqli_num_rows($execquery1) < 1){
			//NO CART EXIST

			$cart_status = 0;
			$cart_total_amount = 0;
			$cart_date = date("Y-m-d");
			$user_id = $_SESSION['user_id'];

			//INSERT NEW CART
			$stmt1 = $db -> prepare("INSERT INTO `cart` (`cart_status`, `cart_total_amount`, `cart_date`, `user_id`) VALUES (?,?,?,?); ");
			$stmt1 ->bind_param("ssss", $cart_status, $cart_total_amount, $cart_date, $user_id);

			$stmt1->execute();
			$stmt1->close();
			// mysqli_close($db);

			echo "Added new Cart!!  ";


			//CHECK FOR NEW CART_ID
			$query4 = "	SELECT * FROM cart WHERE cart_status = '0'" ;
			$execquery4 = mysqli_query($db, $query4);
			while($result4 = mysqli_fetch_array($execquery4)){

				//INSERT NEW CART ITEM
				$cart_id = $result4['cart_id'];
				//$product_id = ok
				$cart_item_quantity = 1;
				$cart_date = date("Y-m-d");
				$user_id = $_SESSION['user_id'];

				//INSERT NEW CART
				$stmt1 = $db -> prepare("INSERT INTO `cart_item` (`product_id`, `cart_item_quantity`, `cart_id`) VALUES (?,?,?); ");
				$stmt1 ->bind_param("iii",  $product_id, $cart_item_quantity, $cart_id);

				$stmt1->execute();
				$stmt1->close();
				mysqli_close($db);

				echo "Added new Cart & new Cart Item!!  ";

			}

		}else{
			//CART EXIST, CART ITEM EXIST
			while($result = mysqli_fetch_array($execquery1)){

				$cart_id = $result['cart_id'];

				//CARTLIST EXITS
				if(isset($cart_id)){

					//VALIDATE IF PRODUCT ALREADY EXIST IN CART ITEM
					$query2 = "	SELECT * FROM cart
								INNER JOIN cart_item ON cart_item.cart_id = cart.cart_id
								WHERE cart.cart_status = '0' AND cart_item.product_id = $product_id " ;
					$execquery2 = mysqli_query($db, $query2);


					if(mysqli_num_rows($execquery2) < 1){
						// PRODUCT ID DOES NOT EXIST --> INSERTION

							// INSERT product_id INTO cart_item BASED ON cart_id
							$quantity = 1;

							$stmt = $db -> prepare("INSERT INTO cart_item(product_id, cart_item_quantity, cart_id) VALUES (?,?,?) ");
							$stmt ->bind_param("iii", $product_id, $quantity, $cart_id);

							$stmt->execute();
							$stmt->close();

							mysqli_close($db);

							echo "Added to item cartlist!!";
							exit();
					}else{
						while($result2 = mysqli_fetch_array($execquery2)){
							$pid = $result2['product_id'];
							$quantity = $result2['cart_item_quantity'];
							// echo $pid;
							// echo $product_id;
							if($product_id == $pid){
								//PRODUCT ID EXIST --> UPDATE QUANTITY
								$query3 = "	UPDATE cart_item  INNER JOIN  cart
											ON cart_item.cart_id = cart.cart_id
											SET cart_item.cart_item_quantity = ($quantity +1)
											WHERE cart_item.product_id = $product_id AND cart.cart_status = '0' ";
								$execquery3 = mysqli_query($db, $query3);

								echo "Item quantity:  ";
								echo $quantity +1;
							}else{

							}
						}
					}



				}

			}
		}





		//

	}

	//get product with category
	if(isset($_POST['get_product_with_category'])){
		$category_name = $_POST['cat_name'];

		$query = "SELECT * FROM category WHERE category_name = '$category_name'";
		$execquery = mysqli_query($db, $query);
		while($result = mysqli_fetch_array($execquery)){
			$catid = $result['category_id'];
		}

		$query2 = "SELECT * FROM product WHERE category_id = '$catid'";
		$execquery2 = mysqli_query($db, $query2);
		while($result2 = mysqli_fetch_array($execquery2)){
			?>

			<div class="col-sm-12 col-lg-4 col-md-6">
				<!-- product card -->
				<div class="product-item bg-light">
					<div class="card">
						<div class="thumb-content">
							<!-- <div class="price">$200</div> -->
							<a href="single.php?id=<?php echo $result2['product_id'] ?>">
								<img class="card-img-top img-fluid" style="height:200px;" src="<?php echo $result2['product_image'] ?>" alt="Card image cap">
							</a>
						</div>
						<div class="card-body">
							<h4 class="card-title"><a href="single.php?id=<?php echo $result2['product_id'] ?>"><?php echo $result2['product_name'] ?></a></h4>
							<ul class="list-inline product-meta">
								<li class="list-inline-item">
									<a href="single.php?id=<?php echo $result2['product_id'] ?>"><i class="fa fa-fol der-open-o"></i><?php echo $category_name ?></a>
								</li>
							</ul>
							<p class="card-text">$ <?php echo $result2['product_price'] ?></p>
							<div class="product-ratings">
								<ul class="list-inline">
								<?php
									$totalrating = 0;
									$productid = $result2['product_id'];
									$query4 = "SELECT * FROM review WHERE product_id = '$productid'";
									$execquery4 = mysqli_query($db, $query4);
									$size = mysqli_num_rows($execquery4);
									while($result4 = mysqli_fetch_array($execquery4)){
										$totalrating = $totalrating + $result4['review_rating'];
									}
									if($size > 0){
										$rating = $totalrating / $size ;
										if($rating >= 1 && $rating < 2){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 2 && $rating < 3){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 3 && $rating < 4){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 4 && $rating < 5){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating == 5){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<?php
										}
									}else{
										?>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<?php
									}
								?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php
		}
		exit();
	}

	if(isset($_POST['display_trending_product'])){


		$query = "SELECT * FROM product WHERE product_status = 1";
		$execquery = mysqli_query($db, $query);
		while($result = mysqli_fetch_array($execquery)){
			$c = $result['category_id'];
			$query2 = "SELECT category_name FROM category WHERE category_id = '$c'";
			$execquery2 = mysqli_query($db, $query2);
			while ($row2 = $execquery2->fetch_assoc()) {
				$categoryname = $row2['category_name'];
			}
			?>
			<!--htmlcode-->

			<div class="col-sm-12 col-lg-4">
				<!-- product card -->

				<div class="product-item bg-light">
					<div class="card">
						<div class="thumb-content">
							<!-- <div class="price">$200</div> -->
							<a href="single.php?id=<?php echo $result['product_id'] ?>">
								<img class="card-img-top img-fluid" src="<?php echo $result['product_image']; ?>" alt="Card image cap" height = "280" width = "340">
							</a>
						</div>
						<div class="card-body">
							<h4 class="card-title"><a href="single.php?id=<?php echo $result['product_id'] ?>"><?php echo $result['product_name']; ?></a></h4>
							<ul class="list-inline product-meta">
								<li class="list-inline-item">
									<a href="single.php?id=<?php echo $result['product_id'] ?>"><i class="fa fa-folder-open-o"></i><?php echo $categoryname; ?></a>
								</li>
								<li class="list-inline-item">

								</li>
							</ul>
							<p class="card-text"><?php echo $result['product_description']; ?></p>
							<div class="product-ratings">
								<ul class="list-inline">
								<?php
									$totalrating = 0;
									$rating = 0;
									$productid = $result['product_id'];
									$query4 = "SELECT * FROM review WHERE product_id = '$productid'";
									$execquery4 = mysqli_query($db, $query4);
									$size = mysqli_num_rows($execquery4);
									while($result4 = mysqli_fetch_array($execquery4)){
										$totalrating = $totalrating + $result4['review_rating'];
									}
									if($size > 0){
										$rating = $totalrating / $size ;
										if($rating >= 1 && $rating < 2){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 2 && $rating < 3){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 3 && $rating < 4){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating >= 4 && $rating < 5){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item"><i class="fa fa-star"></i></li>
											<?php
										}
										else if($rating == 5){
											?>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
											<?php
										}
									}else{
										?>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<li class="list-inline-item"><i class="fa fa-star"></i></li>
										<?php
									}
								?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- JAVASCRIPTS -->
		<!-- tether js -->

		<script src="plugins/slick-carousel/slick/slick.min.js"></script>
		<!-- google map -->
		<script src="js/script.js"></script>

			<?php
		}
		exit();
	}

	// pass product_id for compare / cart
	if(isset($_POST['get_single_product_id'])){
		echo $_POST['product_id'];

		exit();
	}

	//UPDATE COMPARE STATUS
	if(isset($_POST['product_compare'])){

		//VARIABLES
		$update_status = "";  //CHECK IF UPDATE SUCCESS
		$p_id = $_POST['product_id']; // PRODUCT ID FROM SINGLE PAGE
		$count = 0;

			//CHECK
			$query = "SELECT product_compare FROM product WHERE product_id = '$p_id'  ";
			$execquery = mysqli_query($db, $query);
			while($result = mysqli_fetch_array($execquery)){
				$compare_status = $result['product_compare'];
			}

			if($compare_status == 1){

				$update_status = "Product already in compare status. ";

			}else{

				//CHECK NUMBER OF PRODUCTS IN COMPARE STATUS
				$query2 = "SELECT product_id FROM product WHERE product_compare = 1";
				$execquery2 = mysqli_query($db, $query2);
				while($result2 = mysqli_fetch_array($execquery2)){
					$count ++;
				}

				if ($count >= 3) {

					$update_status = "Already 3 products in compare! ";

				}else{

					//UPDATE QUERY
					$query1 = "UPDATE product SET product_compare = 1 WHERE product_id = '$p_id'";
					$execquery1 = mysqli_query($db, $query1);

					if(mysqli_affected_rows($db)>0){

						$update_status = "Product compare status updated ";

					}else{

						$update_status =  "Product compare status not updated ";

					}
				}


		}
		//ALERT RESULT
		echo $update_status;
		exit();
	}

	//UPDATE CART
	if(isset($_POST['product_tocart'])){


		echo $cart_status;
		exit();
	}


//*************SINGLE PAGE FUNCTIONS **************** */

//*************COMAPRE PAGE FUNCTIONS **************** */

	//DISPLAY COMPARE
	if (isset($_POST['display_compare'])) {

		?>
		<!-- TITLE -->
		<div class="col-lg-12">
			<div class="heading text-center pb-5">
				<h1 class="font-weight-bold">Best Price Guaranteed</h1>
			</div>
		</div>
		<?PHP
		$compareItem = 0;
		$query1 = "	SELECT * FROM product WHERE product_compare =1";
		$execquery1 = mysqli_query($db, $query1);
		while($result1 = mysqli_fetch_array($execquery1)){

		$compareItem++;
			?>



			<div class="col-lg-4 col-md-6 mx-sm-auto">
                <div class="package-content bg-light border text-center p-5 my-2 my-lg-0">
                    <div class="package-content-heading border-bottom">
                            <!--<i class="fa fa-rocket"  ></i>-->
                            <image  class = "compare_image" src = "<?php echo $result1['product_image'];?>" width="200" height="150"" ></image>

                        <h2 style = "padding-top: 30px;"><?php echo $result1['product_name'];?></h2>
                        <h4 class="py-3"> <span>$50.00</span> Per Month</h4>
                    </div>
                    <ul>
                        <li class="my-4"> <i class="fa fa-check"></i>Details</li>
                        <li class="my-4" style = "text-align: justify;"></i><?php echo $result1['product_description'];?></li>

                    </ul>

					<button id="btnCart<?php echo $result1['product_id'];?>" value = "<?php echo $result1['product_id'];?>" onclick=""  class="btn btn-primary btnBuy" style = "width: 80%; margin-bottom: 20px;" >Buy Now</button>
					<button id = "<?php echo $result1['product_id'];?>"   value = "Remove Compare" class="btn btn-primary btnRemove" >Remove Compare</button>

                </div>
            </div>
			<script>

				$("document").ready(function(){

					$("#btnCart<?php echo $result1['product_id'];?>").click(function () {
						

						var pid = <?php echo $result1['product_id'];?>;
						
						$.ajax({
							type: "POST",
							url: "process_product.php",
							data: {
							add_to_cart: 1,
							product_id : pid
							

							},
							success: function(respond){
								alert(respond);
								// $("#compare_details").html(respond).show();

							} 
						});
					});

					$("#<?php echo $result1['product_id'];?>").click(function () {

						var pid = <?php echo $result1['product_id'];?>;
						// alert(pid);
						$.ajax({
							type: "POST",
							url: "process_product.php",
							data: {
								unset_compare: 1,
								product_id : pid,

							},
							success: function(respond){
								alert(respond);

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

							}
						});
					});
				});
			</script>
			<?PHP
		} // END POINT WITH WHILE LOOP
		if ($compareItem == 0){
			?>
			<!--DISPLAY NO PRODUCT IN COMPARE -->
		<div style = "width:100%; left:50%;display: inline-block; text-align: center;">
			<div class="row" style = "">
				<div class="col-md-6 text-center mx-auto">
					<div class="404-img">
						<img src="image/noproduct.png" class="img-fluid" alt="">
					</div>
					<div class="404-content">
						<h1 class="display-2 pt-1 pb-2" style = "font-size : 6em;"></h1>
						<p class="px-3 pb-2 text-dark">Select more products to compare!</p>
						<a href="home.php" class="btn btn-info">GO HOME</a>
					</div>
				</div>
			</div>
		</div>


			<?PHP
		}
	}

	//UNSET COMPARE STATUS
	if (isset($_POST['unset_compare'])) {

		//VARIABLES
		$update_status = "";  //CHECK IF UPDATE SUCCESS
		$p_id = $_POST['product_id']; // PRODUCT ID FROM SINGLE PAGE
		$count = 0;

			//CHECK
			$query = "SELECT product_compare FROM product WHERE product_id = '$p_id'  ";
			$execquery = mysqli_query($db, $query);
			while($result = mysqli_fetch_array($execquery)){
				$compare_status = $result['product_compare'];
			}

			if($compare_status == 0){

				$update_status = "Product already already unset. ";

			}else{

				//CHECK NUMBER OF PRODUCTS IN COMPARE STATUS
				$query2 = "SELECT product_id FROM product WHERE product_compare = 1";
				$execquery2 = mysqli_query($db, $query2);
				while($result2 = mysqli_fetch_array($execquery2)){
					$count ++;
				}


				//UPDATE QUERY
				$query1 = "UPDATE product SET product_compare = 0 WHERE product_id = '$p_id'";
				$execquery1 = mysqli_query($db, $query1);

				if(mysqli_affected_rows($db)>0){

					$update_status = "Product compare status updated ";

				}else{

					$update_status =  "Product compare status not updated ";

				}

		}
		//ALERT RESULT
		echo $update_status;
		exit();
	}

//*************COMAPRE PAGE FUNCTIONS **************** */

//*************CART PAGE FUNCTIONS **************** */

	//DISPLAY PRODUCT IN CAL PRICE AREA
	if(isset($_POST['cal_cart'])){

		$totalPrice = 0.00;
		$query = " 	SELECT * FROM cart
					INNER JOIN cart_item ON cart_item.cart_id = cart.cart_id
					WHERE cart.cart_status = '0' ";
		$execquery = mysqli_query($db, $query);
		while($result = mysqli_fetch_array($execquery)){
			$product_id = $result['product_id']; //PRODUCT ID
			$quantity = $result['cart_item_quantity'];//VALUE QUANTITY


			$query2 = "SELECT * FROM product INNER JOIN category ON product.category_id = category.category_id
			WHERE product_id = $product_id  ";
			$execquery2 = mysqli_query($db, $query2);
			while($result2 = mysqli_fetch_array($execquery2)){
				$pprice = $result2['product_price'];//VALUE PRODUCT PRICE
				$pname = $result2['product_name'];//VALUE PRODUCT NAME
				$pcategory = $result2['category_name']; // VALUE PRODUCT CATEGORY

				$product_total_price = $quantity * $pprice;


			?>
			<!--HTML CODE-->

				<li>
                    <a href="single.php?=<?php echo $product_id;?>"><i class="fa fa-shopping-bag"></i>
					<?php echo $pname;?><span><?php echo "RM".$product_total_price;?></span></a>
                </li>
			<?php
			}

			$totalPrice = $totalPrice + $product_total_price;
		}

		?>
		<!--DISPLAY TOTAL PRICE-->
			<li>
				<a href=""><i class="fa fa-money"></i>Total Price<span><?php echo "RM".$totalPrice;?></span></a>
			</li>
			<div id="check_out" class="btn btn-main-sm" >Check Out</div>
			<div id="clear_cart" href="product.php" class="btn btn-main-sm" >Clear</div>

		<script>


			function confirm_clear() {
				var myConfirm = confirm("Sure you sure to remove item from cartlist?");
				return myConfirm;
			}


			function confirm_transaction() {
				var myConfirm = confirm("Sure you sure to proceed to checkout with the total of RM " + <?php echo $totalPrice;?> + "? ");
				return myConfirm;
			}
			//CLEAR PRODUCT
			$("docuement").ready(function(){

				$("#clear_cart").click( function(){

					if(confirm_clear()){
						//UPDATE PRODUCT QUANTITY.
						$.ajax({
							type: "POST",
							url: "process_product.php",
							data: {
								clear_cartlist : 1,
							},
							success: function(respond){
								$("#display_cal_cart").html(respond).show();
								$.ajax({
									type: "POST",
									url: "process_product.php",
									data: {
										cal_cart : 1,

									},
									success: function(respond){
										$("#display_cal_cart").html(respond).show();

									}
								});

								//load cartlist
								$.ajax({
									type: "POST",
									url: "process_product.php",
									data: {
										display_cartlist : 1,

									},
									success: function(respond){
										$("#display_cartlist").html(respond).show();

									}
								});

							}
						});
					}else{
						alert("Continue shopping =D");
					}
				});

				$("#check_out").click(function(){

					if(confirm_transaction()){
						//UPDATE PRODUCT QUANTITY.
						$.ajax({
							type: "POST",
							url: "process_product.php",
							data: {
								check_out : 1,
								total_price : <?php echo $totalPrice;?>
							},
							success: function(respond){

								alert(respond);
								window.location.href = "product.php";

							}
						});
					}else{
						alert("Continue shopping =D");

					}
				});
			});



		</script>
		<?php
	}

	//DISPLAY PRODUCT IN CART
	if(isset($_POST['display_cartlist'])){

		$totalPrice = 0.00;
		$query = " 	SELECT * FROM cart
					INNER JOIN cart_item ON cart_item.cart_id = cart.cart_id
					WHERE cart.cart_status = '0' ";
		$execquery = mysqli_query($db, $query);
		while($result = mysqli_fetch_array($execquery)){
			$product_id = $result['product_id']; //PRODUCT ID
			$quantity = $result['cart_item_quantity'];//VALUE QUANTITY


			$query2 = "SELECT * FROM product INNER JOIN category ON product.category_id = category.category_id
			WHERE product_id = $product_id  ";
			$execquery2 = mysqli_query($db, $query2);
			while($result2 = mysqli_fetch_array($execquery2)){
				$pprice = $result2['product_price'];//VALUE PRODUCT PRICE
				$pname = $result2['product_name'];//VALUE PRODUCT NAME
				$pcategory = $result2['category_name']; // VALUE PRODUCT CATEGORY
				$pimage = $result2['product_image']; // VALUE PRODUCT IMAGE
				$pdescription = $result2['product_description']; // VALUE PRODUCT DESCRIPTION



				$product_total_price = $quantity * $pprice;


			?>
			<!--HTML CODE-->
				<tr>
					<td class="product-thumb">
					<a href="single.php?=<?php echo $product_id;?>"><img width="80px" height="auto" src="<?php echo $pimage; ?>" alt="image description"></td></a>
					<td class="product-details">
						<a href="single.php?=<?php echo $product_id;?>"><h3 class="title"><?php echo $pname; ?></h3></a>
						<a href="single.php?=<?php echo $product_id;?>"><span class="add-id"><strong>Product ID: </strong><?php echo $product_id;?></span></a>
						<a href="single.php?=<?php echo $product_id;?>"><span><strong>Price: </strong><time><?php echo $pprice;?></time> </span></a>
						<!-- <span class="status active"><strong>Status</strong>Active</span> -->
						<a href="single.php?=<?php echo $product_id;?>"><span class=""><strong>Quantity: </strong><?php echo $quantity;?></span></a>
					</td>
					<td class="product-category"><span class="categories">Laptops</span></td>
					<td class="action" data-title="Action">
						<div class="">
							<ul class="list-inline justify-content-center">
							<li class="list-inline-item">
									<a id = "plus<?php echo $product_id;?>" data-toggle="tooltip" data-placement="top" title="add" class="view" >
										<i class="fa fa-plus"></i>
									</a>
								</li>
								<li class="list-inline-item">
									<a  id = "minus<?php echo $product_id;?>"  data-toggle="tooltip" data-placement="top" title="minus" class="edit" >
										<i class="fa fa-minus"></i>
									</a>
								</li>
								<li class="list-inline-item">
									<a id = "delete<?php echo $product_id;?>"  data-toggle="tooltip" data-placement="top" title="Delete" class="delete" >
										<i class="fa fa-trash"></i>
									</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>


			<?php
			}

			$totalPrice = $totalPrice + $product_total_price;

			?>
			<script>

			// function popup() {
			// var a = popupbox('Warning', 'Are you sure?', 'yesno');
			// alert(a);
			// }


			function confirm_delete() {
				var myConfirm = confirm("Sure you sure to remove item from cartlist?");
				return myConfirm
			}
			$("docuement").ready(function(){

				$("#plus<?php echo $product_id;?>").click( function(){
					var get_string_id = "plus<?php echo $product_id;?>";
					var add_product_id = parseInt(get_string_id.replace(/[a-z]/ig, ""));
					// alert(add_product_id);

						//UPDATE PRODUCT QUANTITY.
						$.ajax({
							type: "POST",
							url: "process_product.php",
							data: {
								plus_product_quantity : 1,
								product_id : add_product_id
							},
							success: function(respond){

								//load cart cal product
								$.ajax({
									type: "POST",
									url: "process_product.php",
									data: {
										cal_cart : 1,

									},
									success: function(respond){
										$("#display_cal_cart").html(respond).show();

									}
								});


								//load cartlist
								$.ajax({
									type: "POST",
									url: "process_product.php",
									data: {
										display_cartlist : 1,

									},
									success: function(respond){
										$("#display_cartlist").html(respond).show();

									}
								});
							}
						});

            	});

				$("#minus<?php echo $product_id;?>").click( function(){
					var get_string_id = "minus<?php echo $product_id;?>";
					var minus_product_id = parseInt(get_string_id.replace(/[a-z]/ig, ""));
					// alert(minus_product_id);

						//UPDATE PRODUCT QUANTITY.
						$.ajax({
							type: "POST",
							url: "process_product.php",
							data: {
								minus_product_quantity : 1,
								product_id : minus_product_id
							},
							success: function(respond){
								//load cart cal product
								$.ajax({
									type: "POST",
									url: "process_product.php",
									data: {
										cal_cart : 1,

									},
									success: function(respond){
										$("#display_cal_cart").html(respond).show();

									}
								});


								//load cartlist
								$.ajax({
									type: "POST",
									url: "process_product.php",
									data: {
										display_cartlist : 1,

									},
									success: function(respond){
										$("#display_cartlist").html(respond).show();

									}
								});
							}
						});

            	});

				$("#delete<?php echo $product_id;?>").click( function(){
					var get_string_id = "minus<?php echo $product_id;?>";
					var delete_product_id = parseInt(get_string_id.replace(/[a-z]/ig, ""));

					if(confirm_delete()){
						alert("Proceed to delete item from cart");
						//DELETE ITEM FROM CART
						$.ajax({
							type: "POST",
							url: "process_product.php",
							data: {
								delete_product_quantity : 1,
								product_id : delete_product_id
							},
							success: function(respond){
								$("#display_cal_cart").html(respond).show();

								//load cart cal product
								$.ajax({
									type: "POST",
									url: "process_product.php",
									data: {
										cal_cart : 1,

									},
									success: function(respond){
										$("#display_cal_cart").html(respond).show();

									}
								});


								//load cartlist
								$.ajax({
									type: "POST",
									url: "process_product.php",
									data: {
										display_cartlist : 1,

									},
									success: function(respond){
										$("#display_cartlist").html(respond).show();

									}
								});
							}
						});
					}else{
						alert("Continue shopping =D");

					}

            	});


			});




			</script>



			<?php
		}
	}

	//ADD PRODUCT QUANTITY.
	if(isset($_POST['plus_product_quantity'])){

		$product_id = $_POST['product_id'];

		$totalPrice = 0.00;
		$query = " 	SELECT * FROM cart
					INNER JOIN cart_item ON cart_item.cart_id = cart.cart_id
					WHERE CART.cart_status = '0'
					AND product_id = $product_id  ";
		$execquery = mysqli_query($db, $query);
		while($result = mysqli_fetch_array($execquery)){
			$product_id = $result['product_id']; //PRODUCT ID
			$quantity = $result['cart_item_quantity'];//VALUE QUANTITY

			// echo "<script> alert('".$quantity."'); </script>";

			$query2 = "	UPDATE cart_item  INNER JOIN  cart
						ON cart_item.cart_id = cart.cart_id
						SET cart_item.cart_item_quantity = ($quantity +1)
						WHERE cart_item.product_id = $product_id AND cart.cart_status = '0' ";
			$execquery2 = mysqli_query($db, $query2);
		}
	}

	//MINUS PRODUCT QUANTITY.
	if(isset($_POST['minus_product_quantity'])){
		// echo "<script> alert('sdfsdfsdf!'); </script>";

		$product_id = $_POST['product_id'];


		$query = " 	SELECT * FROM cart
					INNER JOIN cart_item ON cart_item.cart_id = cart.cart_id
					WHERE cart.cart_status = '0'
					AND product_id = $product_id  ";
		$execquery = mysqli_query($db, $query);
		while($result = mysqli_fetch_array($execquery)){
			$product_id = $result['product_id']; //PRODUCT ID
			$quantity = $result['cart_item_quantity'];//VALUE QUANTITY

			// echo "<script> alert('".$quantity."'); </script>";


			if($quantity == 0 ){
				?>
				<div>fsdafasd</div>
				<script>alert("Zero Product");</script>
				<?PHP
			}else if($quantity == 1){
				echo "<script> alert('Last Product!'); </script>";

				?>
				<script>

				var confirm_delete = confirm("Last item, are you sure to remove?");
				if (confirm_delete == true) {
					//NO EXECUTION
				}else{
					alert("no delete");
				}




				</script>

				<?PHP
			}else{
				// echo "<script> alert('Can Minus!'); </script>";

				$minus_quantity = $quantity -1;

				$query2 = "	UPDATE cart_item  INNER JOIN  cart
				ON cart_item.cart_id = cart.cart_id
				SET cart_item.cart_item_quantity = $minus_quantity
				WHERE cart_item.product_id = $product_id AND cart.cart_status = '0' ";
				$execquery2 = mysqli_query($db, $query2);
			}



		}
	}

	//DELETE PRODUCT QUANTITY.
	if(isset($_POST['delete_product_quantity'])){

		$product_id = $_POST['product_id'];
		$delete_query = "	DELETE cart_item.* FROM cart_item
							INNER JOIN cart ON cart.cart_id = cart_item.cart_id
							WHERE cart.cart_status = '0'
							AND cart_item.product_id = $product_id ";
		$execquery2 = mysqli_query($db, $delete_query);



	}


	//DELETE PRODUCT QUANTITY.
	if(isset($_POST['clear_cartlist'])){

		$delete_query = "	DELETE cart_item.*
							FROM cart_item
							INNER JOIN cart ON cart.cart_id = cart_item.cart_id
							WHERE cart.cart_status = '0' ";
		$execquery1 = mysqli_query($db, $delete_query);


		$delete_query2 = "	DELETE FROM cart WHERE cart_status = '0' ";
		$execquery2 = mysqli_query($db, $delete_query2);


	}

	if(isset($_POST['check_out'])){
		$total_price =  $_POST['total_price'];
		$user_id = $_SESSION['user_id'];

		//UPDATE cart_status and total price
		$query1 = "	UPDATE cart
					SET  cart_status = 1, cart_total_amount = $total_price
					WHERE  `user_id` = $user_id AND cart_status = 0 ";
		$execquery1 = mysqli_query($db, $query1);

		if(mysqli_affected_rows($db) <= 0){
			echo "transaction fail";
		}else{
			echo "TRANSACTION SUCCESS";

		}

	}

//*************CART PAGE FUNCTIONS **************** */

?>
