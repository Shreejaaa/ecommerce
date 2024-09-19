<title>Shop</title>

<?php include 'header.php'; ?>

<div class="main__content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Shop List
                    </div>
                    <div class="">
                        <a href="shop-create.php" class="btn btn-secondary" name="button">Add Shop</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>
                                    Shop Name
                                </th>
                                <th>Contact</th>
                                <th>Location</th>
                                <!-- <th>Status</th> -->
                                <th width="160px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <div class="product__container">
                                        <div class="product__image">
                                            <img src="images/Broccoli.jpg" alt="">
                                        </div>
                                        <div class="">
                                            Shop Name
                                        </div>
                                    </div>
                                </td>
                                <td>9880227545</td>
                                <td>Ramkot, Kathmandu</td>
                                <!-- <td>
                                    <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                    </div>
                                </td> -->
                                <td>
                                    <a href="shop-edit.php" class="btn btn-primary">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <a href="shop-show.php" class="btn btn-success">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    <div class="product__container">
                                        <div class="product__image">
                                            <img src="images/Broccoli.jpg" alt="">
                                        </div>
                                        <div class="">
                                            Shop Name
                                        </div>
                                    </div>
                                </td>
                                <td>9880227545</td>
                                <td>Ramkot, Kathmandu</td>
                                <!-- <td>
                                    <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                    </div>
                                </td> -->
                                <td>
                                    <a href="shop-edit.php" class="btn btn-primary">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <a href="shop-show.php" class="btn btn-success">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
