<?php
session_start();
$response = array('success' => false, 'message' => '');

if (isset($_GET['product_id'])) {
    $conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

    if (!$conn) {
        $e = oci_error();
        $response['message'] = 'Error connecting to database: ' . htmlentities($e['message']);
        echo json_encode($response);
        exit();
    }

    if (!isset($_SESSION['username'])) {
        $response['message'] = 'You need to be logged in to perform this action.';
        echo json_encode($response);
        exit();
    }

    $user_id = $_SESSION['customer_id'];
    $product_id = $_GET['product_id'];

    // Get the user's wishlist ID
    $query = "SELECT WISHLIST_ID FROM WISHLIST WHERE USER_ID = :user_id";
    $stid = oci_parse($conn, $query);
    oci_bind_by_name($stid, ':user_id', $user_id);

    if (!oci_execute($stid)) {
        $e = oci_error($stid);
        $response['message'] = 'Error executing query: ' . htmlentities($e['message']);
        echo json_encode($response);
        exit();
    }

    $row = oci_fetch_assoc($stid);
    if (!$row) {
        $response['message'] = 'No wishlist found for user.';
        echo json_encode($response);
        exit();
    }

    $wishlist_id = $row['WISHLIST_ID'];

    // Delete the product from the wishlist
    $query = "DELETE FROM WISHLIST_ITEM WHERE WISHLIST_ID = :wishlist_id AND PRODUCT_ID = :product_id";
    $stid = oci_parse($conn, $query);
    oci_bind_by_name($stid, ':wishlist_id', $wishlist_id);
    oci_bind_by_name($stid, ':product_id', $product_id);

    if (oci_execute($stid)) {
        $response['success'] = true;
    } else {
        $e = oci_error($stid);
        $response['message'] = 'Error deleting product from wishlist: ' . htmlentities($e['message']);
    }

    oci_free_statement($stid);
    oci_close($conn);
} else {
    $response['message'] = 'Product ID not provided.';
}

echo json_encode($response);
?>
