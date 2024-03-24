<!-- Sidebar -->
<div class="sidebar">
    <h3>Admin</h3>
    <ul>
        <li><a href="student_dashboard.php">Dashboard</a></li>
        <li><a href="student_register_courses.php">Register Courses</a></li>
        <li><a href="student_registered_courses.php">My Courses</a></li>
        <li class="has-collapse">
            <a href="#" class="collapsed" data-toggle="collapse" data-target="#usersDropdown" aria-expanded="false" aria-controls="usersDropdown">
                Grades
            </a>
            <div class="collapse" id="usersDropdown"> <!-- Removed "show" class -->
                <ul>
                    <li><a href="student_assignments_grades.php">Assignments</a></li>
                    <li><a href="student_quizes_grades.php">Quizes</a></li>
                    <li><a href="student_final_grades.php">Finals</a></li>
                </ul>
            </div>
        </li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>
