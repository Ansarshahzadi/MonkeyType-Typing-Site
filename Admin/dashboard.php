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

// sirf admin ko allow
if ($_SESSION['role'] !== 'admin') {
    header("Location: Admin/dashboard.php"); // ya aap "unauthorized.php" pe redirect karna chahen
    exit;
}

$role = $_SESSION['role'];
$current_page = basename($_SERVER['PHP_SELF']); // current file ka naam
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
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
<?php  include "sidebar.php"?>

    <!-- Main Content -->
    <div class="content">
        <h2>Welcome, Admin</h2>
        <p>Admin view: Yahan sab users ka data show hoga.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
