<?php

$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe'); 
session_start();
if (!isset($_SESSION['tradername'])) {
    header("Location:../user/sign_in_up.php");
    exit();
}
if (isset($_GET['id'])) {
    $shop_id = $_GET['id'];

    // Database connection
    $conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

    // Check connection
    if (!$conn) {
        $e = oci_error();
        echo "Sorry, there seems to be a problem with the database connection: " . htmlentities($e['message']);
        exit();
    }

   
    // Delete products associated with the shop
    $delete_products_sql = "DELETE FROM PRODUCT WHERE SHOP_ID = :shop_id";
    $delete_products_stmt = oci_parse($conn, $delete_products_sql);
    oci_bind_by_name($delete_products_stmt, ":shop_id", $shop_id);
    $result_products = oci_execute($delete_products_stmt, OCI_NO_AUTO_COMMIT);

    if ($result_products) {
        // Delete the shop
        $delete_shop_sql = "DELETE FROM SHOP WHERE SHOP_ID = :shop_id";
        $delete_shop_stmt = oci_parse($conn, $delete_shop_sql);
        oci_bind_by_name($delete_shop_stmt, ":shop_id", $shop_id);
        $result_shop = oci_execute($delete_shop_stmt, OCI_NO_AUTO_COMMIT);

        if ($result_shop) {
            oci_commit($conn); // Commit the transaction
            
            echo "<script>window.location.href = 'shop-show.php';</script>";
        } else {
            oci_rollback($conn); // Rollback the transaction if deleting the shop fails
            $e = oci_error($delete_shop_stmt);
            echo "<h1>Error deleting shop: " . htmlentities($e['message']) . "</h1>";
        }

        // Free resources
        oci_free_statement($delete_shop_stmt);
    } else {
        oci_rollback($conn); // Rollback the transaction if deleting the products fails
        $e = oci_error($delete_products_stmt);
        echo "<h1>Error deleting products: " . htmlentities($e['message']) . "</h1>";
    }

    // Free resources
    oci_free_statement($delete_products_stmt);
    oci_close($conn);
}
?>
