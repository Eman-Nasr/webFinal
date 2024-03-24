<?php
session_start();
include('../includes/config.php');

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    // Redirect to student login page if not logged in
    header("Location: student_login.php");
    exit;
}

// Fetch student's submitted assignments
$student_id = $_SESSION['student_id'];
$sql_assignments = "SELECT assignments.assignment_name, assignments.due_date, assignments.link, grades.grade
                    FROM assignments
                    LEFT JOIN grades ON assignments.assignment_id = grades.assignment_id
                    WHERE grades.user_id = $student_id";
$result_assignments = $conn->query($sql_assignments);
$assignments = array();
if ($result_assignments->num_rows > 0) {
    while ($row_assignment = $result_assignments->fetch_assoc()) {
        $assignments[] = $row_assignment;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Assignment Marks</title>
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
        <h2 class="text-center mb-4">My Assignment Marks</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Assignment Name</th>
                        <th>Due Date</th>
                        <th>Link</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assignments as $assignment) { ?>
                        <tr>
                            <td><?php echo $assignment['assignment_name']; ?></td>
                            <td><?php echo $assignment['due_date']; ?></td>
                            <td><a href="<?php echo $assignment['link']; ?>" target="_blank">View Assignment</a></td>
                            <td><?php echo isset($assignment['grade']) ? $assignment['grade'] : "Not Graded"; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
