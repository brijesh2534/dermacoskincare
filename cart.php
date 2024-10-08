<?php
session_start();

// Initialize the cart if it's not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Remove item from cart functionality
if (isset($_GET['index'])) {
    $index = intval($_GET['index']);
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
    }
    header("Location: cart.php"); // Redirect back to cart
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .card {
            margin-bottom: 20px;
        }
        .card img {
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<header class="bg-white border-bottom border-2">
    <nav class="container d-flex align-items-center justify-content-between py-3">
        <a href="home.php" class="navbar-brand">
            <img src="https://png.pngtree.com/png-vector/20220708/ourmid/pngtree-skin-care-logo-png-image_5774040.png" alt="Derma Co Logo" class="h-auto" style="max-height: 60px" />
        </a>
        <div class="d-flex align-items-center">
            <a href="login.php" class="btn btn-outline-primary me-2">Admin Login</a>
            <a href="cart.php" class="btn btn-outline-secondary">
    <i class="fa-solid fa-cart-shopping"></i> Cart
</a>

        </div>
    </nav>
</header>

<div class="container mt-5">
    <h2>Your Cart</h2>
    <?php if (!empty($_SESSION['cart'])): ?>
        <div class="row">
            <?php
            $total_price = 0;
            foreach ($_SESSION['cart'] as $index => $product): 
                $product_total = $product['price'] * $product['quantity'];
                $total_price += $product_total;
            ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text">Price: ₹<span class="product-price"><?php echo htmlspecialchars($product['price']); ?></span></p>
                            <div class="d-flex align-items-center mb-2">
                                <button class="btn btn-secondary btn-sm change-quantity" data-index="<?php echo $index; ?>" data-action="decrease">-</button>
                                <input type="number" class="form-control text-center mx-2" value="<?php echo htmlspecialchars($product['quantity']); ?>" style="width: 60px;" min="1" readonly />
                                <button class="btn btn-secondary btn-sm change-quantity" data-index="<?php echo $index; ?>" data-action="increase">+</button>
                            </div>
                            <h6>Total: ₹<span class="product-total" data-index="<?php echo $index; ?>"><?php echo htmlspecialchars($product_total); ?></span></h6>
                            <button class="btn btn-danger btn-sm remove-item" data-index="<?php echo $index; ?>">Remove</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-end">
            <h4>Total Price: ₹<span id="cart-total"><?php echo htmlspecialchars($total_price); ?></span></h4>
            <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
        </div>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>

<script>
$(document).ready(function() {
    // Handle quantity changes
    $('.change-quantity').click(function() {
        var index = $(this).data('index');
        var action = $(this).data('action');
        var quantityInput = $(this).siblings('input[type="number"]');
        var currentQuantity = parseInt(quantityInput.val());
        var productPrice = parseFloat($(this).closest('.card-body').find('.product-price').text());

        if (action === 'increase') {
            currentQuantity++;
        } else if (action === 'decrease' && currentQuantity > 1) {
            currentQuantity--;
        }
        
        // Update the input field
        quantityInput.val(currentQuantity);

        // Calculate new total for this product
        var productTotal = productPrice * currentQuantity;
        $(this).closest('.card-body').find('.product-total').text(productTotal.toFixed(2));

        // Update overall cart total
        updateCartTotal();
        
        // Update session cart through AJAX
        $.ajax({
            url: 'update_cart.php', // A new file to handle updating cart quantities
            type: 'POST',
            data: {
                index: index,
                quantity: currentQuantity
            },
            success: function(response) {
                // Optionally handle success
            },
            error: function() {
                alert("Error updating quantity.");
            }
        });
    });

    // AJAX request to remove item from cart without reloading
    $('.remove-item').click(function() {
        var index = $(this).data('index');
        $.ajax({
            url: 'cart.php', // This is where we handle item removal
            type: 'GET',
            data: { index: index },
            success: function(response) {
                // Reload the page to update the cart
                location.reload(); 
            },
            error: function() {
                alert("Error removing item from cart.");
            }
        });
    });

    function updateCartTotal() {
        var total = 0;
        $('.product-total').each(function() {
            total += parseFloat($(this).text());
        });
        $('#cart-total').text(total.toFixed(2));
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
