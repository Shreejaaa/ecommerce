<?php
include('header.php');


$customerId = $_SESSION['cart_id']; // Adjust if needed



$cart_query = "SELECT ci.PRODUCT_ID, p.PRICE, ci.PRODUCT_QUANTITY 
               FROM CART_ITEM ci
               JOIN PRODUCT p ON ci.PRODUCT_ID = p.PRODUCT_ID
               WHERE CART_ID = :customerID";
$select_cart = oci_parse($conn, $cart_query);
oci_bind_by_name($select_cart, ":customerId", $customerId);

if (oci_execute($select_cart)) {
    while ($order_cart = oci_fetch_assoc($select_cart)) {
        // Insert product details into ORDER_PRODUCT
        $order_product_query = "INSERT INTO ORDER_PRODUCT (ORDER_PRODUCT_ID, ORDER_ID, PRODUCT_ID, QUANTITY)
                                VALUES (ORDER_PRODUCT_SEQ.NEXTVAL, :orderId, :productId, :quantity)";
        $insert_order_product = oci_parse($conn, $order_product_query);

        oci_bind_by_name($insert_order_product, ":orderId", $orderId); // You need to define $orderId
        oci_bind_by_name($insert_order_product, ":productId", $order_cart['PRODUCT_ID']);
        oci_bind_by_name($insert_order_product, ":quantity", $order_cart['PRODUCT_QUANTITY']);
        oci_execute($insert_order_product);

        // Selecting the stock
        $select_stock_query = "SELECT STOCK_NUMBER FROM PRODUCT WHERE PRODUCT_ID = :productId";
        $select_stock = oci_parse($conn, $select_stock_query);
        oci_bind_by_name($select_stock, ":productId", $order_cart['PRODUCT_ID']);
        oci_execute($select_stock);
        $row = oci_fetch_assoc($select_stock);

        $remaining_stock = $row['STOCK_NUMBER'] - $order_cart['PRODUCT_QUANTITY'];

        // Updating the stock
        $update_stock_query = "UPDATE PRODUCT SET STOCK_NUMBER = :stock WHERE PRODUCT_ID = :productId";
        $update_stock = oci_parse($conn, $update_stock_query);
        oci_bind_by_name($update_stock, ":productId", $order_cart['PRODUCT_ID']);
        oci_bind_by_name($update_stock, ":stock", $remaining_stock);
        oci_execute($update_stock);
    }
}


echo "<script>alert('Order placed successfully!'); window.location.href = 'order_table.php';</script>";
include('footer.php');
?>