<?php
session_start();
include('../includes/config.php');

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    // Redirect to student login page if not logged in
    header("Location: student_login.php");
    exit;
}

// Fetch student's registered courses
$student_id = $_SESSION['student_id'];
$sql_courses = "SELECT courses.course_id, courses.course_name, courses.course_description, courses.semester
                FROM courses
                INNER JOIN registered_courses ON courses.course_id = registered_courses.course_id
                WHERE registered_courses.student_id = $student_id";
$result_courses = $conn->query($sql_courses);
$courses = array();
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
    <title>My Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

    <!-- Student Navbar -->
    <?php include('student_navbar.php'); ?>

    <div class="content">
        <h2 class="text-center mb-4">My Courses</h2>
        <div class="row">
            <?php if (!empty($courses)) { ?>
                <?php foreach ($courses as $course) { ?>
                    <div class="col-md-6">
                        <div class="course-details">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><?php echo $course['course_name']; ?></h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>Description:</strong> <?php echo $course['course_description']; ?></p>
                                    <p><strong>Semester:</strong> <?php echo $course['semester']; ?></p>
                                    <a href="student_course_assignments.php?course_id=<?php echo $course['course_id']; ?>" class="btn btn-primary btn-block">View Assignments</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="col-md-12">
                    <p class="text-center">No courses available.</p>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
