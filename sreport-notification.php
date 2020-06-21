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
  $TOTALSREPORT = "SELECT COUNT(*) AS QUANTITY FROM
                   (SELECT * FROM monthly_report GROUP BY product_category_id, month_report, year_report
                   ORDER BY year_report DESC) src";
  $TOTALSREPORTQ = mysqli_query($db, $TOTALSREPORT);

  // assigning the numbers to specific variable
  // sales report
  if ($row = mysqli_fetch_array($TOTALSREPORTQ)) {
    $totalsreport = $row["QUANTITY"];
  }
  echo '<i class="fa fa-bar-chart-o"></i>Sales Report<span>'.$totalsreport.'</span>';
?>
