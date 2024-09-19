<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="reset_password.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><h2>Reset Password</h2></legend>
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required><br><br>
            <label>Re-enter your password</label>
            <input type="password" name="re_password" placeholder="Re enter your password" required><br><br>
            <input type="submit" value="Change Password" name="submit">
        </fieldset>
    </form>

    <?php 
    session_start();
    $email = $_SESSION['reset_email'];
    if(isset($_POST['submit'])){
        $password = $_POST['password'];
        $_re_password = $_POST['re_password'];
        if($password != $_re_password){
            echo "Password does not match with each other. Check your spelling";
        }
        else{

            $conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

            $qry = "UPDATE USERS SET PASSWORD = '$password' WHERE EMAIL = '$email'";
            $stid = oci_parse($conn,$qry);
            $stid1 = oci_execute($stid);

            if($stid1){
                header("Location: ../sign_in_up.php");
            }
            else{
                echo "password could not be reset";
            }
        }
    }
    ?>
</body>
</html>