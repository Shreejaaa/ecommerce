<title>Invoice Page</title>

<?php
    include("header.php")
?>

<section class="invoice__section">
    <h2 class="contact__section-title">Invoice</h2>
    <div class="invoice__section-content">
        <div class="invoice__section-header">
            <div class="invoice__header-info">
                <div class="invoice__header-title">
                    Cleckhudderfax
                </div>
                <div class="invoice__header-detail">
                    West Yorkshire, UK
                </div>
            </div>
            <div class="invoice__section-image">
                <img src="images/LOGO.png" alt="">
            </div>
        </div>
        <div class="invoice__section-title">
            <h4>Invoice</h4>
        </div>

        <div class="invoice__customer-title">
            BILL TO
        </div>
        <div class="invoice__customer">
            <div class="">
                Customer Name
            </div>
            <div class="invoice__customer-detail">
                <div class="">
                    Invoice No : 123-456-789
                </div>
                <div class="">
                    Date : 10/06/2000
                </div>

            </div>
        </div>

        <table class="invoice__section-table">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Product Name</th>
                    <th>Seller/Buyer</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>Name</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                </tr>
                <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>Name</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                </tr>
                <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>Name</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                </tr>
                <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>Name</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td colspan="2" class="text-left">Subtotal</td>
                    <td>#</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td colspan="2" class="text-left">Discount</td>
                    <td>#</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td colspan="2" class="text-left">Total</td>
                    <td>#</td>
                </tr>
            </tbody>
        </table>
        <div class="invoice__section-footer">
            <div class=invoice__section-phone"">
                <i class="fa fa-phone"></i>
                 +977 9812345678
            </div>
            <div class="invoice__section-mail">
                <i class="fa fa-envelope"></i>
                suburbanmart@gmail.com
            </div>
        </div>
    </div>
</section>


<?php
include("footer.php")
?>
