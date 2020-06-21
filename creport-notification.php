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
  // get the number of customer report that yet responded within the database
  $TOTALCREPORT = "SELECT COUNT(*) AS QUANTITY from contact WHERE contact_status = 0";
  $TOTALCREPORTQ = mysqli_query($db, $TOTALCREPORT);

  // assigning the numbers to specific variable
  // customer report
  if ($row = mysqli_fetch_array($TOTALCREPORTQ)) {
    $totalcreport = $row["QUANTITY"];
  }
  echo '<i class="fa fa-edit"></i>Customer Report<span>'.$totalcreport.'</span>';
?>
