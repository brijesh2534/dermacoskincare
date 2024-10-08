<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
// Include database connection
include('config.php');

// Fetch product requests from the database
$query = "SELECT * FROM user_details"; // Replace with your actual table name for storing product requests
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Request - Derma Co</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        textarea {
            resize: none;
        }
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body>
<header class="bg-white border-bottom border-2">
    <nav class="container d-flex align-items-center justify-content-between py-3">
        <a href="Home.php" class="navbar-brand">
            <img src="https://png.pngtree.com/png-vector/20220708/ourmid/pngtree-skin-care-logo-png-image_5774040.png" alt="Derma Co Logo" class="h-auto" style="max-height: 60px" />
        </a>
        <ul class="nav d-none d-md-flex">
            <li class="nav-item"><a href="HomeAdmin.php" class="nav-link text-secondary">Home Data</a></li>
            <li class="nav-item"><a href="ContactAdmin.php" class="nav-link text-secondary">Contact Data</a></li>
            <li class="nav-item"><a href="AddProduct.php" class="nav-link text-secondary">Add Product</a></li>
            <!-- <li class="nav-item"><a href="ProductRequest.php" class="nav-link text-secondary">Product Request</a></li> -->
        </ul>
        <div class="d-flex align-items-center">
            <a href="Login.php"><button class="btn btn-primary">Logout</button></a>
        </div>
    </nav>
</header>

<div class="container-fluid mt-4">
    <h3 class="text-center mb-4">Product Requests</h3>
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="thead-dark bg-black text-white">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Price (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_price']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Font Awesome and Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
