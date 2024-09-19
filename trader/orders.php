<title>Shop</title>

<?php
include 'header.php'; 

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

// Query to get order details along with customer information
$query = "
SELECT o.ORDER_ID, u.FIRST_NAME, u.LAST_NAME, u.PHONE, u.EMAIL, o.STATUS
FROM ORDER_PRODUCT op
JOIN PRODUCT p ON op.PRODUCT_ID = p.PRODUCT_ID
JOIN SHOP s ON p.SHOP_ID = s.SHOP_ID
JOIN ORDERS o ON op.ORDER_ID = o.ORDER_ID
JOIN CART c ON o.CART_ID = c.CART_ID
JOIN USERS u ON c.USER_ID = u.USER_ID
WHERE s.USER_ID = :trader_id";


$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":trader_id", $trader_id);
oci_execute($stmt);

// Fetch the results
$order_details = [];
while ($row = oci_fetch_assoc($stmt)) {
    $order_details[] = $row;
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
                        Order List
                    </div>
                    <div class="">
                        <a href="shop-create.php" class="btn btn-secondary" name="button">Add Shop</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th width="160px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($order_details)): ?>
                                <tr>
                                    <td colspan="6">No orders found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($order_details as $index => $order): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $order['FIRST_NAME'] . ' ' . $order['LAST_NAME']; ?></td>
                                        <td><?php echo $order['PHONE']; ?></td>
                                        <td><?php echo $order['EMAIL']; ?></td>
                                        <td><?php echo $order['STATUS']; ?></td>
                                        <td>
                                            <a href="order-show.php?order_id=<?php echo $order['ORDER_ID']; ?>" class="btn btn-success">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <a href="order-delete.php?order_id=<?php echo $order['ORDER_ID']; ?>" class="btn btn-danger">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
