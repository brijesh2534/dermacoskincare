<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include('config.php');

// Fetch product details for the given id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);
} else {
    $_SESSION['message'] = "No product id provided!";
    header('Location: HomeAdmin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product - Derma Co</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Update Product</h1>

        <form action="updateProductProcess.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

            <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" name="product_name" class="form-control" id="productName" value="<?php echo $product['product_name']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <input type="text" name="category" class="form-control" id="category" value="<?php echo $product['category']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price (₹)</label>
                <input type="number" name="price" class="form-control" id="price" value="<?php echo $product['price']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="discountPrice" class="form-label">Discount Price (₹)</label>
                <input type="number" name="discount_price" class="form-control" id="discountPrice" value="<?php echo $product['discount_price']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock Quantity</label>
                <input type="number" name="stock_quantity" class="form-control" id="stock" value="<?php echo $product['stock_quantity']; ?>" required>
            </div>

            <!-- Display the current image -->
            <div class="mb-3">
                <label for="currentImage" class="form-label">Current Product Image</label><br>
                <img src="<?php echo $product['image_url']; ?>" alt="Product Image" style="max-height: 100px;">
                <input type="hidden" name="current_image" value="<?php echo $product['image_url']; ?>">
            </div>

            <!-- Input to upload a new image -->
            <div class="mb-3">
                <label for="newImage" class="form-label">Upload New Product Image</label>
                <input type="file" name="new_image" class="form-control" id="newImage" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</body>
</html>
