<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" integrity="sha512-PgQMlq+nqFLV4ylk1gwUOgm6CtIIXkKwaIHp/PAIWHzig/lKZSEGKEysh0TCVbHJXCLN7WetD8TFecIky75ZfQ==" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="cart.css">
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

// Get the user's cart ID
$query = "SELECT CART_ID FROM CART WHERE USER_ID = :user_id";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ':user_id', $user_id);

if (!oci_execute($stid)) {
    $e = oci_error($stid);
    echo "<script>alert('Error executing query: " . htmlentities($e['message']) . "')</script>";
    exit();
}

$row = oci_fetch_assoc($stid);
if (!$row) {
    echo "<script>alert('No cart found for user.')</script>";
    exit();
}

$cart_id = $row['CART_ID'];

// Get the products in the user's cart
$query = "
    SELECT CI.PRODUCT_ID, P.NAMES, P.PRICE, P.DESCRIPTIONS, P.IMAGE, CI.PRODUCT_QUANTITY 
    FROM CART_ITEM CI 
    JOIN PRODUCT P ON CI.PRODUCT_ID = P.PRODUCT_ID 
    WHERE CI.CART_ID = :cart_id
";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ':cart_id', $cart_id);

if (!oci_execute($stid)) {
    $e = oci_error($stid);
    echo "<script>alert('Error executing query: " . htmlentities($e['message']) . "')</script>";
    exit();
}
?>

<div class="contact__section mt-5">
    <h1 class="text-center">Cart Page</h1>
    <p class="text-center mb-4">Shipping charges and delivery slots are confirmed at checkout.</p>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-11 mx-auto">
                <div class="row g-5">
                    <div class="col-lg-8">
                        <h4 class="product_name">Shipping Details</h4>
                        <div class="main_cart p-3 mb-lg-0 mb-5 border rounded">
                            <?php
                            $total_price = 0;
                            while ($row = oci_fetch_assoc($stid)) {
                                $product_id = $row['PRODUCT_ID'];
                                $product_name = $row['NAMES'];
                                $product_price = $row['PRICE'];
                                $product_image = $row['IMAGE'];
                                $description = $row['DESCRIPTIONS'];
                                $product_quantity = $row['PRODUCT_QUANTITY'];
                                $item_total_price = $product_price * $product_quantity;
                                $total_price += $item_total_price;
                            ?>
                                <div class="card p-4 mb-3" id="product-<?php echo $product_id; ?>">
                                    <div class="row">
                                        <div class="col-md-4 col-11 mx-auto bg-light d-flex justify-content-center align-items-center rounded product_img">
                                            <img src="<?php echo $product_image; ?>" class="img-fluid" alt="cart img">
                                        </div>
                                        <div class="col-md-8 col-11 mx-auto pl-4 pr-0 mt-2">
                                            <div class="row">
                                                <div class="col-8 card-title">
                                                    <div class="mb-0 product_name"><?php echo $product_name; ?></div>
                                                    <p class="mb-1">Description: <?php echo $description; ?></p>
                                                </div>
                                                <div class="col-4 d-flex justify-content-end">
                                                    <div class="remove_wish">
                                                    <a href="#" onclick="deleteCartItem(<?php echo $product_id; ?>)"> <i class="fas fa-trash-alt"></i> </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-between align-items-center">
                                                    <div class="set_quantity d-flex justify-content-center">
                                                        <button class="page-link decrease" onclick="decreaseNumber('textbox<?php echo $product_id; ?>', 'itemval<?php echo $product_id; ?>', <?php echo $product_price; ?>)">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input type="number" name="" class="page-link count" value="<?php echo $product_quantity; ?>" id="textbox<?php echo $product_id; ?>" min="1" max="10" onchange="updateCartItemQuantity(<?php echo $product_id; ?>, this.value)">
                                                        <button class="page-link increase" onclick="increaseNumber('textbox<?php echo $product_id; ?>', 'itemval<?php echo $product_id; ?>', <?php echo $product_price; ?>)">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="price_money">
                                                        <h4>$<span id="itemval<?php echo $product_id; ?>"><?php echo $item_total_price; ?></span></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <hr />
                            <div class="text-right">
                                <h4>Total: $<span id="total_price"><?php echo $total_price; ?></span></h4>                            
                            </div>
                            <a href="checkout.php"><form action="checkout.php" method="POST">
                            <button type="submit" class="button">Proceed to Checkout</button>
                        </form></a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
oci_free_statement($stid);
oci_close($conn);
?>

<script>
function updateTotalPrice() {
    var total = 0;
    var itemTotals = document.querySelectorAll('.price_money h4 span');
    itemTotals.forEach(function(itemTotal) {
        total += parseFloat(itemTotal.textContent);
    });
    document.getElementById('total_price').textContent = total.toFixed(2);

    // Send the updated total price to the server
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_price.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
        }
    };
    xhr.send("total_price=" + total.toFixed(2));
}


function increaseNumber(textboxId, itemvalId, productPrice) {
    var textbox = document.getElementById(textboxId);
    var itemval = document.getElementById(itemvalId);
    var currentValue = parseInt(textbox.value);
    if (currentValue < 20) {
        textbox.value = currentValue + 1;
        var newQuantity = currentValue + 1;
        itemval.textContent = (newQuantity * productPrice).toFixed(2);
        updateTotalPrice();
        updateCartItemQuantity(textboxId.replace('textbox', ''), newQuantity);
    }
}

function decreaseNumber(textboxId, itemvalId, productPrice) {
    var textbox = document.getElementById(textboxId);
    var itemval = document.getElementById(itemvalId);
    var currentValue = parseInt(textbox.value);
    if (currentValue > 1) {
        textbox.value = currentValue - 1;
        var newQuantity = currentValue - 1;
        itemval.textContent = (newQuantity * productPrice).toFixed(2);
        updateTotalPrice();
        updateCartItemQuantity(textboxId.replace('textbox', ''), newQuantity);
    }
}

function updateCartItemQuantity(productId, quantity) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            updateTotalPrice();
        }
    };
    xhr.send("product_id=" + productId + "&quantity=" + quantity);
}

function deleteCartItem(product_id) {
    if (confirm("Are you sure you want to delete this item from your cart?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delet_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    document.getElementById("product-" + product_id).remove();
                    alert("Product removed from cart!");
                } else {
                    alert("Failed to remove product from cart: " + response.message);
                }
            }
        };
        xhr.send("product_id=" + product_id);
    }
}
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>

<? include('footer.php');?>
</body>
</html>
