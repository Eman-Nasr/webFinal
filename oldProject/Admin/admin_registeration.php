<?php
session_start();
// Database connection code here
include('../includes/config.php');

// Admin Signup
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'admin';

    // Insert admin data into Users table
    $sql = "INSERT INTO Users (username, password, email, role) VALUES ('$username', '$password', '$email', '$role')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['signup_success'] = "Admin signup successful!";
        header("Location: admin_registeration.php"); // Redirect to prevent form resubmission
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Additional custom styles if needed */
        body {
            margin: 80px;
            background-image: url('https://images.unsplash.com/photo-1432821596592-e2c18b78144f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-repeat: no-repeat;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Admin Signup Form -->
                <div class="card" style="padding: 4em">
                    <div class="card-body">
                        <h2 class="card-title">Admin Signup</h2>
                        <?php
                        // Check if admin signup was successful
                        if (isset($_SESSION['signup_success'])) {
                            echo '<div class="alert alert-success" role="alert">' . $_SESSION['signup_success'] . '</div>';
                            unset($_SESSION['signup_success']); // Remove the success message from session
                        }
                        ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <p>Already have an account? login <a href="admin_login.php">here</a></p>
                            <input type="submit" class="btn btn-primary" name="admin_signup" value="Signup">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
