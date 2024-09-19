<title>Setting</title>

<?php 
include 'header.php'; 

$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe'); 

$trader_id = $_SESSION["trader_id"];
$sql_select = "SELECT * FROM USERS WHERE USER_ID = :trader_id";
$qry_select = oci_parse($conn, $sql_select);
oci_bind_by_name($qry_select, ":trader_id", $trader_id);
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
                        <img src="../user/images/profile.jpg" alt="">
                    </li>
                    <li class="list-group-item">
                        <a href="update-profile.php" class="btn btn-secondary">Edit Profile</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
