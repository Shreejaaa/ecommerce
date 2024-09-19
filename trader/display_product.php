<?php
session_start();
if (!isset($_SESSION['tradername'])) {
    header("Location:../user/sign_in_up.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Product page</title>
<!-- <link href="CSS/products.css" rel="stylesheet" type="text/css"/> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<style>
     body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  display: flex;
}

.sidebar {
  width: 200px;
  background-color: #a5c9ed;
  padding-top: 10px;
  display: flex;
  flex-direction: column;
}

.sidebar a {
  padding: 20px 15px;
  text-decoration: none;
  font-size: 18px;
  color: white;
  border-bottom: 1px solid #444;
}

.sidebar a:hover {
  color: #f1f1f1;
  background-color: #575757;
}

.product-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  padding: 20px;
  flex-grow: 1; /* Allow the product container to grow to fill the remaining space */
}

.product {
  background-color: #f9f9f9;
  padding: 20px;
  margin: 10px;
  width: 300px;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.product img {
  width: 100%;
  height: 300px;
  object-fit: cover;
  border-radius: 5px;
  margin-bottom: 10px;
}

.product h3 {
  font-size: 1.2em;
  margin-bottom: 10px;
  text-align: center;
}

.product .price {
  color: #333;
  font-weight: bold;
  margin-bottom: 10px;
  text-align: center;
}

.product .buttons {
  display: flex;
  justify-content: space-between;
  margin-top: 10px;
}

.product .edit-button,
.product .delete-button {
  padding: 5px 20px;
  background-color: #333;
  color: #fff;
  text-decoration: none;
  border-radius: 3px;
}

.product .edit-button:hover,
.product .delete-button:hover {
  background-color: #555;
}

</style>
<div class="sidebar">
  <img src="images/LOGO.png" alt="Logo" width="150px" height="100px">

  <a href="#home" id="homeLink"><img src="images/HOME.png"alt="Home" width="30px" height="30px"> Home</a>
  <a href="#analytics"><img src="images/ANALYTICS.png"alt="Analytics"  width="30px" height="30px"> Analytics</a>
  <a href="#products"><img src="images/PRODUCT.png"alt="Analytics"  width="30px" height="30px"> Products</a>
  <a href="#orders"> <img src="images/ORDERS.png"alt="Home" width="30px" height="30px"> Orders</a>
  <a href="#shop"> <img src="images/SHOP.png"alt="Home" width="30px" height="30px"> Shop</a>
  <a href="#settings"> <img src="images/SETTING.png"alt="Home" width="30px" height="30px"> Settings</a>
  <a href="#log out"> <img src="images/log out.png" alt="Log out" width="30px" height="30px"> log out</a> 

</div>


    



</div>

<?php
// Establish the database connection
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

// Retrieve the shop IDs for the logged-in trader
$trader_id = $_SESSION["trader_id"];
$query = "SELECT SHOP_ID, SHOP_NAME FROM SHOP WHERE USER_ID = :trader_id";
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":trader_id", $trader_id);
oci_execute($stmt);

$shops = [];
while ($row = oci_fetch_assoc($stmt)) {
    $shops[] = $row;
}

// Check if a shop ID is selected, otherwise use the first shop ID
$selected_shop_id = isset($_GET['shop_id']) ? $_GET['shop_id'] : $shops[0]['SHOP_ID'];

// Query to fetch products for the specific shop
$sql = "SELECT * FROM PRODUCT WHERE SHOP_ID = :shop_id";
$qry = oci_parse($conn, $sql);
oci_bind_by_name($qry, ":shop_id", $selected_shop_id);
oci_execute($qry);

$products = [];
while ($row = oci_fetch_assoc($qry)) {
    $products[] = $row;
}

oci_close($conn);
?>

<div class="content">
    <h1>Products</h1>
    
    <form method="GET" action="display_product.php">
        <label for="shop">Select Shop:</label>
        <select id="shop" name="shop_id" onchange="this.form.submit()">
            <?php foreach ($shops as $shop): ?>
                <option value="<?= $shop['SHOP_ID'] ?>" <?= ($shop['SHOP_ID'] == $selected_shop_id) ? 'selected' : '' ?>><?= $shop['SHOP_NAME'] ?></option>
            <?php endforeach; ?>
        </select>
    </form>

    <div class="product-container">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product" data-name="<?php echo htmlspecialchars($product["NAMES"]); ?>">
                    <img src="<?php echo htmlspecialchars($product["IMAGE"]); ?>" alt="<?php echo htmlspecialchars($product["NAMES"]); ?>">
                    <h3><?php echo htmlspecialchars($product["NAMES"]); ?></h3>
                    <div class="price">$<?php echo htmlspecialchars($product["PRICE"]); ?></div>
                    <div class="buttons">
                        <a href="update_product.php?id=<?php echo htmlspecialchars($product["PRODUCT_ID"]); ?>" class="edit-button">Edit</a>
                        <a href="delete_product.php?id=<?php echo htmlspecialchars($product["PRODUCT_ID"]); ?>" class="delete-button">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found for the selected shop.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
