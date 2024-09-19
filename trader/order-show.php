<title>Order details</title>

<?php
include 'header.php';

if (!isset($_SESSION['tradername'])) {
    header("Location:../user/sign_in_up.php");
    exit();
}

// Assuming order ID is passed as a query parameter
$order_id = $_GET['order_id'];

// Establish database connection
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Fetch trader's product categories
$trader_name = $_SESSION['tradername'];
$query = "SELECT t.USER_ID FROM USERS t WHERE t.USERNAME = :trader_name";
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":trader_name", $trader_name);
oci_execute($stmt);

$trader = oci_fetch_assoc($stmt);
$trader_id = $trader['USER_ID'];

// Fetch customer and order details
$query = "
    SELECT u.FIRST_NAME, u.LAST_NAME, u.PHONE, u.EMAIL, o.ORDER_DATE_TIME, o.STATUS
    FROM ORDERS o
    JOIN CART c ON o.CART_ID = c.CART_ID
    JOIN USERS u ON c.USER_ID = u.USER_ID
    WHERE o.ORDER_ID = :order_id";
    
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":order_id", $order_id);
oci_execute($stmt);

$customer_details = oci_fetch_assoc($stmt);

// Fetch product details for the order that belong to the trader's product category
$query = "
    SELECT p.NAMES, op.QUANTITY, p.PRICE
    FROM ORDER_PRODUCT op
    JOIN PRODUCT p ON op.PRODUCT_ID = p.PRODUCT_ID
    JOIN SHOP s ON p.SHOP_ID = s.SHOP_ID
    WHERE op.ORDER_ID = :order_id AND s.USER_ID = :trader_id";
    
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":order_id", $order_id);
oci_bind_by_name($stmt, ":trader_id", $trader_id);
oci_execute($stmt);

$product_details = [];
while ($row = oci_fetch_assoc($stmt)) {
    $product_details[] = $row;
}

// Close the statement
oci_free_statement($stmt);
oci_close($conn);
?>

<div class="main__content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Order details
                    </div>
                    <div class="">
                        <a href="orders.php" class="btn btn-secondary" name="button">Back</a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <h4>Customer Detail</h4>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    Full Name: <span class="ps-2"><?php echo $customer_details['FIRST_NAME'] . ' ' . $customer_details['LAST_NAME']; ?></span>
                                </li>
                                <li class="list-group-item">
                                    Contact: <span class="ps-2"><?php echo $customer_details['PHONE']; ?></span>
                                </li>
                                <li class="list-group-item">
                                    Email: <span class="ps-2"><?php echo $customer_details['EMAIL']; ?></span>
                                </li>
                                <li class="list-group-item">
                                    Ordered Date: <span class="ps-2"><?php echo $customer_details['ORDER_DATE_TIME']; ?></span>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <h4>Product List</h4>
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <td>#</td>
                                        <td>Product Name</td>
                                        <td>Quantity</td>
                                        <td>Price</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($product_details as $index => $product): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $product['NAMES']; ?></td>
                                        <td><?php echo $product['QUANTITY']; ?></td>
                                        <td><?php echo $product['PRICE'] * $product['QUANTITY']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                          