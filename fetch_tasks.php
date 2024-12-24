<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'todo_db');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit;
}

// Get the user's ID from the session
$user_id = $_SESSION['user_id'];

// Fetch tasks for the logged-in user
$result = $conn->query("SELECT id, task, completed FROM tasks WHERE user_id = $user_id");
$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

// Return the tasks as JSON
echo json_encode(['success' => true, 'tasks' => $tasks]);