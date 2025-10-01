<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$current_page = 'settings.php';

// DB credentials — update if different
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "admin_typing";

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

$user_id = intval($_SESSION['user_id']);
$message = "";

/**
 * Helper: try prepare and set friendly message on failure
 * returns prepared statement or false
 */
function try_prepare($conn, $sql, &$message) {
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $message .= "<div class='alert alert-danger'>SQL prepare failed: " . htmlspecialchars($conn->error) . "</div>";
        return false;
    }
    return $stmt;
}

/* Handle update form */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '') {
        $message .= "<div class='alert alert-warning'>Name and email are required.</div>";
    } else {
        if ($password !== '') {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE users SET name=?, email=?, password=? WHERE id=?";
            $stmt = try_prepare($conn, $sql, $message);
            if ($stmt !== false) {
                $stmt->bind_param("sssi", $name, $email, $hash, $user_id);
                if ($stmt->execute()) {
                    $message .= "<div class='alert alert-success'>✅ Settings updated successfully!</div>";
                } else {
                    $message .= "<div class='alert alert-danger'>❌ Update failed: " . htmlspecialchars($stmt->error) . "</div>";
                }
                $stmt->close();
            }
        } else {
            $sql = "UPDATE users SET name=?, email=? WHERE id=?";
            $stmt = try_prepare($conn, $sql, $message);
            if ($stmt !== false) {
                $stmt->bind_param("ssi", $name, $email, $user_id);
                if ($stmt->execute()) {
                    $message .= "<div class='alert alert-success'>✅ Settings updated successfully!</div>";
                } else {
                    $message .= "<div class='alert alert-danger'>❌ Update failed: " . htmlspecialchars($stmt->error) . "</div>";
                }
                $stmt->close();
            }
        }
    }
}

/* Fetch current user info */
$sql = "SELECT name, email, role FROM users WHERE id = ? LIMIT 1";
$stmt = try_prepare($conn, $sql, $message);
$user = ['name'=>'', 'email'=>'', 'role'=>'user'];
if ($stmt !== false) {
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res && $res->num_rows > 0) {
            $user = $res->fetch_assoc();
        } else {
            $message .= "<div class='alert alert-warning'>User not found.</div>";
        }
    } else {
        $message .= "<div class='alert alert-danger'>❌ Query execution failed: " . htmlspecialchars($stmt->error) . "</div>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Settings - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: rgb(234, 88, 12);
            color: #ffffffff;
            flex-shrink: 0;
            border-right: 1px solid #dee2e6;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #ffffffff;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #e9ecef;
            color: rgb(234, 88, 12);
        }

        .sidebar a.active {
            background-color: rgb(234, 88, 12);
            color: #fff;
            font-weight: bold;
            border-left: 4px solid #fcfcfcff;
            border-bottom: 1px solid white;
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
        <h4>Admin Panel</h4>
        <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a>
        <a href="all_users.php" class="<?php echo ($current_page == 'all_users.php') ? 'active' : ''; ?>">All Users</a>
        <a href="all_results.php" class="<?php echo ($current_page == 'all_results.php') ? 'active' : ''; ?>">All Results</a>
        <a href="settings.php" class="<?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>">Settings</a>

        <!-- Authentication Dropdown -->
        <div class="dropdown">
            <a class="dropdown-toggle <?php echo (in_array($current_page, ['login.php','register.php','forgot_password.php','reset_password.php','logout.php'])) ? 'active' : ''; ?>"
                href="#" data-bs-toggle="collapse" data-bs-target="#authMenu" aria-expanded="false">
                Authentication
            </a>
            <div class="collapse" id="authMenu">
                <a href="../login.php" class="<?php echo ($current_page == 'login.php') ? 'active' : ''; ?>">Login</a>
                <a href="../register.php" class="<?php echo ($current_page == 'register.php') ? 'active' : ''; ?>">Register</a>
                <a href="../forgot_password.php" class="<?php echo ($current_page == 'forgot_password.php') ? 'active' : ''; ?>">Forgot Password</a>
                <a href="../recover_password.php" class="<?php echo ($current_page == 'recover_password.php') ? 'active' : ''; ?>">Recover Password</a>
                <a href="../reset_password.php" class="<?php echo ($current_page == 'reset_password.php') ? 'active' : ''; ?>">Reset Password</a>
                <a href="../logout.php" class="<?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>">Logout</a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <h2 class="mb-4">⚙️ Account Settings</h2>

        <?php echo $message; ?>

        <div class="card shadow-sm">
            <div class="card-header">Update Your Information</div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter new password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars(ucfirst($user['role'] ?? 'user')); ?>" disabled>
                    </div>
                    <button type="submit" class="btn btn-primary">💾 Save Changes</button>
                </form>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
