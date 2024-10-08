<?php
session_start();
include('config.php'); // Include your database connection

// Redirect to cart if it's empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $total_price = 0;

    // Prepare products array
    $products = [];

    // Loop through cart items
    foreach ($_SESSION['cart'] as $product) {
        $product_total = $product['price'] * $product['quantity'];
        $total_price += $product_total;

        // Store product details in an array
        $products[] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $product['quantity'],
            'total' => $product_total
        ];
    }

    // Serialize products array for storage in the database
    $products_serialized = serialize($products);

    // Insert order details into the orders table
    $query = "INSERT INTO orders (user_name, user_email, user_address, user_phone, products, total_price) 
              VALUES ('$name', '$email', '$address', '$phone', '$products_serialized', '$total_price')";
    mysqli_query($conn, $query);

    // Optionally, clear the cart after checkout
    unset($_SESSION['cart']);

    // Redirect to a confirmation page or display a success message
    header("Location: confirmation.php?total=$total_price");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container mt-5">
    <h2>Checkout</h2>
    <form method="POST" action="checkout.php">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" required></textarea>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
