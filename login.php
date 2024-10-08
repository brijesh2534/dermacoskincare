<?php
session_start();
include('config.php'); // Include your database configuration file

$error_message = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check admin credentials
    $query = "SELECT * FROM admins WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // If admin credentials are valid
    if ($admin) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $admin['email'];

        // Redirect to HomeAdmin.php
        header("Location: HomeAdmin.php");
        exit();
    } else {
        // Set error message for incorrect login
        $error_message = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
  </head>
  <body>
    <section class="vh-100">
      <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
          <div class="col-md-8 col-lg-7 col-xl-6">
            <img
              src="uploads/design.svg"
              class="img-fluid"
              alt="Phone image"
            />
          </div>
          <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
            <form class="flex flex-column justify-content-center" method="POST" action="login.php">
              <div class="">
                <h1 class="">Admin Login Details</h1>
              </div>

              <!-- Error message -->
              <?php if (!empty($error_message)) : ?>
                <div class="alert alert-danger">
                  <?= $error_message; ?>
                </div>
              <?php endif; ?>

              <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form1Example13">Email address</label>
                <input
                  type="email"
                  name="email"
                  id="form1Example13"
                  class="form-control form-control-lg"
                  required
                />
              </div>

              <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="form1Example23">Password</label>
                <input
                  type="password"
                  name="password"
                  id="form1Example23"
                  class="form-control form-control-lg"
                  required
                />
              </div>

              <div class="d-flex justify-content-around align-items-center mb-4"></div>

              <button
                type="submit"
                class="btn btn-primary btn-lg btn-block"
              >
                Login
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
