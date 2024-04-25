<?php
session_start();
require 'koneksi.php';

if (isset($_SESSION['login'])) {
    header("Location: todoList.php");
    exit();
}

if (isset($_POST['submitbtn'])) {
    tambahAkun($_POST);
}

function tambahAkun($data) {
    global $conn;
    $username = $data['username'];
    $password = $data['password'];
    $confirm_password = $data['confirm_password'];

    // Periksa apakah password dan konfirmasi password sama
    if ($password !== $confirm_password) {
        echo "<script>alert('Password dan konfirmasi password tidak sama.');</script>";
        return; // Kembali tanpa melakukan registrasi
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Akun berhasil dibuat.');</script>";
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Register</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submitbtn">Register</button>
            <a href="login.php" class="btn btn-secondary">Kembali ke Login</a>
        </form>
    </div>
</body>
</html>
