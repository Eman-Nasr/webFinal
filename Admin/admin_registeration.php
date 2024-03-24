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
    <link rel="icon" type="images/png" href="logo1.png">
    <link rel="stylesheet" href="../css/teacherLoginPage.css">

</head>
<body>
        <div class="area">
                <ul class="circles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                </ul>
            </div>
    <div class="container">
    <div class="welcome-section">
            <h1>Student Portal SignUp </h1>
            <p> <p>Get started!</p></p>
        </div>

        <div class="login-section">

<form class="login-form">
<?php
                        // Check if admin signup was successful
                        if (isset($_SESSION['signup_success'])) {
                            echo '<div class="alert alert-success" role="alert">' . $_SESSION['signup_success'] . '</div>';
                            unset($_SESSION['signup_success']); // Remove the success message from session
                        }
                        ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>
    </div>
    
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" name="email" placeholder="Enter your Email" required>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
    </div>

    
    <div class="footer-links">
       <p>Already have an account? login <a href="AdminLoginPage.php">here</a></p>
                <input type="submit" class="btn btn-primary" name="admin_signup" value="Signup"> 
    </div>
</form>
</div>
    </div>
    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
