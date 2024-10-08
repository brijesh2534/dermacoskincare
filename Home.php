<?php
// Include database connection
include('config.php');
session_start(); // Start session for cart handling

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $product_image = mysqli_real_escape_string($conn, $_POST['product_image']); // Add product image

    // Add product to session cart
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$product) {
        if ($product['name'] === $product_name) {
            // Product already exists, increase the quantity
            $product['quantity']++;
            $found = true;
            break;
        }
    }

    // If the product wasn't found, add it to the cart
    if (!$found) {
        $_SESSION['cart'][] = [
            'name' => $product_name,
            'price' => $product_price,
            'image' => $product_image, // Ensure the image is set
            'quantity' => 1,
        ];
    }

    // Set a session variable to show success message
    $_SESSION['success_message'] = "Product added to cart successfully.";

    // Redirect to clear URL parameters
    header("Location: home.php");
    exit();
}

// Fetch products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

// Check for success message and clear it after displaying
$show_success_message = isset($_SESSION['success_message']);
$success_message = $show_success_message ? $_SESSION['success_message'] : '';
if ($show_success_message) {
    unset($_SESSION['success_message']); // Clear the message after showing it
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home - Derma Co</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
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
        .product-image {
            height: 200px;
            object-fit: cover;
        }
        .btn-add-to-cart {
            background-color: #006400;
            border-color: #006400;
            color: white;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-y2SFC0vv7Tkx2qZ7gW4nY0AcA9uY3FIZw2KqD9mpKCy1+1H3vONC54UOYN6W9Do3mJXiAeEc8m+pbn1GSv8zA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
<header class="bg-white border-bottom border-2">
    <nav class="container d-flex align-items-center justify-content-between py-3">
        <a href="Home.php" class="navbar-brand">
            <img src="https://png.pngtree.com/png-vector/20220708/ourmid/pngtree-skin-care-logo-png-image_5774040.png" alt="Derma Co Logo" class="h-auto" style="max-height: 60px" />
        </a>
        <ul class="nav d-none d-md-flex">
            <li class="nav-item"><a href="Home.php" class="nav-link text-secondary">Home</a></li>
            <li class="nav-item"><a href="About.php" class="nav-link text-secondary">About Us</a></li>
            <li class="nav-item"><a href="Contact.php" class="nav-link text-secondary">Contact Us</a></li>
        </ul>
        <div class="d-flex align-items-center">
            <a href="Login.php" class="btn btn-outline-primary me-2">Admin Login</a>
            <a href="cart.php" class="btn btn-outline-secondary">
    <i class="fa-solid fa-cart-shopping"></i> Cart
</a>
        </div>
    </nav>
</header>

<div class="container my-5">
    <div class="text-center">
        <h1>Welcome to Derma Co Skincare</h1>
        <h2>Our Most Loved Products</h2>
    </div>

    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="position-relative">
                            <img src="<?php echo htmlspecialchars($row['image_url']); ?>" class="card-img-top product-image w-100" alt="<?php echo htmlspecialchars($row['product_name']); ?>" />
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['product_name']); ?></h5>
                            <p class="card-text text-muted"><?php echo htmlspecialchars($row['description']); ?></p>
                            <div class="mt-auto">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="fs-4 fw-bold me-2">₹<?php echo htmlspecialchars($row['price']); ?></span>
                                </div>
                                <!-- Pass the product name, price, and image to the modal via data attributes -->
                                <form method="POST" action="home.php">
                                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['product_name']); ?>">
                                    <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($row['price']); ?>">
                                    <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($row['image_url']); ?>">
                                    <button type="submit" class="btn btn-add-to-cart w-100">Add to cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2024 Derma Co. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    <?php if ($show_success_message) { ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?php echo htmlspecialchars($success_message); ?>',
            confirmButtonText: 'OK'
        });
    <?php } ?>
});
</script>

</body>
</html>
