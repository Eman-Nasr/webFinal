<?php
session_start();
include('../includes/config.php');

// Check if teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    // Redirect to teacher login page if not logged in
    header("Location: teacher_login.php");
    exit;
}

// Fetch courses taught by the teacher
$teacher_id = $_SESSION['teacher_id'];
$sql_courses = "SELECT * FROM courses WHERE instructor_id = $teacher_id";
$result_courses = $conn->query($sql_courses);

// Fetch users (students)
$sql_users = "SELECT user_id, username FROM users WHERE role = 'student'";
$result_users = $conn->query($sql_users);

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload_marks'])) {
    $course_id = $_POST['course_id'];
    $user_id = $_POST['user_id'];
    $quiz_name = $_POST['quiz_name'];
    $marks_obtained = $_POST['marks_obtained'];

    // Validate marks obtained
    if ($marks_obtained < 0 || $marks_obtained > 10) {
        echo "Invalid marks obtained. Please enter a number between 0 and 10.";
    } else {
        // Insert marks into the database
        $sql_insert_marks = "INSERT INTO quizes (user_id, course_id, quiz_name, marks_obtained) VALUES ('$user_id', '$course_id', '$quiz_name', '$marks_obtained')";
        if ($conn->query($sql_insert_marks) === TRUE) {
            echo "Marks uploaded successfully.";
        } else {
            echo "Error: " . $sql_insert_marks . "<br>" . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Quiz Marks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>

:root {
  --white-color: #fff;
  --paraText-color: #777;
  --heading-color: #333;
  --primary-color: rgb(218, 165, 32);
  --secondary-color: rgb(51, 83, 156);
}

body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .custom-container {
            margin-top: 50px;
        }

        .custom-form-container {
            width: 30%;
            padding: 40px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-right: 20px;
            margin-bottom: 20px;
        }

        .custom-description-container {
            margin-top: 20px;
            padding-right: 10px;
            font-size: 18px;
            color: #333;
        }

        .custom-pie-chart-container {
            margin-top: 20px;
            padding-left: 10px;
        }

        .custom-image-size {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .custom-image-size:hover {
            transform: scale(1.05);
        }

        .custom-pie-chart {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
body, html {
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  overflow-x: hidden;
}

.hamburger {
  cursor: pointer;
  padding: 15px;
  display: flex;
  flex-direction: column;
  gap: 5px; 
}

.hamburger .line {
  width: 30px; 
  height: 3px; 
  background-color: var(--secondary-color);
  transition: all 0.3s ease;
}


.sidebar {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 2;
  top: 0;
  left: 0;
  background-color: var(--secondary-color);
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
  border-top-right-radius: 25px; 
  border-bottom-right-radius: 25px; 
}


.sidebar ul {
  list-style-type: none;
  padding: 0;
}


.sidebar-title {
  color: var(--white-color); 
  font-size: 32px; 
  padding: 20px 15px; 
  text-align: center; 
  border-bottom: 1px solid var(--white-color); 
  margin-bottom: 20px; 
}

.sidebar ul li a, .dropbtn {
  padding: 8px 15px; 
  text-decoration: none;
  font-size: 18px; 
  color: var(--white-color);
  display: block;
  transition: color 0.3s, background-color 0.3s;
}



.sidebar ul li a:hover, .dropbtn:hover {
  color: var(--primary-color);
  background-color: var(--paraText-color); 
}
.dropdown {
  position: relative;
  display: block;
}



.dropdown {
  position: relative;
  display: block;
}

.dropbtn {
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
  background-color: inherit; 
  width: 100%; 
  text-align: left; 
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: var(--secondary-color);
  min-width: 100%; 
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}


.dropdown-content a {
  color: var(--secondary-color); 
  padding: 12px 16px; 
  text-decoration: none;
  display: block;
  text-align: left; 
  font-size: 10px; 
  margin-left: 25px; 
}

.dropdown-content a:hover {
  background-color: var(--paraText-color); 
}


.dropdown:hover .dropdown-content {
  display: block;
}

.sidebar ul li:hover .dropdown-content {
  display: block;
}



.closebtn {
  position: absolute;
  top: 0;
  right: 10px;
  font-size: 36px;
  margin-left: 50px;
  color: white; 
}

.closebtn:hover {
  color: #ccc; 
}


.dropdown-content .logout-separator {
  border-top: 1px solid var(--paraText-color); 
  margin: 10px 0;
}

.dropdown-content .logout {
  padding-top: 12px; 
}

.dropdown:hover .dropdown-content, .sidebar ul li:hover .dropdown-content {
  display: block;
  position: static; 
}

   

  

        .custom-image-size:hover {
            transform: scale(1.05); /* Slightly enlarge the image on hover */
        }

    
       /* Increase width of form container */
/* Increase width of form container */
.form-container {
    width: 250%; /* Change width as needed */
    padding: 40px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f8f8f8;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.05);
    margin-right: 20px; /* Add margin to the right to create space */
    margin-bottom: 20px; /* Add margin between form and second image */
}

 

.icon-container {
    width: 30%; /* Adjust width as needed */
    margin-left: auto; /* Align to the right */
    margin-bottom: 20px; /* Add margin between icon and form */
    height: auto; /* Set height to auto to match the form height */
}

.custom-image-size {
    max-width: 400px; /* Adjust the maximum width */
    height: 530px; /* Set height to auto to maintain aspect ratio */
    width: 100%; /* Set the width to 100% to fill the container */
    border-radius: 15px; /* Rounded corners for the frame */
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
    transition: transform 0.3s ease; /* Smooth transition for transform changes */
}


.custom-form-container {
    width: 70%; /* Adjust width as needed */
    padding: 40px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

footer {
    height: 50px; /* Adjust the height as needed */
 }



.description-container {
    margin-top: 200px; /* Adjust margin-top to move the description down */
    padding-right: 10px; /* Add padding to the right to create space between description and pie chart */
    text-align: center; /* Center align the text */
}
.pie-chart-description {
    font-family: Arial, sans-serif; /* Specify font family */
    font-size: 16px; /* Adjust font size as needed */
    color: #555; /* Specify text color */
}


.pie-chart-container {
    margin-top: 20px; /* Add margin between description and pie chart */
    padding-left: 10px; /* Add padding to the left to create space between description and pie chart */
    width: 190%; /* Adjust the width as needed */
}

.pie-chart-container img {
    max-width: 100%; /* Ensure the image fits within its container */
}

        
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="hamburger" onclick="toggleMenu()">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <div class="sidebar" id="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <div class="sidebar-title">Teacher</div>
        <ul>
            <li><a href="teacher_dashboard.php">Dashboard</a></li>
            <li><a href="teacher_courses.php">Course</a></li>
            <li class="menu-item dropdown">
                <a href="javascript:void(0)" class="dropbtn" onclick="toggleDropdown(this)">Upload Grades</a>
                <div class="dropdown-content">
                    <a href="teacher_upload_assignments_grades.php">Assignments</a>
                    <a href="teacher_upload_quizes_marks.php">Quizzes</a>
                    <a href="teacher_upload_final_exam_marks.php">Finals</a>
                </div>
            </li>
            <li><a href="logout.php">Logout</a></li> 
        </ul>
    </div>   

  <!-- Main Content -->
  <div class="container custom-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Quiz Image and Form container -->
                <div class="row">
                    <div class="col-md-6">
                        <!-- Quiz Image container -->
                        <div class="icon-container mr-md-5">
                            <!-- Quiz Image -->
                            <img src="images/quiz.png" alt="Quiz" class="custom-image-size" style="width:800px !important;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Form container -->
                        <div class="form-container custom-form-container" style="width: 190%;">
                            <!-- Quiz Marks Upload Form -->
                            <h1 class="text-center mb-4">Upload Quiz Marks</h1>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-group">
                                    <label for="course_id">Select Course:</label>
                                    <select name="course_id" id="course_id" class="form-control" required>
                                        <option value="">Select Course</option>
                                        <?php while ($row_course = $result_courses->fetch_assoc()) { ?>
                                            <option value="<?php echo $row_course['course_id']; ?>"><?php echo $row_course['course_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="user_id">Select Student:</label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        <option value="">Select Student</option>
                                        <?php while ($row_user = $result_users->fetch_assoc()) { ?>
                                            <option value="<?php echo $row_user['user_id']; ?>"><?php echo $row_user['username']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="quiz_name">Quiz Name:</label>
                                    <input type="text" name="quiz_name" id="quiz_name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="marks_obtained">Marks Obtained:</label>
                                    <input min="0" max="10" type="number" name="marks_obtained" id="marks_obtained" class="form-control" min="0" max="100" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block" name="upload_marks">Upload Marks</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Description and Pie Chart container -->
                <div class="row mt-5">
                    <div class="col-md-6">
                        <!-- Description container -->
                        <div class="description-container custom-description-container">
                            <!-- Description of Quiz Grading -->
                            <p class="pie-chart-description">Description: This pie chart represents the distribution of marks obtained by students in the quiz.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Pie Chart container -->
                        <div class="pie-chart-container custom-pie-chart-container">
                            <!-- Pie Chart Image -->
                            <img src="images/piechart.png" alt="Pie Chart" class="custom-image-size custom-pie-chart">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="mt-5"></footer>

    <!-- JavaScript for sidebar functionality -->
    <script>
        function toggleMenu() {
            var sidebar = document.getElementById("sidebar");
            sidebar.style.width = sidebar.style.width === "250px" ? "0" : "250px";
        }

        function closeNav() {
            document.getElementById("sidebar").style.width = "0";
        }

        function toggleDropdown(element) {
            var dropdownContent = element.nextElementSibling;
            dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
        }

        // Close the dropdown if clicked outside
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display === "block") {
                        openDropdown.style.display = "none";
                    }
                }
            }
        };
    </script>
</body>
</html>