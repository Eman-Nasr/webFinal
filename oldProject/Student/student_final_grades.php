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

// Fetch final exam marks of the student
$sql_final_exam_marks = "SELECT c.course_name, fem.marks_obtained, fem.total_marks
                        FROM final_exam_marks fem
                        INNER JOIN courses c ON fem.course_id = c.course_id
                        WHERE fem.student_id = $student_id";
$result_final_exam_marks = $conn->query($sql_final_exam_marks);
$final_exam_marks = array();
if ($result_final_exam_marks->num_rows > 0) {
    while ($row_final_exam_mark = $result_final_exam_marks->fetch_assoc()) {
        $final_exam_marks[] = $row_final_exam_mark;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Final Exam Marks</title>
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
        <h2 class="text-center mb-4">My Final Exam Marks</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Obtained Marks</th>
                        <th>Total Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($final_exam_marks as $final_exam_mark) { ?>
                        <tr>
                            <td><?php echo $final_exam_mark['course_name']; ?></td>
                            <td><?php echo $final_exam_mark['marks_obtained']; ?></td>
                            <td><?php echo $final_exam_mark['total_marks']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
