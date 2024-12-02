<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Manager</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <a href="http://localhost/aht-training/final-case/?act=logout">Logout</a>

    <h1>Todo Manager</h1>

    <!-- Dropdown to filter tasks by status -->
    <label for="statusFilter">Filter by Status: </label>
    <select id="statusFilter">
        <option value="all">All</option>
        <option value="0">Not Complete</option>
        <option value="1">Complete</option>
    </select>

    <!-- Form to add a new task -->
    <form id="taskForm" action="" method="POST">
        <label>Title: <input type="text" name="title" required></label><br>
        <label>Content: <input type="text" name="content" required></label><br>
        <label>Priority:
            <select name="priority">
                <option value="LOW">LOW</option>
                <option value="MEDIUM">MEDIUM</option>
                <option value="HIGH">HIGH</option>
            </select>
        </label><br>
        <button type="submit">Create</button>
    </form>

    <br>

    <!-- Task list table -->
    <table id="taskTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="taskList"></tbody>
    </table>

    <!-- Update task form (initially hidden) -->
    <form id="updateTaskForm" style="display:none;" method="POST">
        <h3>Update Task</h3>
        <label>ID: <input type="text" name="id" readonly></label><br>
        <label>Title: <input type="text" name="title" required></label><br>
        <label>Content: <input type="text" name="content" required></label><br>
        <label>Status:
            <input type="radio" name="status" value="0"> Not Complete
            <input type="radio" name="status" value="1"> Complete
        </label><br>
        <label>Priority:
            <select name="priority">
                <option value="LOW">LOW</option>
                <option value="MEDIUM">MEDIUM</option>
                <option value="HIGH">HIGH</option>
            </select>
        </label><br>
        <button type="submit">Update</button>
        <button type="button" id="cancelUpdate">Cancel</button>
    </form>

    <script>
        $(document).ready(function() {
            let allTasks = [];

            function getAllTask() {
                $.ajax({
                    url: 'http://localhost/aht-training/final-case/?act=getAll',
                    method: 'GET',
                    success: function(responseJson) {
                        if (typeof responseJson === 'string') {
                            responseJson = JSON.parse(responseJson);
                        }

                        allTasks = responseJson; 
                        displayTasks(allTasks);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching tasks:', error);
                    }
                });
            }

            function displayTasks(tasks) {
                let taskList = '';

                tasks.forEach(task => {
                    taskList += `
                        <tr data-id="${task.id}" data-status="${task.status}">
                            <td>${task.id}</td>
                            <td>${task.title}</td>
                            <td>${task.content}</td>
                            <td>${task.priority}</td>
                            <td>${task.status === "1" ? "Complete" : "Not Complete"}</td>
                            <td>
                                <button class="updateBT" data-id="${task.id}">Update</button>
                                <button class="deleteBT" data-id="${task.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                });

                $('#taskList').html(taskList);

                $('.deleteBT').on('click', function() {
                    const taskId = $(this).data('id');
                    deleteTask(taskId);
                });

                $('.updateBT').on('click', function() {
                    const taskId = $(this).data('id');
                    loadTaskForUpdate(taskId);
                });
            }

            $('#statusFilter').on('change', function() {
                const status = $(this).val();
                let filteredTasks = allTasks;

                if (status !== 'all') {
                    filteredTasks = allTasks.filter(task => task.status.toString() === status);
                }

                displayTasks(filteredTasks); 
            });

            function deleteTask(id) {
                $.ajax({
                    url: `http://localhost/aht-training/final-case/?act=delete&id=${id}`,
                    method: 'GET',
                    success: function() {
                        alert("Task deleted successfully");
                        getAllTask();
                    },
                    error: function() {
                        alert("Failed to delete task");
                    }
                });
            }

            function loadTaskForUpdate(id) {
                $.ajax({
                    url: `http://localhost/aht-training/final-case/?act=detail&id=${id}`,
                    method: 'GET',
                    success: function(task) {
                        if (typeof task === 'string') {
                            task = JSON.parse(task);
                        }
                        $('#updateTaskForm').find('[name="id"]').val(task.id);
                        $('#updateTaskForm').find('[name="title"]').val(task.title);
                        $('#updateTaskForm').find('[name="content"]').val(task.content);
                        $('#updateTaskForm').find('[name="status"][value="' + task.status + '"]').prop('checked', true);
                        $('#updateTaskForm').find('[name="priority"]').val(task.priority);
                        $('#updateTaskForm').show();
                    },
                    error: function() {
                        alert('Failed to load task details');
                    }
                });
            }

            $('#taskForm').on('submit', function(event) {
                event.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: 'http://localhost/aht-training/final-case/?act=create',
                    method: 'POST',
                    data: formData,
                    success: function() {
                        alert('Task created successfully');
                        $('#taskForm')[0].reset();
                        getAllTask();
                    },
                    error: function() {
                        alert('Failed to create task');
                    }
                });
            });

            $('#updateTaskForm').on('submit', function(event) {
                event.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: 'http://localhost/aht-training/final-case/?act=update',
                    method: 'POST',
                    data: formData,
                    success: function() {
                        alert('Task updated successfully');
                        $('#updateTaskForm').hide();
                        getAllTask();
                    },
                    error: function() {
                        alert('Failed to update task');
                    }
                });
            });

            $('#cancelUpdate').on('click', function() {
                $('#updateTaskForm').hide();
            });

            getAllTask(); 
        });
    </script>
</body>
</html>
