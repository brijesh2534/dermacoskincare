<?php
session_start();

if (isset($_GET['index'])) {
    $index = intval($_GET['index']);

    // Check if the cart exists and the index is valid
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the cart array
    }
    
    // Redirect back to the cart or home page
    header("Location: cart.php"); // or change to "home.php" if you want to go home
    exit();
}
?>
