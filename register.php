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
  <meta charset="utf-8" />
  <title>Login - Typing Test</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />

  <style>
    body {
      background-color: #ffffff;
      color: #212529;
    }

    .card {
      border: none;
      border-radius: 1rem;
    }

    .btn-orange {
      background-color: rgb(234, 88, 12);
      color: #fff;
      font-weight: bold;
    }

    .btn-orange:hover {
      background-color: rgb(194, 65, 12);
    }
  </style>
</head>

<body>
  <div class="min-vh-100 d-flex align-items-center justify-content-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card shadow-lg">
            <div class="card-body p-4">
              <!-- Logo -->
              <div class="text-center mb-4">
                <a href="index.php">
                  <img src="assets/img/logo.png" style="height: 80px" alt="logo" />
                </a>
              </div>

              <!-- Error Message -->
              <?php if (!empty($error)) : ?>
                <div class="alert alert-danger text-center py-2">
                  <?php echo $error; ?>
                </div>
              <?php endif; ?>

              <!-- Login Form -->
              <form method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" id="username" name="username"
                    class="form-control border-dark"
                    placeholder="Enter your username" required />
                  <div class="invalid-feedback">
                    Please enter your username.
                  </div>
                </div>

                <div class="mb-3">
                  <div class="d-flex justify-content-between align-items-center">
                    <label for="password" class="form-label mb-0">Password</label>
                    <a href="forgot_password.php" class="text-danger fw-bold small">Forgot Password?</a>
                  </div>
                  <input type="password" id="password" name="password"
                    class="form-control border-dark"
                    placeholder="Enter your password" required />
                  <div class="invalid-feedback">
                    Please enter your password.
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Select Role</label>
                  <select name="role" class="form-select" required>
                    <option value="" disabled selected>-- Choose Role --</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                  </select>
                </div>

                <div class="d-grid gap-2 mb-4">
                  <button type="submit" class="btn btn-orange">
                    Register
                  </button>
                </div>
              </form>


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>