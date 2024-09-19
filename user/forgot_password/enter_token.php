<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="enter_token.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><h2>Enter token</h2></legend>
            <label>Token</label>
            <input type="text" name="token" placeholder="token" required><br><br>
            <input type="submit" value="submit" name="submit">
        </fieldset>
    </form>

    <?php 
    session_start();
    if(isset($_POST['submit'])){
        if(isset($_SESSION['reset_email'])){
        $email = $_SESSION['reset_email'];
        $token = $_POST['token'];
       

        $conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

            $qry = "UPDATE ALL_USER SET tmp_key = '$token' WHERE EMAIL = '$email'";
            $stid = oci_parse($conn,$qry);
            $stid1 = oci_execute($stid);
        if($qry){
            header("Location:reset_password.php");
            exit();
        }
        else{
            echo "Failed to update token";
        }
    }
}

    
    ?>
</body>
</html>