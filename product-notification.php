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
  // get the number of products within the database
  $TOTALPRODUCT = "SELECT COUNT(*) AS QUANTITY from product";
  $TOTALPRODUCTQ = mysqli_query($db, $TOTALPRODUCT);

  // assigning the numbers to specific variable
  // products
  if ($row = mysqli_fetch_array($TOTALPRODUCTQ)) {
    $totalproduct = $row["QUANTITY"];
  }

  echo '<i class="fa fa-shopping-cart"></i> Products<span>'.$totalproduct.'</span>';
?>
