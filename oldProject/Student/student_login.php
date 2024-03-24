<?php
session_start();
include('../includes/config.php');

// Check if student is already logged in, redirect to dashboard if logged in
if (isset($_SESSION['student_id'])) {
    header("Location: student_dashboard.php");
    exit;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check student credentials
    $sql = "SELECT * FROM users WHERE username = '$username' AND role = 'student'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password == $row['password']) {
            // Student authenticated, set session variables
            $_SESSION['student_id'] = $row['user_id'];
            $_SESSION['student_username'] = $row['username'];
            // Redirect to student dashboard
            header("Location: student_dashboard.php");
            exit;
        } else {
            $login_error = "Invalid username or password.";
        }
    } else {
        $login_error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background-color: rgba(255, 255, 255, 01); /* Semi-transparent white background */
            padding: 3em 10em;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Student Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <?php if(isset($login_error)) { ?>
                <div class="alert alert-danger" role="alert"><?php echo $login_error; ?></div>
            <?php } ?>
            <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
        </form>
    </div>
</body>
</html>
 