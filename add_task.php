<?php
// add_task.php


// Database connection

$conn = new mysqli('localhost', 'root','','todo_db');

// Check connection

if ($conn->connect_error)
    {
        die(json_encode(['success'=>false, 'error'=>'Database connection failed]']));
    }

// Get the JSON data from the request


$data = json_decode(file_get_contents('php://input'),true);
$task = $conn->real_escape_string($data['task']);

// Insert task into the database

$sql = "INSERT INTO tasks (task) VALUES ('$task')";

if ($conn->query($sql))
    {
        echo json_encode(['success'=> true, 'id'=>$conn->insert_id]);
    }
else
    {
        echo json_encode(['success'=>false, 'error'=>$conn->error]);
    }

$conn->close();