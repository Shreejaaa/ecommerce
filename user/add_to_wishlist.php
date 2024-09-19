<?php
session_start();

if (isset($_POST['add_to_wishlist'])) {
    $conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe'); 

    if (!$conn) {
        $e = oci_error();
        echo "<script>alert('Error connecting to database: " . htmlentities($e['message']) . "')</script>";
        exit();
    }

    if (!isset($_SESSION['username'])) {
        header("Location: ../user/sign_in_up.php");
        exit();
    } else {
        $user_id = $_SESSION['customer_id'];
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];

        // Get the user's wishlist ID
        $query = "SELECT WISHLIST_ID FROM WISHLIST WHERE USER_ID = :user_id";
        $stid = oci_parse($conn, $query);
        oci_bind_by_name($stid, ':user_id', $user_id);

        if (!oci_execute($stid)) {
            $e = oci_error($stid);
            echo "<script>alert('Error executing query: " . htmlentities($e['message']) . "')</script>";
            exit();
        }

        $row = oci_fetch_assoc($stid);
        if (!$row) {
            // Create a new wishlist for the user
            $query_new_wishlist = "INSERT INTO WISHLIST (USER_ID, CREATED_ON) VALUES (:user_id, SYSDATE) RETURNING WISHLIST_ID INTO :wishlist_id";
            $stid_new_wishlist = oci_parse($conn, $query_new_wishlist);
            oci_bind_by_name($stid_new_wishlist, ':user_id', $user_id);
            oci_bind_by_name($stid_new_wishlist, ':wishlist_id', $wishlist_id, -1, SQLT_INT);

            if (!oci_execute($stid_new_wishlist)) {
                $e = oci_error($stid_new_wishlist);
                echo "<script>alert('Error creating new wishlist: " . htmlentities($e['message']) . "')</script>";
                exit();
            }
        } else {
            $wishlist_id = $row['WISHLIST_ID'];
        }

        // Check if the product is already in the wishlist
        $query1 = "SELECT PRODUCT_ID FROM WISHLIST_ITEM WHERE WISHLIST_ID = :wishlist_id AND PRODUCT_ID = :product_id";
        $stid1 = oci_parse($conn, $query1);
        oci_bind_by_name($stid1, ':wishlist_id', $wishlist_id);
        oci_bind_by_name($stid1, ':product_id', $product_id);

        if (!oci_execute($stid1)) {
            $e = oci_error($stid1);
            echo "<script>alert('Error executing query: " . htmlentities($e['message']) . "')</script>";
            exit();
        }

        $row1 = oci_fetch_assoc($stid1);
        if ($row1) {
            echo "<script>alert('Product already in Wishlist!')</script>";
        } else {
            // Insert the new item into the wishlist
            $query2 = "INSERT INTO WISHLIST_ITEM (WISHLIST_ID, PRODUCT_ID) VALUES (:wishlist_id, :product_id)";
            $stid2 = oci_parse($conn, $query2);
            oci_bind_by_name($stid2, ':wishlist_id', $wishlist_id);
            oci_bind_by_name($stid2, ':product_id', $product_id);

            if (oci_execute($stid2)) {
                $_SESSION['wishlist_product_added'] = true;
                header("LOCATION: wishlist.php");
                exit();
            } else {
                $e = oci_error($stid2);
                echo "<script>alert('Failed to add product to wishlist: " . htmlentities($e['message']) . "')</script>";
            }
        }
    }
}
?>
