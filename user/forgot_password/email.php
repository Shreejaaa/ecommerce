<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="email.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><h2>Reset Password</h2></legend>
            <label>Email</label>
            <input type="text" name="email" placeholder="Enter your email" required><br><br>
            <input type="submit" value="submit" name="submit">
        </fieldset>
    </form>

<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send_mail($email, $token)
{
    require '../PHPMailer/PHPMailer.php';
    require '../PHPMailer/Exception.php';
    require '../PHPMailer/SMTP.php';

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'koko.mitsuu@gmail.com';
        $mail->Password = 'oiov bjhy xxcl tcbp';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('koko.mitsuu@gmail.com', 'Submart');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset, SubMart';
        $mail->Body = "Thank you for registration. Your OTP code is: $token";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $token = rand(10000, 99999);

    $conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

    $qry = "SELECT tmp_key FROM USERS WHERE EMAIL = '$email'";
    $stid = oci_parse($conn, $qry);
    $stid1 = oci_execute($stid);
    $row = oci_fetch_assoc($stid);

    if ($row > 0) {
        $sql_update_token = "UPDATE USERS SET TOKEN = '$token' WHERE EMAIL = '$email'";
        $qry_update = oci_parse($conn, $sql_update_token);
        $run_qry = oci_execute($qry_update);
        $_SESSION['reset_email'] = $email;

        if (send_mail($email, $token)) {
            header("Location: enter_token.php");
            exit();
        } else {
            echo "Failed to send email.";
        }
    } else {
        echo "Email does not exist.";
    }
}
?>

</body>
</html>
