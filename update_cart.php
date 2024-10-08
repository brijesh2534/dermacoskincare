<?php
session_start();

// Update the quantity of a product in the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['index'], $_POST['quantity'])) {
    $index = intval($_POST['index']);
    $quantity = intval($_POST['quantity']);

    if (isset($_SESSION['cart'][$index])) {
        // Update the quantity in the session cart
        $_SESSION['cart'][$index]['quantity'] = $quantity;
    }
}
?>
