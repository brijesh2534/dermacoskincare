<?php
// Include database connection
include('config.php');

// Initialize variables
$name = $email = $message = '';
$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Validate form data
    if (empty($name) || empty($email) || empty($message)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        // Insert data into database
        $query = "INSERT INTO contact (name, email, message) VALUES ('$name', '$email', '$message')";
        if (mysqli_query($conn, $query)) {
            $success = 'Your message has been sent successfully.';
        } else {
            $error = 'There was an error sending your message. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us - Derma Co</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
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

<section class="container my-5">
    <h2>Contact Us</h2>
    <p>If you have any questions or inquiries, feel free to reach out to us using the form below.</p>
    
    <!-- Display Success or Error Message -->
    <?php if ($success): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success; ?>
        </div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="Contact.php">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" value="<?php echo htmlspecialchars($name); ?>" />
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?php echo htmlspecialchars($email); ?>" />
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Your Message"><?php echo htmlspecialchars($message); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</section>

<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2024 Derma Co. All Rights Reserved.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
