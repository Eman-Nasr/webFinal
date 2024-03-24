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
$sql_courses = "SELECT COUNT(*) as num_courses FROM Courses WHERE instructor_id = $teacher_id"; 
$result_courses = $conn->query($sql_courses); 
$num_courses = 0; 
if ($result_courses->num_rows > 0) { 
    $row_course = $result_courses->fetch_assoc(); 
    $num_courses = $row_course['num_courses']; 
} 
?> 


<!DOCTYPE html>
<html>
<head>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="../css/styles.css">
    <style>
 

        body {
            background-color: var(--white-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--paraText-color);
            transition: background-color 0.5s ease;
        }

        .card {
            background-color: var(--white-color);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transition: box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        .card-header {
            background-color: var(--secondary-color);
            color: var(--white-color);
            border-bottom: none;
        }

     


 
 
        .dashboard-image-frame {
    width: 400px; /* Adjusted width of the container */
    height: 450px; /* Increased height of the container */
    border-radius: 10px; /* Add border radius */
    overflow: hidden; /* Ensure the border doesn't overflow */
    position: relative; /* Set container position to relative */
}


.dashboard-image-frame img {
    width: 100%; /* Make the image fill the container width */
    height: 100%; /* Make the image fill the container height */
    object-fit: cover; /* Maintain aspect ratio */
    transition: transform 0.3s ease-in-out;
    position: absolute; /* Set image position to absolute */
    margin-top: 80px; /* Move the top of the image down by 50% of the container height */
  }




.dashboard-image-frame:hover img {
    transform: scale(1.03); /* Subtle zoom effect on hover */
}



        a, .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }

        a:hover, .btn-primary:hover {
            background-color: var(--hover-color);
            border-color: var(--hover-color);
        }

        .logo:hover {
            transform: scale(1.1);
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
  background-color: transparent; /* Set background color to transparent */
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
  background-color: transparent; /* Set background color to transparent */
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





.col-md-7 {
    flex: 0 0 70%;
    max-width: 70%;
}

.col-md-5 {
    flex: 0 0 30%;
    max-width: 30%;
}
 

.logos-row {
    margin-top: 20px;
    display: flex;
    justify-content: center; /* Align icons horizontally */
}

.logos-row .text-center {
    margin-right: 20px; /* Adjust spacing between icons */
}

.logos-row .logo {
    font-size: 30px; /* Adjust icon size */
}


.logos-row .col-md-4 {
    padding: 0 15px;
}



@media (max-width: 768px) {
            .dashboard-image-frame {
                display: none; /* Hide the image container on smaller screens */
            }

            .col-md-6 {
                width: 100%; /* Make the course section take full width on smaller screens */
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


    
    <body>
    <div class="container mt-5" style="margin-top: 100px;">
    <div class="row">
        <!-- Left Column for Title and Courses -->
<!-- Left Column for Title and Courses -->
<div class="col-md-6">
    <h1 class="text-left mb-4">Teacher Dashboard</h1>
    <div class="card">
        <div class="card-header">
            <h3>Your Courses</h3>
        </div>
        <div class="card-body" style="height: 300px;"> <!-- Adjusted height -->
            <p>Total Courses: <?php echo $num_courses; ?></p>
        </div>
    </div>
    <!-- Logos Row -->
    <div class="mt-5 logos-row">
        <div class="text-center mb-3">
            <i class="fas fa-chalkboard-teacher logo" id="courseManagement"></i>
            <p>Course Management</p>
        </div>
        <div class="text-center mb-3">
            <i class="fas fa-book logo" id="resources"></i>
            <p>Resources</p>
        </div>
        <div class="text-center mb-3">
            <i class="fas fa-apple-alt logo" id="nutritionTips"></i>
            <p>Nutrition Tips</p>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="dashboard-image-frame">
        <img id="dashboardImage" src="images/dashboard.png" alt="Dashboard Overview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
    </div>
</div>





<script>
        // Fade in effect for the content
        document.addEventListener('DOMContentLoaded', function() {
            const content = document.querySelector('.container');
            content.style.opacity = 1;
        });

        // Animation for the welcome message
        document.addEventListener('DOMContentLoaded', function() {
            const welcomeMessage = document.querySelector('.card-title');
            welcomeMessage.style.animation = 'fadeIn 1s ease-out';
        });

        // Extra JavaScript for the logos
        const courseManagement = document.getElementById('courseManagement');
        const resources = document.getElementById('resources');
        const nutritionTips = document.getElementById('nutritionTips');

        courseManagement.addEventListener('click', function() {
            // Your JavaScript logic for Course Management
            console.log('Course Management clicked');
        });

        resources.addEventListener('click', function() {
            // Your JavaScript logic for Resources
            console.log('Resources clicked');
        });

        nutritionTips.addEventListener('click', function() {
            // Your JavaScript logic for Nutrition Tips
            console.log('Nutrition Tips clicked');
});

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

function loadPage(url) {
    // Make an AJAX request to load the page content
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("content").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", url, true);
    xhttp.send();
}

document.addEventListener('DOMContentLoaded', function() {
    // Adjust content margin based on sidebar width on page load
    var sidebar = document.getElementById("sidebar");
    var content = document.getElementById("content");
    if (sidebar.style.width === "250px") {
        content.style.marginLeft = "250px";
    } else {
        content.style.marginLeft = "0";
    }
});

// Function to toggle the sidebar menu
function toggleMenu() {
    var sidebar = document.getElementById("sidebar");
    var content = document.getElementById("content");
    if (sidebar.style.width === "250px") {
        sidebar.style.width = "0";
        content.style.marginLeft = "0";
    } else {
        sidebar.style.width = "250px";
        content.style.marginLeft = "250px";
    }
}

// Function to close the sidebar menu
function closeNav() {
    document.getElementById("sidebar").style.width = "0";
}

// Close the sidebar menu if clicked outside
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


 