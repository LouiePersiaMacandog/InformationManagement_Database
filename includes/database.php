<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'rental_db';

// Connect to MySQL server first
$conn = new mysqli($host, $user, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $database");

// Select the database
$conn->select_db($database);

// Set charset
$conn->set_charset("utf8");

// Function for prepared statements
function executeQuery($sql, $types = "", ...$params) {
    global $conn;
    $stmt = $conn->prepare($sql);
    if (!empty($types)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result();
}

// Function to generate IDs
function generateId($prefix, $table, $column) {
    global $conn;
    $result = $conn->query("SELECT MAX($column) as max_id FROM $table");
    $row = $result->fetch_assoc();
    $lastId = $row['max_id'];
    if ($lastId) {
        $num = intval(substr($lastId, 1)) + 1;
        return $prefix . str_pad($num, 5, '0', STR_PAD_LEFT);
    }
    return $prefix . '00001';
}
?>