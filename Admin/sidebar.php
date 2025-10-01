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