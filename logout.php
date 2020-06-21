<?php
	session_start();
	include("conn.php");


    //logout
    session_unset();
    session_destroy();

		// It will return to admin panel automatically //
  	echo "<script>alert('You have logged out, please come again.');";
  	echo "window.location.href='index.php';</script>";

?>
