<?php
include "includes/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role']; // admin or user

    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $role]);

    echo "<script>alert('User registered successfully! You can login now.'); window.location='login.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4">Register</h2>
  <form method="POST" class="card p-4 shadow-sm">
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Select Role</label>
      <select name="role" class="form-select" required>
        <option value="" disabled selected>-- Choose Role --</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
      </select>
    </div>

    <button type="submit" class="btn btn-success">Register</button>
    <a href="login.php" class="btn btn-link">Already have an account? Login</a>
  </form>
</div>
</body>
</html>
