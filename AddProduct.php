<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Product - Derma Co</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
      /* Prevent textarea resizing */
      textarea {
        resize: none;
      }
      input[type="number"]::-webkit-outer-spin-button,
      input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }

      input[type="number"] {
        -moz-appearance: textfield; /* Firefox */
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
      <h2 class="mb-4 text-center">Add a New Skincare Product</h2>
      <form action="addProductProcess.php" method="POST" enctype="multipart/form-data">
        <!-- Product Name -->
        <div class="mb-3">
          <label for="productName" class="form-label">Product Name</label>
          <input type="text" class="form-control" name="product_name" id="productName" placeholder="Enter product name" required />
        </div>

        <!-- Description -->
        <div class="mb-3">
          <label for="productDescription" class="form-label">Description</label>
          <textarea class="form-control" name="description" id="productDescription" rows="4" placeholder="Enter product description" required></textarea>
        </div>

        <!-- Category -->
        <div class="mb-3">
          <label for="productCategory" class="form-label">Category</label>
          <select class="form-select" name="category" id="productCategory" required>
            <option value="">Select a category</option>
            <option value="Serum">Serum</option>
            <option value="Moisturizer">Moisturizer</option>
            <option value="Sunscreen">Sunscreen</option>
          </select>
        </div>

        <!-- Price -->
        <div class="mb-3">
          <label for="productPrice" class="form-label">Price (₹)</label>
          <input type="number" class="form-control" name="price" id="productPrice" placeholder="Enter price" required />
        </div>

        <!-- Discount Price -->
        <div class="mb-3">
          <label for="productDiscountPrice" class="form-label">Discount Price (₹)</label>
          <input type="number" class="form-control" name="discount_price" id="productDiscountPrice" placeholder="Enter discount price (optional)" />
        </div>

        <!-- Stock Quantity -->
        <div class="mb-3">
          <label for="stockQuantity" class="form-label">Stock Quantity</label>
          <input type="number" class="form-control" name="stock_quantity" id="stockQuantity" placeholder="Enter stock quantity" required />
        </div>

        <!-- Product Image -->
        <div class="mb-3">
          <label for="productImage" class="form-label">Product Image</label>
          <input class="form-control" type="file" name="product_image" id="productImage" required />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Add Product</button>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
