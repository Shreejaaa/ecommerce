<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In & Sign Up Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="sign.css">
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div class="image-placeholder">
                <img src="images/Welcome.png" alt="Welcome">
            </div>
            <h1>Welcome!</h1>
            <form class="form-login" method="POST" action="traderlogin.php" enctype="multipart/form-data">
                <input type="text" placeholder="Shop name" name="shopname" required>
                <textarea placeholder="Shop description" name="description" required></textarea>
                <input type="email" placeholder="Email" name="email" required>
                <input type="file" placeholder="Image" name="image" accept="image/*" required>
                <select name="category" required>
                    <option value="" disabled selected>Select Category</option>
                    <option value="bakery">Bakery</option>
                    <option value="grocery">Grocery</option>
                    <option value="fishmonger">Fishmonger</option>
                    <option value="delicatessen">Delicatessen</option>
                    <option value="butcher">Butcher</option>
                </select>
                <button type="submit" name="register" class="w-100">Register Now</button>
            </form>
        </div>
    </div>
</body>

</html>
