<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: adminlogin.php');
    exit();
}

include('config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $discount_price = $_POST['discount_price'];
    $stock_quantity = $_POST['stock_quantity'];

    // Handle new image upload
    if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] == 0) {
        $target_dir = "uploads/"; // Directory where the image will be saved
        $target_file = $target_dir . basename($_FILES['new_image']['name']);
        move_uploaded_file($_FILES['new_image']['tmp_name'], $target_file);
        $product_image = $target_file; // Set the new image path
    } else {
        // If no new image uploaded, use the existing image from the database
        $product_image = $_POST['current_image'];
    }

    // Update query
    $query = "UPDATE products SET 
        product_name = '$product_name',
        category = '$category',
        price = '$price',
        discount_price = '$discount_price',
        stock_quantity = '$stock_quantity',
        image_url = '$product_image'
        WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Product updated successfully!";
    } else {
        $_SESSION['message'] = "Failed to update product!";
    }

    // Redirect back to admin home page
    header('Location: HomeAdmin.php');
    exit();
}
