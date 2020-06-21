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
// the filteration of product shown based on the option list //
if (isset($_GET["category"])) {
  $category = $_GET["category"];
} else {
  $category = "0";
}
// if there's no input data then we will treat the variable as 0, as there's no indication of filteration needed, then we will show everything: 0 //
if ($category == "") {
  $category_filter = 0;
} else {
  // else we take in the value of the $_GET into the $category_filter.
  // P.S: $category_filter is $category_id //
  $category_filter = $category;
}
?>

<?php
// the number of page table that we will be receiving //
if (isset($_GET["page"])) {
  $page = $_GET["page"];
} else {
  $page = "1";
}

if (empty($_GET["page"])) {
  if (isset($_POST['pagenumb'])) {
    $page = $_POST['pagenumb'];
  } else {
    $page = "1";
  }
}

// if there's no input data then we will treat the variable as 0, as there's no indication of extra page needed //
if (($page == "") || $page == "1") {
  $page_count = 0;
} else {
  // we will multiply the input data by 5, which will result changes in SQL query like "LIMIT 10, 5" or "LIMIT 20, 5" //
  $page_count = (($page - 1) * 5);
}
?>

<?php
if (isset($_POST['search_prod'])) {
  // if the search box is empty then proceed to normal queries
  if ($_POST['search_prod'] == 0) {
    // if user didn't choose a specific brand
    if ($category_filter == 0) {
      $PRODUCTLIST = "SELECT product.product_id, product.product_name, product.product_description, product.product_image, product.product_price, product.product_status, product.category_id,
                      (SUM(review.review_rating) / COUNT(*)) AS AVGRATING
                      FROM product LEFT JOIN review on product.product_id = review.product_id
                      GROUP BY product.product_id
                      ORDER BY AVGRATING DESC
                      LIMIT $page_count, 5";
    } else {
      $PRODUCTLIST = "SELECT product.product_id, product.product_name, product.product_description, product.product_image, product.product_price, product.product_status, product.category_id,
                      (SUM(review.review_rating) / COUNT(*)) AS AVGRATING
                      FROM product LEFT JOIN review on product.product_id = review.product_id
                      WHERE category_id = $category_filter
                      GROUP BY product.product_id
                      ORDER BY AVGRATING DESC
                      LIMIT $page_count, 5";
    }
  } else {
    if (isset($_POST['searchName'])) {
      $productname = $_POST['searchName'];
      // if user choose to search
      $PRODUCTLIST = "SELECT * FROM product WHERE product_name LIKE '%$productname%'
                      LIMIT $page_count, 5";
    }
  }
}
?>

<div class="widget dashboard-container my-adslist">
  <div style="position:relative">
    <h3 class="widget-header">Product List</h3>
    <button type="button" class="btn btn-light" title="Add a new product" style="height:30px!important; width:30px!important; padding: 0px 0px!important; position: absolute; right: -2.5px; bottom:5px" onclick="location.href='admin_add_product.php'"><i class="fa fa-plus" aria-hidden="true"></i></button>
  </div>
  <div class="filter-container d-flex">
    <div class="form-group has-search d-inline-block">
      <span class="fa fa-search form-control-feedback"></span>
      <input type="text" class="search form-control" id="admin-search-product" oninput="searchProduct()" style="height:40px!important; width:34vw;" placeholder="Search" value="<?php
      if (isset($_POST['search_prod'])) {
        // if the search box is empty then proceed to normal queries
        if ($_POST['search_prod'] == 0) {
        } else {
          if (isset($_POST['searchName'])) {
            $productname = $_POST['searchName'];
            // if user choose to search
            echo $productname;
          }
        }
      }
      ?>">
    </div>
    <select class="role-select d-inline-block" id="category-type" name="category-types" style="margin-left: 10px; width:300px; height:40px;" onchange="categoryFilter()">
      <option value="0">ALL</option>
      <!-- call out the categories value -->
      <?php
      $CATEGORYTYPE = "SELECT * FROM category";
      $result = $db->query($CATEGORYTYPE);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '
          <option value="'.$row["category_id"].'"';
          // if the $_GET["brand_filter"] is equal as the selected option, then call it as selected //
          if ($category_filter == $row["category_id"]) {
            echo 'Selected';
          }
          echo '>' .$row["category_name"]. '</option>
          ';
        }
      }
    ?>
    </select>
  </div>
  <table class="table table-responsive product-dashboard-table">
    <thead>
      <tr>
        <th>Image</th>
        <th>Product Title</th>
        <th class="text-center">Category</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      <!-- begin to list the products accordingly -->
      <?php
        $result = $db->query($PRODUCTLIST);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            // find the specific category name
            $CATEGORYNAME = "SELECT category_name FROM category WHERE category_id = ".$row['category_id'];
            $CATEGORYNAMEQ = mysqli_query($db, $CATEGORYNAME);

            if (mysqli_num_rows($CATEGORYNAMEQ) < 1) {
              $category_name = "Null";
            } else {
              if ($rows = mysqli_fetch_array($CATEGORYNAMEQ)) {
                $category_name = $rows["category_name"];
              }
            }

            // assign the image address accordingly
            if (isset($row["product_image"])) {
              $product_image = $row["product_image"];
            } else {
              $product_image = "images/imgnotfound.jpg";
            }

            // assign the price accordingly and set the decimal point
            if (isset($row["product_price"])) {
              $product_price = number_format((float)$row["product_price"], 2, '.', '');
            } else {
              $product_price = "0.00";
            }
            echo '
            <tr class="product-section" id="';
            echo $row["product_id"];
            echo
            '">
              <td class="product-thumb">
                <img width="80px" height="auto" src="'.$product_image.'" alt="'.$row["product_name"].'">
              </td>
              <td class="product-details">
                <h3 class="title col">'.$row["product_name"].'</h3>
                <span class="add-id col" style="text-overflow: ellipsis!important; overflow:hidden!important; min-width:100%; width: 10vw"><strong style="min-width:100%; width: 5vw">Description: </strong>'.$row["product_description"].' </span>
                <span class="col" style="text-overflow: ellipsis; overflow:hidden;"><strong style="min-width:40%;">Product Price: </strong>$ '.$product_price.'</span>
                <span class="status col" style="color:';
                if ($row["product_status"] == 0) {
                  echo 'red';
                } else {
                  echo '#59D659';
                }
                echo
                '; text-overflow: ellipsis; overflow:hidden;"><strong style="min-width:40%;">Status: </strong>';
                if ($row["product_status"] == 0) {
                  echo 'Inactive';
                } else {
                  echo 'Active';
                }
                echo
                '</span>
              </td>
              <td class="product-category"><span class="categories">'.$category_name.'</span></td>
              <td class="action" data-title="Action">
                <div class="">
                  <ul class="list-inline justify-content-center">
                    <li class="list-inline-item">
                      <a data-toggle="tooltip" data-placement="top" title="View" class="view" href="admin_product_view.php?id='.$row["product_id"].'" target="_blank">
                        <i class="fa fa-eye"></i>
                      </a>
                    </li>
                    <li class="list-inline-item">
                      <a data-toggle="tooltip" data-placement="top" title="Edit" class="edit" href="admin_edit_product.php?id='.$row["product_id"].'">
                        <i class="fa fa-pencil"></i>
                      </a>
                    </li>
                    <li class="list-inline-item" onclick="productID(this)" id="';
                    echo $row["product_id"];
                    echo
                    '">
                      <a data-toggle="modal" data-placement="top" title="';
                      if ($row["product_status"] == 0) {
                        echo 'Activate';
                      } else {
                        echo 'Deactivate';
                      }
                      echo
                      '" data-target="#deleteaccount"class="delete">';
                      if ($row["product_status"] == 0) {
                        echo '<i class="fa fa-key"></i>';
                      } else {
                        echo '<i class="fa fa-ban"></i>';
                      }
                      echo
                      '
                      </a>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            ';
          }
        } else {
          echo '
          <tr>
            <td class="product-thumb">
              <img width="80px" height="auto" src="images/imgnotfound.jpg" alt="image description">
            </td>
            <td class="product-details">
              <h3 class="title col">No Result</h3>
              <span class="add-id col" style="text-overflow: ellipsis!important; overflow:hidden!important; min-width:100%; width: 10vw"><strong style="min-width:100%; width: 5vw">Description: </strong>No result found</span>
              <span class="col" style="text-overflow: ellipsis; overflow:hidden;"><strong style="min-width:40%;">Product Price: </strong>$ 0.00 </span>
              <span class="status col" style="color:red; text-overflow: ellipsis; overflow:hidden;"><strong style="min-width:40%;">Status: </strong>Null</span>
            </td>
            <td class="product-category"><span class="categories">Null</span></td>
            <td class="action" data-title="Action">
              <div class="">
                <ul class="list-inline justify-content-center">
                  <li class="list-inline-item">
                    <a data-toggle="tooltip" data-placement="top" title="View" class="view" href="#">
                      <i class="fa fa-eye"></i>
                    </a>
                  </li>
                  <li class="list-inline-item">
                    <a data-toggle="tooltip" data-placement="top" title="Edit" class="edit" href="#">
                      <i class="fa fa-pencil"></i>
                    </a>
                  </li>
                  <li class="list-inline-item">
                    <a data-toggle="tooltip" data-placement="top" title="Delete" class="delete" href="#">
                      <i class="fa fa-trash"></i>
                    </a>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
          ';
        }
      ?>

      <!-- default code -->
      <!--
      <tr>
        <td class="product-thumb">
          <img width="80px" height="auto" src="images/imgnotfound.jpg" alt="image description">
        </td>
        <td class="product-details">
          <h3 class="title col">No Result</h3>
          <span class="add-id col" style="text-overflow: ellipsis!important; overflow:hidden!important; min-width:100%; width: 10vw"><strong style="min-width:100%; width: 5vw">Description: </strong>No result found</span>
          <span class="col" style="text-overflow: ellipsis; overflow:hidden;"><strong style="min-width:40%;">Product Price: </strong><time>RM 0.00 </time> </span>
          <span class="status col" style="color:red; text-overflow: ellipsis; overflow:hidden;"><strong style="min-width:40%;">Status: </strong>Null</span>
        </td>
        <td class="product-category"><span class="categories">Null</span></td>
        <td class="action" data-title="Action">
          <div class="">
            <ul class="list-inline justify-content-center">
              <li class="list-inline-item">
                <a data-toggle="tooltip" data-placement="top" title="View" class="view" href="#">
                  <i class="fa fa-eye"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a data-toggle="tooltip" data-placement="top" title="Edit" class="edit" href="#">
                  <i class="fa fa-pencil"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a data-toggle="tooltip" data-placement="top" title="Delete" class="delete" href="#">
                  <i class="fa fa-trash"></i>
                </a>
              </li>
            </ul>
          </div>
        </td>
      </tr>
      -->

    </tbody>
  </table>

</div>

<?php
  // creating the page number based on the $category which stands for category_id value
  // if $category has the category_id, then we create the pagination according to the number of product
  if (isset($_POST['search_prod'])) {
    // if the search box is empty then proceed to normal queries
    if ($_POST['search_prod'] == 0) {
      if ($category > 0) {
        $PAGEPRODUCT = "SELECT COUNT(*) AS QUANTITY
                        FROM product INNER JOIN category
                        ON product.category_id = category.category_id
                        WHERE category.category_id = $category";
      } else {
        // if its not then its viewing all the product
        $PAGEPRODUCT = "SELECT COUNT(*) AS QUANTITY
                        FROM product";
      }
    } else {
      if (isset($_POST['searchName'])) {
        // if user choose to search
        $productname = $_POST['searchName'];
        $PAGEPRODUCT = "SELECT COUNT(*) AS QUANTITY
                        FROM product
                        WHERE product_name LIKE '%$productname%'";
      }
    }
  }

  $PAGEPRODUCTQ = mysqli_query($db, $PAGEPRODUCT);
  if (mysqli_num_rows($PAGEPRODUCTQ) < 1) {
   // only 1 page needed //
   $page_numb = "1";
  } else {
   // count how many pages are needed //
   if ($row = mysqli_fetch_array($PAGEPRODUCTQ)) {
     $page_numb = $row["QUANTITY"];
     // then we divide the number of record by 5, then round up, i.e. 1.1 > 2; since any extra records will required 1 new page //
     $page_numb = ($page_numb / 5);
     $page_numb = ceil($page_numb);
   }
  }

  echo '
  <!-- pagination -->
  <div class="pagination justify-content-center">
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item">
          <a class="page-link" onclick="';
          if (isset($_POST['search_prod'])) {
            // if the search box is empty then proceed to normal queries
            if ($_POST['search_prod'] == 0) {
              echo "productTable(this)";
            } else {
              if (isset($_POST['searchName'])) {
                // if user choose to search
                echo "searchProduct()";
              }
            }
          }
          echo
          '" aria-label="Previous" id="'.$category.'" value="';

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
        '"><a class="page-link" onclick="';
        if (isset($_POST['search_prod'])) {
          // if the search box is empty then proceed to normal queries
          if ($_POST['search_prod'] == 0) {
            echo "productTable(this)";
          } else {
            if (isset($_POST['searchName'])) {
              // if user choose to search
              echo "searchProduct()";
            }
          }
        }
        echo
        '" id="'.$category.'" value="1">1</a></li>';

        for ($n = 2; $n <= $page_numb; $n++) {
          echo '<li class="page-item';
          if ($page == $n) {
              echo ' active';
          }
          echo '"><a class="page-link" onclick="';
          if (isset($_POST['search_prod'])) {
            // if the search box is empty then proceed to normal queries
            if ($_POST['search_prod'] == 0) {
              echo "productTable(this)";
            } else {
              if (isset($_POST['searchName'])) {
                // if user choose to search
                echo "searchProduct()";
              }
            }
          }
          echo
          '" id="'.$category.'" value="'.$n.'">'.$n.'</a></li>';
        }

        echo
        '<li class="page-item">
          <a class="page-link" onclick="';
          if (isset($_POST['search_prod'])) {
            // if the search box is empty then proceed to normal queries
            if ($_POST['search_prod'] == 0) {
              echo "productTable(this)";
            } else {
              if (isset($_POST['searchName'])) {
                // if user choose to search
                echo "searchProduct()";
              }
            }
          }
          echo
          '" aria-label="Next" id="'.$category.'" value="';
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
