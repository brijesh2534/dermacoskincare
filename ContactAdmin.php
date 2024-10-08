<?php
// Include database connection

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include('config.php');

// Fetch data from contact_requests table
$sql = "SELECT * FROM contact";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Admin - Derma Co</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
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
    <div class="container my-4">
        <table class="table">
            <thead class="thead-dark bg-black text-white">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email Address</th>
                    <th scope="col">Message</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<th scope='row'>" . $row['id'] . "</th>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No contact requests found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
