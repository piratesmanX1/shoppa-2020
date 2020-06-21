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
if (isset($_POST['search_report'])) {
  // if the search box is empty then proceed to normal queries
  if ($_POST['search_report'] == 0) {
    $CAREPORTLIST = "SELECT * FROM contact WHERE contact_status = 0
                     ORDER BY contact_date DESC
                     LIMIT $page_count, 6";
    $CIREPORTLIST = "SELECT * FROM contact WHERE contact_status = 1
                     ORDER BY contact_date DESC
                     LIMIT $page_count, 6";
  } else {
    if (isset($_POST['searchName'])) {
      $creportname = $_POST['searchName'];
      // if user choose to search
      $CAREPORTLIST = "SELECT * FROM contact WHERE contact_content LIKE '%$creportname%' AND contact_status = 0
                       ORDER BY contact_date DESC
                       LIMIT $page_count, 6";
      $CIREPORTLIST = "SELECT * FROM contact WHERE contact_content LIKE '%$creportname%' AND contact_status = 1
                       ORDER BY contact_date DESC
                       LIMIT $page_count, 6";
    } else {
      $CAREPORTLIST = "SELECT * FROM contact WHERE contact_status = 0
                       ORDER BY contact_date DESC
                       LIMIT $page_count, 6";
      $CIREPORTLIST = "SELECT * FROM contact WHERE contact_status = 1
                       ORDER BY contact_date DESC
                       LIMIT $page_count, 6";
    }
  }
} else {
  $CAREPORTLIST = "SELECT * FROM contact WHERE contact_status = 0
                   ORDER BY contact_date DESC
                   LIMIT $page_count, 6";
  $CIREPORTLIST = "SELECT * FROM contact WHERE contact_status = 1
                   ORDER BY contact_date DESC
                   LIMIT $page_count, 6";
}
?>

<div class="widget dashboard-container my-adslist">
  <h3 class="widget-header">Customer Report (Unresponded)</h3>
  <div class="form-group has-search d-inline-block">
    <span class="fa fa-search form-control-feedback"></span>
    <input type="text" class="search form-control" id="admin-search-creport" oninput="searchCReport()" style="height:40px!important; width:34vw;" placeholder="Search" value="<?php
    if (isset($_POST['search_report'])) {
      // if the search box is empty then proceed to normal queries
      if ($_POST['search_report'] == 0) {
      } else {
        if (isset($_POST['searchName'])) {
          $creportname = $_POST['searchName'];
          // if user choose to search
          echo $creportname;
        }
      }
    }
    ?>">
  </div>
  <div class="list-group">
    <!-- begin to list the reports accordingly -->
    <?php
      $result = $db->query($CAREPORTLIST);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          // search for user name
          $userID = $row["user_id"];
          $USERNAME = "SELECT * FROM user WHERE user_id = $userID";
          $USERNAMEQ = mysqli_query($db, $USERNAME);
          if (mysqli_num_rows($USERNAMEQ) < 1) {
          // if we can't retrieve the data then //
            $userName = "-";
          } else {
          // get into the variable //
            if ($row_user = mysqli_fetch_array($USERNAMEQ)) {
              $userName = $row_user["user_fname"].' '.$row_user["user_lname"];
            }
          }
          echo '
          <a href="customer_report_content.php?id='.$row["contact_id"].'" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">';
              // getting the first sentence of the content as the title
              $content = preg_replace('/(.*?[?!.](?=\s|$)).*/', '\\1', $row["contact_content"]);

              echo $content;
              echo
              '</h5>
              <small>'.date('d/m/y h:i A', strtotime($row["contact_date"])).'</small>
            </div>
            <p class="mb-1">'.$userName.'</p>
            <small>'.$row["contact_content"].'</small>
          </a>
          ';
        }
      } else {
        echo '
        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"> No result </h5>
            <small> 00/00/00 00:00 AM </small>
          </div>
          <p class="mb-1"> - </p>
          <small> - </small>
        </a>
        ';
      }
    ?>
  </div>
</div>

<div class="widget dashboard-container my-adslist">
  <h3 class="widget-header">Customer Report (Responded)</h3>
  <div class="list-group">
    <?php
      $result = $db->query($CIREPORTLIST);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          // search for user name
          $userID = $row["user_id"];
          $USERNAME = "SELECT * FROM user WHERE user_id = $userID";
          $USERNAMEQ = mysqli_query($db, $USERNAME);
          if (mysqli_num_rows($USERNAMEQ) < 1) {
          // if we can't retrieve the data then //
            $userName = "-";
          } else {
          // get into the variable //
            if ($row_user = mysqli_fetch_array($USERNAMEQ)) {
              $userName = $row_user["user_fname"].' '.$row_user["user_lname"];
            }
          }
          echo '
          <a href="customer_report_content.php?id='.$row["contact_id"].'" class="list-group-item list-group-item-success list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">';
              // getting the first sentence of the content as the title
              $content = preg_replace('/(.*?[?!.](?=\s|$)).*/', '\\1', $row["contact_content"]);

              echo $content;
              echo
              '</h5>
              <small>'.date('d/m/y h:i A', strtotime($row["contact_date"])).'</small>
            </div>
            <p class="mb-1">'.$userName.'</p>
            <small>'.$row["contact_content"].'</small>
          </a>
          ';
        }
      } else {
        echo '
        <a href="#" class="list-group-item list-group-item-success list-group-item-action flex-column align-items-start">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"> No result </h5>
            <small> 00/00/00 00:00 AM </small>
          </div>
          <p class="mb-1"> - </p>
          <small> - </small>
        </a>
        ';
      }
    ?>
  </div>
</div>
<?php
  // creating the page number based on the list's number, if its over 6 records then create 1 page //
  // we first find how many records in the report list //
  // since we have two types of data: responded and unresponded, we have to find both of them and compare them, then take the highest value out of all //
  // first we find the value of unresponded ones //
  $TOTCREPORTA = "SELECT COUNT(*) AS TOTAL_CREPORTA FROM contact
                  WHERE contact_status = '0'";
  $TOTCREPORTAQ = mysqli_query($db, $TOTCREPORTA);
  if (mysqli_num_rows($TOTCREPORTAQ) < 1) {
   // only 1 page needed //
   $total_creporta = "1";
  } else {
   // count how many pages are needed //
   if ($row = mysqli_fetch_array($TOTCREPORTAQ)) {
     $total_creporta = $row["TOTAL_CREPORTA"];
     // then we divide the number of total unresponded record by 6, then round up, i.e. 1.1 > 2; since any extra records will required 1 new page //
     $total_creporta = ($total_creporta / 6);
     $total_creporta = ceil($total_creporta);
   }
  }
  // after we got the value from the responded tables then we proceeds to find the value of the responded //
  $TOTCREPORTI = "SELECT COUNT(*) AS TOTAL_CREPORTI FROM contact
                  WHERE contact_status = '1'";
  $TOTCREPORTIQ = mysqli_query($db, $TOTCREPORTI);
  if (mysqli_num_rows($TOTCREPORTIQ) < 1) {
   // only 1 page needed //
   $total_creporti = "1";
  } else {
   // count how many pages are needed //
   if ($row = mysqli_fetch_array($TOTCREPORTIQ)) {
     $total_creporti = $row["TOTAL_CREPORTI"];
     // then we divide the number of total responded record by 6, then round up, i.e. 1.1 > 2; since any extra records will required 1 new page //
     $total_creporti = ($total_creporti / 6);
     $total_creporti = ceil($total_creporti);
   }
  }
  // now checking which category got the highest value //
  if ($total_creporti >= $total_creporta) {
    $page_numb = $total_creporti;
  } else if ($total_creporti <= $total_creporta) {
    $page_numb = $total_creporta;
  } else {
    $page_numb = 1;
  }

  echo '
  <!-- pagination -->
  <div class="pagination justify-content-center">
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item">
          <a class="page-link" onclick="creportTable(this)" aria-label="Previous" value="';
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
        '"><a class="page-link" onclick="creportTable(this)" value="1">1</a></li>';

        for ($n = 2; $n <= $page_numb; $n++) {
          echo '<li class="page-item';
          if ($page == $n) {
              echo ' active';
          }
          echo '"><a class="page-link" onclick="creportTable(this)" value="'.$n.'">'.$n.'</a></li>';
        }

        echo
        '<li class="page-item">
          <a class="page-link" onclick="creportTable(this)" aria-label="Next" value="';
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
