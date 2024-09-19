<?php include 'header.php';

$conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');
?>
<title>Create New Product</title>

<div class="main__content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Create New Product
                    </div>
                    <div class="">
                        <a href="products.php" class="btn btn-secondary" name="button">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    $trader_id = $_SESSION["trader_id"];
                    $query = "SELECT SHOP_ID, SHOP_NAME, IS_VERIFIED FROM SHOP WHERE USER_ID = :trader_id";
                    $stmt = oci_parse($conn, $query);
                    oci_bind_by_name($stmt, ":trader_id", $trader_id);
                    oci_execute($stmt);

                    $shop_count = 0;
                    while ($row = oci_fetch_assoc($stmt)) {
                        if ($row['IS_VERIFIED'] != 1) {
                            echo "<h3>Your shop is not verified. You cannot add products until your shop is verified.</h3>";
                            break;
                        }
                        $shop_count++;
                    }

                    if ($shop_count > 0) {
                        echo "<form action='add_product.php' method='POST' enctype='multipart/form-data'>";
                        echo "<div class='row g-3'>";
                        
                        echo "<div class='col-md-6'>";
                        echo "<label class='form-label'>Product Name <span class='text-danger'>*</span></label>";
                        echo "<input type='text' name='name' class='form-control'>";
                        echo "</div>";
                        
                        // Shop ID (Select Shop)
                        echo "<div class='col-md-6'>";
                        echo "<label for='shop_id'><br>Select Shop:</label><br>";
                        echo "<select id='shop_id' name='shop_id'>";
                       
                        oci_execute($stmt);
                        while ($row = oci_fetch_assoc($stmt)) {
                            if ($row['IS_VERIFIED'] == 1) {
                                echo "<option value='".$row['SHOP_ID']."'>".$row['SHOP_NAME']."</option>";
                            }
                        }
                        echo "</select>";
                        echo "</div>";
                        
                        $qry = "SELECT PROD_CATEGORY_ID, NAMES FROM PRODUCT_CATEGORY";
                        $stmts = oci_parse($conn, $qry);
                        oci_execute($stmts);

                        echo "<div class='col-md-6'>";
                        echo "<label for='prod_category_id'><br>Select Product Category:</label><br>";
                        echo "<select id='prod_category_id' name='prod_category_id'>";
                        while ($rows = oci_fetch_assoc($stmts)) {
                            echo "<option value='".$rows['PROD_CATEGORY_ID']."'>".$rows['NAMES']."</option>";
                        }
                        echo "</select>";
                        echo "</div>";

                        // Price
                        echo "<div class='col-md-6'>";
                        echo "<label class='form-label'>Price <span class='text-danger'>*</span></label>";
                        echo "<input type='number' step='0.01' name='price' class='form-control'>";
                        echo "</div>";
                        
                        // Description
                        echo "<div class='col-md-6'>";
                        echo "<label class='form-label'>Description <span class='text-danger'>*</span></label>";
                        echo "<textarea name='description' class='form-control'></textarea>";
                        echo "</div>";

                         
                        // allergy
                        echo "<div class='col-md-6'>";
                        echo "<label class='form-label'>Allegry Information <span class='text-danger'>*</span></label>";
                        echo "<textarea name='allergy' class='form-control'></textarea>";
                        echo "</div>";
                        
                        // Quantity
                        echo "<div class='col-md-6'>";
                        echo "<label class='form-label'>Quantity <span class='text-danger'>*</span></label>";
                        echo "<input type='number' name='quantity' class='form-control'>";
                        echo "</div>";
                        
                        // Minimum Order
                        echo "<div class='col-md-6'>";
                        echo "<label class='form-label'>Minimum Order <span class='text-danger'>*</span></label>";
                        echo "<input type='number' name='minorder' class='form-control'>";
                        echo "</div>";
                        
                        // Maximum Order
                        echo "<div class='col-md-6'>";
                        echo "<label class='form-label'>Maximum Order <span class='text-danger'>*</span></label>";
                        echo "<input type='number' name='maxorder' class='form-control'>";
                        echo "</div>";
                        
                        // Upload Image
                        echo "<div class='col-md-6'>";
                        echo "<label class='form-label'>Upload Image <span class='text-danger'>*</span></label>";
                        echo "<input type='file' name='image' class='form-control'>";
                        echo "</div>";
                        
                        // Stock
                        echo "<div class='col-md-6'>";
                        echo "<label class='form-label'>Stock <span class='text-danger'>*</span></label>";
                        echo "<input type='number' name='stock' class='form-control'>";
                        echo "</div>";
                        
                        // Weight
                        echo "<div class='col-md-6'>";
                        echo "<label class='form-label'>Weight (kg) <span class='text-danger'>*</span></label>";
                        echo "<input type='number' step='0.01' name='weight' class='form-control'>";
                        echo "</div>";
                        
                        // Manufacture Date
                        echo "<div class='col-md-6'>";
                        echo "<label class='form-label'>Manufacture Date <span class='text-danger'>*</span></label>";
                        echo "<input type='date' name='manufacture' class='form-control'>";
                        echo "</div>";
                        
                        // Expiry Date
                        echo "<div class='col-md-6'>";
                        echo "<label class='form-label'>Expiry Date <span class='text-danger'>*</span></label>";
                        echo "<input type='date' name='expiry' class='form-control'>";
                        echo "</div>";
                        
                        // Submit Button
                        echo "<div class='col-md-12'>";
                        echo "<button type='submit' class='btn btn-success' name='add'>Submit</button>";
                        echo "</div>";
                        
                        echo "</div>";
                        echo "</form>";
                    } else {
                        if ($shop_count == 0) {
                            echo "<h3>No shops available to add products.</h3>";
                        }
                    }

                    // Free the statement and close the connection
                    oci_free_statement($stmt);
                    oci_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
