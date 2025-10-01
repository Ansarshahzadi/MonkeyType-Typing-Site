<?php
session_start();
include "includes/config.php"; // assume $pdo PDO connection is provided here

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = "Please enter both username and password.";
    } else {
        // Fetch user by username (case-sensitive or insensitive depending on your DB collation)
        $query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $query->execute([$username]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // If DB role says admin, allow admin dashboard ONLY for the special Ansar credentials
            $isAnsarCredentials = (strtolower($username) === 'ansar' && $password === 'ansar');

            if ($user['role'] === 'admin') {
                if ($isAnsarCredentials) {
                    // Successful admin login (only for Ansar)
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = 'admin';
                    header("Location: Admin/dashboard.php");
                    exit;
                } else {
                    // Prevent any other user (even if role='admin' in DB) from accessing admin dashboard
                    $error = "⚠️ Admin access is restricted. Only the owner (Ansar) can login as admin.";
                }
            } else {
                // Normal user login
                $_SESSION['user_id'] = $user['id'];
                // Always treat non-ansar users as 'user' role regardless of DB (prevents privilege escalation)
                $_SESSION['role'] = 'user';
                header("Location: dashboard_user.php");
                exit;
            }
        } else {
            $error = "Invalid username or password!";
        }
    }
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
                                    <?php echo htmlspecialchars($error); ?>
                                </div>
                            <?php endif; ?>

                            <!-- Login Form -->
                            <form method="POST" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" id="username" name="username"
                                        class="form-control border-dark"
                                        placeholder="Enter your username" required
                                        value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" />
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

                                <div class="d-grid gap-2 mb-4">
                                    <button type="submit" class="btn btn-orange">
                                        Login
                                    </button>
                                </div>
                            </form>

                            <!-- Footer -->
                            <p class="text-center">
                                Don’t have an account?
                                <a href="register.php" class="text-danger fw-bold">Register</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Validation Script -->
    <script>
        (() => {
            "use strict";
            const forms = document.querySelectorAll(".needs-validation");
            Array.from(forms).forEach((form) => {
                form.addEventListener(
                    "submit",
                    (event) => {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add("was-validated");
                    },
                    false
                );
            });
        })();
    </script>
</body>

</html>
