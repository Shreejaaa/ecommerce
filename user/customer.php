<?php
include("header.php");

$customer_id = $_SESSION["customer_id"];

// Fetch user details
$sql_select = "SELECT * FROM USERS WHERE USER_ID = :customer_id";
$qry_select = oci_parse($conn, $sql_select);
oci_bind_by_name($qry_select, ":customer_id", $customer_id);
oci_execute($qry_select);
$user_row = oci_fetch_assoc($qry_select);

// Fetch order history for the user
$order_history_query = "
    SELECT o.ORDER_ID, o.CART_ID, o.COLL_SLOT_ID, o.TOTAL_ORDER, o.STATUS, cs.SLOT_DATE, cs.DAY_DETAILS, cs.TIME_DETAILS
    FROM ORDERS o
    JOIN COLLECTION_SLOT cs ON o.COLL_SLOT_ID = cs.COLL_SLOT_ID
    JOIN CART c ON o.CART_ID = c.CART_ID
    WHERE c.USER_ID = :customer_id
    ORDER BY o.ORDER_ID DESC";
$order_history_statement = oci_parse($conn, $order_history_query);
oci_bind_by_name($order_history_statement, ":customer_id", $customer_id);
oci_execute($order_history_statement);

?>

<title>Customer Profile</title>
<link rel="stylesheet" href="customer.css"/>
<link rel="stylesheet" href="nav.css" />
<link rel="stylesheet" href="footer.css" />

<div class="main-wrapper">
    <aside class="sidebar">
        <nav class="side-navigation">
            <a href="profile.php" class="side-nav-item">Manage Account</a>
            <p>Personal Details</p>
            <p>Delivery Address</p>
            <a href="#" class="side-nav-item">Orders</a>
            <a href="#" class="side-nav-item">Reviews</a>
            <a href="wishlist.php" class="side-nav-item">Wish List</a>
            <a href="cart.php" class="side-nav-item">Cart</a>
            <a href="logout.php" class="side-nav-item">Become a Trader</a>
        </nav>
    </aside>
    <main class="main-content">
        <h2>Manage My Account</h2>
        <div class="details-container">
            <section class="personal-details">
                <h3>Personal Details<a href="profile.php" class="edit-profile">| EDIT</a></h3>
                <?php
                echo "Username: " . $user_row['USERNAME'];
                echo "<br>";
                echo "Email: " . $user_row['EMAIL'];
                ?>
            </section>

            <section class="delivery-address">
                <h3>Delivery Address<a href="#" class="edit-profile">| EDIT</a></h3>
                <h2>DEFAULT DELIVERY ADDRESS</h2>
                <p>[Customer's Full Name]</p>
                <p>123 Green Street</p>
                <p>Manchester</p>
                <p>M1 2NQ</p>
                <p>United Kingdom</p>
            </section>
        </div>

        <section class="recent-orders">
            <h3>Recent Orders</h3>
            <table>
                <tr>
                    <th>ORDER ID</th>
                    <th>CART ID</th>
                    <th>COLLECTION SLOT</th>
                    <th>TOTAL AMOUNT</th>
                    <th>STATUS</th>
                </tr>
                <?php
                while ($order_row = oci_fetch_assoc($order_history_statement)) {
                    echo "<tr>";
                    echo "<td>" . $order_row['ORDER_ID'] . "</td>";
                    echo "<td>" . $order_row['CART_ID'] . "</td>";
                    echo "<td>" . $order_row['SLOT_DATE'] . " (" . $order_row['DAY_DETAILS'] . ", " . $order_row['TIME_DETAILS'] . ")</td>";
                    echo "<td>$" . number_format($order_row['TOTAL_ORDER'], 2) . "</td>";
                    echo "<td>" . $order_row['STATUS'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </section>
    </main>
</div>

<?php
include("footer.php")
?>
