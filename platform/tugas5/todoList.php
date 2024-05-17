<?php
session_start();
require 'koneksi.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    if (empty($_POST['todolist'])) {
        echo "<script>alert('Form harus diisi terlebih dahulu.');</script>";
    } else {
        $todo = $_POST["todolist"];
        $status = "Pending";
        $user_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("SELECT * FROM todo WHERE todolist = ? AND user_id = ?");
        $stmt->bind_param("si", $todo, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Todo yang sama sudah ada.');</script>";
        } else {
            $stmt = $conn->prepare("INSERT INTO todo (todolist, status, user_id) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $todo, $status, $user_id);
            if ($stmt->execute() === TRUE) {
                echo "<script>alert('Todo berhasil ditambahkan.');</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}

// Update status todo menjadi 'Selesai'
if (isset($_POST['status'])) {
    $id_todo = $_POST["status"];
    $stmt = $conn->prepare("UPDATE todo SET status='Selesai' WHERE id=?");
    $stmt->bind_param("i", $id_todo);
    $stmt->execute();
    $stmt->close();
}

// Hapus todo
if (isset($_POST['delete'])) {
    if (isset($_POST["id_todo"])) {
        $id_todo = $_POST["id_todo"];
        $stmt = $conn->prepare("DELETE FROM todo WHERE id=?");
        $stmt->bind_param("i", $id_todo);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "<script>alert('Error: ID Todo tidak ditemukan.');</script>";
    }
}

// Ambil todo
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM todo WHERE user_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        .strikethrough {
            text-decoration: line-through;
            color: #808080;
        }
    </style>
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
                    $class = ($row["status"] == 'Selesai') ? 'strikethrough' : '';
                    echo "<li class='list-group-item $class'>" . htmlspecialchars($row["todolist"]) . " - Status: " . htmlspecialchars($row["status"]) . "
                          <form action='' method='POST' style='display: inline;'>
                            <input type='hidden' name='id_todo' value='" . $row["id"] . "'>
                            <button type='submit' name='delete' class='btn btn-danger btn-sm ml-2'>Delete</button>
                          </form>
                          <form action='' method='POST' style='display: inline;'>
                            <button type='submit' name='status' value='" . $row["id"] . "' class='btn btn-success btn-sm ml-2'>Selesai</button>
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
<?php
$stmt->close();
$conn->close();
?>
