<?php
session_start();
include('config.php'); // Include your database connection

// Retrieve the total price from the URL parameter
$total_price = isset($_GET['total']) ? htmlspecialchars($_GET['total']) : 0;

// Fetch the latest order for display
$query = "SELECT * FROM orders ORDER BY id DESC LIMIT 1"; // Get the latest order
$result = mysqli_query($conn, $query);
$order = mysqli_fetch_assoc($result);

// Check if order exists
if (!$order) {
    echo "<h1>No Order Found</h1>";
    exit();
}

$products = unserialize($order['products']); // Deserialize products
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Thank You for Your Order!</h2>
        <div class="alert alert-success text-center" role="alert">
            Your order has been placed successfully!
        </div>
        <h4 class="text-center">Order Summary</h4>
        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['id']); ?></p>
                <p><strong>Total Price:</strong> ₹<?php echo $total_price; ?></p>
                <h5>Products:</h5>
                <ul class="list-group">
                    <?php foreach ($products as $product): ?>
                        <li class="list-group-item">
                            <?php echo htmlspecialchars($product['name']); ?> (Quantity: <?php echo htmlspecialchars($product['quantity']); ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="text-center">
            <a href="home.php" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
