<?php
// Database connection
include("header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $userId = $_POST['user_id'];
    $rating = floatval($_POST['rating']);
    $comment = htmlspecialchars($_POST['comment']);
    $date = date('d-M-Y'); // Assuming this is the format you want

    // Prepare the INSERT statement
    $query = "INSERT INTO REVIEW (USER_ID, PRODUCT_ID, RATING, COMMENTS, REVIEW_DATE) VALUES (:user_id, :product_id, :rating, :comment, TO_DATE($date, 'DD-MM-YYYY'))";
    $stmt = oci_parse($conn, $query);

    // Bind the parameters
    oci_bind_by_name($stmt, ":user_id", $userId);
    oci_bind_by_name($stmt, ":product_id", $productId);
    oci_bind_by_name($stmt, ":rating", $rating);
    oci_bind_by_name($stmt, ":comment", $comment);
    // oci_bind_by_name($stmt, ":date", $date);

    // Execute the statement
    $result = oci_execute($stmt);

    if ($result) {
        // Redirect to product detail page after successful insert
        header("Location: product-details.php?id=" . $productId);
        exit();
    } else {
        // Display error message if insertion fails
        $error_message = oci_error($stmt);
        echo "Failed to submit review: " . $error_message['message'];
    }

    oci_free_statement($stmt);
}

oci_close($conn);
?>
