<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
    integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
    integrity="sha512-PgQMlq+nqFLV4ylk1gwUOgm6CtIIXkKwaIHp/PAIWHzig/lKZSEGKEysh0TCVbHJXCLN7WetD8TFecIky75ZfQ=="
    crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="wishlist.css">
</head>
<body>
    
<?php
include('header.php');

$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

if (!$conn) {
    $e = oci_error();
    echo "<script>alert('Error connecting to database: " . htmlentities($e['message']) . "')</script>";
    exit();
}

if (!isset($_SESSION['username'])) {
    header("Location: ../user/sign_in_up.php");
    exit();
}

$user_id = $_SESSION['customer_id'];

// Get the user's wishlist ID
$query = "SELECT WISHLIST_ID FROM WISHLIST WHERE USER_ID = :user_id";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ':user_id', $user_id);

if (!oci_execute($stid)) {
    $e = oci_error($stid);
    echo "<script>alert('Error executing query: " . htmlentities($e['message']) . "')</script>";
    exit();
}

$row = oci_fetch_assoc($stid);
if (!$row) {
    echo "<script>alert('No wishlist found for user.')</script>";
    exit();
}

$wishlist_id = $row['WISHLIST_ID'];

// Get the products in the user's wishlist
$query = "
    SELECT WI.PRODUCT_ID, P.NAMES, P.PRICE, P.DESCRIPTIONS, P.IMAGE 
    FROM WISHLIST_ITEM WI 
    JOIN PRODUCT P ON WI.PRODUCT_ID = P.PRODUCT_ID 
    WHERE WI.WISHLIST_ID = :wishlist_id
";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ':wishlist_id', $wishlist_id);

if (!oci_execute($stid)) {
    $e = oci_error($stid);
    echo "<script>alert('Error executing query: " . htmlentities($e['message']) . "')</script>";
    exit();
}

?>


<section class="contact__section">
    <div class="container-lg">
        <h2>Wish List</h2>
        <button class="add-all-to-cart">ADD ALL TO CART</button>

        <?php
        while ($row = oci_fetch_assoc($stid)) {
            ?>
            <div class="wish-list-item">
                <div class="shop-info">
                    <!-- Assuming you want to display the same shop information for all products in the wishlist -->
                    <h2 class="shop-name">Shop Name</h2>
                    <hr class="shop-divider">
                </div>
                <div class="item-details-container">
                    <div class="product-info">
                        <!-- Left section for product image and details -->
                        <div class="product-image">
                            <img src="<?php echo $row['IMAGE']; ?>" alt="<?php echo $row['NAMES']; ?>">
                        </div>
                        <div class="product-details">
                            <h3 class="product-name"><?php echo $row['NAMES']; ?></h3>
                            <p class="product-description"><?php echo $row['DESCRIPTIONS']; ?></p>
                        </div>
                    </div>
                    <div class="price-container">
                        <!-- Middle section for product price -->
                        <span class="product-price">$<?php echo $row['PRICE']; ?></span>
                    </div>
                    <div class="actions-container">
                        <!-- Right section for actions -->
                        <a href="delete_wishlist.php?product_id=<?php echo $row['PRODUCT_ID']; ?>" class="delete-product"><i class="fa fa-trash-alt fa-2x"></i></a>

                      <a href="add_to_cart.php" button  class="add-to-cart"><i class="fa fa-cart-plus fa-2x"></i>Add to Cart</button> </a>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</section>
<script>
function deleteWishlistItem(product_id) {
    if (confirm("Are you sure you want to delete this item from your wishlist?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "delete_wishlist.php?product_id=" + product_id, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    document.getElementById("product-" + product_id).remove();
                    alert("Product removed from wishlist!");
                } else {
                    alert("Failed to remove product from wishlist: " + response.message);
                }
            }
        };
        xhr.send();
    }
}
</script>

<?php
    include("footer.php")
?>
