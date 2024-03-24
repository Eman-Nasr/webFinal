<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add your custom CSS here -->
    <style>
        /* Custom Navbar Styling */
        .navbar-custom {
            background-color: #343a40; /* Dark background color */
        }
        .navbar-custom .navbar-brand, .navbar-custom .navbar-nav .nav-link {
            color: #ffffff; /* White text color */
        }
        /* Adjusted carousel height */
        #carouselExampleSlidesOnly {
            height: 500px; /* Set specific height */
            overflow: hidden; /* Hide overflow content */
        }
        .carousel-item img {
            width: 100%;
            height: auto;
        }
        /* Carousel caption styling */
        .carousel-caption {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #ffffff; /* Text color */
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">Student Management System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Admin/admin_login.php">Admin Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Teacher/teacher_login.php">Teacher Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Student/student_login.php">Student Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Image Carousel -->
    <div class="container">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100" alt="...">
                    <div class="carousel-caption">
                        <h5>Welcome to the Student Management System</h5>
                        <p>Efficiently manage student information, courses, and assignments.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100" alt="...">
                    <div class="carousel-caption">
                        <h5>Stay Organized with Our Student Management System</h5>
                        <p>Track student progress, attendance, and performance with ease.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="d-block w-100" alt="...">
                    <div class="carousel-caption">
                        <h5>Enhance Educational Efficiency with Our System</h5>
                        <p>Streamline administrative tasks and focus on student success.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></
