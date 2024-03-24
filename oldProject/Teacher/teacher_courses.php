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
    <title>Teacher Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.0/main.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
 

<style>
        /* Styles for the calendar and online users list */
        .calendar {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        /* Define different background colors for course cards */
        .course-card {
            transition: transform .2s, border-radius .2s; /* Animation for card */
            border-radius: 15px; /* Initial border radius */
            margin-bottom: 15px;
        }
        .course-card:hover {
            transform: scale(1.05); /* Card grow effect on hover */
            border-radius: 25px; /* Change border radius on hover */
            box-shadow: 0 0 20px rgba(0,0,0,0.5); /* Add stronger shadow on hover */
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

    /* Add a slight frame highlight */
    .course-card {
    border-radius: 15px;
    border: 1px solid #ccc;
}
 
/* CSS for the layout */
.course-info {
    display: flex;
}

/* Additional CSS for the computer icon */
.icon-container {
    display: flex;
    justify-content: center; /* Center the content horizontally */
    align-items: center; /* Center the content vertically */
    margin-right: 20px; /* Adjust as needed */
}

 
.text-container {
    flex-grow: 1;
}

 .course-icon {
 }

.course-card {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

    
    .course-card:hover {
        border-color: #999; /* Change border color on hover */
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
    <div class="row">
        <div class="col-md-6">
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



                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Calendar</h3>
                </div>
                <div class="card-body">
                    <iframe src="https://calendar.google.com/calendar/embed?src=67d55346daf51aecd970f69d9c5752fdd1c44c03a153f80749407dc060a1f718%40group.calendar.google.com&ctz=Asia%2FDubai style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
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