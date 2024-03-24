<?php
session_start();
include('../includes/config.php');

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    // Redirect to student login page if not logged in
    header("Location: StudentLoginPage.php");
    exit;
}

// Fetch student's ID
$student_id = $_SESSION['student_id'];

// Fetch registered courses for the student
$sql_registered_courses = "SELECT c.course_id, c.course_name , c.course_description
                            FROM courses c 
                            INNER JOIN registered_courses rc ON c.course_id = rc.course_id 
                            WHERE rc.student_id = $student_id";
$result_registered_courses = $conn->query($sql_registered_courses);
$registered_courses = array();
if ($result_registered_courses->num_rows > 0) {
    while ($row_registered_course = $result_registered_courses->fetch_assoc()) {
        $registered_courses[] = $row_registered_course;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registered Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/navbar.css">
    
</head>
<body>
    <?php include('StudentNavbar.php'); ?>
   
        <div class="wrapper">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h2>Registered Courses</h2>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($registered_courses)) { ?>
                            <div class="row">
                                <?php foreach ($registered_courses as $course) { ?>
                                    <div class="col-md-4">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h5 class="card-title"><strong><?php echo $course['course_name']; ?></strong></h5>
                                                <p class="card-text"><?php echo $course['course_description']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <p class="text-center">No courses registered yet.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
 
</body>

</html>

