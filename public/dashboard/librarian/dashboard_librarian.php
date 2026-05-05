<?php
session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Librarian') {
//     header("Location: ../../../auth/login.php");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian Dashboard | LibroTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <link rel="stylesheet" href="../../../src/css/librarian_dashboard.css">
</head>

<body class="dashboard-body">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="../../../img/techbook.png" alt="LibroTech Logo">
            <span>LibroTech</span>
        </div>
        <nav class="sidebar-menu">
            <a href="dashboard_librarian.php" class="menu-item active">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>
            <a href="sidebar/book_cataloging.php" class="menu-item">
                <i class="fas fa-book"></i>
                <span>Book Cataloging</span>
            </a>
            <a href="sidebar/circulation.php" class="menu-item">
                <i class="fas fa-exchange-alt"></i>
                <span>Circulation</span>
            </a>
            <a href="sidebar/manage_members.php" class="menu-item">
                <i class="fas fa-user-graduate"></i>
                <span>Member Management</span>
            </a>
            <a href="sidebar/notification.php" class="menu-item">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
            </a>
            <a href="sidebar/statistics.php" class="menu-item">
                <i class="fas fa-chart-line"></i>
                <span>Statistics</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="../../../auth/logout.php" class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header (Mirrored from Admin) -->
        <header class="top-header animate-fade">
            <div class="header-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search books, members, or transactions...">
            </div>
            <div class="header-user">
                <div class="user-info">
                    <span class="user-name"><?php echo $_SESSION['username'] ?? 'Librarian'; ?></span>
                    <span class="user-role">Librarian</span>
                </div>
                <div class="user-avatar">
                    <?php
                    $initials = isset($_SESSION['username']) ? strtoupper(substr($_SESSION['username'], 0, 2)) : 'LB';
                    echo $initials;
                    ?>
                </div>
            </div>
        </header>

        <!-- Dashboard Container -->
        <div class="dashboard-container">
            <div class="welcome-section animate-up delay-1">
                <h1>Librarian Command Center</h1>
                <p>Manage inventory and circulation with the professional LibroTech suite.</p>
            </div>

            <!-- Stats Grid (Mirrored Layout) -->
            <div class="stats-grid">
                <div class="glass-card stat-card animate-up delay-2">
                    <div class="stat-details">
                        <h3>Total Inventory</h3>
                        <span class="number">8,124</span>
                    </div>
                    <div class="stat-icon icon-books">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
                <div class="glass-card stat-card animate-up delay-3">
                    <div class="stat-details">
                        <h3>Active Borrows</h3>
                        <span class="number">1,120</span>
                    </div>
                    <div class="stat-icon icon-borrow">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                </div>
                <div class="glass-card stat-card animate-up delay-4">
                    <div class="stat-details">
                        <h3>Due Today</h3>
                        <span class="number">42</span>
                    </div>
                    <div class="stat-icon icon-users">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="glass-card stat-card animate-up delay-5">
                    <div class="stat-details">
                        <h3>Overdue Books</h3>
                        <span class="number">18</span>
                    </div>
                    <div class="stat-icon icon-overdue">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>

            <!-- Content Grid (Mirrored from Admin) -->
            <div class="content-grid">
                <!-- Recent Activity -->
                <div class="glass-card data-card animate-up delay-6">
                    <div class="card-header">
                        <h2>Recent Circulation Activity</h2>
                        <a href="sidebar/circulation.php" class="view-all">View All History</a>
                    </div>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-img">
                                <i class="fas fa-arrow-up" style="color: #10b981;"></i>
                            </div>
                            <div class="activity-info">
                                <span class="activity-title">Book Returned</span>
                                <span class="activity-desc">"Clean Code" returned by <strong>John Doe</strong></span>
                            </div>
                            <div class="activity-time">5 mins ago</div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-img">
                                <i class="fas fa-arrow-down" style="color: #f59e0b;"></i>
                            </div>
                            <div class="activity-info">
                                <span class="activity-title">Book Borrowed</span>
                                <span class="activity-desc">"Modern JS" issued to <strong>Jane Smith</strong></span>
                            </div>
                            <div class="activity-time">25 mins ago</div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-img">
                                <i class="fas fa-user-plus" style="color: #3b82f6;"></i>
                            </div>
                            <div class="activity-info">
                                <span class="activity-title">New Member Registered</span>
                                <span class="activity-desc"><strong>Alice Johnson</strong> joined the library</span>
                            </div>
                            <div class="activity-time">1 hour ago</div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Quick Status -->
                <div class="glass-card data-card animate-up delay-6">
                    <div class="card-header">
                        <h2>Upcoming Returns</h2>
                        <a href="#" class="view-all">See Full List</a>
                    </div>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="user-avatar" style="background: #f59e0b;">SM</div>
                            <div class="activity-info">
                                <span class="activity-title">Sam Miller</span>
                                <span class="activity-desc">Return: Advanced PHP</span>
                            </div>
                            <span class="badge badge-pending">Due Today</span>
                        </div>
                        <div class="activity-item">
                            <div class="user-avatar" style="background: #3b82f6;">AL</div>
                            <div class="activity-info">
                                <span class="activity-title">Anna Lee</span>
                                <span class="activity-desc">Return: Database Design</span>
                            </div>
                            <span class="badge badge-pending">Due Today</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../../../src/js/dashboard.js"></script>
</body>

</html>