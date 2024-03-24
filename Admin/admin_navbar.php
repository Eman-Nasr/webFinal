<!-- Sidebar -->
<div class="sidebar">
    <h3>Admin</h3>
    <ul>
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li class="has-collapse">
            <a href="#" class="collapsed" data-toggle="collapse" data-target="#usersDropdown" aria-expanded="false" aria-controls="usersDropdown">
                Users
            </a>
            <div class="collapse" id="usersDropdown"> <!-- Removed "show" class -->
                <ul>
                    <li><a href="admin_students.php">Students</a></li>
                    <li><a href="admin_teachers.php">Teachers</a></li>
                    <li><a href="admin_admins.php">Admins</a></li>
                </ul>
            </div>
        </li>
        <li><a href="admin_majors.php">Majors</a></li>
        <li><a href="admin_assign_major.php">Assign Majors</a></li>
        <li><a href="admin_courses.php">Courses</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>
