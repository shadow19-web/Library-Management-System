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
    <title>Statistics & Analytics | LibroTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../../src/css/styles.css">
    <link rel="stylesheet" href="../../../../src/css/librarian_dashboard.css">
    <style>
        /* Specific styles for Statistics (Admin-Style Mirror) */
        .management-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .analytics-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        .progress-stat-item {
            margin-bottom: 20px;
        }

        .progress-stat-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-dark);
        }

        .progress-bar-bg {
            height: 8px;
            background: #f1f5f9;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: var(--primary-color);
            border-radius: 10px;
        }

        .ranking-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .ranking-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid var(--border-light);
        }

        .rank-number {
            width: 28px;
            height: 28px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
        }

        .rank-details h5 {
            font-size: 14px;
            margin: 0;
            color: var(--text-dark);
        }

        .rank-details span {
            font-size: 12px;
            color: var(--text-muted);
        }

        .stat-comparison {
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 4px;
        }

        .up { color: #10b981; }
        .down { color: #ef4444; }
    </style>
</head>

<body class="dashboard-body">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="../../../../img/techbook.png" alt="LibroTech Logo">
            <span>LibroTech</span>
        </div>
        <nav class="sidebar-menu">
            <a href="../dashboard_librarian.php" class="menu-item">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>
            <a href="book_cataloging.php" class="menu-item">
                <i class="fas fa-book"></i>
                <span>Book Cataloging</span>
            </a>
            <a href="circulation.php" class="menu-item">
                <i class="fas fa-exchange-alt"></i>
                <span>Circulation</span>
            </a>
            <a href="manage_members.php" class="menu-item">
                <i class="fas fa-user-graduate"></i>
                <span>Member Management</span>
            </a>
            <a href="notification.php" class="menu-item">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
            </a>
            <a href="statistics.php" class="menu-item active">
                <i class="fas fa-chart-line"></i>
                <span>Statistics</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="../../../../auth/logout.php" class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="top-header animate-fade">
            <div class="header-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search analytics reports...">
            </div>
            <div class="header-user">
                <div class="user-info">
                    <span class="user-name">Librarian</span>
                    <span class="user-role">Librarian</span>
                </div>
                <div class="user-avatar">LB</div>
            </div>
        </header>

        <div class="dashboard-container">
            <div class="management-header animate-up delay-1">
                <div>
                    <div class="breadcrumb">Librarian / Statistics</div>
                    <h1>Library Analytics</h1>
                </div>
                <button class="btn-primary" style="background: #f1f5f9; color: var(--text-dark); border: 1px solid var(--border-light);">
                    <i class="fas fa-download"></i> Export Reports
                </button>
            </div>

            <!-- Analytics Row (Mirrored from Admin) -->
            <div class="analytics-grid">
                <!-- Category Distribution -->
                <div class="glass-card animate-up delay-2">
                    <div class="card-header" style="margin-bottom: 20px;">
                        <h2>Collection Distribution</h2>
                    </div>
                    <div class="progress-stat-item">
                        <div class="progress-stat-info">
                            <span>Computer Science</span>
                            <span>42% (3,412 Books)</span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: 42%;"></div>
                        </div>
                    </div>
                    <div class="progress-stat-item">
                        <div class="progress-stat-info">
                            <span>Mathematics</span>
                            <span>25% (2,030 Books)</span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: 25%; background: #3b82f6;"></div>
                        </div>
                    </div>
                    <div class="progress-stat-item">
                        <div class="progress-stat-info">
                            <span>Engineering</span>
                            <span>20% (1,624 Books)</span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: 20%; background: #10b981;"></div>
                        </div>
                    </div>
                </div>

                <!-- Top Titles Ranking -->
                <div class="glass-card animate-up delay-3">
                    <div class="card-header" style="margin-bottom: 20px;">
                        <h2>Most Borrowed Titles</h2>
                    </div>
                    <div class="ranking-list">
                        <div class="ranking-item">
                            <div class="rank-number">1</div>
                            <div class="rank-details">
                                <h5>Clean Code</h5>
                                <span>124 borrows this semester</span>
                            </div>
                        </div>
                        <div class="ranking-item">
                            <div class="rank-number">2</div>
                            <div class="rank-details">
                                <h5>Modern JavaScript</h5>
                                <span>98 borrows this semester</span>
                            </div>
                        </div>
                        <div class="ranking-item">
                            <div class="rank-number">3</div>
                            <div class="rank-details">
                                <h5>Advanced PHP</h5>
                                <span>76 borrows this semester</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Row: Comparison Metrics (Mirrored from Admin) -->
            <div class="stats-grid animate-up delay-4">
                <div class="glass-card stat-card">
                    <div class="stat-details">
                        <h3>Borrowing Velocity</h3>
                        <span class="number" style="font-size: 1.25rem;">12.5 Books/Day</span>
                        <div class="stat-comparison up">
                            <i class="fas fa-caret-up"></i> 8% vs last month
                        </div>
                    </div>
                </div>
                <div class="glass-card stat-card">
                    <div class="stat-details">
                        <h3>New Members</h3>
                        <span class="number" style="font-size: 1.25rem;">+42 Students</span>
                        <div class="stat-comparison up">
                            <i class="fas fa-caret-up"></i> 12% vs last month
                        </div>
                    </div>
                </div>
                <div class="glass-card stat-card">
                    <div class="stat-details">
                        <h3>Overdue Rate</h3>
                        <span class="number" style="font-size: 1.25rem;">4.2%</span>
                        <div class="stat-comparison down">
                            <i class="fas fa-caret-down"></i> 1.5% decrease
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../../../../src/js/dashboard.js"></script>
</body>

</html>