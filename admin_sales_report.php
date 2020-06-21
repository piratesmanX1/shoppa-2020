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
// the filteration of product shown based on the option list //
if (isset($_GET["month"])) {
  $monthly_filter = $_GET["month"];
} else {
  $monthly_filter = "0";
}

if (isset($_GET["year"])) {
  $yearly_filter = $_GET["year"];
} else {
  $yearly_filter = "0";
}

// if there's no input data then we will treat the variable as 0, as there's no indication of filteration needed, then we will show everything: 0 //
if ($monthly_filter == "") {
  $monthly_filter = 0;
}
// if there's no input data then we will treat the variable as 0, as there's no indication of filteration needed, then we will show everything: 0 //
if ($yearly_filter == "") {
  $yearly_filter = 0;
}
?>

<?php
// the number of page table that we will be receiving //
if (isset($_GET["page"])) {
  $page = $_GET["page"];
} else {
  $page = "1";
}
// if there's no input data then we will treat the variable as 0, as there's no indication of extra page needed //
if (($page == "") || $page == "1") {
  $page_count = 0;
} else {
  // we will multiply the input data by 6, which will result changes in SQL query like "LIMIT 10, 6" or "LIMIT 20, 6" //
  $page_count = (($page - 1) * 6);
}
?>

<?php
// if user didn't choose a specific brand
if (($monthly_filter == 0) && ($yearly_filter == 0)) {
  $SREPORTLIST = "SELECT * FROM
                  (SELECT * FROM monthly_report GROUP BY product_category_id, month_report, year_report
                  ORDER BY year_report DESC) src
                  LIMIT $page_count, 6";
  $TOTALSREPORT = "SELECT COUNT(*) AS QUANTITY FROM
                   (SELECT * FROM monthly_report GROUP BY product_category_id, month_report, year_report
                   ORDER BY year_report DESC) src";
} else {
  $SREPORTLIST = "SELECT * FROM
                  (SELECT * FROM monthly_report GROUP BY product_category_id, month_report, year_report
                  ORDER BY year_report DESC) src
                  WHERE month_report = $monthly_filter AND year_report = $yearly_filter
                  LIMIT $page_count, 6";
  $TOTALSREPORT = "SELECT COUNT(*) AS QUANTITY FROM
                  (SELECT * FROM monthly_report GROUP BY product_category_id, month_report, year_report
                  ORDER BY year_report DESC) src
                  WHERE month_report = $monthly_filter AND year_report = $yearly_filter
                  LIMIT $page_count, 6";
}
?>

<div class="widget dashboard-container my-adslist">
  <h3 class="widget-header">Sales Report (Monthly)</h3>
  <div class="filter-container d-flex" style="position:reflective!important">
    <select class="sreport-select d-inline-block" id="sreport-type" name="sreport-types" style="width:200px; height:30px; position:absolute; right:44px; top:75px;" onchange="dateFilter(this)">
      <option value="0" data="0">ALL</option>
      <!-- call out the categories value -->
      <?php
      $REPORTDATES = "SELECT DISTINCT month_report, year_report FROM monthly_report";
      $result = $db->query($REPORTDATES);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '
          <option value="'.$row["month_report"].'" data="'.$row["year_report"].'"';
          // if the date is equal as the selected option, then call it as selected //
          if (($monthly_filter == $row["month_report"]) && ($yearly_filter == $row["year_report"])) {
            echo 'Selected';
          }
          echo '> '.date('F', mktime(0, 0, 0, $row["month_report"], 10)).', '.$row["year_report"].' </option>
          ';
        }
      }
      ?>
    </select>
  </div>
  <br>
  <br>
  <div style="overflow-x:auto!important;">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col"></th>
          <th scope="col">Report Name</th>
          <th scope="col">Generated Time</th>
          <th scope="col">Total Sales</th>
          <th scope="col">Total Revenue</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $result = $db->query($SREPORTLIST);
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $category_id = $row['product_category_id'];
              $list_month = $row['month_report'];
              $list_year = $row['year_report'];
              // find the specific category name
              $CATEGORYNAME = "SELECT category_name FROM category WHERE category_id = ".$row['product_category_id'];
              $CATEGORYNAMEQ = mysqli_query($db, $CATEGORYNAME);
              if (mysqli_num_rows($CATEGORYNAMEQ) < 1) {
                $category_name = "Null";
              } else {
                if ($rows = mysqli_fetch_array($CATEGORYNAMEQ)) {
                  $category_name = $rows["category_name"];
                }
              }
              // calculating the total product sold for the specific category
              // Formula: SUM of all product_cost_total value where the category id are the same //
              $TOTALREV = "SELECT
                           SUM(product_cost_total)
                           AS TOTAL_REVENUE
                           FROM monthly_report
                           WHERE product_category_id = $category_id AND month_report = $list_month AND year_report = $list_year";
              $TOTALREVQ = mysqli_query($db, $TOTALREV);
              if (mysqli_num_rows($TOTALREVQ) < 1) {
                // if we can't retrieve the data then //
               $total_revenue = "-";
              } else {
               // get into the variable //
               if ($row_rev = mysqli_fetch_array($TOTALREVQ)) {
                $total_revenue = $row_rev["TOTAL_REVENUE"];
               }
              }
              // now finding the total number of product sold for the specific category //
              // Formula: SUM of all product_quantity_total value where the category id are the same //
              $TOTALSALES = "SELECT
                             SUM(product_quantity_total)
                             AS TOTAL_PRODUCT_SOLD
                             FROM monthly_report
                             WHERE product_category_id = $category_id AND month_report = $list_month AND year_report = $list_year";
              $TOTALSALESQ = mysqli_query($db, $TOTALSALES);
              if (mysqli_num_rows($TOTALSALESQ) < 1) {
              // if we can't retrieve the data then //
                $total_sales = "-";
              } else {
              // get into the variable //
                if ($row_sal = mysqli_fetch_array($TOTALSALESQ)) {
                  $total_sales = $row_sal["TOTAL_PRODUCT_SOLD"];
                }
              }
              echo '
              <tr>
                <th scope="row"><div class="table-text"><a href="monthly_report.php?category_id='.$category_id.'&month='.$list_month.'&year='.$list_year.'" target="_blank">'.$category_name.'</a></div></th>
                <td><div class="table-text"><a style="display: block;" href="monthly_report.php?category_id='.$category_id.'&month='.$list_month.'&year='.$list_year.'" target="_blank">'.$category_name.' ('.date('F', mktime(0, 0, 0, $row["month_report"], 10)).' '.$row["year_report"].')</a></div></td>
                <td><div class="table-text"><a style="display: block;" href="monthly_report.php?category_id='.$category_id.'&month='.$list_month.'&year='.$list_year.'" target="_blank">'.date('d/m/y h:i A', strtotime($row["generated_time"])).'</a></div></td>
                <td><div class="table-text"><a style="display: block;" href="monthly_report.php?category_id='.$category_id.'&month='.$list_month.'&year='.$list_year.'" target="_blank">'.$total_sales.'</a></div></td>
                <td><div class="table-text"><a style="display: block;" href="monthly_report.php?category_id='.$category_id.'&month='.$list_month.'&year='.$list_year.'" target="_blank">$ '.$total_revenue.'</a></div></td>
              </tr>
              ';
            }
          } else {
            echo '
            <tr>
              <th scope="row"><div class="table-text"> - </div></th>
              <td><div class="table-text"> - </div></td>
              <td><div class="table-text"> - </div></td>
              <td><div class="table-text"> - </div></td>
              <td><div class="table-text"> - </div></td>
            </tr>
            ';
          }
        ?>
      </tbody>
    </table>
  </div>

</div>

<?php
  // creating the page number based on the date given
  $TOTALSREPORTQ = mysqli_query($db, $TOTALSREPORT);
  if (mysqli_num_rows($TOTALSREPORTQ) < 1) {
   // only 1 page needed //
   $page_numb = "1";
  } else {
   // count how many pages are needed //
   if ($row = mysqli_fetch_array($TOTALSREPORTQ)) {
     $page_numb = $row["QUANTITY"];
     // then we divide the number of record by 6, then round up, i.e. 1.1 > 2; since any extra records will required 1 new page //
     $page_numb = ($page_numb / 6);
     $page_numb = ceil($page_numb);
   }
  }

  echo '
  <!-- pagination -->
  <div class="pagination justify-content-center">
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item">
          <a class="page-link" onclick="sreportTable(this)" aria-label="Previous" name="'.$monthly_filter.'" data-value="'.$yearly_filter.'" value="';
          // if the current $_GET['page'] number is not more than 2 then it has no value, but 1 //
          if ($page < 2) {
            $previous_page = 1;
            echo $previous_page;
          } else {
            $previous_page = ($page - 1);
            echo $previous_page;
          }
          echo
          '">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        <li class="page-item';
        if ($page == 1) {
            echo ' active';
        }
        echo
        '"><a class="page-link" onclick="sreportTable(this)" name="'.$monthly_filter.'" data-value="'.$yearly_filter.'" value="1">1</a></li>';

        for ($n = 2; $n <= $page_numb; $n++) {
          echo '<li class="page-item';
          if ($page == $n) {
              echo ' active';
          }
          echo '"><a class="page-link" onclick="sreportTable(this)" name="'.$monthly_filter.'" data-value="'.$yearly_filter.'" value="'.$n.'">'.$n.'</a></li>';
        }

        echo
        '<li class="page-item">
          <a class="page-link" onclick="sreportTable(this)" aria-label="Next" name="'.$monthly_filter.'" data-value="'.$yearly_filter.'" value="';
          // By default $next_page if no value and the total records division is no more than 1 then the value of it is 1 //
          if (empty($next_page) && ($page_numb > 1)) {
            $next_page = 2;
          } else if (empty($next_page) && ($page_numb < 2)) {
            $next_page = 1;
          }
          // if the total records division is not more than 2, then it has no value, but 1 //
          if ($page_numb < 2) {
            $next_page = 1;
            echo $next_page;
          } else {
            if ($page == $page_numb) {
              // if the current $_GET['page'] reached its limit then we will make the value the maximum one //
              $next_page = $page;
              echo $next_page;
            } else {
              $next_page = ($page + 1);
              echo $next_page;
            }
          }
          echo
          '">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
  ';
?>
<style>
.table-text {
  overflow: hidden!important;
  text-overflow: ellipsis!important;
  display: -webkit-box!important;
  -webkit-line-clamp: 3!important; /* number of lines to show */
  -webkit-box-orient: vertical;
}
.has-search .form-control {
  padding-left: 2.375rem;
}

.has-search .form-control-feedback {
  position: absolute;
  z-index: 2;
  display: block;
  width: 2.375rem;
  height: 2.375rem;
  line-height: 2.375rem;
  text-align: center;
  pointer-events: none;
  color: #aaa;
}
</style>
