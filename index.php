<!-- index.php -->

<?php
// index.php
$conn = new mysqli('localhost', 'root', '', 'todo_db');
$tasks = $conn->query("SELECT * FROM tasks")->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px auto;
            max-width: 600px;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        button {
            background-color: red;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<h1>To-Do List</h1>

<!-- Form to add tasks -->
<form id="taskForm">
    <label for="taskInput">New Task</label>
    <input type="text" id="taskInput" placeholder="E.g., Buy groceries" required>
    <button type="submit">Add Task</button>
</form>

<!-- Task list -->
<ul id="taskList">
    <!-- Tasks will be dynamically inserted here -->
</ul>

<script>
    // JavaScript for handling dynamic task addition
    document.getElementById('taskForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const taskInput = document.getElementById('taskInput');
        const taskText = taskInput.value;

        // Send the task to the server
        const response = await fetch('add_task.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ task: taskText })
        });

        const result = await response.json();

        if (result.success) {
            // Add task to the DOM
            const ul = document.getElementById('taskList');
            const li = document.createElement('li');
            li.textContent = taskText;

            const button = document.createElement('button');
            button.textContent = 'Delete';
            button.onclick = async function () {
                // Delete task via PHP
                const res = await fetch('delete_task.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: result.id })
                });
                const deleteResult = await res.json();
                if (deleteResult.success) {
                    li.remove();
                }
            };

            li.appendChild(button);
            ul.appendChild(li);

            taskInput.value = ''; // Clear the input
        }
    });
</script>
</body>
</html>