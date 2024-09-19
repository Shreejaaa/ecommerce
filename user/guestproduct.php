<!DOCTYPE html>
<html>
<head>
    <title>Product Page</title>
    <link href="productpage.css" rel="stylesheet" type="text/css" />
</head>
<body>
    
<?php include("guestheader.php"); ?>

<div class="slider__container banner__height"></div>
<div class="rectangle">
    <div class="search-bar">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search...">
            <button type="submit" name="search_submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="dropdowns">
        <form action="" method="GET">
            <div class="dropdown">
                <label for="price">Price</label>
                <select name="price">
                    <option value="">Select</option>
                    <option value="high_to_low">High to Low</option>
                    <option value="low_to_high">Low to High</option>
                </select>
                <button type="submit" name="price_sort">Sort</button>
            </div>
            </form>
            <form action="" method="GET">
                <div class="dropdown">
                    <label for="sort">Sort by</label>
                    <select name="sort">
                        <option value="">Select</option>
                        <option value="name_asc">Name A-Z</option>
                        <option value="name_desc">Name Z-A</option>
                       
                    </select>
                    <button type="submit" name="name_sort">Sort</button>
                </div>
            </form>
        </div>
    </div>

<?php
$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');
if (!$conn) {
    $e = oci_error();
    echo htmlentities($e['message']);
    exit;
}

$sql = "SELECT * FROM PRODUCT WHERE 1=1";

if (isset($_GET['search_submit'])) {
    $searchTerm = htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8');
    if (!empty($searchTerm)) {
        $sql .= " AND UPPER(NAMES) LIKE UPPER('%$searchTerm%')";
    }
}


if (isset($_GET['price_sort'])) {
    $priceOrder = $_GET['price'];
    if ($priceOrder == 'high_to_low') {
        $sql .= " ORDER BY PRICE DESC";
    } elseif ($priceOrder == 'low_to_high') {
        $sql .= " ORDER BY PRICE ASC";
    }
}

if (isset($_GET['name_sort'])) {
    $sortBy = $_GET['sort'];
    if ($sortBy == 'name_asc') {
        $sql .= " ORDER BY NAMES ASC";
    } elseif ($sortBy == 'name_desc') {
        $sql .= " ORDER BY NAMES DESC";
    } elseif ($sortBy == 'ratings') {
        $sql .= " ORDER BY RATINGS DESC";
    }
}

$qry = oci_parse($conn, $sql);
if (!$qry) {
    $e = oci_error($conn);
    echo htmlentities($e['message']);
    exit;
}

$r = oci_execute($qry);
if (!$r) {
    $e = oci_error($qry);
    echo htmlentities($e['message']);
    exit;
}
echo "<div class='product-container mb-8'>";
while ($row = oci_fetch_assoc($qry)) {
    echo "<div class='product'>";
    echo "<a href='product-details.php?product_id=" . $row['PRODUCT_ID'] . "'>";
    $image = "../trader/" . htmlspecialchars($row['IMAGE']);
    echo "<img src='$image' alt='Product'></a>";
    echo "<div class='details'";
    echo "<p class='name'>" . htmlspecialchars($row['NAMES']) . "</p>";
    echo "<p class='price'>$" . htmlspecialchars($row['PRICE']) . "</p>";
    echo "<form method='post' action='guest.php'>";
    echo "<div class='buttons'>";
    echo "<input type='hidden' name='product_id' value='" . $row['PRODUCT_ID'] . "'>";
    echo "<input type='hidden' name='product_name' value='" . htmlspecialchars($row['NAMES']) . "'>";
    echo "<input type='hidden' name='product_price' value='" . htmlspecialchars($row['PRICE']) . "'>";
    echo "<input type='hidden' name='product_image' value='" . htmlspecialchars($row['IMAGE']) . "'>";
    echo "<button type='submit' name='add_to_cart' class='add-to-cart-button';'>Add to Cart</button>";
    echo "</form>";
    echo "<form method='post' action='guest.php'>";
    echo "<input type='hidden' name='product_id' value='" . $row['PRODUCT_ID'] . "'>";
    echo "<input type='hidden' name='product_name' value='" . htmlspecialchars($row['NAMES']) . "'>";
    echo "<input type='hidden' name='product_price' value='" . htmlspecialchars($row['PRICE']) . "'>";
    echo "<input type='hidden' name='product_image' value='" . htmlspecialchars($row['IMAGE']) . "'>";
    echo "<button type='submit' name='add_to_wishlist' class='wishlist-button'><i class='far fa-heart'></i></button>";
    echo "</form>";

    echo "</div>";
    echo "</div>";
    echo "</div>";
}

echo "</div>";


echo "</div>";


oci_free_statement($qry);
oci_close($conn);
?>

<?php include("footer.php"); ?>
</body>
</html>
