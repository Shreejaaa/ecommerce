<?php include("header.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Status</title>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            
            if (status === 'success') {
                alert('Payment successful, your order has been placed successfully.');
            } else if (status === 'cancelled') {
                alert('Payment unsuccessful, you may try again.');
            }
        });
    </script>
</head>
<body>
    <h1>Order Status</h1>
    <!-- Your existing order page content -->
</body>
</html>

<?php include("footer.php"); ?>
