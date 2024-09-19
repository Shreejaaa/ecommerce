<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/> -->
        
    </head>
    <body>

<title>Setting</title>

<?php 
include 'header.php'; 

$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe'); 

$customer_id = $_SESSION["customer_id"];
$sql_select = "SELECT * FROM USERS WHERE USER_ID = :customer_id";
$qry_select = oci_parse($conn, $sql_select);
oci_bind_by_name($qry_select, ":customer_id", $customer_id);
oci_execute($qry_select);
$row = oci_fetch_assoc($qry_select);

if (!$row) {
    echo "User not found.";
    exit();
}

$full_name = $row['FIRST_NAME'] . ' ' . $row['MIDDLE_NAME'] . ' ' . $row['LAST_NAME'];
?>

<div class="main__content">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item">
                        User Name: <span class="ps-2"><?php echo htmlspecialchars($row['USERNAME']); ?></span>
                    </li>
                    <li class="list-group-item">
                        Full Name: <span class="ps-2"><?php echo htmlspecialchars($full_name); ?></span>
                    </li>
                    <li class="list-group-item">
                        Age: <span class="ps-2"><?php echo htmlspecialchars($row['AGE']); ?></span>
                    </li>
                    <li class="list-group-item">
                        Email: <span class="ps-2"><?php echo htmlspecialchars($row['EMAIL']); ?></span>
                    </li>
                    <li class="list-group-item">
                        Role: <span class="ps-2"><?php echo htmlspecialchars($row['ROLE']); ?></span>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-group">
                    <li class="list-group-item text-center">
                        <img src="images/profile.jpg" alt="" style = "width:200px;height:200px;">
                    </li>
                    <li class="list-group-item">
                        <a href="update-profile.php" class="btn btn-secondary">Edit Profile</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
