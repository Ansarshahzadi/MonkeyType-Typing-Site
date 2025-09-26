<?php
session_start();

// cache control
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// agar login nahi hai to redirect
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// sirf normal user ko allow
if ($_SESSION['role'] !== 'user') {
    header("Location: dashboard.php"); // ya admin_dashboard.php pe redirect karna chahen
    exit;
}

$role = $_SESSION['role'];
$current_page = basename($_SERVER['PHP_SELF']); // current file ka naam
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: #f8f9fa;
            color: #212529;
            flex-shrink: 0;
            border-right: 1px solid #dee2e6;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #495057;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #e9ecef;
            color: #212529;
        }

        .sidebar a.active {
            background: #fff;
            color: #0d6efd;
            font-weight: bold;
            border-left: 4px solid #0d6efd;
        }

        .sidebar h4 {
            padding: 15px 20px;
            margin: 0;
            background: #e9ecef;
            color: #212529;
            font-weight: bold;
            border-bottom: 1px solid #dee2e6;
        }

        .dropdown-toggle::after {
            float: right;
            margin-top: 6px;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4>User Panel</h4>
        <a href="dashboard_user.php" class="<?php echo ($current_page == 'dashboard_user.php') ? 'active' : ''; ?>">Dashboard</a>
        <a href="my_results.php" class="<?php echo ($current_page == 'my_results.php') ? 'active' : ''; ?>">My Results</a>
        <a href="top10.php" class="<?php echo ($current_page == 'top10.php') ? 'active' : ''; ?>">Top 10 Typers</a>
        <a href="profile.php" class="<?php echo ($current_page == 'profile.php') ? 'active' : ''; ?>">Profile</a>

        <!-- Authentication Dropdown -->
        <div class="dropdown">
            <a class="dropdown-toggle <?php echo (in_array($current_page, ['login.php', 'register.php', 'forgot_password.php', 'reset_password.php', 'logout.php'])) ? 'active' : ''; ?>"
                href="#" data-bs-toggle="collapse" data-bs-target="#authMenu" aria-expanded="false">
                Authentication
            </a>
            <div class="collapse <?php echo (in_array($current_page, ['login.php', 'register.php', 'forgot_password.php', 'reset_password.php', 'logout.php'])) ? 'show' : ''; ?>" id="authMenu">
                <a href="login.php" class="<?php echo ($current_page == 'login.php') ? 'active' : ''; ?>">Login</a>
                <a href="register.php" class="<?php echo ($current_page == 'register.php') ? 'active' : ''; ?>">Register</a>
                <a href="forgot_password.php" class="<?php echo ($current_page == 'forgot_password.php') ? 'active' : ''; ?>">Forgot Password</a>
                <a href="recover_password.php" class="<?php echo ($current_page == 'recover_password.php') ? 'active' : ''; ?>">Recover Password</a>
                <a href="reset_password.php" class="<?php echo ($current_page == 'reset_password.php') ? 'active' : ''; ?>">Reset Password</a>
                <a href="logout.php" class="<?php echo ($current_page == 'logout.php') ? 'active text-danger' : 'text-danger'; ?>">Logout</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Welcome, User</h2>
        <p>User view: Yahan apka result aur Top 10 Typers show hoga.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
