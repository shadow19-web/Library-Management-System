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
    <title>Notifications | LibroTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../../src/css/styles.css">
    <link rel="stylesheet" href="../../../../src/css/librarian_dashboard.css">
    <style>
        /* Specific styles for Notifications (Admin-Style Mirror) */
        .management-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .notif-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 25px;
            background: #f1f5f9;
            padding: 5px;
            border-radius: 12px;
            width: fit-content;
        }

        .tab-btn {
            padding: 8px 20px;
            border-radius: 8px;
            border: none;
            background: none;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .tab-btn.active {
            background: white;
            color: var(--primary-color);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .notif-feed-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .notif-item {
            display: flex;
            gap: 1.25rem;
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-light);
            transition: background 0.2s;
            position: relative;
        }

        .notif-item:hover {
            background: #f8fafc;
        }

        .notif-item.unread {
            background: rgba(245, 158, 11, 0.02);
            border-left: 4px solid var(--primary-color);
        }

        .notif-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .icon-alert { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .icon-info { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        .icon-success { background: rgba(16, 185, 129, 0.1); color: #10b981; }

        .notif-content {
            flex: 1;
        }

        .notif-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 4px;
        }

        .notif-title {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 1rem;
        }

        .notif-time {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .notif-desc {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .notif-actions {
            margin-top: 12px;
            display: flex;
            gap: 10px;
        }

        .btn-text {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
        }

        .btn-text:hover {
            text-decoration: underline;
        }
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
            <a href="notification.php" class="menu-item active">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
            </a>
            <a href="statistics.php" class="menu-item">
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
                <input type="text" placeholder="Search notifications...">
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
                    <div class="breadcrumb">Librarian / Notifications</div>
                    <h1>System Alerts</h1>
                </div>
                <button class="btn-text" style="color: var(--text-muted); font-weight: 500;">
                    <i class="fas fa-check-double"></i> Mark all as read
                </button>
            </div>

            <!-- Category Tabs (Mirrored from Admin Style) -->
            <div class="notif-tabs animate-up delay-2">
                <button class="tab-btn active">All Alerts</button>
                <button class="tab-btn">Overdue</button>
                <button class="tab-btn">Member Requests</button>
                <button class="tab-btn">System</button>
            </div>

            <!-- Notification Feed (Admin Mirror Card Style) -->
            <div class="notif-feed-container animate-up delay-3">
                <!-- Unread Overdue Notif -->
                <div class="notif-item unread">
                    <div class="notif-icon-box icon-alert">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="notif-content">
                        <div class="notif-header">
                            <span class="notif-title">Critical Overdue: Student ST-2401</span>
                            <span class="notif-time">2 hours ago</span>
                        </div>
                        <p class="notif-desc">Student <strong>Mark Davis</strong> has not returned "Clean Code" after 3 reminders. Automatic fine has been applied.</p>
                        <div class="notif-actions">
                            <button class="btn-text">View Record</button>
                            <button class="btn-text" style="color: var(--text-muted);">Dismiss</button>
                        </div>
                    </div>
                </div>

                <!-- Unread New Member Notif -->
                <div class="notif-item unread">
                    <div class="notif-icon-box icon-info">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="notif-content">
                        <div class="notif-header">
                            <span class="notif-title">New Member Awaiting Verification</span>
                            <span class="notif-time">5 hours ago</span>
                        </div>
                        <p class="notif-desc"><strong>Sarah Miller</strong> has submitted a registration request for the Computer Science department.</p>
                        <div class="notif-actions">
                            <button class="btn-text">Review Request</button>
                        </div>
                    </div>
                </div>

                <!-- Read Success Notif -->
                <div class="notif-item">
                    <div class="notif-icon-box icon-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="notif-content">
                        <div class="notif-header">
                            <span class="notif-title">Inventory Update Complete</span>
                            <span class="notif-time">Yesterday</span>
                        </div>
                        <p class="notif-desc">The catalog has been successfully updated with 15 new acquisitions for the semester.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../../../../src/js/dashboard.js"></script>
</body>

</html>