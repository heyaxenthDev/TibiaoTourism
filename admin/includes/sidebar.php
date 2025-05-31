<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <?php 
            // Get the current file name
            $current_page = basename($_SERVER['PHP_SELF']);
        ?>

        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'dashboard.php' ? '' : 'collapsed'; ?>" href="dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'resort data.php' ? '' : 'collapsed'; ?>"
                href="resort data.php">
                <i class="bi bi-clipboard-data"></i>
                <span>Resort Data</span>
            </a>
        </li><!-- End Resort Data Nav -->

        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'ResortAccountManagement.php' ? '' : 'collapsed'; ?>"
                href="ResortAccountManagement.php">
                <i class="bi bi-shield-lock"></i>
                <span>Resort Account Management</span>
            </a>
        </li><!-- End Notifications Nav -->

        <li class="nav-heading">User</li>

        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'users-profile.php' ? '' : 'collapsed'; ?>"
                href="users-profile.php">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->

    </ul>

</aside><!-- End Sidebar-->