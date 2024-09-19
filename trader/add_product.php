<?php
// include('header.php');
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');
session_start();
if (!isset($_SESSION['tradername'])) {
    header("Location:../user/sign_in_up.php");
    exit();
}
if (isset($_POST["add"])) {
    $shop_id = $_POST["shop_id"];
    $prod_category_id = $_POST["prod_category_id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $allergy = $_POST["allergy"];
    $quantity = $_POST["quantity"];
    $maxorder = $_POST["maxorder"];
    $minorder = $_POST["minorder"];
    $stock = $_POST["stock"];
    $weight = $_POST["weight"];
    $manufacture = date('d-M-Y', strtotime($_POST["manufacture"]));
    $expiry = date('d-M-Y', strtotime($_POST["expiry"]));

    // Check if the shop is verified
    $trader_id = $_SESSION['trader_id'];
    $query = "SELECT IS_VERIFIED FROM SHOP WHERE SHOP_ID = :shop_id AND USER_ID = :trader_id";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":shop_id", $shop_id);
    oci_bind_by_name($stmt, ":trader_id", $trader_id);
    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);
    $shop_verified = $row['IS_VERIFIED'];

    if ($shop_verified != 1) {
        echo "<h1>Your shop is not verified. You cannot add products until your shop is verified. Add Shop First</h1>";
    } else {
        // Verify if the product category ID exists
        $category_query = "SELECT COUNT(*) AS COUNT FROM PRODUCT_CATEGORY WHERE PROD_CATEGORY_ID = :prod_category_id";
        $category_stmt = oci_parse($conn, $category_query);
        oci_bind_by_name($category_stmt, ":prod_category_id", $prod_category_id);
        oci_execute($category_stmt);
        $category_row = oci_fetch_assoc($category_stmt);
        
        if ($category_row['COUNT'] == 0) {
            echo "<h1>Invalid Product Category ID.</h1>";
        } else {
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                $filename = $_FILES["image"]["name"];
                $tempname = $_FILES["image"]["tmp_name"];
                $target_dir = "../user/uploads/";
                $target_file = $target_dir . basename($filename);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $extensions_arr = array("jpg", "jpeg", "png", "gif", "svg");

                if (in_array($imageFileType, $extensions_arr)) {
                    if (move_uploaded_file($tempname, $target_file)) {
                        $sql = "INSERT INTO PRODUCT (PROD_CATEGORY_ID, SHOP_ID, NAMES, PRICE, DESCRIPTIONS, QUANTITY, MIN_ORDER, MAX_ORDER, IMAGE, STOCK_NUMBER, WEIGHT, MANUFACTURING_DATE, EXPIRY_DATE, ALLERGY) 
                        VALUES (:prod_category_id, :shop_id, :name, :price, :description, :quantity, :minorder, :maxorder, :target_file, :stock, :weight, TO_DATE(:manufacture, 'DD-MON-YYYY'), TO_DATE(:expiry, 'DD-MON-YYYY'), :allergy)";

                        $qry = oci_parse($conn, $sql);
                        oci_bind_by_name($qry, ":prod_category_id", $prod_category_id);
                        oci_bind_by_name($qry, ":shop_id", $shop_id);
                        oci_bind_by_name($qry, ":name", $name);
                        oci_bind_by_name($qry, ":price", $price);
                        oci_bind_by_name($qry, ":description", $description);
                        oci_bind_by_name($qry, ":quantity", $quantity);
                        oci_bind_by_name($qry, ":minorder", $minorder);
                        oci_bind_by_name($qry, ":maxorder", $maxorder);
                        oci_bind_by_name($qry, ":target_file", $target_file);
                        oci_bind_by_name($qry, ":stock", $stock);
                        oci_bind_by_name($qry, ":weight", $weight);
                        oci_bind_by_name($qry, ":manufacture", $manufacture);
                        oci_bind_by_name($qry, ":expiry", $expiry);
                        oci_bind_by_name($qry, ":allergy", $allergy);

                        $result = oci_execute($qry);
                        if ($result) {
                            echo "Data inserted successfully";
                            echo "<script>window.location.href = 'products.php';</script>";
                        } else {
                            $error = oci_error($qry);
                            echo "<h1>Error inserting data: " . htmlentities($error['message']) . "</h1>";
                        }
                    } else {
                        echo "Error uploading file.";
                    }
                } else {
                    echo "Invalid file format.";
                }
            } else {
                echo "No file uploaded.";
            }
        }

        oci_free_statement($category_stmt);
    }

    oci_free_statement($stmt);
    oci_close($conn);
}
?>
