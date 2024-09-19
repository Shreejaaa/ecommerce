<?php
include("header.php");
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe'); //workspace name, admin-paassword ,last ko samee
if (isset($_POST["update"])) 
{
    $id = $_POST["id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $quantity = $_POST["quantity"];
    $maxorder = $_POST["maxorder"];
    $minorder = $_POST["minorder"];
    $stock = $_POST["stock"];
    $weight = $_POST["weight"];
    $manufacture = date('d-M-Y', strtotime($_POST["manufacture"]));
    $expiry = date('d-M-Y', strtotime($_POST["expiry"]));

    // Check if a new image file has been uploaded
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $target_dir = "../user/uploads";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $extensions_arr = array("jpg", "jpeg", "png", "gif", "svg");

        // Check if the file format is valid
        if (in_array($imageFileType, $extensions_arr)) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($tempname, $target_file)) {
                $image = $target_file;

                // Update the product record in the database
                $sql = "UPDATE PRODUCT SET NAMES='$name', PRICE='$price', DESCRIPTIONS='$description', QUANTITY='$quantity', MIN_ORDER='$minorder', MAX_ORDER='$maxorder', IMAGE='$image', STOCK_NUMBER='$stock', WEIGHT='$weight', MANUFACTURING_DATE='$manufacture', EXPIRY_DATE='$expiry' WHERE PRODUCT_ID= '$id'";

                $qry = oci_parse($conn, $sql);
                $row = oci_execute($qry);

                if ($row) {
                    echo "<script>window.location.href = 'products.php';</script>";
                } else {
                    echo "Error updating data: ";
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file format.";
        }
    } else {
        // Update the product record without changing the image
        $sql = "UPDATE PRODUCT SET NAMES='$name', PRICE='$price', DESCRIPTIONS='$description', QUANTITY='$quantity', MIN_ORDER='$minorder', MAX_ORDER='$maxorder', STOCK_NUMBER='$stock', WEIGHT='$weight', MANUFACTURING_DATE='$manufacture', EXPIRY_DATE='$expiry' WHERE PRODUCT_ID='$id'";
        $qry = oci_parse($conn, $sql);
        $row = oci_execute($qry);

        if ($row) {
            echo "<script>window.location.href = 'products.php';</script>";
            
        } else {
            echo "Error updating data: ";
        }
    }
} 
else 
{
    echo "Invalid request.";
}


?>
