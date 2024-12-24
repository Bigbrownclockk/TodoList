
document.getElementById('taskForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const taskInput = document.getElementById('taskInput');
    const taskText = taskInput.value.trim();

    if (taskText) {
        // Add task to the central task list
        addTaskToMainList(taskText);

        // Add task to the "Ongoing Tasks" tab
        addTaskToSidebar('ongoing-tasks', taskText);

        // Clear the input field
        taskInput.value = '';
    } else {
        alert('Task cannot be empty!');
    }
});
function addTaskToMainList(taskText) {
    const ul = document.getElementById('taskList');
    const li = document.createElement('li');
    const span = document.createElement('span');
    span.textContent = taskText;

    const buttonsContainer = document.createElement('div');
    buttonsContainer.className = 'task-buttons';

    // Complete button
    const completeButton = document.createElement('button');
    completeButton.textContent = 'Complete';
    completeButton.className = 'complete-button';
    completeButton.addEventListener('click', function () {
        li.classList.add('completed'); // Mark as completed visually
        moveTaskToCompleted(taskText); // Move task to completed list in sidebar
        updateProgressBar();           // Update progress bar
    });

    // Delete button
    const deleteButton = document.createElement('button');
    deleteButton.textContent = 'Delete';
    deleteButton.className = 'delete-button';
    deleteButton.addEventListener('click', function () {
        li.remove();                   // Remove task from main list
        removeTaskFromSidebar(taskText); // Remove task from sidebar
        updateProgressBar();
        showEmptyState();// Update progress bar
    });

    buttonsContainer.appendChild(completeButton);
    buttonsContainer.appendChild(deleteButton);
    li.appendChild(span);
    li.appendChild(buttonsContainer);
    ul.appendChild(li);
    showEmptyState();
    updateProgressBar(); // Recalculate progress bar on task addition
}
function addTaskToSidebar(listId, taskText) {
    const list = document.getElementById(listId);
    const li = document.createElement('li');
    li.textContent = taskText;
    list.appendChild(li);
}
function moveTaskToCompleted(taskText) {
    // Remove task from "Ongoing Tasks"
    const ongoingList = document.getElementById('ongoing-tasks');
    Array.from(ongoingList.children).forEach((li) => {
        if (li.textContent === taskText) {
            ongoingList.removeChild(li);
        }
    });

    // Add task to "Completed Tasks"
    addTaskToSidebar('completed-tasks', taskText);
}
function removeTaskFromSidebar(taskText) {
    const ongoingList = document.getElementById('ongoing-tasks');
    const completedList = document.getElementById('completed-tasks');

    // Remove from "Ongoing Tasks"
    Array.from(ongoingList.children).forEach((li) => {
        if (li.textContent === taskText) {
            ongoingList.removeChild(li);
        }
    });

    // Remove from "Completed Tasks"
    Array.from(completedList.children).forEach((li) => {
        if (li.textContent === taskText) {
            completedList.removeChild(li);
        }
    });
}
function markTaskComplete(btn) {
    const taskItem = btn.parentElement.parentElement;
    const completedTasks = document.getElementById('completed-tasks');

    // Move to completed list
    completedTasks.appendChild(taskItem);

    // Change button actions
    taskItem.querySelector('.complete').remove(); // Remove the complete button
    taskItem.querySelector('.btn.delete').textContent = "Delete"; // Keep delete button

    updateProgressBar();
}
function deleteTask(btn) {
    const taskItem = btn.parentElement.parentElement;
    taskItem.remove();
    updateProgressBar();
}
// Tabs functionality
function showTab(tabName) {
    const ongoingTab = document.getElementById('ongoing-tab');
    const completedTab = document.getElementById('completed-tab');
    const ongoingContent = document.getElementById('ongoing-tasks');
    const completedContent = document.getElementById('completed-tasks');

    if (tabName === 'ongoing') {
        ongoingTab.classList.add('active');
        completedTab.classList.remove('active');
        ongoingContent.classList.add('visible');
        completedContent.classList.remove('visible');
    } else if (tabName === 'completed') {
        ongoingTab.classList.remove('active');
        completedTab.classList.add('active');
        ongoingContent.classList.remove('visible');
        completedContent.classList.add('visible');
    }
}
function showEmptyState() {
    const taskList = document.getElementById('taskList');
    let emptyState = document.getElementById('emptyState');

    // Check if the task list is empty
    if (!taskList.children.length) {
        // If empty and "No tasks yet!" is missing, add it
        if (!emptyState) {
            emptyState = document.createElement('li');
            emptyState.id = 'emptyState';
            emptyState.textContent = 'No tasks yet! 🎉 Start by adding a task above.';
            emptyState.style.textAlign = 'center';
            taskList.appendChild(emptyState);
        }
    } else {
        // If tasks are present and "No tasks yet!" exists, remove it
        if (emptyState) {
            emptyState.remove();
        }
    }
}

function updateProgressBar() {
    const ongoingTasks = document.querySelectorAll('#ongoing-tasks li');
    const completedTasks = document.querySelectorAll('#completed-tasks li');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');

    const totalTasks = ongoingTasks.length + completedTasks.length;
    const completedCount = completedTasks.length;
    const progress = totalTasks > 0 ? Math.round((completedCount / totalTasks) * 100) : 0;

    progressBar.style.width = progress + '%';
    progressText.textContent = `${progress}% completed`;
}

document.addEventListener('DOMContentLoaded', function () {
    showEmptyState();
    updateProgressBar();
});