<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send_mail($email, $v_code)
{
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/SMTP.php';

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
        $mail->Subject = 'Email verification from SubMart';
        $mail->Body = "Thank you for registration. Your OTP code is: $v_code";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if (isset($_POST["submit"])) {
    $role = $_POST["role"];
    $firstname = trim($_POST["firstname"]);
    $middlename = trim($_POST["middlename"]);
    $lastname = trim($_POST["lastname"]);
    $age = $_POST["age"];
    $contact = $_POST["phone"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    function validatePassword($password) {
        if (strlen($password) < 8) {
            return "Password must be at least 8 characters long.";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            return "Password must contain at least one uppercase letter.";
        }
        if (!preg_match('/[a-z]/', $password)) {
            return "Password must contain at least one lowercase letter.";
        }
        if (!preg_match('/[0-9]/', $password)) {
            return "Password must contain at least one number.";
        }
        if (!preg_match('/[\W_]/', $password)) {
            return "Password must contain at least one special character.";
        }
        return true;
    }

    // Validate password
    $passwordValidationResult = validatePassword($password);
    if ($passwordValidationResult !== true) {
        echo "<script>alert('$passwordValidationResult')</script>";
        exit;
    }

    if (empty($firstname) || empty($lastname) || empty($age) || empty($contact) || empty($email) || empty($username) || empty($password)) {
        echo "All fields should be filled.";
        exit;
    }

    $conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');
    $v_code = rand(100000, 999999);

    $sql = "INSERT INTO \"USERS\" (FIRST_NAME, MIDDLE_NAME, LAST_NAME, AGE, PHONE, EMAIL, USERNAME, PASSWORD, ROLE, CREATED_DATE, UPDATED_DATE, VERIFICATION_CODE, IS_VERIFIED) VALUES ('$firstname', '$middlename', '$lastname', '$age', '$contact', '$email', '$username', '$password', '$role', SYSDATE, SYSDATE, '$v_code', 0)";

    if (oci_execute(oci_parse($conn, $sql)) && send_mail($email, $v_code)) {
        $_SESSION['email'] = $email;
        $_SESSION['v_code'] = $v_code;
        $_SESSION['role'] = $role;
        $_SESSION['otp_sent'] = true;
        if($role == "Trader")
        {
            
            echo "<script>window.location.href = 'trade-sign-up.php';</script>";
            exit;
        }
        exit;
    } else {
        echo "Cannot execute";
    }
}

if (isset($_POST["verify_otp"])) {
    $user_otp = $_POST['otp'];
    if ($user_otp == $_SESSION['v_code']) {
        $conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');
        $email = $_SESSION['email'];
        $sql = "UPDATE \"USERS\" SET IS_VERIFIED = '1' WHERE EMAIL = '$email' AND ROLE = 'Customer'";
        oci_execute(oci_parse($conn, $sql));
        unset($_SESSION['v_code']);
        echo "<script>alert('OTP verified successfully.'); window.location.href = 'success.php';</script>";
    } else {
        echo "<script>alert('Invalid OTP. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In & Sign Up Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="sign.css">
    <style>
        .otp-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            z-index: 1000;
        }

        .otp-popup h2 {
            margin-top: 0;
        }

        .otp-popup input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .otp-popup button {
            width: 100%;
            padding: 10px;
            background-color: black;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

        .otp-popup button:hover {
            background-color: grey;
        }

        .otp-popup .resend {
            margin-top: 10px;
            color: #007bff;
            cursor: pointer;
            text-decoration: underline;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="image-placeholder">
                <img src="images/Welcome.png" alt="Welcome">
            </div>
            <h1>Welcome!</h1>
            <form class="form-login" method="POST" action="login.php">
                <input type="text" placeholder="Username" name="username">
                <input type="password" placeholder="Password" name="password">
                Role:
                <select name="role">
                    <option value="Trader">Trader</option>
                    <option value="Customer">Customer</option>
                    <option value="Admin">Admin</option>
                </select>
                <div class="flex-container">
                    <label class="remember-me">
                        <input type="checkbox" id="rememberMe">
                        Remember Me
                        <a href="#" class="forgot-password">forgot password?</a>
                    </label>
                </div>
                <button type="submit" name="login">Login</button>
            </form>
        </div>

        <div class="signup-container">
            <h1>Create Account!</h1>
            <form class="form-signup" method="POST" action="register.php">
                <div class="role-selection">
                    <label class="role-option customer">
                        <input type="radio" name="role" value="Customer">
                        <img src="images/Customer.png" alt="Customer">
                        Customer
                    </label>
                    <label class="role-option trader">
                        <input type="radio" name="role" value="Trader">
                        <img src="images/Trader.png" alt="Trader">
                        Trader
                    </label>
                </div>
                <input type="text" placeholder="First name" name="firstname">
                <input type="text" placeholder="Middle name" name="middlename">
                <input type="text" placeholder="Last name" name="lastname">
                <input type="date" placeholder="DOB" name="dob">
                <div class="contact-field">
                    <select id="countryCode" name="countryCode">
                        <option value="+1">USA (+1)</option>
                        <option value="+44">UK (+44)</option>
                        <option value="+977">Nepal (+977)</option>
                        <option value="+1">Canada (+1)</option>
                    </select>
                    <input type="text" name="phone" placeholder="Contact number">
                </div>
                <select name="age">
                    <option value="Select Age">-Select Age-</option>
                    <?php
                    for ($age = 1; $age < 151; $age++) {
                        echo "<option value=\"$age\"";
                        if (isset($_POST['age']) && $_POST['age'] == $age) {
                            echo "selected";
                        }
                        echo ">$age</option><br>";
                    }
                    ?>
                </select>
                <input type="email" placeholder="Email" name="email">
                <input type="text" placeholder="Username" name="username">
                <input type="password" placeholder="Password" name="password">
                <button name="submit" type="submit">Create</button>
            </form>
        </div>
    </div>

    <!-- OTP Popup -->
    <div class="overlay" id="overlay"></div>
    <div class="otp-popup" id="otp-popup">
        <h2>Enter OTP</h2>
        <p>We have sent an OTP to your registered email.</p>
        <form action="register.php" method="POST">
            <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
            <button type="submit" name="verify_otp">Verify</button>
        </form>
        <div class="resend" onclick="resendOtp()">Resend OTP</div>
    </div>

    <script>
        function showOtpPopup() {
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('otp-popup').style.display = 'block';
        }

        function hideOtpPopup() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('otp-popup').style.display = 'none';
        }

        function resendOtp() {
            // Implement the resend OTP functionality (e.g., via AJAX)
            alert('OTP resent');
        }

        <?php if (isset($_SESSION['otp_sent']) && $_SESSION['otp_sent'] == true) { ?>
            showOtpPopup();
            <?php unset($_SESSION['otp_sent']); ?>
        <?php } ?>
    </script>
</body>
</html>