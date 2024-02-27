<?php
session_start();
error_reporting(1);
include('includes/dbconnection.php');

if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
} else {
    // CRUD operations for to-do list
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $task = $_POST['task'];
                $desc = $_POST['desc'];
                $date = $_POST['date'];
                $user_id = $_SESSION['id'];
                $sql = "INSERT INTO tasks (enrollmentNo, task, Description, completed, date) VALUES ('$user_id', '$task', '$desc', 0, '$date')";
                $query = mysqli_query($conn, $sql);
                if ($query) {
                    echo "Task added successfully";
                } else {
                    echo "Error adding task";
                }
                exit;
            case 'update':
                $task_id = $_POST['task_id'];
                $completed = $_POST['completed'];
                $sql = "UPDATE tasks SET completed='$completed' WHERE taskid='$task_id'";
                $query = mysqli_query($conn, $sql);
                if ($query) {
                    echo "Task updated successfully";
                } else {
                    echo "Error updating task";
                }
                exit;
            case 'delete':
                $task_id = $_POST['task_id'];
                $sql = "DELETE FROM tasks WHERE taskid='$task_id'";
                $query = mysqli_query($conn, $sql);
                if ($query) {
                    echo "Task deleted successfully";
                } else {
                    echo "Error deleting task";
                }
                exit;
        }
    }

    // Retrieve tasks for the logged-in user
    $user_id = $_SESSION['id'];
    $sql = "SELECT * FROM tasks WHERE enrollmentNo='$user_id'";
    $result = mysqli_query($conn, $sql);
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Student Portal || Dashboard</title>

    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/animate-css/animate.min.css">
    <link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css">
    <link rel="stylesheet" href="../assets/vendor/parsleyjs/css/parsley.css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/color_skins.css">

</head>
<body class="theme-blue">
<div class="overlay" style="display: none;"></div>
<div id="wrapper">
    <?php include_once('includes/header.php'); ?>
    <?php include_once('includes/sidebar.php');?>

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">
                        <h2>To Do List</h2>
                    </div>
                    <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                        <ul class="breadcrumb justify-content-end">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">To Do List</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="body">
                            <form id="basic-form">
                                <div class="form-group">
                                    <label>Enter Task:</label>
                                    <input type="text" id="task" class="form-control" required='true' placeholder="Enter Task">
                                </div>
                                <div class="form-group">
                                    <label>Task Description</label>
                                    <input type="text" id="desc" class="form-control" required='true' placeholder="Enter Task Description">
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" id="date" class="form-control" required='true' placeholder="Select Date">
                                </div>
                                <button type="button" class="btn btn-primary" id="add-task">Add</button>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="body">
                            <ul class="list-group" id="task-list">
                                <?php foreach ($tasks as $task): ?>
                                    <li class="list-group-item">
                                        <div class="form-check">
                                            <input class="form-check-input update-task" type="checkbox" <?php echo $task['completed'] ? 'checked' : '' ?> data-id="<?php echo $task['taskid'] ?>">
                                            <label class="form-check-label">
                                                <?php echo $task['task']; ?>
                                                  <p>Description: <?php echo $task['Description']; ?></p> <p>Date: <?php echo $task['date']; ?></p> <p> Status: <?php echo $task['completed'] ? 'Complete' : 'Incomplete'; ?></p>   
                                            </label>
                                            <button type="button" class="btn btn-primary float-right delete-task" data-id="<?php echo $task['taskid'] ?>">Delete</button>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Javascript -->
<script src="assets/bundles/libscripts.bundle.js"></script>
<script src="assets/bundles/vendorscripts.bundle.js"></script>
<script src="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../assets/vendor/parsleyjs/js/parsley.min.js"></script>
<script src="assets/bundles/mainscripts.bundle.js"></script>
<script src="assets/bundles/morrisscripts.bundle.js"></script>
<!-- CRUD Operations for To-Do List -->
<script>
    $(document).ready(function () {
        // Add task
        $('#add-task').click(function () {
            var task = $('#task').val();
            var desc = $('#desc').val();
            var date = $('#date').val();
            $.ajax({
                url: 'dashboard.php',
                method: 'POST',
                data: {
                    action: 'add',
                    task: task,
                    desc: desc,
                    date: date
                },
                success: function (response) {
                    alert(response);
                    // Reload tasks after adding
                    $('#task-list').load(location.href + ' #task-list');
                }
            });
        });

        // Update task status when checkbox is changed
        $('.update-task').change(function () {
            var task_id = $(this).data('id');
            var completed = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: 'dashboard.php',
                method: 'POST',
                data: {
                    action: 'update',
                    task_id: task_id,
                    completed: completed
                },
                success: function (response) {
                    alert(response);
                    // Reload tasks after updating
                    $('#task-list').load(location.href + ' #task-list');
                }
            });
        });

        // Delete task
        $('.delete-task').click(function () {
            var task_id = $(this).data('id');
            $.ajax({
                url: 'dashboard.php',
                method: 'POST',
                data: {
                    action: 'delete',
                    task_id: task_id
                },
                success: function (response) {
                    alert(response);
                    // Reload tasks after deletion
                    $('#task-list').load(location.href + ' #task-list');
                }
            });
        });
    });
</script>
</body>
</html>
