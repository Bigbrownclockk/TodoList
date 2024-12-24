<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List with Progress Bar</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<div id="main-container">
<!-- Sidebar -->
<div id="sidebar">
    <div class="tab active" id="ongoing-tab" onclick="showTab('ongoing')">
        Ongoing Tasks
    </div>
    <div class="tab" id="completed-tab" onclick="showTab('completed')">
        Completed Tasks
    </div>

    <!-- Tab Content for Ongoing and Completed -->
    <div id="tab-content">
        <!-- Ongoing Tasks -->
        <ul id="ongoing-tasks" class="tab-content visible">
            <h3>Ongoing Tasks</h3>
            <!-- Tasks dynamically added by JS -->
        </ul>

        <!-- Completed Tasks -->
        <ul id="completed-tasks" class="tab-content">
            <h3>Completed Tasks</h3>
            <!-- Tasks dynamically added by JS -->
        </ul>
    </div>
</div>
<div id="container">
    <h1>To-Do List</h1>
    <form id="taskForm">
        <input type="text" id="taskInput" placeholder="Enter your task" required>
        <button type="submit">Add Task</button>
    </form>

    <div id="progressContainer">
        <label for="progressBar">Task Completion Progress:</label>
        <div style="background-color: #ddd; border-radius: 8px; overflow: hidden; height: 20px;">
            <div id="progressBar"></div>
        </div>
        <p id="progressText">0% completed</p>
    </div>

    <ul id="taskList"></ul>
</div>

<!-- SVG Waves -->
<div class="waves">
    <svg viewBox="0 0 1440 320">
        <path fill="#ffffff" fill-opacity="1" d="M0,160L48,176C96,192,192,224,288,218.7C384,213,480,171,576,154.7C672,139,768,149,864,176C960,203,1056,245,1152,245.3C1248,245,1344,203,1392,181.3L1440,160L1440,320L0,320Z"></path>
    </svg>
</div>
</div>

<script src="script.js">

</script>
<a href="user_logout.php" class="logout-button">Logout</a></body>
</html>