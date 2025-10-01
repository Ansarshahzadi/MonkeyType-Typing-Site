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