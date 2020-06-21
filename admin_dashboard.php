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
// Present Date //
$present = date_create();
// Taking the current time //
date_default_timezone_set("Etc/GMT-8");
$now = date("Y-m-d H:i:s");
// Name of the current month //
$month_name = (strftime("%B",time()));

// Variable to store Error Message //
$error = '';

// Bar Chart //
// To count the average value of the reviews //
// Formula: (Total Rating / Total number of product bought) from this month and this year
$REVIEWSTOP5 = "SELECT product_id,
                (SUM(review_rating) / COUNT(*)) AS AVGRATING,
                COUNT(*) AS QUANTITY FROM review
                WHERE MONTH(review_date) = MONTH(CURRENT_TIMESTAMP()) AND YEAR(review_date) = YEAR(CURRENT_TIMESTAMP())
                GROUP BY product_id
                ORDER BY AVGRATING ASC LIMIT 5";
$REVIEWSTOP5Q = mysqli_query($db, $REVIEWSTOP5);
// Formula: (Total Rating / Total number of product bought) from this month and this year
// P.S: Repeated due to unknown error causing the graph not showing the value, although able to print it
$REVIEWSTOP5QUAN = "SELECT (SUM(review_rating) / COUNT(*)) AS AVGRATING,
                    COUNT(*) AS QUANTITY FROM review
                    WHERE MONTH(review_date) = MONTH(CURRENT_TIMESTAMP()) AND YEAR(review_date) = YEAR(CURRENT_TIMESTAMP())
                    GROUP BY product_id
                    ORDER BY AVGRATING ASC LIMIT 5";
$REVIEWSTOP5QUANQ = mysqli_query($db, $REVIEWSTOP5QUAN);
// Formula: (Total Rating / Total number of product bought) from this month and this year
$REVIEWSTOP5_2 = "SELECT product_id,
                  (SUM(review_rating) / COUNT(*)) AS AVGRATING,
                  COUNT(*) AS QUANTITY FROM review
                  WHERE MONTH(review_date) = MONTH(CURRENT_TIMESTAMP()) AND YEAR(review_date) = YEAR(CURRENT_TIMESTAMP())
                  GROUP BY product_id
                  ORDER BY AVGRATING ASC LIMIT 5";
$REVIEWSTOP5_2Q = mysqli_query($db, $REVIEWSTOP5_2);

// Progress Bar //
// Get the total number of specific product sold within the current month and year
$SPECPRODUCTTOP10 = "SELECT cart_item.product_id, COUNT(*) AS QUANTITY FROM cart
                     INNER JOIN cart_item ON cart_item.cart_id = cart.cart_id
                     WHERE MONTH(cart.cart_date) = MONTH(CURRENT_TIMESTAMP()) AND YEAR(cart.cart_date) = YEAR(CURRENT_TIMESTAMP()) AND cart.cart_status = 1
                     GROUP BY cart_item.product_id
                     ORDER BY QUANTITY DESC LIMIT 10";
$SPECPRODUCTTOP10Q = mysqli_query($db, $SPECPRODUCTTOP10);

// Get the total number of all product sold within the current month and year
$ALLPRODUCTSOLD = "SELECT COUNT(*) AS QUANTITY FROM cart
                   INNER JOIN cart_item ON cart_item.cart_id = cart.cart_id
                   WHERE MONTH(cart.cart_date) = MONTH(CURRENT_TIMESTAMP()) AND YEAR(cart.cart_date) = YEAR(CURRENT_TIMESTAMP()) AND cart.cart_status = 1";
$ALLPRODUCTSOLDQ = mysqli_query($db, $ALLPRODUCTSOLD);

// Doughnut Chart //
// Get the total number of specific catetgory sold within the current month and year
$CATEGORYTOP5 = "SELECT category.category_id, category.category_name, cart_item.product_id, COUNT(*) AS QUANTITY FROM cart
                 INNER JOIN cart_item ON cart_item.cart_id = cart.cart_id
                 INNER JOIN product ON cart_item.product_id = product.product_id
                 INNER JOIN category ON product.category_id = category.category_id
                 WHERE MONTH(cart.cart_date) = MONTH(CURRENT_TIMESTAMP()) AND YEAR(cart.cart_date) = YEAR(CURRENT_TIMESTAMP()) AND cart.cart_status = 1
                 GROUP BY category.category_id
                 ORDER BY QUANTITY DESC LIMIT 5";
$CATEGORYTOP5Q = mysqli_query($db, $CATEGORYTOP5);
// P.S: Repeated due to unknown error although the query can run smoothly at once
// Get the total number of all product sold within the current month and year
$ALLPRODUCTSOLD_2 = "SELECT COUNT(*) AS QUANTITY FROM cart
                     INNER JOIN cart_item ON cart_item.cart_id = cart.cart_id
                     WHERE MONTH(cart.cart_date) = MONTH(CURRENT_TIMESTAMP()) AND YEAR(cart.cart_date) = YEAR(CURRENT_TIMESTAMP()) AND cart.cart_status = 1";
$ALLPRODUCTSOLD_2Q = mysqli_query($db, $ALLPRODUCTSOLD_2);

// Reloading charts function in javascript
// P.S: Repeated due to unknown error although the query can run smoothly at once
// Formula: (Total Rating / Total number of product bought) from this month and this year
$REVIEWSTOP5_3 = "SELECT product_id,
                  (SUM(review_rating) / COUNT(*)) AS AVGRATING,
                  COUNT(*) AS QUANTITY FROM review
                  WHERE MONTH(review_date) = MONTH(CURRENT_TIMESTAMP()) AND YEAR(review_date) = YEAR(CURRENT_TIMESTAMP())
                  GROUP BY product_id
                  ORDER BY AVGRATING ASC LIMIT 5";
$REVIEWSTOP5_3Q = mysqli_query($db, $REVIEWSTOP5_3);
// P.S: Repeated due to unknown error although the query can run smoothly at once
// Formula: (Total Rating / Total number of product bought) from this month and this year
$REVIEWSTOP5QUAN_2 = "SELECT (SUM(review_rating) / COUNT(*)) AS AVGRATING,
                      COUNT(*) AS QUANTITY FROM review
                      WHERE MONTH(review_date) = MONTH(CURRENT_TIMESTAMP()) AND YEAR(review_date) = YEAR(CURRENT_TIMESTAMP())
                      GROUP BY product_id
                      ORDER BY AVGRATING ASC LIMIT 5";
$REVIEWSTOP5QUAN_2Q = mysqli_query($db, $REVIEWSTOP5QUAN_2);
// P.S: Repeated due to unknown error although the query can run smoothly at once
// Get the total number of all product sold within the current month and year
$ALLPRODUCTSOLD_3 = "SELECT COUNT(*) AS QUANTITY FROM cart
                     INNER JOIN cart_item ON cart_item.cart_id = cart.cart_id
                     WHERE MONTH(cart.cart_date) = MONTH(CURRENT_TIMESTAMP()) AND YEAR(cart.cart_date) = YEAR(CURRENT_TIMESTAMP()) AND cart.cart_status = 1";
$ALLPRODUCTSOLD_3Q = mysqli_query($db, $ALLPRODUCTSOLD_3);
// P.S: Repeated due to unknown error although the query can run smoothly at once
$CATEGORYTOP5_2 = "SELECT category.category_id, category.category_name, cart_item.product_id, COUNT(*) AS QUANTITY FROM cart
                   INNER JOIN cart_item ON cart_item.cart_id = cart.cart_id
                   INNER JOIN product ON cart_item.product_id = product.product_id
                   INNER JOIN category ON product.category_id = category.category_id
                   WHERE MONTH(cart.cart_date) = MONTH(CURRENT_TIMESTAMP()) AND YEAR(cart.cart_date) = YEAR(CURRENT_TIMESTAMP()) AND cart.cart_status = 1
                   GROUP BY category.category_id
                   ORDER BY QUANTITY DESC LIMIT 5";
$CATEGORYTOP5_2Q = mysqli_query($db, $CATEGORYTOP5_2);
?>

<!-- chart.js script link -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<!-- canvasjs.com doughnut chart script link -->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<div class="widget dashboard-container">
  <h3 class="widget-header">Dashboard</h3>
  <!-- Based on top 5 reviews -->
  <h2 class="widget-header">Top 5 Trends of the Month (<?php echo $month_name; ?>)</h2>
  <canvas id="myChartReview" width="400" height="200"></canvas>
  <div class="container">
    <div class="row">
      <?php
        $cn = 0;
        $n = 0;

        while($row = mysqli_fetch_array($REVIEWSTOP5_2Q)) {
          // calling out the product names accordingly
          $PRODUCTNAMES = "SELECT product_name FROM product WHERE product_id = ".$row['product_id'];
          $PRODUCTNAMESQ = mysqli_query($db, $PRODUCTNAMES);

          if (mysqli_num_rows($PRODUCTNAMESQ) < 1) {
            echo "NULL";
          } else {
            if ($row = mysqli_fetch_array($PRODUCTNAMESQ)) {
              echo '
              <div class="col" style="text-overflow: ellipsis; overflow:hidden;">
                <svg width="15" height="13">
                  <rect width="15" height="10" style="fill:';
                  if ($cn == 0) {
                    echo 'rgba(255, 99, 132, 0.2)';
                  } else if ($cn == 1) {
                    echo 'rgba(54, 162, 235, 0.2)';
                  } else if ($cn == 2) {
                    echo 'rgba(255, 206, 86, 0.2)';
                  } else if ($cn == 3) {
                    echo 'rgba(75, 192, 192, 0.2)';
                  } else if ($cn == 4) {
                    echo 'rgba(153, 102, 255, 0.2)';
                  }
                  echo '; stroke-width:1; stroke:';
                  if ($cn == 0) {
                    echo 'rgba(255, 99, 132, 1)';
                  } else if ($cn == 1) {
                    echo 'rgba(54, 162, 235, 1)';
                  } else if ($cn == 2) {
                    echo 'rgba(255, 206, 86, 1)';
                  } else if ($cn == 3) {
                    echo 'rgba(75, 192, 192, 1)';
                  } else if ($cn == 4) {
                    echo 'rgba(153, 102, 255, 1)';
                  }
                  echo ';" />
                </svg> '.strtoupper($row["product_name"]).' </div>';
            }
          }

          $cn++;
          $n++;
          if ($n == 2) {
            echo '<div class="w-100"></div>';
            $n = 0;
          }
        }
      ?>
    </div>
  </div>
  <br>
  <br>
  <!-- Based on top 10 products -->
  <h2 class="widget-header">Top 10 Products of the Month (<?php echo $month_name; ?>)</h2>
  <div class="container" style="font-size:13px!important">
  <?php
    $n = 0;

    // first get the total product sold of the current month and year for future calculation
    if (mysqli_num_rows($ALLPRODUCTSOLDQ) < 1) {
      $totalproduct = 0;
    } else {
      if ($row = mysqli_fetch_array($ALLPRODUCTSOLDQ)) {
        $totalproduct = $row["QUANTITY"];
      }
    }

    if ($totalproduct > 0) {
      while($row = mysqli_fetch_array($SPECPRODUCTTOP10Q)) {
        // performing calculation on the percentage
        $top10percent = number_format((float)(($row["QUANTITY"] / $totalproduct) * 100), 2, '.', '');

        // calling out the product names accordingly
        $PRODUCTNAMES = "SELECT product_name FROM product WHERE product_id = ".$row['product_id'];
        $PRODUCTNAMESQ = mysqli_query($db, $PRODUCTNAMES);

        if (mysqli_num_rows($PRODUCTNAMESQ) < 1) {
          echo "NULL";
        } else {
          if ($row = mysqli_fetch_array($PRODUCTNAMESQ)) {
            echo '
            <div class="row">
              <div class="col-3">
                <div class="progresstitle" style="text-overflow: ellipsis; overflow:hidden;">'.strtoupper($row["product_name"]).'</div>
              </div>
              <div class="col-7">
                <div class="progress" style="height:100%!important; max-height:20px!important">
                  <div class="progress-bar" role="progressbar" style="width: '.$top10percent.'%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
              <div class="col-1">
                '.$top10percent.'%
              </div>
            </div>
            ';
          }
        }
        if ($n < mysqli_num_rows($SPECPRODUCTTOP10Q)) {
          echo '<br>';
          $n++;
        }
      }
    } else {
      echo '<div style="color:red;">System Notice: No available data for calculation. </div>';
    }
  ?>
  </div>
  <br>
  <br>
  <!-- Based on top 5 category -->
  <h2 class="widget-header">Top 5 Category of the Month (<?php echo $month_name; ?>)</h2>
  <div class="container" style="font-size:13px!important">
    <div id="myChartCategory" style="height: 370px; min-width: 100%;"></div>
  </div>
</div>

<script>
var ctx = document.getElementById('myChartReview').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
        <?php
          while($row = mysqli_fetch_array($REVIEWSTOP5Q)) {
            // calling out the product names accordingly
            $PRODUCTNAMES = "SELECT product_name FROM product WHERE product_id = ".$row['product_id'];
            $PRODUCTNAMESQ = mysqli_query($db, $PRODUCTNAMES);
            // first we check whether the data can be found from the database or note
            echo "'";
            if (mysqli_num_rows($PRODUCTNAMESQ) < 1) {
              echo "NULL";
            } else {
              if ($row = mysqli_fetch_array($PRODUCTNAMESQ)) {
                echo strtoupper($row["product_name"]);
              }
            }
            echo "',";
          }
        ?>
        ],
        datasets: [{
            label: ' Average Rating ',
            data: [
            <?php
              while($row = mysqli_fetch_array($REVIEWSTOP5QUANQ)) {
                echo "'";
                // calling out the value accordinly
                $avgrating = number_format((float)$row["AVGRATING"], 2, '.', '');
                echo $avgrating;
                echo "',";
              }
            ?>
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

<!-- function to reload the bar chart -->
<script>
function reloadBar() {
  var ctx = document.getElementById('myChartReview').getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: [
          <?php
            while($row = mysqli_fetch_array($REVIEWSTOP5_3Q)) {
              // calling out the product names accordingly
              $PRODUCTNAMES = "SELECT product_name FROM product WHERE product_id = ".$row['product_id'];
              $PRODUCTNAMESQ = mysqli_query($db, $PRODUCTNAMES);
              // first we check whether the data can be found from the database or note
              echo "'";
              if (mysqli_num_rows($PRODUCTNAMESQ) < 1) {
                echo "NULL";
              } else {
                if ($row = mysqli_fetch_array($PRODUCTNAMESQ)) {
                  echo strtoupper($row["product_name"]);
                }
              }
              echo "',";
            }
          ?>
          ],
          datasets: [{
              label: ' Average Rating ',
              data: [
              <?php
                while($row = mysqli_fetch_array($REVIEWSTOP5QUAN_2Q)) {
                  echo "'";
                  // calling out the value accordinly
                  $avgrating = number_format((float)$row["AVGRATING"], 2, '.', '');
                  echo $avgrating;
                  echo "',";
                }
              ?>
              ],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });
}
</script>

<!-- Donut Chart Scripts -->
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("myChartCategory", {
	animationEnabled: true,
	title:{
		text: "Product Categories",
		horizontalAlign: "left"
	},
	data: [{
		type: "doughnut",
		startAngle: 60,
		//innerRadius: 60,
		indexLabelFontSize: 17,
		indexLabel: "{label} - #percent%",
		toolTipContent: "<b>{label}:</b> {y} (#percent%)",
		dataPoints: [
      <?php

        // first get the total product sold of the current month and year for future calculation
        if (mysqli_num_rows($ALLPRODUCTSOLDQ) < 1) {
          $totalproduct = 0;
        } else {
          if ($row = mysqli_fetch_array($ALLPRODUCTSOLDQ)) {
            $totalproduct = $row["QUANTITY"];
          }
        }
        if ($totalproduct > 0) {
          while($row = mysqli_fetch_array($CATEGORYTOP5Q)) {
            echo '{ y: '.$row["QUANTITY"].', label: "'.strtoupper($row["category_name"]).'" },';
            $totalproduct = $totalproduct - $row["QUANTITY"];
          }
          echo '{ y: '.$totalproduct.', label: "OTHERS" },';
        }
      ?>
		]
	}]
});
chart.render();

}
</script>

<!-- function to reload the Donut Chart-->
<script>
function reloadDonut() {

var chart = new CanvasJS.Chart("myChartCategory", {
	animationEnabled: true,
	title:{
		text: "Product Categories",
		horizontalAlign: "left"
	},
	data: [{
		type: "doughnut",
		startAngle: 60,
		//innerRadius: 60,
		indexLabelFontSize: 17,
		indexLabel: "{label} - #percent%",
		toolTipContent: "<b>{label}:</b> {y} (#percent%)",
		dataPoints: [
      <?php

        // first get the total product sold of the current month and year for future calculation
        if (mysqli_num_rows($ALLPRODUCTSOLD_3Q) < 1) {
          $totalproduct = 0;
        } else {
          if ($row = mysqli_fetch_array($ALLPRODUCTSOLD_3Q)) {
            $totalproduct = $row["QUANTITY"];
          }
        }
        if ($totalproduct > 0) {
          while($row = mysqli_fetch_array($CATEGORYTOP5_2Q)) {
            echo '{ y: '.$row["QUANTITY"].', label: "'.strtoupper($row["category_name"]).'" },';
            $totalproduct = $totalproduct - $row["QUANTITY"];
          }
          echo '{ y: '.$totalproduct.', label: "OTHERS" },';
        }
      ?>
		]
	}]
});
chart.render();

}
</script>
