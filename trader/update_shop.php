<?php
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe'); 
session_start();
if (!isset($_SESSION['tradername'])) {
    header("Location:../user/sign_in_up.php");
    exit();
}


if (isset($_GET['id'])) {
    $shop_id = $_GET['id'];


    $query = "SELECT * FROM SHOP WHERE SHOP_ID = :shop_id";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":shop_id", $shop_id);
    oci_execute($stmt);

    if ($row = oci_fetch_assoc($stmt)) 
    

            if (isset($_POST['update'])) {
                $shop_id = $_POST['shop_id'];
                $shopname = $_POST['shopname'];
                $description = $_POST['description'];
                $status = $_POST['status'];
                $email = $_POST['email'];
                
                $query = "UPDATE SHOP SET SHOP_NAME=:shopname, DESCRIPTIONS=:description, STATUS=:status, EMAIL=:email WHERE SHOP_ID=:shop_id";
                $stmt = oci_parse($conn, $query);
                oci_bind_by_name($stmt, ":shopname", $shopname);
                oci_bind_by_name($stmt, ":description", $description);
                oci_bind_by_name($stmt, ":status", $status);
                oci_bind_by_name($stmt, ":email", $email);
                oci_bind_by_name($stmt, ":shop_id", $shop_id);
                
                $result = oci_execute($stmt);
                
                if ($result) {
                    echo"<script>windows.href='shop-show.php'</script>";
                    
                } else {
                    echo "Error updating shop: " . oci_error($stmt)['message'];
                }

                oci_free_statement($stmt);
                oci_close($conn);
}
}

else{
    echo"No data is updated";
}
