<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
</head>
<body>

<?php include 'header.php'; ?>

<?php
// Establish the database connection
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

// Retrieve the shop IDs for the logged-in trader
$trader_id = $_SESSION["trader_id"];
$query = "SELECT SHOP_ID, SHOP_NAME FROM SHOP WHERE USER_ID = :trader_id AND IS_VERIFIED = 1";
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":trader_id", $trader_id);
oci_execute($stmt);

$shops = [];
while ($row = oci_fetch_assoc($stmt)) {
    $shops[] = $row;
}

oci_free_statement($stmt);

// Check if a shop ID is selected, otherwise use the first shop ID if available
$selected_shop_id = isset($_GET['shop_id']) ? $_GET['shop_id'] : (isset($shops[0]['SHOP_ID']) ? $shops[0]['SHOP_ID'] : null);

$products = [];
if ($selected_shop_id) {
    // Query to fetch products for the specific shop
    $sql = "SELECT * FROM PRODUCT WHERE SHOP_ID = :shop_id";
    $qry = oci_parse($conn, $sql);
    oci_bind_by_name($qry, ":shop_id", $selected_shop_id);
    oci_execute($qry);

    while ($row = oci_fetch_assoc($qry)) {
        $products[] = $row;
    }

    oci_free_statement($qry);
}

oci_close($conn);
?>

<div class="content">
    <h1>Products</h1>
    
    <form method="GET" action="products.php">
        <label for="shop">Select Shop:</label>
        <select style="margin-left:200px !important;" id="shop" name="shop_id" onchange="this.form.submit()">
            <?php if (!empty($shops)): ?>
                <?php foreach ($shops as $shop): ?>
                    <option value="<?= $shop['SHOP_ID'] ?>" <?= ($shop['SHOP_ID'] == $selected_shop_id) ? 'selected' : '' ?>><?= htmlspecialchars($shop['SHOP_NAME']) ?></option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">No verified shops available</option>
            <?php endif; ?>
        </select>
    </form>

    <div class="main__content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Product List
                        </div>
                        <div class="">
                            <a href="product-create.php" class="btn btn-secondary" name="button">Add Product</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Product Description</th>
                                    <th>Price</th>
                                    <th width="160px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($products)): ?>
                                    <?php foreach ($products as $index => $product): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <div class="product__container">
                                                    <div class="product__image">
                                                        <img src="<?= htmlspecialchars($product["IMAGE"]) ?>" alt="">
                                                    </div>
                                                    <div class="">
                                                        <?= htmlspecialchars($product["NAMES"]) ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($product["DESCRIPTIONS"]) ?></td>
                                            <td>$<?= htmlspecialchars($product["PRICE"]) ?></td>
                                            <td>
                                                <a href="product-edit.php?id=<?= htmlspecialchars($product["PRODUCT_ID"]) ?>" class="btn btn-primary">
                                                    <i class="fa-solid fa-pencil"></i>
                                                </a>
                                                <a href="product-show.php?id=<?= htmlspecialchars($product["PRODUCT_ID"]) ?>" class="btn btn-success">
                                                    <i class="fa-regular fa-eye"></i>
                                                </a>
                                                <a href="delete_product.php?id=<?= htmlspecialchars($product["PRODUCT_ID"]) ?>" class="btn btn-danger">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">No products found for the selected shop.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>
