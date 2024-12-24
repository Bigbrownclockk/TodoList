<?php

// update_task.php
session_start();
$conn = new mysqli('localhost', 'root', '', 'todo_db');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit;
}

// Get the data
$data = json_decode(file_get_contents('php://input'), true);
$task_id = $data['task_id'];
$completed = $data['completed'] ? 1 : 0;

// Update the task's completion status in the database
$sql = "UPDATE tasks SET completed = $completed WHERE id = $task_id AND user_id = {$_SESSION['user_id']}";
if ($conn->query($sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
