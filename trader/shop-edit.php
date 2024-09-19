<title>Edit Shop</title>

<?php include 'header.php'; ?>

<div class="main__content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Edit Shop
                    </div>
                    <div class="">
                        <a href="shops.php" class="btn btn-secondary" name="button">Back</a>
                    </div>
                </div>
                <div class="card-body">
                <form class="" action="update_shop.php" method="post"  enctype="multipart/form-data">
                        <div class="row g-3">
                        <input type="hidden" name="shop_id" value="<?php echo htmlspecialchars($shop_id); ?>">
                            <div class="col-md-6">
                                <label class="form-label">Shop Name <span class="text-danger">*</span> </label>
                                <input type="text" name="shopname" class="form-control" value="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Description <span class="text-danger">*</span> </label>
                                <input type="text" name="description" class="form-control" value="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span> </label>
                                <input type="text" name="status" class="form-control" value="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span> </label>
                                <input type="text" name="email" class="form-control" value="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Image <span class="text-danger">*</span> </label>
                                <input type="file" class="form-control" name="image" value="">
                            </div>
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success" name="update">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
