<?php

include('header.php');

if (isset($_POST['add_to_cart'])) {
    $conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe'); 

    if (!$conn) {
        $e = oci_error();
        echo "<script>alert('Error connecting to database: " . htmlentities($e['message']) . "')</script>";
        exit();
    }

    if (!isset($_SESSION['username'])) {
        header("Location:../user/sign_in_up.php");
        exit();
    } else {
        $user_id = $_SESSION['customer_id'];
        echo "User ID: $user_id<br>";

        $product_id = $_POST['product_id'];
        echo "Product ID: $product_id<br>";
        $product_name = $_POST['product_name'];
        echo "Product Name: $product_name<br>";
        $product_price = $_POST['product_price'];
        echo "Product Price: $product_price<br>";
        $product_image = $_POST['product_image'];
        echo "Product Image: $product_image<br>";
        $quantity = 1; // Assuming a default quantity of 1

        // Get the user's cart ID
        $query = "SELECT CART_ID FROM CART WHERE USER_ID = :user_id";
        $stid = oci_parse($conn, $query);
        oci_bind_by_name($stid, ':user_id', $user_id);

        echo "Executing query to get cart ID...<br>";

        if (!oci_execute($stid)) {
            $e = oci_error($stid);
            echo "<script>alert('Error executing query: " . htmlentities($e['message']) . "')</script>";
            exit();
        }

        $row = oci_fetch_assoc($stid);
        if (!$row) {
            echo "Cart not found for user. Creating a new cart...<br>";
            // Create a new cart for the user
            $query_new_cart = "INSERT INTO CART (USER_ID, CREATED_ON) VALUES (:user_id, SYSDATE) RETURNING CART_ID INTO :cart_id";
            $stid_new_cart = oci_parse($conn, $query_new_cart);
            oci_bind_by_name($stid_new_cart, ':user_id', $user_id);
            oci_bind_by_name($stid_new_cart, ':cart_id', $cart_id, -1, SQLT_INT);

            if (!oci_execute($stid_new_cart)) {
                $e = oci_error($stid_new_cart);
                echo "<script>alert('Error creating new cart: " . htmlentities($e['message']) . "')</script>";
                exit();
            }
            echo "New Cart ID: $cart_id<br>";
        } else {
            $cart_id = $row['CART_ID'];
            echo "Cart ID: $cart_id<br>";
        }

        // Check if the product is already in the cart
        $query1 = "SELECT PRODUCT_ID FROM CART_ITEM WHERE CART_ID = :cart_id AND PRODUCT_ID = :product_id";
        $stid1 = oci_parse($conn, $query1);
        oci_bind_by_name($stid1, ':cart_id', $cart_id);
        oci_bind_by_name($stid1, ':product_id', $product_id);

        echo "Executing query to check if product is already in the cart...<br>";

        if (!oci_execute($stid1)) {
            $e = oci_error($stid1);
            echo "<script>alert('Error executing query: " . htmlentities($e['message']) . "')</script>";
            exit();
        }

        $row1 = oci_fetch_assoc($stid1);
        if ($row1) {
            echo "<script>alert('Product already in Cart!')</script>";
        } else {
            // Insert the new item into the cart
            $query2 = "INSERT INTO CART_ITEM (CART_ID, PRODUCT_ID, PRODUCT_QUANTITY) VALUES (:cart_id, :product_id, :quantity)";
            $stid2 = oci_parse($conn, $query2);
            oci_bind_by_name($stid2, ':cart_id', $cart_id);
            oci_bind_by_name($stid2, ':product_id', $product_id);
            oci_bind_by_name($stid2, ':quantity', $quantity);

            if (oci_execute($stid2)) {
                $_SESSION['cart_product_added'] = true;
                header("LOCATION: cart.php?product_id=$product_id");
                exit();
            } else {
                $e = oci_error($stid2);
                echo "<script>alert('Failed to add product to cart: " . htmlentities($e['message']) . "')</script>";
            }
        }
    }
}
?>
