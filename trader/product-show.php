<title>Product details</title>

<?php include 'header.php'; 


$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

// Retrieve the product details based on the product ID
$product_id = isset($_GET['id']) ? $_GET['id'] : '';
$query = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = :product_id";
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":product_id", $product_id);
oci_execute($stmt);

$product = oci_fetch_assoc($stmt);

oci_close($conn);
?>

<div class="main__content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Product details
                    </div>
                    <div class="">
                        <a href="products.php" class="btn btn-secondary" name="button">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <img src="<?= htmlspecialchars($product['IMAGE']) ?>" alt="">
                            </li>
                            <li class="list-group-item">
                                Product Name: <span class="ps-2"><?= htmlspecialchars($product['NAMES']) ?></span>
                            </li>
                            <li class="list-group-item">
                                Price: <span class="ps-2">$<?= htmlspecialchars($product['PRICE']) ?></span>
                            </li>
                            <li class="list-group-item">
                                Stock: <span class="ps-2"><?= htmlspecialchars($product['STOCK_NUMBER']) ?></span>
                            </li>
                            
                            <li class="list-group-item">
                                Published Date: <span class="ps-2"><?= htmlspecialchars($product['MANUFACTURING_DATE']) ?></span>
                            </li>
                            <li class="list-group-item">
                                Expiry Date: <span class="ps-2"><?= htmlspecialchars($product['EXPIRY_DATE']) ?></span>
                            </li>
                            <li class="list-group-item">
                                Description: <span class="ps-2"><?= htmlspecialchars($product['DESCRIPTIONS']) ?></span>
                            </li>
                            <li class="list-group-item">
                                Quantity: <span class="ps-2"><?= htmlspecialchars($product['QUANTITY']) ?></span>
                            </li>
                            <li class="list-group-item">
                                Minimum Order: <span class="ps-2"><?= htmlspecialchars($product['MIN_ORDER']) ?></span>
                            </li>
                            <li class="list-group-item">
                                Maximum Order: <span class="ps-2"><?= htmlspecialchars($product['MAX_ORDER']) ?></span>
                            </li>
                            <li class="list-group-item">
                                Weight: <span class="ps-2"><?= htmlspecialchars($product['WEIGHT']) ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>