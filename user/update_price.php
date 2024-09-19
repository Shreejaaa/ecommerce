<?php
session_start();
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

if (!$conn) {
    $e = oci_error();
    echo json_encode(array('status' => 'error', 'message' => htmlentities($e['message'])));
    exit();
}

if (!isset($_SESSION['username'])) {
    echo json_encode(array('status' => 'error', 'message' => 'User not logged in.'));
    exit();
}

$user_id = $_SESSION['user_id'];
$total_price = $_POST['total_price']; // Note: use lowercase for 'total_price' to match the JS variable

// Get the user's cart ID
$query = "SELECT CART_ID FROM CART WHERE USER_ID = :user_id";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ':user_id', $user_id);

if (!oci_execute($stid)) {
    $e = oci_error($stid);
    echo json_encode(array('status' => 'error', 'message' => htmlentities($e['message'])));
    exit();
}

$row = oci_fetch_assoc($stid);
if (!$row) {
    echo json_encode(array('status' => 'error', 'message' => 'No cart found for user.'));
    exit();
}
$cart_id = $row['CART_ID'];

// Update the total price of the cart
$query = "UPDATE CART SET TOTAL_PRICE = :total_price WHERE CART_ID = :cart_id";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ':total_price', $total_price);
oci_bind_by_name($stid, ':cart_id', $cart_id);

if (oci_execute($stid)) {
    echo json_encode(array('status' => 'success', 'message' => 'Total price updated successfully.'));
} else {
    $e = oci_error($stid);
    echo json_encode(array('status' => 'error', 'message' => htmlentities($e['message'])));
}

oci_free_statement($stid);
oci_close($conn);
?>
