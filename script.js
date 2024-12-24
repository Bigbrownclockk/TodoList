// Your existing JavaScript functionality remains unchanged
document.getElementById('taskForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const taskInput = document.getElementById('taskInput');
    const taskText = taskInput.value.trim();

    if (taskText) {
        const ul = document.getElementById('taskList');
        const li = document.createElement('li');
        const span = document.createElement('span');
        span.textContent = taskText;

        const buttonsContainer = document.createElement('div');
        buttonsContainer.className = 'task-buttons';

        const completeButton = document.createElement('button');
        completeButton.textContent = 'Complete';
        completeButton.className = 'complete-button';
        completeButton.addEventListener('click', function () {
            li.classList.toggle('completed');
            updateProgressBar();
        });

        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.className = 'delete-button';
        deleteButton.addEventListener('click', function () {
            li.remove();
            showEmptyState();
            updateProgressBar();
        });

        buttonsContainer.appendChild(completeButton);
        buttonsContainer.appendChild(deleteButton);
        li.appendChild(span);
        li.appendChild(buttonsContainer);
        ul.appendChild(li);

        taskInput.value = '';
        showEmptyState();
        updateProgressBar();
    } else {
        alert('Task cannot be empty!');
    }
});

function showEmptyState() {
    const taskList = document.getElementById('taskList');
    const emptyState = document.getElementById('emptyState');
    if (!taskList.children.length && !emptyState) {
        const li = document.createElement('li');
        li.id = 'emptyState';
        li.textContent = 'No tasks yet! 🎉 Start by adding a task above.';
        li.style.textAlign = 'center';
        taskList.appendChild(li);
    } else if (taskList.children.length && emptyState) {
        emptyState.remove();
    }
}

function updateProgressBar() {
    const tasks = document.querySelectorAll('#taskList li');
    const completedTasks = document.querySelectorAll('#taskList li.completed');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');

    const totalTasks = tasks.length;
    const completedCount = completedTasks.length;
    const progress = totalTasks > 0 ? Math.round((completedCount / totalTasks) * 100) : 0;

    progressBar.style.width = progress + '%';
    progressText.textContent = `${progress}% completed`;
}

document.addEventListener('DOMContentLoaded', function () {
    showEmptyState();
    updateProgressBar();
});