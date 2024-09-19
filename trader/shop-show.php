<title>Shop details</title>


<?php include 'header.php'; ?>

<div class="main__content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Shop details
                        </div>
                        <div class="">
                            <a href="shop-create.php" class="btn btn-secondary" name="button">Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        $conn = oci_connect('Suburbanmart', 'Shreeja#123', '//localhost/xe');

                        if (!isset($_SESSION['tradername'])) {
                            header("Location:../user/sign_in_up.php");
                            exit();
                        }

                        $trader_id = $_SESSION["trader_id"];
                        $query = "SELECT * FROM SHOP WHERE USER_ID = :trader_id";
                        $stmt = oci_parse($conn, $query);
                        oci_bind_by_name($stmt, ":trader_id", $trader_id);
                        oci_execute($stmt);

                        if ($stmt) {
                            while ($row = oci_fetch_assoc($stmt)) {
                                ?>
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <img src="<?php echo htmlspecialchars($row["IMAGE"]); ?>" alt="<?php echo htmlspecialchars($row["SHOP_NAME"]); ?>">
                                        </li>
                                        <li class="list-group-item">
                                            Shop Name: <span class="ps-2"><?php echo htmlspecialchars($row["SHOP_NAME"]); ?></span>
                                        </li>
                                        
                                        <li class="list-group-item">
                                            Email: <span class="ps-2"><?php echo htmlspecialchars($row["EMAIL"]); ?></span>
                                        </li>
                                        <li class="list-group-item">
                                            Status: <span class="ps-2"><?php echo htmlspecialchars($row["STATUS"]); ?></span>
                                        </li>
                                        <li class="list-group-item">
                                            Created Date: <span class="ps-2"><?php echo htmlspecialchars($row["CREATED_ON"]); ?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="buttons">
                                                <a href="shop-edit.php?id=<?php echo htmlspecialchars($row["SHOP_ID"]); ?>" class="edit-button btn btn-primary">Edit</a>
                                                <a href="delete_shop.php?id=<?php echo htmlspecialchars($row["SHOP_ID"]); ?>" class="delete-button btn btn-danger">Delete</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <?php
                            }
                        } else {
                            echo "No shops found.";
                        }

                        oci_free_statement($stmt);
                        oci_close($conn);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>