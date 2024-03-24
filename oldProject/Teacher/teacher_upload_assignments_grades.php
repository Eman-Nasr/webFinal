<?php
session_start();
include('../includes/config.php');

// Check if teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    // Redirect to teacher login page if not logged in
    header("Location: teacher_login.php");
    exit;
}

// Get teacher's courses
$teacher_id = $_SESSION['teacher_id'];
$sql_courses = "SELECT * FROM Courses WHERE instructor_id = $teacher_id";
$result_courses = $conn->query($sql_courses);

$teacher_courses = array();
if ($result_courses->num_rows > 0) {
    while ($row_course = $result_courses->fetch_assoc()) {
        $course_name = $row_course['course_name'];
        // Count number of students in each course
        $course_id = $row_course['course_id'];
        $sql_students = "SELECT COUNT(*) as num_students FROM courses WHERE course_id = $course_id";
        $result_students = $conn->query($sql_students);
        $num_students = $result_students->fetch_assoc()['num_students'];
        $teacher_courses[] = array('course_id' => $course_id, 'course_name' => $course_name, 'num_students' => $num_students);
    }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['select_course'])) {
    $selected_course_id = $_POST['course_id'];
    $_SESSION['course_id'] = $selected_course_id;
    // Fetch assignments for the selected course
    $sql_assignments = "SELECT * FROM assignments WHERE course_id = $selected_course_id";
    $result_assignments = $conn->query($sql_assignments);

    // Fetch students for the selected course
    $sql_students = "SELECT * FROM users WHERE users.role = 'student'";
    $result_students = $conn->query($sql_students);
}

// Upload assignment grades
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload_marks'])) {
    $selected_course_id = $_SESSION['course_id'];
    $assignment_id = $_POST['assignment_id'];
    $student_id = $_POST['student_id'];
    $grade = $_POST['grade'];

    // Validate grade
    if ($grade < 0 || $grade > 10) {
        echo "Invalid grade. Please enter a number between 0 and 10.";
    } else {
        $sql = "INSERT INTO grades (assignment_id, user_id, grade, course_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $assignment_id, $student_id, $grade, $selected_course_id);
        
        if ($stmt->execute()) {
            // Redirect to a success page or display a success message
            header("Location: teacher_upload_assignments_grades.php");
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>

        <head>

        <title>Assignments</title>


  :root {
    --white-color: #fff;
    --paraText-color: #777;
    --heading-color: #333;
    --primary-color: #d3ac7c;
    --secondary-color: rgb(0, 38, 128);
}

body {
    background-color: var(--white-color);
    color: var(--paraText-color);
    /* Rest of body styles */
}

.card-header {
    background-color: var(--secondary-color);
    color: var(--white-color);
    /* Rest of card-header styles */
}

.btn-primary, .btn-primary:hover {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    /* For hover effects, consider a slightly darker or lighter shade */
}

.card-title, .text-center h1 {
    color: var(--heading-color);
    /* Rest of card-title and h1 styles */
}

        .card {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .content {
    display: flex;
    justify-content: center; /* Center the content horizontally */
    flex-wrap: wrap; /* Allow items to wrap as needed */
    gap: 20px; /* Add some space between the left and right contents */
}

.left-content, .right-content {
    flex: 1; /* Allow both sides to grow equally */
    max-width: 50%; /* Set a max-width to avoid overly wide elements */
}

/* Ensure the image inside left-content scales nicely */
.left-content img {
    width: 100%;
    height: auto;
    border-radius: 8px; /* Optional: Adds rounded corners to the image */
}

/* Adjustments for smaller screens */
@media (max-width: 768px) {
    .left-content, .right-content {
        max-width: 100%;
    }
}


        
        .left-content i {
            font-size: 350px;
            color: #007bff;
        }
 


        .icon-container {
            font-size: 30px; /* Adjust the font size as needed */
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



#assignmentImage {
            transition: opacity 0.3s ease;
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


 
        <!-- Left Content with Icon -->
        <div class="left-content">

        <img src="images/Assignment.png" alt="Assignment Overview" style="max-width: 100%; height: auto;" id="assignmentImage">

  

    
        </div>

        <!-- Right Content (Form) -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h3>Upload Assignment Grades</h3>
                        </div>
                        <div class="col-auto">
                            <div class="icon-container">
                                <!-- Icon representing assignment grades -->
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                    </div> <!-- Close the row here -->
                </div>
                <div class="card-body">
                  <!-- Form -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
        <label for="course">Select Course:</label>
        <select class="form-control" id="course" name="course_id">
            <option value="">Select Course</option>
            <?php foreach ($teacher_courses as $course) { ?>
                <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
            <?php } ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary mb-3" name="select_course">Select Course</button> <!-- Add mb-3 class for margin-bottom -->
</form>
<?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['select_course'])) { ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group mt-3"> <!-- Add mt-3 class for margin-top -->
            <label for="assignment">Select Assignment:</label>
            <select class="form-control" id="assignment" name="assignment_id">
                <?php if ($result_assignments->num_rows > 0) { ?>
                    <?php while ($row_assignment = $result_assignments->fetch_assoc()) { ?>
                        <option value="<?php echo $row_assignment['assignment_id']; ?>"><?php echo $row_assignment['assignment_name']; ?></option>
                    <?php } ?>
                <?php } else { ?>
                    <option value="">No Assignments Found</option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="student">Select Student:</label>
            <select class="form-control" id="student" name="student_id">
                <?php if ($result_students->num_rows > 0) { ?>
                    <?php while  ($row_student = $result_students->fetch_assoc()) { ?>
                        <option value="<?php echo $row_student['user_id']; ?>"><?php echo $row_student['username']; ?></option>
                    <?php } ?>
                <?php } else { ?>
                    <option value="">No Students Found</option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="grade">Grade (0-10):</label>
            <input type="number" class="form-control" id="grade" name="grade" min="0" max="10" step="0.1">
        </div>
        <button type="submit" class="btn btn-primary" name="upload_marks">Upload Marks</button>
    </form>
 

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script>
$(document).ready(function() {
    // Example: Animate the form opacity on page load
    $('.right-content').css('opacity', '0').animate({opacity: '1'}, 1000);

    // Example: Validate form input before submission
    $('form').submit(function(e) {
        const grade = parseFloat($('#grade').val());
        if (isNaN(grade) || grade < 0 || grade > 10) {
            alert('Please enter a valid grade between 0 and 10.');
            e.preventDefault(); // Prevent form submission
        }
    });
});
</script>
<script>
$(document).ready(function() {
    // Example of fading in the entire content slowly
    $('.content').fadeIn(1000);

    // Subtle "slide in" effect for the form
    $('.right-content').hide().slideDown(1000);

    // Hover effect on buttons for a slight movement
    $('.btn').hover(
        function() { $(this).animate({ marginTop: "-=1px" }, 200); },
        function() { $(this).animate({ marginTop: "+=1px" }, 200); }
    );

    // Validate form input as an example of interactivity
    $('form').submit(function(e) {
        const grade = parseFloat($('#grade').val());
        if (isNaN(grade) || grade < 0 || grade > 10) {
            alert('Please enter a valid grade between 0 and 10.');
            e.preventDefault(); // Prevent form submission
        }
    });
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
<script>
        // Get the image element
        const assignmentImage = document.getElementById('assignmentImage');

        // Add event listener for mouseover
        assignmentImage.addEventListener('mouseover', function() {
            // Apply fade-in effect
            assignmentImage.style.opacity = '0.7'; // Adjust opacity as needed
        });

        // Add event listener for mouseout
        assignmentImage.addEventListener('mouseout', function() {
            // Apply fade-out effect
            assignmentImage.style.opacity = '1'; // Restore original opacity
        });
    </script>


</body>
</html>
