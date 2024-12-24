<?php

// delete_task.php


// Database connection

$conn = new mysqli('localhost', 'root', '', 'todo_db');

// Check connection

if($conn->connect_error)
    {
        die(json_encode(['success'=>false, 'error'=> 'Database connection failed']));
    }

// Get the JSON data from the request

$data = json_decode(file_get_contents('php://input'), true);

$id = (int)$data['id'];

// Delete the task

$sql = "DELETE FROM tasks WHERE id = $id";

if($conn->query($sql))
    {
        echo json_encode(['success'=>true]);
    }
else
    {
        echo json_encode (['success'=>false, 'error'=>$conn->error]);
    }

$conn->close();
