<?php
if (isset($_POST["register"])) {
    $shopname = $_POST["shopname"];
    $description = $_POST["description"];
    $email = $_POST["email"];
    $category = $_POST["category"];
    $image_folder = "uploads/";

    // File upload handling
    $image = $_FILES["image"]["name"];
    $image_file = $image_folder . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $image_file);

    // Establish database connection
    $conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Query to retrieve the user_id from the user table
    $query = "SELECT USER_ID FROM USERS WHERE EMAIL = :email";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":email", $email);
    oci_execute($stmt);

    // Debug: Print the query result
    if (($row = oci_fetch_assoc($stmt)) !== false) {
        echo "User ID retrieved successfully: " . $row['USER_ID'] . "<br>";
    } else {
        echo "Failed to retrieve user ID<br>";
    }


    $user_id = $row['USER_ID'];

    // Prepare the SQL statement to insert data into the SHOP table
    $sql = "INSERT INTO SHOP(USER_ID, SHOP_NAME, DESCRIPTIONS, STATUS, EMAIL, CREATED_ON, IMAGE, IS_VERIFIED, CATEGORY) VALUES (:user_id, :shopname, :description,  'open', :email, SYSDATE, :image, 0,:category)";
    $qry = oci_parse($conn, $sql);

    // Bind the PHP variables to the SQL placeholders
    oci_bind_by_name($qry, ":user_id", $user_id);
    oci_bind_by_name($qry, ":shopname", $shopname);
    oci_bind_by_name($qry, ":description", $description);
    oci_bind_by_name($qry, ":email", $email);
    oci_bind_by_name($qry, ":image", $image_file);
    oci_bind_by_name($qry, ":category", $category);

    // Execute the query
    $result = oci_execute($qry);

    if ($result) {
        oci_commit($conn);
        echo "<script>alert('Data inserted successfully'); window.location.href = 'sign_in_up.php';</script></script>";
    } else {
        echo "Error inserting data";
    }

    // Free resources
    oci_free_statement($qry);
    oci_close($conn);
}
?>
