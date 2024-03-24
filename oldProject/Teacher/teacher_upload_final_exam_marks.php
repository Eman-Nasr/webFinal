<?php
session_start();
include('../includes/config.php');

// Check if teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    // Redirect to teacher login page if not logged in
    header("Location: teacher_login.php");
    exit;
}

// Fetch all courses of the teacher
$teacher_id = $_SESSION['teacher_id'];
$sql_courses = "SELECT * FROM courses WHERE instructor_id = $teacher_id";
$result_courses = $conn->query($sql_courses);

$teacher_courses = array();
if ($result_courses->num_rows > 0) {
    while ($row_course = $result_courses->fetch_assoc()) {
        $teacher_courses[] = $row_course;
    }
}

// Process form submission to upload final exam marks
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload_marks'])) {
    $course_id = $_POST['course_id'];
    $student_id = $_POST['student_id'];
    $marks_obtained = $_POST['marks_obtained'];
    $total_marks = $_POST['total_marks'];

    // Insert marks into final_exam_marks table
    $sql_insert = "INSERT INTO final_exam_marks (student_id, course_id, marks_obtained, total_marks) 
                   VALUES ($student_id, $course_id, $marks_obtained, $total_marks)";
    if ($conn->query($sql_insert) === TRUE) {
        // Marks uploaded successfully
        // Redirect or show success message
        header("Location: teacher_dashboard.php");
        exit;
    } else {
        // Error in uploading marks
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Final Exam Marks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .form-container {
            padding: 30px;
            border: 1px solid #ccc;
            margin:20px;
            border-radius: 10px;
        }
        .form-container label,
.form-container input,
.form-container button {
    line-height: 2; /* Increase line height */
    margin-bottom: 8px; /* Increase bottom margin */
}


        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

      
        .icon-container {
    margin-bottom: 20px;
    text-align: center;
    margin-right: 25px; /* Add right margin to move the icon to the left */
}

.icon-container img {
    border: 3px solid #007bff; /* Blue frame around the image */
    border-radius: 8px; /* Rounded corners for the image */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
}


        .icon-container i {
            font-size: 15em; /* Reduced size */
            color: #007bff;
        }

 
        .content {
            margin-top: 50px;
        }

        .center-form {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Added new CSS for the layout */
        @media (min-width: 576px) {
            .row {
                display: flex;
                align-items: center;
            }

            .col-md-3 {
                flex: 0 0 auto;
            }

            .col-md-9 {
                flex: 1;
            }


            /* For a specific pixel width */
            .finals-image {
    width: 100%; /* Makes the image responsive to the container width */
    height: auto; /* Maintains the aspect ratio of the image */
    object-fit: contain; /* Ensures the image is scaled correctly within the given dimensions */
    transition: transform 0.5s ease-in-out; /* Smooth transition for hover effect */
    border-radius: 50px;
}

.finals-image:hover {
    transform: scale(1.05); /* Slightly enlarge the image on hover for a subtle effect */
}

:root {
  --white-color: #fff;
  --paraText-color: #777;
  --heading-color: #333;
  --primary-color: rgb(218, 165, 32);
  --secondary-color: rgb(51, 83, 156);
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


        }
        
    </style>
</head>
<body>



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

    <div class="content">
    <div class="container">
    <div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
        <img src="images/finals.png" alt="Finals" class="finals-image">
        </div>
        <div class="col-md-6">
             <div class="form-container">
                        <h2>Upload Final Exam Marks</h2>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <label for="course">Select Course:</label>
                                <select class="form-control" id="course" name="course_id">
                                    <?php foreach ($teacher_courses as $course) { ?>
                                        <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="student">Select Student:</label>
                                <!-- Fetch and display students for the selected course -->
                                <select class="form-control" id="student" name="student_id">
                                    <?php
                                        $sql_students = "SELECT user_id, username FROM users where role = 'student'";
                                        $result_students = $conn->query($sql_students);

                                        if ($result_students->num_rows > 0) {
                                            while ($row_student = $result_students->fetch_assoc()) {
                                                echo '<option value="'.$row_student['user_id'].'">'.$row_student['username'].'</option>';
                                            }
                                        } else {
                                            echo '<option value="">No students found</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="marks_obtained">Marks Obtained:</label>
                                <input type="number" class="form-control" id="marks_obtained" name="marks_obtained" min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="total_marks">Total Marks:</label>
                                <input type="number" class="form-control" id="total_marks" name="total_marks" min="0" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="upload_marks">Upload Marks</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.icon-container img').hover(
        function() { // Mouse enter
            $(this).animate({ marginTop: "-10px" }, 200);
        },
        function() { // Mouse leave
            $(this).animate({ marginTop: "0px" }, 200);
        }
    );
});
</script>


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
