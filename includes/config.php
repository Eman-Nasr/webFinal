<?php

// Database configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = 'P246P.project';
$dbName = 'STMS';

// Create database connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
