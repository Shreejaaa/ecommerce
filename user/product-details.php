<title>Product Detail</title>
<?php include 'header.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<?php
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id']; // Assuming you pass the product ID via GET parameter

    $query = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = :product_id";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":product_id", $product_id);
    oci_execute($stmt);

    // Fetch product details
    if ($row = oci_fetch_assoc($stmt)) {
        $productImage = htmlspecialchars($row['IMAGE']);
        $imagePath = "../trader/" . $productImage;
        $productName = htmlspecialchars($row['NAMES']);
        $productPrice = htmlspecialchars($row['PRICE']);
        $productDescription = htmlspecialchars($row['DESCRIPTIONS']);
        $productQuantity = htmlspecialchars($row['STOCK_NUMBER']);
        $productAllergy = htmlspecialchars($row['ALLERGY']);

    } else {
        echo 'Product not found.';
        exit;
    }
} else {
    echo 'No product ID provided.';
    exit;
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-7">
            <div class="product__detail-image">
                <div class="product__images">
                    <?php
                    echo "<img src='$imagePath' alt='Product'>";
                    echo "<img src='$imagePath' alt='Product'>";
                    echo "<img src='$imagePath' alt='Product'>";
                    echo "<img src='$imagePath' alt='Product'>";
                    ?>
                </div>
                <div class="product__image">
                    <img src="<?= $imagePath ?>" alt="Product">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="text-muted">
                Category
            </div>
            <h1 class="product__detail-title"><?= $productName ?></h1>
            <div class="product__price">
                $ <?= $productPrice ?> <span class="text-muted">/per item</span>
            </div>
            <div class="product__rating">
                <div class="">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                </div>
                <span>|</span>
                <div class="product__rating-subtitle">
                    <div class="">
                        Xx Ratings
                    </div>
                    <div class="text-muted">In Stock</div>
                </div>
            </div>
            <div class="product__description">
                <?= $productDescription ?>
            </div>
            <hr>
            <div class="product__quantity">
                <div class="product__quantity-title">
                    Quantity: <?= $productQuantity ?>
                </div>
                <div class="product__quantity-button">
                    <button type="button" class="product__quantity-plus">
                        <i class="fa fa-minus"></i>
                    </button>
                    <input type="text" class="product__quantity-number" name="" value="1">
                    <button type="button" class="product__quantity-minus">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="product__button">
                <div class="product__button-common">
                    <button type="button" name="button">Buy Now</button>
                </div>
                <div class="product__button-common">
                    <button type="button" name="button">
                        <i class="fa fa-shopping-cart"></i>
                        Add To Cart
                    </button>
                </div>
                <div class="product__button-common product__button-border">
                    <button type="button" name="button">
                        <i class="fa fa-heart"></i>
                        Save
                    </button>
                </div>
            </div>

        </div>

        <div class="col-md-12">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Description
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                        <?= $productDescription ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            ALLERGIES
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                        <?= $productAllergy?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            REVIEW
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <form class="col-md-8" id="reviewForm">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Rating (0 - 5)</label>
                                        <input type="number" name="rating" min="0" max="5" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" >Full Name</label>
                                        <input type="text" name="full_name" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Phone No.</label>
                                        <input type="text" name="phone" class="form-control" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Comments</label>
                                        <textarea name="comments" rows="6" class="form-control" required></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                        <button type="submit" class="shop-now-button">Submit</button>
                                    </div>
                                </div>
                            </form>
                            <div id="reviews" class="mt-4">
                                <?php
                                $query = "SELECT R.*, U.FIRST_NAME, U.LAST_NAME FROM REVIEW R JOIN USERS U ON R.USER_ID = U.USER_ID WHERE PRODUCT_ID = :product_id ORDER BY REVIEW_DATE DESC";
                                $stmt = oci_parse($conn, $query);
                                oci_bind_by_name($stmt, ":product_id", $product_id);
                                oci_execute($stmt);

                                while ($review = oci_fetch_assoc($stmt)) {
                                    $stars = str_repeat('<i class="fa fa-star"></i>', $review['RATING']) .
                                             str_repeat('<i class="fa fa-star-o"></i>', 5 - $review['RATING']);
                                    echo "<div class='card mb-3'>";
                                    echo "<div class='card-body'>";
                                    echo "<h5 class='card-title'>" . htmlspecialchars($review['FIRST_NAME']) . " " . htmlspecialchars($review['LAST_NAME']) . "</h5>";
                                    echo "<h6 class='card-subtitle mb-2 text-muted'>$stars</h6>";
                                    echo "<p class='card-text'>" . htmlspecialchars($review['COMMENTS']) . "</p>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                                ?>
                            </div>
                            <button id="loadMore" class="btn btn-primary mt-3">Load More Reviews</button>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseFour" aria-expanded="false"
                            aria-controls="flush-collapseFour">
                            Faq
                        </button>
                    </h2>
                    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="faq__item">
                                <h2>How do I place an order?</h2>
                                <p>Register and log in to browse products, add items to your basket, and select a collection slot
                                     (Wed, Thu, Fri: 10-13, 13-16, 16-19). Orders must be placed 24 hours in advance, with a
                                      maximum of 20 orders per slot.</p>
                            </div>
                            <div class="faq__item">
                                <h2>What payment options are available?</h2>
                                <p>We currently accept PayPal and are considering adding Stripe for more options.
                                     Select your preferred payment method at checkout for secure transactions.

</p>
                            </div>
                            <div class="faq__item">
                                <h2>What should I do if I have allergies or dietary restrictions?</h2>
                                <p>Each product listing includes detailed information about ingredients and allergy warnings.
                                     Please review these details carefully before making a purchase. If you have any specific 
                                     concerns or need additional information, feel free to contact the trader directly through
                                      our platform.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="">
                <h3 class="text-center mb-4 mt-5">RELATED PRODUCTS</h3>
                <div class="row mb-8">
                    <div class="col-md-3">
                        <div class="product">
                            <img src="images/butcher/sausage.jpg" alt="Product ">
                            <div class="details">
                                <p class="name">Product Name </p>
                                <p class="price">$10.00</p>
                                <div class="buttons">
                                    <button class="add-to-cart-button">Add to Cart</button>
                                    <button class="wishlist-button"><i class="far fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="product">
                            <img src="images/butcher/beef.jpg" alt="Product ">
                            <div class="details">
                                <p class="name">Product Name </p>
                                <p class="price">$10.00</p>
                                <div class="buttons">
                                    <button class="add-to-cart-button">Add to Cart</button>
                                    <button class="wishlist-button"><i class="far fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="product">
                            <img src="images/butcher/chicken.jpg" alt="Product ">
                            <div class="details">
                                <p class="name">Product Name </p>
                                <p class="price">$10.00</p>
                                <div class="buttons">
                                    <button class="add-to-cart-button">Add to Cart</button>
                                    <button class="wishlist-button"><i class="far fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="product">
                            <img src="images/butcher/pork.jpg" alt="Product ">
                            <div class="details">
                                <p class="name">Product Name </p>
                                <p class="price">$10.00</p>
                                <div class="buttons">
                                    <button class="add-to-cart-button">Add to Cart</button>
                                    <button class="wishlist-button"><i class="far fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

<script>
document.getElementById('reviewForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'submit_review.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Clear the form fields
                document.getElementById('reviewForm').reset();
                // Optionally, you can reload the reviews or show a success message
            } else {
                // Optionally, handle the error
                alert('Failed to submit review.');
            }
        }
    };
    xhr.send(formData);
});

document.getElementById('loadMore').addEventListener('click', function() {
    var product_id = <?= $product_id ?>;
    var reviewContainer = document.getElementById('reviews');

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'load_more_reviews.php?product_id=' + product_id, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            reviewContainer.innerHTML += xhr.responseText;
        }
    };
    xhr.send();
});
</script>

<?php include 'footer.php'; ?>