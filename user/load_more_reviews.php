<?php
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $query = "SELECT R.*, U.FIRST_NAME, U.LAST_NAME FROM REVIEW R JOIN USERS U ON R.USER_ID = U.USER_ID WHERE PRODUCT_ID = :product_id ORDER BY REVIEW_DATE DESC";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":product_id", $product_id);
    oci_execute($stmt);

    while ($review = oci_fetch_assoc($stmt)) {
        $stars = str_repeat('<i class="fa fa-star"></i>', $review['RATING']) .
                 str_repeat('<i class="far fa-star-o"></i>', 5 - $review['RATING']);
        echo "<div class='card mb-3'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . htmlspecialchars($review['FIRST_NAME']) . " " . htmlspecialchars($review['LAST_NAME']) . "</h5>";
        echo "<h6 class='card-subtitle mb-2 text-muted'>$stars</h6>";
        echo "<p class='card-text'>" . htmlspecialchars($review['COMMENTS']) . "</p>";
        echo "</div>";
        echo "</div>";
    }
}
?>