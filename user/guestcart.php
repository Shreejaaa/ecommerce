<title>Cart List</title>

<?php
    include("guestheader.php")
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
    integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
    integrity="sha512-PgQMlq+nqFLV4ylk1gwUOgm6CtIIXkKwaIHp/PAIWHzig/lKZSEGKEysh0TCVbHJXCLN7WetD8TFecIky75ZfQ=="
    crossorigin="anonymous" />
<link rel="stylesheet" type="text/css" href="cart.css">

<div class="contact__section mt-5">
    <h1 class="text-center">Cart</h1>
    <p class="text-center mb-4">Shipping charges and delivery slots are confirmed at checkout.</p>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-11 mx-auto">

                <!-- Orders and Summary Headers -->
                <div class="row g-5">
                    <!-- Your Orders heading -->
                    <div class="col-lg-8">
                        <h4 class=" product_name">Your Orders</h4>
                        <div class="main_cart p-3 mb-lg-0 mb-5 border rounded">
                            <div class="card p-4">
                                <div class="row">

                                    <!-- cart images div -->
                                    <div class="col-md-4 col-11 mx-auto bg-light d-flex justify-content-center align-items-center rounded product_img">
                                        <img src="images/CAULIFLOWER.jpg" class="img-fluid" alt="cart img">
                                    </div>


                                    <!-- Adjusted cart product details to match wireframe layout -->
                                    <div class="col-md-8 col-11 mx-auto pl-4 pr-0 mt-2">
                                        <div class="row">

                                            <!-- product name and description -->
                                            <div class="col-8 card-title">
                                                <div class="mb-0 product_name">Product Name</div>
                                                <p class="mb-1">Description: xxx</p>
                                                <p class="mb-1">Color: xxx</p>
                                                <p class="mb-2">Size: xxx</p>
                                            </div>

                                            <!-- Positions for delete icon and add/subtract items -->
                                            <div class="col-4 d-flex justify-content-end">
                                                <div class="remove_wish">
                                                    <i class="fas fa-trash-alt"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-between align-items-center">

                                                <!-- Add/Subtract items -->
                                                <div class="set_quantity d-flex justify-content-center">
                                                    <button class="page-link decrease" onclick="decreaseNumber('textbox1','itemval1')">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="text" name="" class="page-link count" value="0" id="textbox1">
                                                    <button class="page-link increase" onclick="increaseNumber('textbox1','itemval1')">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>

                                                <!-- Price -->
                                                <div class="price_money">
                                                    <h4>$<span id="itemval1">X.XX </span></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr />

                            <div class="card p-4">
                                <div class="row">

                                    <!-- cart images div -->
                                    <div class="col-md-4 col-11 mx-auto bg-light d-flex justify-content-center align-items-center rounded product_img">
                                        <img src="images/CAULIFLOWER.jpg" class="img-fluid" alt="cart img">
                                    </div>


                                    <!-- Adjusted cart product details to match wireframe layout -->
                                    <div class="col-md-8 col-11 mx-auto pl-4 pr-0 mt-2">
                                        <div class="row">

                                            <!-- product name and description -->
                                            <div class="col-8 card-title">
                                                <div class="mb-0 product_name">Product Name</div>
                                                <p class="mb-1">Description: xxx</p>
                                                <p class="mb-1">Color: xxx</p>
                                                <p class="mb-2">Size: xxx</p>
                                            </div>

                                            <!-- Positions for delete icon and add/subtract items -->
                                            <div class="col-4 d-flex justify-content-end">
                                                <div class="remove_wish">
                                                    <i class="fas fa-trash-alt"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-between align-items-center">

                                                <!-- Add/Subtract items -->
                                                <div class="set_quantity d-flex justify-content-center">
                                                    <button class="page-link decrease" onclick="decreaseNumber('textbox1','itemval1')">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="text" name="" class="page-link count" value="0" id="textbox1">
                                                    <button class="page-link increase" onclick="increaseNumber('textbox1','itemval1')">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>

                                                <!-- Price -->
                                                <div class="price_money">
                                                    <h4>$<span id="itemval1">X.XX </span></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Summary heading -->
                    <div class="col-lg-4">
                        <h4 class="product_name">Summary</h4>

                        <div class=" ">
                            <div class="right_side p-3 bg-white border rounded">
                                <div class="price_indiv d-flex justify-content-between">
                                    <p>Items in the cart</p>
                                    <p>$<span id="product_total_amt">XXX</span></p>
                                </div>
                                <div class="price_indiv d-flex justify-content-between">
                                    <p>Shipping Charge</p>
                                    <p>$<span id="shipping_charge">XX</span></p>
                                </div>
                                <hr />
                                <div class="total-amt d-flex justify-content-between font-weight-bold">
                                    <p>Total</p>
                                    <p>$<span id="total_cart_amt">XXXX.XX</span></p>
                                </div>
                                <div class="button-container">
                                    <button class="button">PROCEED TO CHECKOUT</button>
                                </div>
                            </div>

                            <!-- discount code part -->
                            <div class="discount_code mt-3 border rounded">
                                <div class="card">
                                    <div class="card-body">
                                        <a class="d-flex justify-content-between" data-toggle="collapse"
                                            href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                            DISCOUNT CODE / VOUCHER CODE
                                            <span><i class="fas fa-chevron-down pt-1"></i></span>
                                        </a>
                                        <div class="collapse" id="collapseExample">
                                            <div class="mt-3">
                                                <input type="text" name="" id="discount_code1"
                                                    class="form-control font-weight-bold"
                                                    placeholder="Enter the discount code">
                                            </div>
                                            <button class="btn btn-primary btn-sm mt-3"
                                                onclick="discount_code()">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/"
        crossorigin="anonymous"></script>

    <script src="cart.js"></script>

<?php
    include("footer.php")
?>
