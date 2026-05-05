<?php
session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Student') {
//     header("Location: ../../../auth/login.php");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | LibroTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <link rel="stylesheet" href="../../../src/css/student_dashboard.css">
</head>

<body class="dashboard-body">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="../../../img/techbook.png" alt="LibroTech Logo">
            <span>LibroTech</span>
        </div>
        <nav class="sidebar-menu">
            <a href="dashboard_student.php" class="menu-item active">
                <i class="fas fa-th-large"></i>
                <span>My Dashboard</span>
            </a>
            <a href="sidebar/search_catalog.php" class="menu-item">
                <i class="fas fa-search"></i>
                <span>Search Catalog</span>
            </a>
            <a href="sidebar/my_barrowed.php" class="menu-item">
                <i class="fas fa-book-reader"></i>
                <span>My Borrowed</span>
            </a>
            <a href="sidebar/saved_books.php" class="menu-item">
                <i class="fas fa-bookmark"></i>
                <span>Saved Books</span>
            </a>
            <a href="sidebar/notification.php" class="menu-item">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
            </a>
            <a href="sidebar/my_profile.php" class="menu-item">
                <i class="fas fa-user-circle"></i>
                <span>My Profile</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="../../../auth/logout.php" class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Sign Out</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header (Admin Mirror) -->
        <header class="top-header animate-fade">
            <div class="header-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Find books, authors, or categories...">
            </div>
            <div class="header-user">
                <div class="user-info">
                    <span class="user-name"><?php echo $_SESSION['username'] ?? 'Student User'; ?></span>
                    <span class="user-role">Student</span>
                </div>
                <div class="user-avatar">
                    <?php 
                        $initials = isset($_SESSION['username']) ? strtoupper(substr($_SESSION['username'], 0, 2)) : 'ST';
                        echo $initials;
                    ?>
                </div>
            </div>
        </header>

        <!-- Dashboard Container -->
        <div class="dashboard-container">
            <div class="welcome-section animate-up delay-1">
                <h1>Welcome Back, <?php echo $_SESSION['username'] ?? 'Student'; ?>!</h1>
                <p>Track your reading progress and discover new academic resources.</p>
            </div>

            <!-- Stats Grid (Mirrored) -->
            <div class="stats-grid">
                <div class="glass-card stat-card animate-up delay-2">
                    <div class="stat-details">
                        <h3>Borrowed</h3>
                        <span class="number">04</span>
                    </div>
                    <div class="stat-icon icon-books">
                        <i class="fas fa-book-open"></i>
                    </div>
                </div>
                <div class="glass-card stat-card animate-up delay-3">
                    <div class="stat-details">
                        <h3>Due Soon</h3>
                        <span class="number">01</span>
                    </div>
                    <div class="stat-icon icon-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="glass-card stat-card animate-up delay-4">
                    <div class="stat-details">
                        <h3>Saved Books</h3>
                        <span class="number">12</span>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fas fa-bookmark"></i>
                    </div>
                </div>
                <div class="glass-card stat-card animate-up delay-5">
                    <div class="stat-details">
                        <h3>Fines</h3>
                        <span class="number">₱0.00</span>
                    </div>
                    <div class="stat-icon icon-danger">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                </div>
            </div>

            <!-- Content Grid (Admin Mirror) -->
            <div class="content-grid">
                <!-- Left: Currently Borrowed -->
                <div class="glass-card data-card animate-up delay-6">
                    <div class="card-header">
                        <h2>Currently Borrowed</h2>
                        <a href="sidebar/my_barrowed.php" class="view-all">See All History</a>
                    </div>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-info">
                                <span class="activity-title">Introduction to Algorithms</span>
                                <span class="activity-desc">Return by: <strong>May 15, 2026</strong></span>
                            </div>
                            <span class="badge" style="background: #fee2e2; color: #ef4444; font-size: 11px; padding: 4px 10px; border-radius: 20px;">3 Days Left</span>
                        </div>
                        <div class="activity-item">
                            <div class="activity-info">
                                <span class="activity-title">Modern Web Design</span>
                                <span class="activity-desc">Return by: <strong>May 20, 2026</strong></span>
                            </div>
                            <span class="badge" style="background: #f1f5f9; color: #64748b; font-size: 11px; padding: 4px 10px; border-radius: 20px;">8 Days Left</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Recommendation (Special Indigo Card) -->
                <div class="glass-card data-card recommendation-card animate-up delay-6">
                    <div class="card-header">
                        <h2 style="color: white;">Picked For You</h2>
                    </div>
                    <p style="font-size: 13px; opacity: 0.9; margin-bottom: 20px;">Personalized academic suggestions.</p>
                    <div class="activity-list">
                        <div class="activity-item" style="border-bottom-color: rgba(255,255,255,0.1);">
                            <div class="activity-info">
                                <span class="activity-title">Clean Code</span>
                                <span class="activity-desc">Robert C. Martin</span>
                            </div>
                            <button class="btn" style="background: white; color: #6366f1; padding: 5px 12px; font-size: 11px; border: none; border-radius: 6px; font-weight: 600;">Reserve</button>
                        </div>
                        <div class="activity-item" style="border: none;">
                            <div class="activity-info">
                                <span class="activity-title">The Pragmatic Programmer</span>
                                <span class="activity-desc">Andrew Hunt</span>
                            </div>
                            <button class="btn" style="background: white; color: #6366f1; padding: 5px 12px; font-size: 11px; border: none; border-radius: 6px; font-weight: 600;">Reserve</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../../../src/js/dashboard.js"></script>
</body>

</html>
