<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link rel="stylesheet" href="css/checkout.css">
</head>
<body>
    <div class="checkout-container">
        <h1 class="checkout-title">Checkout</h1>
        <div class="content-wrapper">
            <div class="left-side">
                <form action="submit_order.php" method="post" class="checkout-form">
                    <section class="payment-options">
                        <h2>Payment Options</h2>
                        <label>
                            <input type="radio" name="payment" value="paypal" required>
                            <img src="path/to/paypal-logo.png" alt="PayPal" class="paypal-logo">
                        </label>
                    </section>

                    <section class="delivery-options">
                        <h2>Delivery Options</h2>
                        <label>
                            <input type="radio" name="delivery" value="pickup" required> 🏬 Pickup
                        </label>
                    </section>

                    <section class="pickup-timeslot">
                        <h2>Pickup Timeslot</h2>
                        <label for="pickup-day">Day:</label>
                        <select id="pickup-day" name="pickup-day" required>
                            <option value="" disabled selected>Select a day</option>
                            <option value="wednesday">Wednesday</option>
                            <option value="thursday">Thursday</option>
                            <option value="friday">Friday</option>
                        </select>

                        <label for="pickup-time">Time:</label>
                        <select id="pickup-time" name="pickup-time" required>
                            <option value="" disabled selected>Select a time</option>
                            <option value="morning">Morning</option>
                            <option value="afternoon">Afternoon</option>
                            <option value="evening">Evening</option>
                        </select>
                    </section>

                    <button type="submit" class="submit-btn">Place Order</button>
                </form>
            </div>

            <aside class="order-summary">
                <h2>Order Summary</h2>
                <div class="order-items">
                    <p>Item 1: $10.00</p>
                    <p>Item 2: $15.00</p>
                </div>
                <p>Shipping Fee: $5.00</p>
                <p><strong>Total: $30.00</strong></p>
            </aside>
        </div>
    </div>
</body>
</html>

<?php
$paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
$paypalID = 'sb-o4oq4730724473_api1.business.example.com'; //Business Email

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <title>PayPal Standard Payment Gateway Integration by CodexWorld</title>
</head>
<body>

 </body>
 </html>
