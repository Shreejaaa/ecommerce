<?php
session_start();

$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');
if (!$conn) {
    die("Connection failed: " . oci_error());
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = md5($_POST["password"]);
    $role = $_POST["role"];


    $sql1 = "SELECT * FROM USERS";
    $qry1 = oci_parse($conn, $sql1);
    oci_execute($qry1);

    $authenticated = false;

    while ($row = oci_fetch_assoc($qry1)) {
        if ($role === "Admin" && strcasecmp(trim($row['USERNAME']), trim($username)) === 0 && $password === $admin_password) {
            $authenticated = true;
            $_SESSION["adminname"] = $row['USERNAME'];
            $_SESSION["admin_id"] = $row['USER_ID'];
            echo "<script>window.location.href = '../admin/admin.php';</script>";
            exit;
        }

        if (strcasecmp(trim($row['USERNAME']), trim($username)) === 0 && $row['PASSWORD'] === $password && $row['ROLE'] === $role) {
            $authenticated = true;

            if ($row['IS_VERIFIED'] == '0') {
                echo "<script>alert('You have not been verified yet.'); window.location.href = 'sign_in_up.php';</script>";
                exit;
            } else {
                if ($role == "Trader") {
                    $_SESSION["tradername"] = $username;
                    $_SESSION["trader_id"] = $row['USER_ID'];
                    echo "<script>window.location.href = '../trader/home.php';</script>";
                    exit;
                } elseif ($role == "Customer") {
                    $_SESSION["username"] = $username;
                    $_SESSION["customer_id"] = $row['USER_ID'];
                    echo "<script>window.location.href = 'homepage.php';</script>";
                    exit;
                }
            }
        }
    }

    if (!$authenticated) {
        echo "<script>alert('Authentication Failed'); window.location.href = 'sign_in_up.php';</script>";
        exit;
    }
}
?>
