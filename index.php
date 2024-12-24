<!DOCTYPE html>
<html lang="en">
<!-- Linking external CSS and JS files -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List with Progress Bar</title>
    <link rel="stylesheet" href="styles.css">
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40vh;
            z-index: -1;
            opacity: 0.9;
        }
        .waves svg {
            display: block;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        /* Gradient Animation */
        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Content Container */
        #container {
            max-width: 600px;
            margin: 50px auto;
            color: #333;
            background: rgba(255, 255, 255, 0.85);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        h1 {
            text-align: center;
            color: #444;
        }

        form {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 12px;
            flex: 3;
            margin-right: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        button {
            flex: 1;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            cursor: pointer;
        }

        button:hover {
            background: #218838;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        li.completed span {
            text-decoration: line-through;
            color: #888;
        }

        #progressContainer {
            margin: 20px 0;
        }

        #progressBar {
            background-color: #28a745;
            width: 0%;
            height: 100%;
            transition: width 0.3s ease-in-out;
        }
        /* Buttons */
        .complete-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .complete-button:hover {
            background-color: #0056b3;
        }

        .delete-button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #a71d2a;
        }

    </style>
</head>
<body>
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
    <script src="script.js"></script>
</body>
</html>