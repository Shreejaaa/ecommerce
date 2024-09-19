<?php
include('header.php'); 

if (!isset($_SESSION['tradername'])) {
    header("Location:../user/sign_in_up.php");
    exit();
}

// Assuming trader is logged in and trader ID is stored in session
$trader_id = $_SESSION['trader_id']; // Adjust this to your session variable

// Establish database connection
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Query to check if the trader's shop is verified
$query = "SELECT IS_VERIFIED FROM SHOP WHERE USER_ID = :trader_id";
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":trader_id", $trader_id);
oci_execute($stmt);

// Fetch the result
$row = oci_fetch_assoc($stmt);
$is_verified = $row ? $row['IS_VERIFIED'] : 0;

// Query to get the number of shops
$query_shops = "SELECT COUNT(*) AS SHOP_COUNT FROM SHOP WHERE USER_ID = :trader_id";
$stmt_shops = oci_parse($conn, $query_shops);
oci_bind_by_name($stmt_shops, ":trader_id", $trader_id);
oci_execute($stmt_shops);
$row_shops = oci_fetch_assoc($stmt_shops);
$shop_count = $row_shops ? $row_shops['SHOP_COUNT'] : 0;

// Query to get the number of products
$query_products = "SELECT COUNT(*) AS PRODUCT_COUNT FROM PRODUCT WHERE SHOP_ID IN (SELECT SHOP_ID FROM SHOP WHERE USER_ID = :trader_id)";
$stmt_products = oci_parse($conn, $query_products);
oci_bind_by_name($stmt_products, ":trader_id", $trader_id);
oci_execute($stmt_products);
$row_products = oci_fetch_assoc($stmt_products);
$product_count = $row_products ? $row_products['PRODUCT_COUNT'] : 0;

// Query to get the number of orders
$query_orders = "
    SELECT COUNT(*) AS ORDER_COUNT 
    FROM ORDERS o
    JOIN ORDER_PRODUCT op ON o.ORDER_ID = op.ORDER_ID
    JOIN PRODUCT p ON op.PRODUCT_ID = p.PRODUCT_ID
    WHERE p.SHOP_ID IN (SELECT SHOP_ID FROM SHOP WHERE USER_ID = :trader_id)";
$stmt_orders = oci_parse($conn, $query_orders);
oci_bind_by_name($stmt_orders, ":trader_id", $trader_id);
oci_execute($stmt_orders);
$row_orders = oci_fetch_assoc($stmt_orders);
$order_count = $row_orders ? $row_orders['ORDER_COUNT'] : 0;

// Close the statements
oci_free_statement($stmt);
oci_free_statement($stmt_shops);
oci_free_statement($stmt_products);
oci_free_statement($stmt_orders);
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <div class="main__content">
 

       
            <div class="col-md-12">
                <div class="row g-3">
                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <a href="products.php" class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Products</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-3">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-3"><?php echo $product_count; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <a href="orders.php" class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Orders</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-3">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-3"><?php echo $order_count; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <a href="shop-show.php" class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Shops</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-3">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-3"><?php echo $shop_count; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
</body>