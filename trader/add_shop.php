<?php
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');
session_start();
if (!isset($_SESSION['tradername'])) {
    header("Location:../user/sign_in_up.php");
    exit();
}

if (isset($_POST["ADD"])) {
    $shopname = $_POST["shopname"];
    $description = $_POST["description"];
    $category = $_POST["category"]; // New category field
    $status = $_POST["status"];
    $email = $_POST["email"];
    $trader_id = $_SESSION["trader_id"];
    
    $image = $_FILES["image"]["name"]; 
    $image_folder = "../user/uploads/";
    $image_file = $image_folder . basename($image);
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $image_file)) {
        $sql = "INSERT INTO SHOP(USER_ID, SHOP_NAME, DESCRIPTIONS, STATUS, EMAIL, IMAGE ,IS_VERIFIED, CATEGORY) 
                VALUES (:trader_id, :shopname, :description, :status, :email, :image_file, 0, :category)";
        $qry1 = oci_parse($conn, $sql);

        // Bind variables
        oci_bind_by_name($qry1, ":trader_id", $trader_id);
        oci_bind_by_name($qry1, ":shopname", $shopname);
        oci_bind_by_name($qry1, ":description", $description);
        oci_bind_by_name($qry1, ":status", $status);
        oci_bind_by_name($qry1, ":email", $email);
        oci_bind_by_name($qry1, ":image_file", $image_file);
        oci_bind_by_name($qry1, ":category", $category); // Bind the new category field

        // Execute query
        $result = oci_execute($qry1);

        if ($result) {
            echo "Shop added successfully";
            // Redirect to shop detail page
            echo "<script>window.location.href = 'shop-show.php';</script>";
        } else {
            $e = oci_error($qry1);
            echo "<h1>Error inserting data: " . htmlentities($e['message']) . "</h1>";
        }

        // Free resources
        oci_free_statement($qry1);
        oci_close($conn);
    } else {
        echo "Error uploading file.";
    }
}
?>
