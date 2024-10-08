<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include('config.php');

// Fetch products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home Admin - Derma Co</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
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

    <div class="table-responsive" style="overflow-y: auto">
      <table class="table">
        <thead class="thead-dark bg-black text-white">
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Product Name</th>
            <th scope="col">Category</th>
            <th scope="col">Price (₹)</th>
            <th scope="col">Discount Price (₹)</th>
            <th scope="col">Stock Quantity</th>
            <th scope="col">Product Image</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <th scope="row"><?php echo htmlspecialchars($row['id']); ?></th>
            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
            <td><?php echo htmlspecialchars($row['category']); ?></td>
            <td>₹<?php echo htmlspecialchars($row['price']); ?></td>
            <td>₹<?php echo htmlspecialchars($row['discount_price']); ?></td>
            <td><?php echo htmlspecialchars($row['stock_quantity']); ?></td>
            <td>
              <?php
              $imagePath = htmlspecialchars($row['image_url']);
              if (file_exists($imagePath)) {
                  echo "<img src='$imagePath' alt='Product Image' style='max-height: 60px' />";
              } else {
                  echo "Image not found.";
              }
              ?>
            </td>
            <td>
              <a href="updateProduct.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-primary me-2">
                <i class="fas fa-edit"></i> Update
              </a>
              <a href="deleteProduct.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger">
                <i class="fas fa-trash"></i> Delete
              </a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </body>
</html>
