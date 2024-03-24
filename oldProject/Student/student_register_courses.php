<?php
session_start();
include('../includes/config.php');

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    // Redirect to student login page if not logged in
    header("Location: student_login.php");
    exit;
}

// Fetch student's major
$student_id = $_SESSION['student_id'];
$sql_major = "SELECT major_id FROM student_major WHERE student_id = $student_id";
$result_major = $conn->query($sql_major);
$major = $result_major->fetch_assoc();
$major_id = $major['major_id'];

// Fetch available courses for the student's major
$sql_courses = "SELECT course_id, course_name FROM courses WHERE major_id = $major_id";
$result_courses = $conn->query($sql_courses);
$courses = array();
if ($result_courses->num_rows > 0) {
    while ($row_course = $result_courses->fetch_assoc()) {
        $courses[] = $row_course;
    }
}

// Process course registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_course'])) {
    $course_id = $_POST['course_id'];

    // Check if the student is already registered for the course
    $sql_check = "SELECT * FROM registered_courses WHERE course_id = $course_id AND student_id = $student_id";
    $result_check = $conn->query($sql_check);
    if ($result_check->num_rows > 0) {
        echo "You are already registered for this course.";
    } else {
        // Register the student for the course
        $sql_register = "INSERT INTO registered_courses (course_id, student_id) VALUES ($course_id, $student_id)";
        if ($conn->query($sql_register) === TRUE) {
            echo "Course registered successfully.";
        } else {
            echo "Error: " . $sql_register . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Course Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include('student_navbar.php'); ?>
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title mb-0">Register for Courses</h2>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="course">Select Course:</label>
                        <select class="form-control" name="course_id">
                            <?php foreach ($courses as $course) { ?>
                                <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="register_course">Register</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS link -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
