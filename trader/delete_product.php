<?php
session_start();
if (!isset($_SESSION['tradername'])) {
    header("Location:../user/sign_in_up.php");
    exit();
}

$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe'); 
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Retrieve the shop ID for the logged-in trader
    $trader_id = $_SESSION["trader_id"];
    $query = "SELECT SHOP_ID FROM SHOP WHERE USER_ID = :trader_id";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":trader_id", $trader_id);
    oci_execute($stmt);
    $row = oci_fetch_assoc($stmt);
    $shop_id = $row['SHOP_ID'];

    // Check if the product belongs to the trader's shop
    $check_query = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = :product_id AND SHOP_ID = :shop_id";
    $check_stmt = oci_parse($conn, $check_query);
    oci_bind_by_name($check_stmt, ":product_id", $product_id);
    oci_bind_by_name($check_stmt, ":shop_id", $shop_id);
    oci_execute($check_stmt);

    if (oci_fetch($check_stmt)) {
        // Delete the product if it belongs to the trader's shop
        $sql = "DELETE FROM PRODUCT WHERE PRODUCT_ID = :product_id";
        $qry = oci_parse($conn, $sql);
        oci_bind_by_name($qry, ":product_id", $product_id);
        $result = oci_execute($qry);

        if ($result) {
            echo "<script>window.location.href = 'products.php';</script>";
        } else {
            echo "<h1>Error Deleting Product</h1>";
        }
    } else {
        echo "<h1>You are not authorized to delete this product</h1>";
    }
} else {
    echo "<h1>Product ID not provided</h1>";
}

// Close the database connection
oci_close($conn);
?>
