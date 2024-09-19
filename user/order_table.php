<?php
include("header.php");

$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

if (!$conn) {
    $e = oci_error();
    echo "<script>alert('Error connecting to database: " . htmlentities($e['message']) . "')</script>";
    exit();
}

// Assume $cart_id is already available
$cart_id = $_SESSION['cart_id'];

// Fetch cart items
$cart_items_query = "
    SELECT ci.PRODUCT_ID, p.PRICE, ci.PRODUCT_QUANTITY 
    FROM CART_ITEM ci
    JOIN PRODUCT p ON ci.PRODUCT_ID = p.PRODUCT_ID
    WHERE ci.CART_ID = :cart_id";
$cart_items_statement = oci_parse($conn, $cart_items_query);
oci_bind_by_name($cart_items_statement, ':cart_id', $cart_id);
oci_execute($cart_items_statement);

// Fetch collection slot details
$collection_slot_query = "
    SELECT COLL_SLOT_ID, SLOT_DATE, DAY_DETAILS, TIME_DETAILS 
    FROM COLLECTION_SLOT
    WHERE CART_ID = :cart_id";
$collection_slot_statement = oci_parse($conn, $collection_slot_query);
oci_bind_by_name($collection_slot_statement, ':cart_id', $cart_id);
oci_execute($collection_slot_statement);
$collection_slot = oci_fetch_assoc($collection_slot_statement);

if (!$collection_slot) {
    die("Collection slot not found for cart ID: $cart_id");
}

// Initialize variables for total items and total order price
$total_items = 0;
$total_order_price = 0;

while ($item = oci_fetch_assoc($cart_items_statement)) {
    $total_items += $item['PRODUCT_QUANTITY'];
    // Apply 10% discount to the price
    $discounted_price = $item['PRICE'] * 0.9;
    $total_order_price += ($discounted_price * $item['PRODUCT_QUANTITY']);
}

// Insert data into ORDERS table
$insert_order_query = "
    INSERT INTO ORDERS (ORDER_ID, CART_ID, COLL_SLOT_ID, NO_OF_ITEM, TOTAL_ORDER, STATUS, ORDER_DATE_TIME)
    VALUES (ORDER_SEQ.NEXTVAL, :cart_id, :coll_slot_id, :total_items, :total_order_price, 'paid', SYSDATE)";
$insert_order_statement = oci_parse($conn, $insert_order_query);
oci_bind_by_name($insert_order_statement, ':cart_id', $cart_id);
oci_bind_by_name($insert_order_statement, ':coll_slot_id', $collection_slot['COLL_SLOT_ID']);
oci_bind_by_name($insert_order_statement, ':total_items', $total_items);
oci_bind_by_name($insert_order_statement, ':total_order_price', $total_order_price);

if (oci_execute($insert_order_statement)) 
{
    
   // echo"<script> alert('Data inserted successfully into ORDERS table')</script>";

    // Commit the transaction to ensure the ORDER_ID is available for reference
    oci_commit($conn);

    // Fetch the ORDER_ID based on CART_ID using ROWNUM
    $fetch_order_id_query = "
        SELECT ORDER_ID 
        FROM (
            SELECT ORDER_ID 
            FROM ORDERS 
            WHERE CART_ID = :cart_id 
            ORDER BY ORDER_DATE_TIME DESC
        ) WHERE ROWNUM = 1";
    $fetch_order_id_statement = oci_parse($conn, $fetch_order_id_query);
    oci_bind_by_name($fetch_order_id_statement, ':cart_id', $cart_id);
    oci_execute($fetch_order_id_statement);
    $order_id_row = oci_fetch_assoc($fetch_order_id_statement);
    $order_id = $order_id_row['ORDER_ID'];

    // Fetch cart items again to insert into ORDER_PRODUCT table
    oci_execute($cart_items_statement);
    
    // Insert data into ORDER_PRODUCT table
    while ($item = oci_fetch_assoc($cart_items_statement)) {
        $insert_order_product_query = "
            INSERT INTO ORDER_PRODUCT (ORDER_PRODUCT_ID, ORDER_ID, PRODUCT_ID, QUANTITY)
            VALUES (ORDER_PRODUCT_SEQ.NEXTVAL, :order_id, :product_id, :quantity)";
        $insert_order_product_statement = oci_parse($conn, $insert_order_product_query);
        oci_bind_by_name($insert_order_product_statement, ':order_id', $order_id);
        oci_bind_by_name($insert_order_product_statement, ':product_id', $item['PRODUCT_ID']);
        oci_bind_by_name($insert_order_product_statement, ':quantity', $item['PRODUCT_QUANTITY']);
        
        if (oci_execute($insert_order_product_statement)) {
           // echo "<script> alert('Data inserted successfully into ORDER_PRODUCT table') </script>";
   
        } else {
            $error = oci_error($insert_order_product_statement);
            echo "Error inserting data into ORDER_PRODUCT table for product ID: " . $item['PRODUCT_ID'] . " - " . $error['message'] . "<br>";
        }
    }

$email_query = "
    SELECT u.EMAIL
    FROM USERS u
    JOIN CART c ON u.USER_ID = c.USER_ID
    WHERE c.CART_ID = :cart_id";
$email_statement = oci_parse($conn, $email_query);
oci_bind_by_name($email_statement, ':cart_id', $cart_id);
oci_execute($email_statement);
$email_row = oci_fetch_assoc($email_statement);
$customer_email = $email_row['EMAIL'];

if (!$customer_email) {
    die("Email not found for cart ID: $cart_id");
}

// Create the receipt message
$receipt_message = "
<h1>Thank you for your purchase from SubMart!</h1>
<table border='1' cellpadding='10' cellspacing='0'>
    <tr><th colspan='2'>Order Details</th></tr>
    <tr><td><strong>Order ID:</strong></td><td>$order_id</td></tr>
    <tr><td><strong>Collection Slot:</strong></td><td>" . $collection_slot['SLOT_DATE'] . " (" . $collection_slot['DAY_DETAILS'] . ", " . $collection_slot['TIME_DETAILS'] . ")</td></tr>
    <tr><th colspan='2'>Items</th></tr>
    
    <tr><td><strong>Total Items:</strong></td><td>$total_items</td></tr>
    <tr><td><strong>Total Order Price:</strong></td><td>$" . number_format($total_order_price, 2) . "</td></tr>
</table>
";


if (send_mail($customer_email, $receipt_message)) {
   
    echo "<script> alert('Receipt sent successfully to $customer_email'); window.location.href = 'homepage.php'; </script>";
    
} else {
    echo "Failed to send the receipt email.";
}


$delete_cart_items_query = "DELETE FROM CART_ITEM WHERE CART_ID = :cart_id";
$delete_cart_items_statement = oci_parse($conn, $delete_cart_items_query);
oci_bind_by_name($delete_cart_items_statement, ':cart_id', $cart_id);
if (oci_execute($delete_cart_items_statement)) {
   
    //echo "<script> alert('Cart items deleted successfully') </script>";
} else {
    $error = oci_error($delete_cart_items_statement);
    echo "Error deleting cart items: " . $error['message'] . "<br>";
}




}
 else 
{
$error = oci_error($insert_order_statement);
echo "Error inserting data into ORDERS table: " . $error['message'] . "<br>";
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
function send_mail($email, $message)
{
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/SMTP.php';

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'koko.mitsuu@gmail.com';
        $mail->Password = 'oiov bjhy xxcl tcbp';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('koko.mitsuu@gmail.com', 'Submart');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your Receipt from SubMart';
        $mail->Body = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>