<?php include ("header.php"); ?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
    integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
    integrity="sha512-PgQMlq+nqFLV4ylk1gwUOgm6CtIIXkKwaIHp/PAIWHzig/lKZSEGKEysh0TCVbHJXCLN7WetD8TFecIky75ZfQ=="
    crossorigin="anonymous" />
<link rel="stylesheet" type="text/css" href="cart.css">

<div class="contact__section mt-5">
    <h1 class="text-center">Checkout Page</h1>
    <p class="text-center mb-4" style="font-size: 13px">Shipping charges and delivery slots are confirmed at checkout.
    </p>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-11 mx-auto">
                <?php
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
                $query = "SELECT * FROM users WHERE user_id = :user_id";
                $row = oci_parse($conn, $query);

                // Assuming you have a user_id to fetch specific user data
                
                oci_bind_by_name($row, ':user_id', $user_id);

                oci_execute($row);
                $user = oci_fetch_assoc($row);

                oci_free_statement($row);
                oci_close($conn);
                ?>

                <!-- Orders and Summary Headers -->
                <div class="row g-5">
                    <!-- Embed fetched data into HTML -->
                    <div class="col-lg-8">
                        <h4 class="product_name mb-3">
                            <i class="fa-regular fa-circle-user"></i>
                            <?php echo htmlspecialchars($user['USERNAME']); ?>
                        </h4>
                        <div class="main_cart p-2 mb-lg-0 mb-5 border rounded">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div><strong>USERNAME</strong></div>
                                            <div><?php echo htmlspecialchars($user['USERNAME']); ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div><strong>EMAIL</strong></div>
                                            <div><?php echo htmlspecialchars($user['EMAIL']); ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div><strong>Mobile Phone</strong></div>
                                            <div><?php echo htmlspecialchars($user['PHONE']); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="product_name">Order Summary</h4>
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
                                        <div
                                            class="col-md-4 col-11 mx-auto bg-light d-flex justify-content-center align-items-center rounded product_img">
                                            <img src="<?php echo $product_image; ?>" class="img-fluid" alt="cart img">
                                        </div>
                                        <div class="col-md-8 col-11 mx-auto pl-4 pr-0 mt-2">
                                            <div class="row">
                                                <div class="col-8 card-title">
                                                    <div class="mb-0 product_name">
                                                        <?php echo $product_name; ?>
                                                    </div>
                                                    <p class="mb-1">Description:
                                                        <?php echo $description; ?>
                                                    </p>
                                                </div>
                                                <div class="col-4 d-flex justify-content-end">
                                                    <div class="set_quantity d-flex justify-content-center">
                                                        <input type="number" class="page-link count"
                                                            value="<?php echo $product_quantity; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-between align-items-center">
                                                    <div class="price_money">
                                                        <h4>$<span><?php echo $item_total_price; ?></span>
                                                        </h4>
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
                                <h4>Total: $<span><?php echo $total_price; ?></span></h4>
                            </div>
                            <form action="confirmation.php" method="POST">
                                <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                                <input type="hidden" name="item_name" value="Order">
                                <input type="hidden" name="item_number" value=".">
                                <input type="hidden" name="quantity" value=".">
                                <button type="submit" class="button">Place Order</button>
                            </form>
                        </div>
                    </div>

                    <!-- Summary section -->
                    <div class="col-lg-4">
                        <h4 class="product_name">Summary</h4>
                        <div class="right_side p-3 bg-white border rounded">
                            <div class="price_indiv d-flex justify-content-between">
                                <p>Items in the cart</p>
                                <p>$<span id="product_total_amt"><?php echo $total_price; ?></span>
                                </p>
                            </div>
                            <div class="price_indiv d-flex justify-content-between">
                                <p>Shipping Charge</p>
                                <p><span id="shipping_charge">Free Delivery</span></p>
                            </div>
                            <div class="price_indiv d-flex justify-content-between">
                                <p>Discount</p>
                                <p><span id="savings">10%</span></p>
                            </div>
                            <hr />
                            <div class="total-amt d-flex justify-content-between font-weight-bold">
                                <p>Total</p>
                                <p>$<span id="total_cart_amt">
                                        <?php
                                        $shipping_charge = 0; // Example shipping charge, you can adjust this based on your logic
                                        $discount_percentage = 0.10; // 10% discount
                                        $discount = $total_price * $discount_percentage; // Calculate the discount amount
                                        $final_amount = $total_price + $shipping_charge - $discount;
                                        echo number_format($final_amount, 2); // Format the final amount to 2 decimal places
                                        ?>
                                    </span></p>
                            </div>
                            <?php
                            $user_id = $_SESSION['customer_id'];
                            $sql = "INSERT INTO CART(USER_ID, TOTAL_PRICE) VALUES ($user_id , $final_amount)";
                            $qry = oci_parse($conn, $sql);
                            if (!$qry) {
                                echo "error in inserting data";
                            } else {
                                oci_execute($qry);
                            }
                            $_SESSION['cart_id'] = $cart_id;
                            ?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h2>Select Collection Slot</h2>
                                        <form action="collection_slot.php" method="POST" onsubmit="return selectCollectionSlot()">
                                            <div class="form-group" style="margin-top:10px; margin-bottom:10px;">
                                                <label for="collection-date">
                                                    Collection Date:
                                                </label>
                                                <input type="date" id="collection-date" name="date"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group" style="margin-top:10px;">
                                                <label for="collection-time">
                                                    Collection Time:
                                                </label>
                                                <select id="collection-time" class="form-control" name="time">
                                                    <option value="10:00">10:00 AM - 1:00 PM
                                                    </option>
                                                    <option value="1:00">1:00 PM - 4:00 PM
                                                    </option>
                                                    <option value="4:00">4:00 PM - 7:00 PM
                                                    </option>

                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary"
                                                style="padding: 5px; margin-top:10px; background-color:black;">
                                                Select Slot
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function isValidCollectionDate(dateString) {
                                    var date = new Date(dateString);
                                    var day = date.getUTCDay();
                                    // Check if the day is Wednesday (3), Thursday (4), or Friday (5)
                                    return day === 3 || day === 4 || day === 5;
                                }

                                function getNextAvailableDate(date) {
                                    var nextDate = new Date(date);
                                    nextDate.setDate(nextDate.getDate() + 1);
                                    while (!isValidCollectionDate(nextDate.toISOString().split('T')[0])) {
                                        nextDate.setDate(nextDate.getDate() + 1);
                                    }
                                    return nextDate;
                                }

                                function selectCollectionSlot() {
                                    var dateInput = document.getElementById('collection-date');
                                    var timeInput = document.getElementById('collection-time');
                                    var selectedDate = new Date(dateInput.value);
                                    var currentTime = new Date();
                                    console.log(dateInput, timeInput, selectedDate);

                                    if (selectedDate && timeInput.value) {
                                        // Check if the selected date is valid
                                        if (!isValidCollectionDate(selectedDate.toISOString().split('T')[0])) {
                                            alert('Please select a valid collection date (Wednesday, Thursday, or Friday).');
                                            return;
                                        }

                                        // Ensure the selected date is at least 24 hours in the future
                                        if ((selectedDate - currentTime) < (24 * 60 * 60 * 1000)) {
                                            selectedDate = getNextAvailableDate(currentTime);
                                            alert('Selected date is less than 24 hours from now. Collection slot moved to: ' + selectedDate.toISOString().split('T')[0]);
                                        }

                                        // Find the next valid date for order processing after 24 hours
                                        var orderProcessingDate = new Date(selectedDate);
                                        orderProcessingDate.setDate(orderProcessingDate.getDate() + 1);

                                        if (!isValidCollectionDate(orderProcessingDate.toISOString().split('T')[0])) {
                                            orderProcessingDate = getNextAvailableDate(orderProcessingDate);
                                        }

                                        alert('Collection slot selected: ' + selectedDate.toISOString().split('T')[0] + ' at ' + timeInput.value + '. Your order will be processed on: ' + orderProcessingDate.toISOString().split('T')[0]);
                                    } else {
                                        alert('Please select both date and time.');
                                    }
                                }

                            </script>

                        </div>

                        <!-- Paypal payment button -->
                        <div class="container">
                            <h4 class="product_name">Payment</h4>
                            <form action="confirmation.php" method="POST">
                                <div id="paypal-button-container"></div>
                                <script src="https://www.paypal.com/sdk/js?client-id=YOUR_PAYPAL_CLIENT_ID"></script>
                                <script>
                                    paypal.Buttons({
                                        createOrder: function (data, actions) {
                                            return actions.order.create({
                                                purchase_units: [{
                                                    amount: {
                                                        value: '<?php echo $final_amount; ?>' // Total amount
                                                    }
                                                }]
                                            });
                                        },
                                        onApprove: function (data, actions) {
                                            return actions.order.capture().then(function (details) {
                                                alert('Transaction completed by ' + details.payer.name.given_name);
                                                window.location.href = "confirmation.php";
                                            });
                                        }
                                    }).render('#paypal-button-container');
                                </script>
                            </form>
                        </div>
                    </div>
                    <!-- End summary section -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ("footer.php"); ?>