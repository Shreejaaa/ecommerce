<?php
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

header('Content-Type: application/json');

$response = array('success' => false);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $comments = $_POST['comments'];

    // Assuming USER_ID is available in session or you have a way to get it
    $user_id = 1; // Placeholder for actual user ID

    $query = "INSERT INTO REVIEW (USER_ID, PRODUCT_ID, RATING, COMMENTS, REVIEW_DATE) 
              VALUES (:user_id, :product_id, :rating, :comments, SYSDATE)";
    $stmt = oci_parse($conn, $query);

    oci_bind_by_name($stmt, ":user_id", $user_id);
    oci_bind_by_name($stmt, ":product_id", $product_id);
    oci_bind_by_name($stmt, ":rating", $rating);
    oci_bind_by_name($stmt, ":comments", $comments);

    if (oci_execute($stmt)) {
        $response['success'] = true;
    }
}

echo json_encode($response);
?>