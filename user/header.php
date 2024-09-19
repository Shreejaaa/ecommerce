<?php
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');
session_start();
if (!isset($_SESSION['username'])) {
  header("Location:../user/sign_in_up.php");
  exit();
}
$user_id = $_SESSION['customer_id'];
$sql1 = "SELECT USERNAME from USERS where user_id = $user_id";
$stmt = oci_parse($conn, $sql1);
oci_execute($stmt);
$row1 = oci_fetch_assoc($stmt);
$username = $row1['USERNAME'];
$_SESSION["username"] = $username;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="images/favicon.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css"
    integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css"
    integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="nav.css" />
  <link rel="stylesheet" href="footer.css">
</head>

<body>

  <nav class="navbar">
    <div class="header__logo">
      <a href="homepage.php">
        <img src="images/LOGO.png" class="navbar-logo" alt="logo" />
      </a>
    </div>
    <div class="header__container">
      <ul class="navbar-list">
        <li><a href="homepage.php">HOME</a></li>
        <li><a href="category_page.php">CATEGORIES</a></li>
        <li><a href="product_page.php">ALL PRODUCTS</a></li>
      </ul>
      <div class="box">
        <form action="" method="GET">
          <div class="search-box">
            <input type="text" name="search" placeholder="Search...">
            <button for="check" class="icon" type="submit" name="search_submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </form>
      </div>

      <div class="profile-dropdown">
        <div onclick="toggle()" class="profile-dropdown-btn">
          <div class="profile-img">
            <i class="fa-solid fa-circle"></i>
          </div>

          <span><?php echo $username ?></span><i class="fa-solid fa-angle-down"></i>
        </div>

        <ul class="profile-dropdown-list">
          <li class="profile-dropdown-list-item"><a href="customer.php"><i class="fa-regular fa-user"></i>Account</a>
          </li>
          <li class="profile-dropdown-list-item"><a href="wishlist.php"><i class="fa fa-heart-o"
                aria-hidden="true"></i>Wishlist</a></li>
          <li class="profile-dropdown-list-item"><a href="cart.php"><i class="fa fa-shopping-cart"></i>Cart</a></li>
          <hr class="m-0" />
          <li class="profile-dropdown-list-item"><a href="logout.php"><i
                class="fa-solid fa-arrow-right-from-bracket"></i>Log out</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <?php
  $sql = "SELECT * FROM PRODUCT WHERE 1=1";
  if (isset($_GET['search_submit'])) {
    $searchTerm = htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8');
    if (!empty($searchTerm)) {
      $sql .= " AND UPPER(NAMES) LIKE UPPER('%$searchTerm%')";
    }
  }

 

  ?>
</body>