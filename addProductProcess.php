<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: adminlogin.php');
    exit();
}

include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $discount_price = $_POST['discount_price'];
    $stock_quantity = $_POST['stock_quantity'];
    
    // Handle file upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['product_image']['name']);
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
            $product_image = $target_file;
        } else {
            $_SESSION['message'] = "Failed to upload product image!";
            header('Location: AddProduct.php');
            exit();
        }
    } else {
        $_SESSION['message'] = "No image uploaded!";
        header('Location: AddProduct.php');
        exit();
    }

    // Insert the product data into the database
    $query = "INSERT INTO products (`product_name`, `description`, `category`, `price`, `discount_price`, `stock_quantity`, `image_url`) 
              VALUES ('$product_name', '$description', '$category', '$price', '$discount_price', '$stock_quantity', '$product_image')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Product added successfully!";
    } else {
        $_SESSION['message'] = "Failed to add product! Error: " . mysqli_error($conn);
    }

    header('Location: HomeAdmin.php');
    exit();
}
?>
