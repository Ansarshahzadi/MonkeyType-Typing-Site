<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}
$current_page = basename($_SERVER['PHP_SELF']);

// Database connection
$mysqli = new mysqli("localhost", "root", "", "admin_typing");
if ($mysqli->connect_error) {
    die("DB Connection Failed: " . $mysqli->connect_error);
}

// Fetch all results
$query = "SELECT r.id, u.username, r.wpm, r.accuracy, r.correct, r.incorrect, r.wordsTyped, r.timeTaken, r.created_at 
          FROM results r 
          JOIN users u ON r.user_id = u.id 
          ORDER BY r.created_at DESC";
$results = $mysqli->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Results - Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
        <a class="dropdown-toggle <?php echo (in_array($current_page, ['login.php', 'register.php', 'forgot_password.php', 'reset_password.php', 'logout.php'])) ? 'active' : ''; ?>"
            href="#" data-bs-toggle="collapse" data-bs-target="#authMenu" aria-expanded="false">
            Authentication
        </a>
        <div class="collapse <?php echo (in_array($current_page, ['login.php', 'register.php', 'forgot_password.php', 'reset_password.php', 'logout.php'])) ? 'show' : ''; ?>" id="authMenu">
            <a href="../login.php" class="<?php echo ($current_page == 'login.php') ? 'active' : ''; ?>">Login</a>
            <a href="../register.php" class="<?php echo ($current_page == 'register.php') ? 'active' : ''; ?>">Register</a>
            <a href="../forgot_password.php" class="<?php echo ($current_page == 'forgot_password.php') ? 'active' : ''; ?>">Forgot Password</a>
            <a href="../recover_password.php" class="<?php echo ($current_page == 'recover_password.php') ? 'active' : ''; ?>">Recover Password</a>
            <a href="../reset_password.php" class="<?php echo ($current_page == 'reset_password.php') ? 'active' : ''; ?>">Reset Password</a>
            <a href="../logout.php" class="<?php echo ($current_page == 'logout.php') ? 'active ' : ''; ?>">Logout</a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="content">
    <h2 class="fw-bold mb-4">📊 All Typing Test Results</h2>
    
    <div class="card shadow-sm">
        <div class="card-body">
            <table id="resultsTable" class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>WPM</th>
                        <th>Accuracy</th>
                        <th>Correct</th>
                        <th>Incorrect</th>
                        <th>Words</th>
                        <th>Time</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($results && $results->num_rows > 0): ?>
                        <?php while($row = $results->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= $row['wpm'] ?></td>
                                <td><?= $row['accuracy'] ?>%</td>
                                <td><?= $row['correct'] ?></td>
                                <td><?= $row['incorrect'] ?></td>
                                <td><?= $row['wordsTyped'] ?></td>
                                <td><?= gmdate("i:s", $row['timeTaken']) ?></td>
                                <td><?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="9" class="text-center text-muted">No results found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#resultsTable').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
});
</script>
</body>
</html>
