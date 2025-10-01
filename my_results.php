<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'includes/config.php'; // database connection
$current_page = 'my_results.php';

// Fetch logged-in user results
$user_id = $_SESSION['user_id'];
$sql = "SELECT wpm, accuracy, time_taken, created_at FROM results WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #f8f9fa;
            padding: 20px;
            border-right: 1px solid #ddd;
        }
        .sidebar a {
            display: block;
            padding: 10px;
            color: #000;
            text-decoration: none;
            margin-bottom: 5px;
            border-radius: 5px;
        }
        .sidebar a.active, .sidebar a:hover {
            background: #0d6efd;
            color: #fff;
        }
        .content {
            flex: 1;
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
                <a href="logout.php" class="<?php echo ($current_page == 'logout.php') ? 'active ' : ''; ?>">Logout</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>My Typing Results</h2>
        <table id="resultsTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>WPM</th>
                    <th>Accuracy (%)</th>
                    <th>Time Taken (s)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['wpm']); ?></td>
                    <td><?php echo htmlspecialchars($row['accuracy']); ?></td>
                    <td><?php echo htmlspecialchars($row['time_taken']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        $(document).ready(function() {
            $('#resultsTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });
    </script>
</body>
</html>
