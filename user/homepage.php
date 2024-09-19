
<title>Home page</title>
<link href="homepage.css" rel="stylesheet" type="text/css"/>

<?php
    include("header.php")
?>
    <div class="slider__container">
        <div class="container-lg">
            <p class="paragraph">
            At Sub Mart, we believe in delivering the freshest, highest quality organic
             produce. Our wide selection of fruits and vegetables
              is carefully curated to ensure you get the best nature has to offer. 
              Shop with us today and enjoy the convenience and benefits of eating healthy.
            </p>
            <a href="product_page.php" class="shop-now-button">Shop Now</a>
        </div>
    </div>

<section class="favourite__section">
    <div class="container-lg">
        <h2 class="favourite__section-title mb-4">Shop by Category</h2>
        <div class=" product-slider">
             <a href="butchers.php" class="product">
                 <img src="images/butcher.jpg" alt="Product">
                 <div class="name">BUTCHERS </div>
             </a>

             <a href="greengrocer.php" class="product">
                 <img src="images/greengrocer.jpg" alt="Product">
                 <div class="name">
                    GREENGROCER
                 </div>
             </a>

             <a href="fishmonger.php" class="product">
                 <img src="images/fishmonger.jpg" alt="Product">
                 <div class="name">
                     FISHMONGER
                 </div>
             </a>

             <a href="bakery.php" class="product">
                 <img src="images/bakery.jpg" alt="Product">
                 <div class="name">
                     BAKERY
                 </div>
             </a>

             <a href="delicatessen.php" class="product">
                 <img src="images/delicatessen.jpg" alt="Product">
                 <div class="name">
                     DELICATESSEN
                 </div>
             </a>

         </div>
    </div>
</section>

<section class="favourite__section">
    <div class="container-lg">
        <h2 class="favourite__section-title">See What's New</h2>
        <div class="favourite__section-container justify-content-between">
            <div class="product2">
                <a href = "bakery.php" >     
                <img src="images/bakery/cheesecake.jpg" alt="Product ">
                <div class="details">
                    <p class="name">Cheese cake </p>
                    <p class="price">$10.00</p>
                    <div class="buttons">
                        <button class="add-to-cart-button">Add to Cart</button>
                            <button class="wishlist-button"><i class="far fa-heart"></i></button>
                       
                    </div>
                </div>
                </a>
            </div>
           

            <div class="product2">
            <a href = "butchers.php" >   
                <img src="images/butcher/chicken.jpg" alt="Product ">
                <div class="details">
                    <p class="name">Chicken </p>
                    <p class="price">$14.00</p>
                    <div class="buttons">
                        <button class="add-to-cart-button">Add to Cart</button>
                            <button class="wishlist-button"><i class="far fa-heart"></i></button>
                    </div>
                </div>
                    </a>
            </div>

            <div class="product2">
                <a href = "fishmonger.php">
                <img src="images/fishmonger/lobster.jpg" alt="Product ">
                <div class="details">
                    <p class="name">Lobster </p>
                    <p class="price">$25.00</p>
                    <div class="buttons">
                        <button class="add-to-cart-button">Add to Cart</button>
                            <button class="wishlist-button"><i class="far fa-heart"></i></button>
                    </div>
                </div>
                </a>
            </div>

            <div class="product2">
            <a href = "delicatessen.php">
                <img src="images/delicatessen/melon.jpg" alt="Product ">
                <div class="details">
                    <p class="name">Melon </p>
                    <p class="price">$9.00</p>
                    <div class="buttons">
                        <button class="add-to-cart-button">Add to Cart</button>
                            <button class="wishlist-button"><i class="far fa-heart"></i></button>
                    </div>
                </div>
                </a>
            </div>

        </div>

    </div>
</section>
<?php

$sql = "SELECT * FROM PRODUCT WHERE 1=1";
$qry = oci_parse($conn, $sql);
oci_execute($qry);
?>

<section class="favourite__section">
    <div class="container-lg">
        <h2 class="favourite__section-title">Fam Favorites!</h2>
        <div class="favourite__section-container">
            <?php
            echo "<div class='product-container mb-8'>";
            $count = 0;
            while ($row = oci_fetch_assoc($qry)) {
                if ($count >= 8) {
                    break;
                }
                echo "<div class='product3'>";
                echo "<a href='product-details.php?product_id=" . $row['PRODUCT_ID'] . "'>";
                $image = "../trader/" . htmlspecialchars($row['IMAGE']);
                echo "<img src='$image' alt='Product'></a>";
                echo "<div class='details'>";
                echo "<p class='name'>" . htmlspecialchars($row['NAMES']) . "</p>";
                echo "<p class='price'>$" . htmlspecialchars($row['PRICE']) . "</p>";
                echo "<div class='rating'>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                      </div>";
                echo "</div>";
                echo "</div>";
                $count++;
            }
            echo "</div>";
            ?>
        </div>
    </div>
</section>


<?php
include("footer.php")
?>
