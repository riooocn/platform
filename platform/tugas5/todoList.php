<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['logoutbtn'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Tambahkan todo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['todolist'])) {
    $todo = $_POST["todolist"];
    $status = "Pending";
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO todo (todolist, status, user_id) VALUES ('$todo', '$status', '$user_id')";
    $conn->query($sql);
}

// Hapus todo
if (isset($_POST['delete'])) {
    $id_todo = $_POST["id_todo"];
    $sql = "DELETE FROM todo WHERE id_todo=$id_todo";
    $conn->query($sql);
}

// Ambil todo
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM todo WHERE user_id='$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Todo List</h2>
        <form action="" method="POST" class="form-inline mb-3">
            <input type="text" name="todolist" class="form-control mr-2" placeholder="Enter Todo">
            <button type="submit" class="btn btn-primary">Add Todo</button>
            <button type="submit" class="btn btn-danger ml-auto" name="logoutbtn">Logout</button>
        </form>
        <ul class="list-group">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item'>" . $row["todolist"] . " - Status: " . $row["status"] . "
                          <form action='' method='POST' style='display: inline;'>
                            <input type='hidden' name='id_todo' value='" . $row["id_todo"] . "'>
                            <button type='submit' name='delete' class='btn btn-danger btn-sm ml-2'>Delete</button>
                          </form>
                          </li>";
                }
            } else {
                echo "<li class='list-group-item'>No todos yet.</li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>
