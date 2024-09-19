<?php
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe'); 

if (!$conn) {
    $e = oci_error();
    echo "Connection failed: " . htmlentities($e['message']);
    exit;
}

if (isset($_GET['email']) && isset($_GET['v_code'])) {
    $email = $_GET['email'];
    $v_code = $_GET['v_code'];
    
    $sql = "SELECT * FROM USERS WHERE EMAIL = '$email' AND VERIFICATION_CODE = '$v_code'";
    $result = oci_parse($conn, $sql);
    
    oci_execute($result);
    
    if ($result) {
        if (oci_fetch($result)) {
            $is_verified = oci_result($result, 'IS_VERIFIED');
            
            if ($is_verified == 0) {
                $update = "UPDATE USERS SET is_verified = 1 WHERE EMAIL = '$email' "; //AND ROLE = 'Customer'
                $update_stmt = oci_parse($conn, $update);
                
                $update_result = oci_execute($update_stmt);
                
                if ($update_result) {
                    echo "Email verification successful";
                } else {
                    $e = oci_error($update_stmt);
                    echo "Cannot verify email: " . htmlentities($e['message']);
                }
                
                oci_free_statement($update_stmt);
            } else {
                echo "Email already registered.";
            }
        } else {
            echo "Invalid email or verification code.";
        }
    } else {
        $e = oci_error($result);
        echo "Cannot execute: " . htmlentities($e['message']);
    }
    
    oci_free_statement($result);
}

oci_close($conn);
?>
