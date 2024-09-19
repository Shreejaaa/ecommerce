<title>Update Shop</title>

<?php include 'header.php'; 
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe'); //workspace name, admin-paassword ,last ko samee

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trader_id = $_SESSION["trader_id"];
    $first_name = $_POST["first_name"];
    $middle_name = $_POST["middle_name"];
    $last_name = $_POST["last_name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Fetch user's current profile information
    $sql_select = "SELECT * FROM USERS WHERE USER_ID = :trader_id";
    $qry_select = oci_parse($conn, $sql_select);
    oci_bind_by_name($qry_select, ":trader_id", $trader_id);
    oci_execute($qry_select);
    $row = oci_fetch_assoc($qry_select);

    // Update profile with new information
    $sql_update = "UPDATE USERS SET FIRST_NAME = :first_name, MIDDLE_NAME = :middle_name, LAST_NAME = :last_name, USERNAME = :username, EMAIL = :email, PASSWORD = :password WHERE USER_ID = :trader_id";
    $qry_update = oci_parse($conn, $sql_update);
    oci_bind_by_name($qry_update, ":first_name", $first_name);
    oci_bind_by_name($qry_update, ":middle_name", $middle_name);
    oci_bind_by_name($qry_update, ":last_name", $last_name);
    oci_bind_by_name($qry_update, ":username", $username);
    oci_bind_by_name($qry_update, ":email", $email);
    oci_bind_by_name($qry_update, ":password", $password);
    oci_bind_by_name($qry_update, ":trader_id", $trader_id);

    $result = oci_execute($qry_update);

    if ($result) {
        echo "Profile updated successfully";
    } else {
        echo "Error updating profile";
    }
}
?>

<div class="main__content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Update Profile
                    </div>
                    <div class="">
                        <a href="settings.php" class="btn btn-secondary" name="button">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="" action="" method="POST">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">First Name <span class="text-danger">*</span> </label>
                                <input type="text" name="first_name" class="form-control" value="">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Middle Name <span class="text-danger">*</span> </label>
                                <input type="text" name="middle_name" class="form-control" value="">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Last Name <span class="text-danger">*</span> </label>
                                <input type="text" name="last_name" class="form-control" value="">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Username <span class="text-danger">*</span> </label>
                                <input type="text" name="username" class="form-control" value="">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email <span class="text-danger">*</span> </label>
                                <input type="email" name="email" class="form-control" value="">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Password <span class="text-danger">*</span> </label>
                                <input type="password" name="password" class="form-control" value="">
                            </div>
                           
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success" name="update">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
