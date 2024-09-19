<?php
$paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
$paypalID = 'sb-baxfl30555449@business.example.com'; //Business Email

// Retrieve order details from the form submission
$item_name = "Sample Order";
$item_number = 1;
$amount = 30.00; // Assuming a fixed amount for simplicity
$currency_code = 'USD';
$quantity = 1; // Adjust as needed

// Proceed with PayPal form
?>
<body>
    <form action="<?php echo $paypal_url; ?>" method="post" id="paypalForm">
        <input type="hidden" name="business" value="<?php echo $merchant_email; ?>">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="item_name" value="<?php echo $item_name; ?>">
        <input type="hidden" name="item_number" value="<?php echo $item_number; ?>">
        <input type="hidden" name="amount" value="<?php echo $total_price; ?>">
        <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="return" value="<?php echo $return_url; ?>">
        <input type="hidden" name="cancel_return" value="<?php echo $cancel_url; ?>">
        <input type="hidden" name="notify_url" value="<?php echo $notify_url; ?>">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="no_note" value="1">
        <input type="hidden" name="custom" value="<?php echo $_SESSION['customer_id']; ?>">
    </form>

    <script>
        document.getElementById('paypalForm').submit();
    </script>

        <!-- Specify URLs -->
        <input type='hidden' name='cancel_return' value='http://localhost//group-18/user/order.php'>
        <input type='hidden' name='return' value='http://localhost/group-18/user/success.php'>

        <!-- Display the payment button. -->
        <input type="image" name="submit" border="0"
        src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
        <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
    </form>
</body>
</html>
