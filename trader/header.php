<?php
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');
session_start();
if (!isset($_SESSION['tradername'])) {
    header("Location:../user/sign_in_up.php");
    exit();
}
$user_id = $_SESSION['trader_id'];
$sql1 = "SELECT USERNAME from USERS where user_id = $user_id";
$stmt = oci_parse($conn, $sql1);
oci_execute($stmt);
$row1 = oci_fetch_assoc($stmt);
$username = $row1['USERNAME'];
$_SESSION["traderrname"] = $username;
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="sidebar">
            <div class="sidebar__image">
                <img src="images/LOGO.png" alt="Logo" width="150px">
            </div>


          <a href="home.php" id="homeLink" class="mt-3">
              <img src="images/HOME.png"alt="Home" width="30px" height="30px"> Home
          </a>
          <a href="analytics.php"><img src="images/ANALYTICS.png"alt="Analytics"  width="30px" height="30px"> Analytics</a>
          <a href="products.php"><img src="images/PRODUCT.png"alt="Analytics"  width="30px" height="30px"> Products</a>
          <a href="orders.php"> <img src="images/ORDERS.png"alt="Home" width="30px" height="30px"> Orders</a>
          <a href="shop-show.php"> <img src="images/SHOP.png"alt="Home" width="30px" height="30px"> Shop</a>
          <a href="settings.php"> <img src="images/SETTING.png"alt="Home" width="30px" height="30px"> Settings</a>
          <a href="../user/sign_in_up.php"> <img src="images/log out.png" alt="Log out" width="30px" height="30px"> log out</a>

        </div>

            <div class="header__container">
                <div class="name">
                  Welcome Back, <?php echo $username  ?>
                  <div class="description">
                    Here are today's stats from your Online Store!
                  </div>
                </div>
                <div class="search">
                  <form action="/search" method="GET">
                      <input type="text" name="q" placeholder="Search">
                      <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="header__user">
                    <div class="user-info">
                      <img src="images/USER.png" alt="User" width="40px" height="40px">
                     </div>
                     <div class="header__user-trader">
                         <div class="trader-name"><?php echo $username  ?> </div>
                         <div class="trader-role">Trade</div>
                     </div>
                     <div class="header__user-icon">
                         <i class="fa-solid fa-chevron-down"></i>
                     </div>
                </div>
            </div>
