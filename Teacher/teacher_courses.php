<?php
session_start();
include('../includes/config.php');

// Check if teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    // Redirect to teacher login page if not logged in
    header("Location: teacher_login.php");
    exit;
}

// Fetch courses for the teacher
$sql_courses = "SELECT * FROM Courses WHERE instructor_id = {$_SESSION['teacher_id']}";
$result_courses = $conn->query($sql_courses);
$courses = [];
if ($result_courses->num_rows > 0) {
    while ($row_course = $result_courses->fetch_assoc()) {
        $courses[] = $row_course;
    }
}

 

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.0/main.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
 



<style>


 

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.header-title {
    position: absolute;
    width: 100%;
    left: 0;
    text-align: center;
    font-size: 24px; /* Adjust font size as needed */
    font-weight: bold;
    color: var(--white-color); /* Assuming you have this color variable defined */
}

.hamburger {
    z-index: 1000; /* Ensure it's above the sidebar */
    position: relative; /* May already be set */
}
 
header {
    background-color: var(--secondary-color);

    z-index: 1; /* Ensure this is lower than the sidebar's z-index */
    /* Other properties remain unchanged */
}

.hamburger {
    z-index: 1; /* This ensures it is not above the sidebar */
    /* Other properties remain unchanged */
}


 
header {
    position: relative; /* Ensures absolute positioning is relative to the header */
    display: flex;
    justify-content: center; /* Center the items horizontally */
    align-items: center; /* Align items vertically */
    /* Other properties remain unchanged */
}


.sidebar {
    width: 0;
    height: 100%;
    position: fixed;
    z-index: 2;
    top: 0;
    transition: 0.5s;
    /* Adjust 'left' or 'right' based on slide direction */
    left: 0; /* For left slide-in */
    /* right: 0; For right slide-in */
    overflow-x: hidden;
    padding-top: 60px; /* Adjust as needed */
    /* Rest of the sidebar styling */
}

 
.main-content {
    transition: margin-left 0.3s ease; /* Adjust the duration and timing function as needed */
}

.main-content-shifted {
    margin-left: 250px; /* Adjust this value based on the actual sidebar width */
}

.sidebar-shifted {
            width: 250px;
        }
 

.container-flex {
    display: flex;
    flex-wrap: wrap; /* Allows items to wrap as needed */
    gap: 20px; /* Space between courses and calendar */
    margin: 20px; /* Outer margin for overall spacing */
}

.courses-container {
    flex: 3; /* Takes up more space in the flex container */
    display: flex;
    flex-direction: column;
    gap: 0px; /* Space between individual course cards */
}

.calendar-container {
    flex: 2; /* Allows the calendar to take up less space than courses */
    height: auto; /* Adjust height as needed */
}

/* Ensure calendar iframe resizes correctly */
.calendar-container iframe {
    width: 100%; /* Full width of its container */
    height: 300px; /* Adjust height to your preference */
    border: 0; /* Remove any default border */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container-flex {
        flex-direction: column; /* Stack them on smaller screens */
    }

    .calendar-container iframe {
        height: 500px; /* Adjust height for smaller screens */
    }
}

:root {
    --white-color: #fff;
    --paraText-color: #777;
    --heading-color: #333;
    --primary-color: rgb(31, 153, 167);
    --secondary-color: rgb(94, 7, 40);
}
body, html {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    overflow-x: hidden;
    font-family: 'Nunito', sans-serif; /* Example of modern font */
}

header {
    color: var(--white-color);
    background-color: var(--secondary-color);
    padding: 20px 0;
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    width: 100%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* subtle shadow for depth */
}

/* Enhancing the Course Cards with the new palette */
.course-card {
    background-color: var(--white-color);
    border: none;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Soft shadow for depth */
    border-radius: 8px; /* Rounded corners */
    transition: transform .3s; /* Smooth transition for hover effect */
}

.course-card:hover {
    transform: scale(1.03); /* Slight scale up on hover */
    box-shadow: 0 6px 12px rgba(0,0,0,0.2); /* Deeper shadow on hover */
}

/* Utilizing primary color for interactive elements */
.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background-color: darken(var(--primary-color), 10%);
    border-color: darken(var(--primary-color), 10%);
}

/* Additional style adjustments for course details */
.course-title {
    color: var(--heading-color);
    font-size: 18px;
    font-weight: bold;
}

.card-text {
    color: var(--paraText-color);
}

/* Custom scrollbar for a modern look */
::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: var(--white-color);
}

::-webkit-scrollbar-thumb {
    background: var(--primary-color);
}

::-webkit-scrollbar-thumb:hover {
    background: darken(var(--primary-color), 10%);
}

    .course-color-0 {
        background-color: #F0F8FF; /* Alice Blue */
    }
    .course-color-1 {
        background-color: #FFCCFF; /* Lavender Pink */
    }
    .course-color-2 {
        background-color: #FFFAF0; /* Floral White */
    }
    .course-color-3 {
        background-color: #F0F8FF; /* Alice Blue */
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
  background-color: #fff; /* Makes the lines white */
  transition: all 0.3s ease;
}

 

.sidebar {
  height: 100%;
  z-index: 500; /* Adjusted to be lower than the hamburger menu */

  width: 0;
  position: fixed;
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

.teacher-avatar-icon {
    color: var(--secondary-color); /* Adjust the color as needed */
    margin-right: 1rem; /* Adds spacing to the right of the icon */
}
.task-overview .progress-wrapper {
    margin-bottom: 10px;
}

.task-overview .task-label {
    font-size: 14px;
    margin-bottom: 5px;
    display: block;
}

.progress-bar {
    transition: width 1s ease-in-out;
}

/* Customize progress-bar colors as needed */
.progress-bar.bg-success {
    background-color: #28a745;
}

.progress-bar.bg-info {
    background-color: #17a2b8;
}
.dashboard-sections {
    display: flex;
    justify-content: space-between; /* Adjust alignment as needed */
}

.welcome-section {
    flex: 1; /* Adjust the size as needed */
    margin-right: 20px; /* Add spacing between sections */
}

.courses-section {
    width: 100%; /* Adjust this to your desired percentage or pixel value */
    max-width: 1400px; /* Example: Increase maximum width */
    margin: 0 auto; /* Centers the section if it's smaller than the viewport */
}
 


.calendar-section {
    width: 100%; /* Calendar takes full width */
    /* Additional styling for the calendar section */
}

/* Responsive design */
@media (max-width: 768px) {
    .dashboard-top-row {
        flex-direction: column;
    }

    .welcome-section {
        margin-right: 0; /* No margin on the right in small screens */
        margin-bottom: 20px; /* Adds space between welcome section and courses section */
    }

    /* Ensure the courses and calendar sections take full width on smaller screens */
    .courses-section, .calendar-section {
        width: 100%;
    }
}


.courses-section .card-body {
    width: 100%; /* Set the width to 100% */
}

/* Optional: Adjust padding for better spacing */
.courses-section .card-body {
    padding: 20px; /* Adjust padding as needed */
}


.course-card {
    margin-bottom: 2rem; /* Standardizes bottom margin */
    padding: 1.5rem; /* Increases padding inside the card for more space */
    box-shadow: 0 6px 12px rgba(0,0,0,0.1); /* Enhances shadow for depth */
}

#courses-section .col-md-12 {
    max-width: 100%; /* Ensures it takes full available width */
    /* Add more styles here as needed */
}
#courses-section {
    width: 100%; /* Full width of its parent container */
    max-width: 850px; /* Or any maximum width you prefer */
    margin: auto; /* Center it if the max-width is less than the parent container's width */
}


</style>
 

</head>
<body>
<header>
        <div class="header-content"> <!-- Container for header content and toggle -->
            <div class="hamburger" onclick="toggleMenu()">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
            <div class="header-title">Courses Dashboard</div> 
        </div>
    </header>
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

    <div class="main-content" id="main-content">
    <div class="container-flex">
        <div class="dashboard-sections">


    <div class="welcome-section card">
    <div class="card-body">
        <div class="user-info d-flex align-items-center">
            <!-- Using a FontAwesome icon as the avatar -->
            <i class="fas fa-user-circle teacher-avatar-icon fa-4x"></i>
            <div class="ml-3"> <!-- Added margin-left for spacing -->
                <h2>Welcome back, <?php echo $_SESSION['teacher_name']; ?>!</h2>
                 <div class="task-overview">
    <h3>Here's what's happening today:</h3>
    <div class="progress-wrapper mb-2">
        <span class="task-label">Grade Assignments</span>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
        </div>
    </div>
    <div class="progress-wrapper mb-2">
        <span class="task-label">Prepare for Meetings</span>
        <div class="progress">
            <div class="progress-bar bg-success" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40%</div>
        </div>
    </div>
    <div class="progress-wrapper">
        <span class="task-label">Check Messages</span>
        <div class="progress">
            <div class="progress-bar bg-info" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>
</div>
</div>


<div class="row" id="courses-section"> <!-- Adding an ID for specific targeting -->
    <div class="col-md-12"> 
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Your Courses</h3>
                 </div>
                <div class="card-body">
                    <?php foreach ($courses as $index => $course) { ?>
                        <?php
                            $class_index = $index % 4;
                            $class_name = "course-color-" . $class_index;
                        ?>
                        <!-- Inside the PHP foreach loop -->
                        <div class="card mb-4 course-card <?php echo $class_name; ?>">
                            <div class="card-body">
                                <div class="course-info">
                                    <div class="icon-container">
                                        <i class="fas fa-desktop fa-3x course-icon"></i>
                                    </div>
                                    <div class="text-container">
                                        <h5 class="course-title"><?php echo $course['course_name']; ?></h5>
                                        <p class="card-text"><?php echo $course['course_description']; ?></p>
                                        <a href="#" class="btn btn-primary add-assignment" data-course-id="<?php echo $course['course_id']; ?>">
                                            <i class="fas fa-arrow-right"></i> Add Assignment
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
                    </div>
                    <div class="calendar-container">
                    <div class="calendar-section card">

        <div class="col-md-6"> <!-- Calendar card -->
            <div class="card mb-6">
                <div class="card-header">
                    <h3 class="card-title">Calendar</h3>
                </div>
                <div class="card-body">
                    <iframe src="https://calendar.google.com/calendar/embed?src=67d55346daf51aecd970f69d9c5752fdd1c44c03a153f80749407dc060a1f718%40group.calendar.google.com&ctz=Asia%2FDubai" style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
                    </div>
                    </div>
                    </div>

<!-- Include Bootstrap and other scripts if needed -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        $('.add-assignment').click(function(e){
            e.preventDefault();
            var courseId = $(this).data('course-id');
            if(confirm('Are you sure you want to add an assignment to this course?')){
                window.location.href = 'teacher_course_assignment.php?course_id=' + courseId;
            }
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('.add-assignment').click(function(e){
            e.preventDefault();
            var courseId = $(this).data('course-id');
            if(confirm('Are you sure you want to add an assignment to this course?')){
                window.location.href = 'teacher_course_assignment.php?course_id=' + courseId;
            }
        });
    });
</script>


<script>
function toggleMenu() {
    var sidebar = document.getElementById("sidebar");
    var mainContent = document.getElementById("main-content"); // If you plan to shift the main content

    if (sidebar.style.width === "250px") {
        sidebar.style.width = "0";
        if (mainContent) mainContent.style.marginLeft = "0"; // Adjust if main content needs to shift
    } else {
        sidebar.style.width = "250px";
        if (mainContent) mainContent.style.marginLeft = "250px"; // Adjust if main content needs to shift
    }
}

function closeNav() {
    document.getElementById("sidebar").style.width = "0";
    var mainContent = document.getElementById("main-content"); // If shifting main content
    if (mainContent) mainContent.style.marginLeft = "0"; // Adjust if main content needs to shift
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