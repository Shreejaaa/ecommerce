<?php
include('header.php');

$total_price = $_POST['total_price'];
$total_price =   $total_price - ($total_price * 0.10);
echo$total_price;
$item_name = $_POST['item_name'];
echo$item_name;
$item_number = $_POST['item_number'];
echo$item_number;
$quantity = $_POST['quantity'];
echo$quantity;
$cart_id = $_SESSION['cart_id'];

$paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
$paypalID = 'sb-baxfl30555449@business.example.com'; // Business Email

// Proceed with PayPal form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PayPal Payment</title>
    <script>
        function confirmPayment(event) {
            event.preventDefault(); // Prevent form submission
            var userConfirmed = confirm('Do you want to confirm your payment and proceed to PayPal?');
            if (userConfirmed) {
                event.target.submit(); // Submit the form if the user confirms
            } else {
                window.location.href = 'http://localhost/group18/user/homepage.php'; // Redirect to homepage if the user cancels
            }
        }
    </script>
</head>
<body>
    <h1>Checkout with PayPal</h1>
    <form action="<?php echo $paypalURL; ?>" method="post" onsubmit="confirmPayment(event)">
        <input type="hidden" name="business" value="<?php echo $paypalID; ?>">

        <!-- Specify a Buy Now button. -->
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="item_name" value="<?php echo $item_name; ?>">
        <input type="hidden" name="item_number" value="<?php echo $item_number; ?>">
        <input type="hidden" name="amount" value="<?php echo $total_price; ?>">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">

        <!-- Specify URLs -->
        <input type='hidden' name='cancel_return' value='http://localhost/group18/user/cart.php'>
        <input type='hidden' name='return' value='http://localhost/group18/user/success.php?cart_id=<?php echo $cart_id; ?>&total_price=<?php echo $total_price; ?>'>

        <!-- Display the payment button. -->
        <input type="image" name="submit" border="0"
        src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
        <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
    </form>


</body>
</html>
