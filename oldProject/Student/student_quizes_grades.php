<?php
session_start();
include('../includes/config.php');

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    // Redirect to student login page if not logged in
    header("Location: student_login.php");
    exit;
}

// Fetch student's ID
$student_id = $_SESSION['student_id'];

// Fetch student's quiz marks along with course name
$sql_quizes = "SELECT q.quiz_name, q.marks_obtained, c.course_name
               FROM quizes q
               INNER JOIN courses c ON q.course_id = c.course_id
               INNER JOIN registered_courses rc ON c.course_id = rc.course_id
               WHERE rc.student_id = $student_id";
$result_quizes = $conn->query($sql_quizes);
$quizes = array();
if ($result_quizes->num_rows > 0) {
    while ($row_quiz = $result_quizes->fetch_assoc()) {
        $quizes[] = $row_quiz;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Quiz Marks</title>
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
        <h2 class="text-center mb-4">My Quiz Marks</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Quiz Name</th>
                        <th>Marks Obtained</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quizes as $quiz) { ?>
                        <tr>
                            <td><?php echo $quiz['course_name']; ?></td>
                            <td><?php echo $quiz['quiz_name']; ?></td>
                            <td><?php echo $quiz['marks_obtained']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
