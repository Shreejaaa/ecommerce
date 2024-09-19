<title>Edit Product</title>

<?php include 'header.php'; ?>

<div class="main__content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Edit Product
                    </div>
                    <div class="">
                        <a href="products.php" class="btn btn-secondary" name="button">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="" action="update_product.php" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                        <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                            <div class="col-md-6">
                                <label class="form-label">Product Name <span class="text-danger">*</span> </label>
                                <input type="text" name="name" class="form-control" value="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Price <span class="text-danger">*</span> </label>
                                <input type="text" name="price" class="form-control" value="">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description <span class="text-danger">*</span> </label>
                                <textarea type="text" name="description" rows="6" class="form-control" value=""> </textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Quantity <span class="text-danger">*</span> </label>
                                <input type="number" id="quantity" name="quantity" >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mininum Order <span class="text-danger">*</span> </label>
                                <input type="number"  name="minorder" >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Maximum Order <span class="text-danger">*</span> </label>
                                <input type="number"  name="maxorder" >
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Stock <span class="text-danger">*</span> </label>
                                <input type="number" name="stock" class="form-control" value="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Weight <span class="text-danger">*</span> </label>
                                <input type="number" name="weight" class="form-control" value="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Manufacture Date <span class="text-danger">*</span> </label>
                                <input type="date" name="manufacture" class="form-control" value="">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Expiry Date <span class="text-danger">*</span> </label>
                                <input type="date" name="expiry" class="form-control" value="">
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
