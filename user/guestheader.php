<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="nav.css" />
    <link rel="stylesheet" href="footer.css">
    <title>Nav bar</title>
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
              <li><a href="index.php">HOME</a></li>
              <li><a href="guestcategory.php">CATEGORIES</a></li>
              <li><a href="guestproduct.php">ALL PRODUCTS</a></li>
            </ul>
            <div class="box">
              <div class="search-box">
              <form action="" method="GET">
            <input type="text" name="search" placeholder="Search...">
            <button type="submit" name="search_submit"></button>
        </form>
                <label for="check" class="icon">
                  <i class="fas fa-search"></i>
                </label>
              </div>
            </div>
            <div class="profile-dropdown">
              <div  onclick="toggle()" class="profile-dropdown-btn">
                <div class="profile-img">
                  <i class="fa-solid fa-circle"></i>
                </div>

                <span>Guest</span><i class="fa-solid fa-angle-down"></i>
              </div>

              <ul class="profile-dropdown-list">
                  <li class="profile-dropdown-list-item">
                    <a href="#">
                      <i class="fa fa-shopping-cart"></i>
                      Cart
                    </a>
                  </li>

                  <hr />

                  <li class="profile-dropdown-list-item">
                    <a href="sign_in_up.php">
                      <i class="fa fa-sign-in"></i>
                      Log In
                    </a>
                  </li>
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

$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe'); 
?>