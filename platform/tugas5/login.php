<?php 
session_start();
require 'koneksi.php';

if (isset($_SESSION['login'])) {
    header("Location: todoList.php");
    exit();
}

if (isset($_POST['loginbtn'])) {
    login($_POST);
}

function login($data) {
    global $conn;
    $username = $data['username'];
    $password = $data['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_num_rows($result) == 0) {
        echo "<script>alert('Username tidak ditemukan.');</script>";
    } else {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row["password"])) {
            $_SESSION["login"] = true;
            $_SESSION['user_id'] = $row['id'];
            header("Location: todoList.php");
            exit();
        } else {
            echo "<script>alert('Password salah.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">LOGIN</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="loginbtn">Login</button>
            <a href="register.php" class="btn btn-secondary">Registrasi</a>
        </form>
    </div>
</body>
</html>
