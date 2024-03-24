<?php
session_start();
include('includes/config.php');

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    // Redirect to student login page if not logged in
    header("Location: StudentLoginPage.php");
    exit;
}

// Check if course ID is provided in the URL
if (!isset($_GET['course_id'])) {
    // Redirect to a suitable page or display an error message
    exit("Course ID is missing.");
}

$course_id = $_GET['course_id'];

// Fetch course details
$sql_course = "SELECT course_name FROM courses WHERE course_id = $course_id";
$result_course = $conn->query($sql_course);

if ($result_course->num_rows > 0) {
    $course = $result_course->fetch_assoc();
} else {
    exit("Course not found.");
}

// Fetch assignments for the selected course
$sql_assignments = "SELECT assignment_id, assignment_name, due_date, description, link 
                    FROM assignments 
                    WHERE course_id = $course_id";
$result_assignments = $conn->query($sql_assignments);
$assignments = array();

if ($result_assignments->num_rows > 0) {
    while ($row = $result_assignments->fetch_assoc()) {
        $assignments[] = $row;
    }
}

// Process assignment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_link'])) {
    $assignment_id = $_POST['assignment_id'];
    $student_id = $_SESSION['student_id'];
    $link = $_POST['submission_link'];

    // Insert the submitted link into the submitted_assignments table
    $sql_submission = "INSERT INTO submitted_assignments (assignment_id, student_id, submission_link, submission_date) 
                       VALUES ($assignment_id, $student_id, '$link',  CURDATE())";
    
    if ($conn->query($sql_submission) === TRUE) {
        echo "Assignment submitted successfully.";
    } else {
        echo "Error: " . $sql_submission . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $course['course_name']; ?> Assignments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
    <!-- Student Navbar -->
    <?php include('StudentNavbar.php'); ?>

    <div class="wrapper">
        <h2>Assignments for <?php echo $course['course_name']; ?></h2>
        
        <?php if (!empty($assignments)) { ?>
            <div class="row">
                <?php foreach ($assignments as $assignment) { ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo $assignment['assignment_name']; ?></h3>
                            </div>
                            <div class="card-body">
                                <p><strong>Due Date:</strong> <?php echo $assignment['due_date']; ?></p>
                                <p><strong>Description:</strong> <?php echo $assignment['description']; ?></p>
                                <p><a href="<?php echo $assignment['link']; ?>" target="_blank">View Assignment</a></p>
                                <!-- Assignment Submission Form -->
                                <form method="post" action="student_course_assignments.php?course_id=<?php echo $_GET['course_id']; ?>">
                                    <input type="hidden" name="assignment_id" value="<?php echo $assignment['assignment_id']; ?>">
                                    <div class="form-group">
                                        <label for="submission_link">Submit Assignment Link:</label>
                                        <input type="text" class="form-control" name="submission_link" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit_link">Submit Link</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p>No assignments available for this course.</p>
        <?php } ?>
    </div>
</body>
</html>
