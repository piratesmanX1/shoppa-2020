<section>
	<!--===============================
=            Hero Area            =
================================-->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar navbar-expand-lg navbar-light navigation">
					<a class="navbar-brand" href="home.php">
						<img src="logo_image/logo1.png" alt="" height=43px >
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
						aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav ml-auto main-nav ">
                                <li class="nav-item active">
                                    <a class="nav-link" href="home.php">Home</a>
                                </li>
																<?php
																if(isset($_SESSION['role'])){
																	if ($_SESSION['role'] == 0) {
																		echo '
																		<li class="nav-item active">
		                                    <a class="nav-link" href="product.php">Product</a>
		                                </li>

		                                <li class="nav-item active">
		                                    <a class="nav-link" href="compare.php">Compare</a>
		                                </li>
																		';
																	}
																}
																?>

											<?php
												if(isset($_SESSION['user_id'])){
													if ($_SESSION['role'] == 0) {
														echo '
														<li class="nav-item active">
																<a class="nav-link" href="contact.php">Contact</a>
														</li>
														';
													}
													echo '
													<li class="nav-item active">
															<a class="nav-link" href="user_profile.php">Profile</a>
													</li>
													';
												}
												if(isset($_SESSION['role'])){
													if ($_SESSION['role'] == 1) {
														echo '
														<li class="nav-item active">
																<a class="nav-link" href="admin_panel.php">Admin Panel</a>
														</li>
														';
													}
												}
											?>
              </ul>
						</ul>
						<!--===============================
						=            Button           =
						================================-->
						<!--normal prospect show login button, user show logout + cart -->

						<ul class="navbar-nav ml-auto mt-10">

							<?php
								if(isset($_SESSION['username'])){
							?>

									<li class="nav-item">
										<button class="nav-link login-button" onclick="logout_confirm()">Logout</button>
									</li>

									<?php
										if ($_SESSION["role"] == 0) {
											echo '
											<li class="nav-item">
												<a class="nav-link text-white add-button" href="cart.php"><i class="fa fa-shopping-cart"></i> Cart</a>
											</li>
											';
										}
									?>
							<?php
								}else{
									?>
									<li class="nav-item">
										<a class="nav-link login-button" href="login.php">Login</a>
									</li>

									<?php
								}
							?>

						</ul>
					</div>
				</nav>
			</div>
		</div>
	</div>
</section>

<!-- Confirmation on returning back to Admin Panel -->
<script type='text/javascript'>
function logout_confirm() {
  var confirmation = confirm("System Notice: Are you sure to logout?");
  if (confirmation == true) {
    location.href='logout.php';
  } else {
    // do nothing
  }
}
</script>
