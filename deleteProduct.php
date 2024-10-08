<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: adminlogin.php');
    exit();
}

include('config.php');

// Check if the id parameter exists
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the product from the database
    $query = "DELETE FROM products WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Product deleted successfully!";
    } else {
        $_SESSION['message'] = "Failed to delete product!";
    }
} else {
    $_SESSION['message'] = "No product id provided!";
}

// Redirect back to the admin home page with a message
header('Location: HomeAdmin.php');
exit();
?>
