<?php
session_start();
include('config.php'); // Include your database connection

// Check if the user is an admin (implement your own authentication)
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch all orders from the database
$query = "SELECT `id`, `user_name`, `user_email`, `user_address`, `user_phone`, `products`, `total_price`, `order_date` FROM `orders` WHERE 1";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<header class="bg-white border-bottom border-2">
      <nav class="container d-flex align-items-center justify-content-between py-3">
        <a href="Home.php" class="navbar-brand">
          <img src="https://png.pngtree.com/png-vector/20220708/ourmid/pngtree-skin-care-logo-png-image_5774040.png" alt="Derma Co Logo" class="h-auto" style="max-height: 60px" />
        </a>
        <ul class="nav d-none d-md-flex">
          <li class="nav-item">
            <a href="HomeAdmin.php" class="nav-link text-secondary">Home Data</a>
          </li>
          <li class="nav-item">
            <a href="ContactAdmin.php" class="nav-link text-secondary">Contact Data</a>
          </li>
          <li class="nav-item">
            <a href="AddProduct.php" class="nav-link text-secondary">Add Product</a>
          </li>
          <li class="nav-item">
            <a href="admin_orders.php" class="nav-link text-secondary">Cart Request</a>
          </li>
        </ul>

        <div class="d-flex align-items-center">
          <a href="logout.php">
            <button class="btn btn-primary">Logout</button>
          </a>
        </div>
      </nav>
    </header>
<div class="container mt-5">
    <h2 class="text-center">All Orders</h2>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>User Address</th>
                <th>User Phone</th>
                <th>Products</th>
                <th>Total Price</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                    <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($order['user_email']); ?></td>
                    <td><?php echo htmlspecialchars($order['user_address']); ?></td>
                    <td><?php echo htmlspecialchars($order['user_phone']); ?></td>
                    <td>
                        <ul class="list-group">
                            <?php
                            // Assuming products are serialized in the database
                            $products = unserialize($order['products']);
                            if ($products) {
                                foreach ($products as $product):
                            ?>
                                <li class="list-group-item">
                                    <?php echo htmlspecialchars($product['name']); ?> (Quantity: <?php echo htmlspecialchars($product['quantity']); ?>)
                                </li>
                            <?php endforeach; } else { echo "No products"; } ?>
                        </ul>
                    </td>
                    <td>₹<?php echo htmlspecialchars($order['total_price']); ?></td>
                    <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
