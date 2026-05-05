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
    <title>Circulation Desk | LibroTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../../src/css/styles.css">
    <link rel="stylesheet" href="../../../../src/css/librarian_dashboard.css">
    <style>
        /* Specific styles for Circulation (Admin-Style Mirror) */
        .management-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .tool-group {
            display: flex;
            gap: 12px;
        }

        .circ-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .circ-stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid var(--primary-color);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .circ-stat-card h4 {
            font-size: 12px;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .circ-stat-card .value {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .circ-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .circ-table th {
            background: #f8fafc;
            padding: 15px 20px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            border-bottom: 1px solid var(--border-light);
        }

        .circ-table td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-light);
            font-size: 14px;
        }

        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            font-size: 12px;
        }

        .indicator-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .status-active { color: #3b82f6; }
        .status-active .indicator-dot { background: #3b82f6; }
        .status-overdue { color: #ef4444; }
        .status-overdue .indicator-dot { background: #ef4444; }
        .status-returned { color: #10b981; }
        .status-returned .indicator-dot { background: #10b981; }

        .btn-outline-amber {
            background: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-outline-amber:hover {
            background: rgba(245, 158, 11, 0.05);
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
            <a href="circulation.php" class="menu-item active">
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
                <input type="text" placeholder="Search transactions, student IDs...">
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
                    <div class="breadcrumb">Librarian / Circulation</div>
                    <h1>Circulation Desk</h1>
                </div>
                <div class="tool-group">
                    <button class="btn-outline-amber">
                        <i class="fas fa-undo"></i> Return Book
                    </button>
                    <button class="btn-primary">
                        <i class="fas fa-sign-out-alt"></i> Issue Book
                    </button>
                </div>
            </div>

            <!-- Circulation Stats (Mirrored from Admin) -->
            <div class="circ-stats animate-up delay-2">
                <div class="circ-stat-card" style="border-left-color: #3b82f6;">
                    <h4>Active Borrows</h4>
                    <div class="value">1,124</div>
                </div>
                <div class="circ-stat-card" style="border-left-color: #f59e0b;">
                    <h4>Due Today</h4>
                    <div class="value">42</div>
                </div>
                <div class="circ-stat-card" style="border-left-color: #ef4444;">
                    <h4>Overdue Items</h4>
                    <div class="value">18</div>
                </div>
                <div class="circ-stat-card" style="border-left-color: #10b981;">
                    <h4>Returns (Today)</h4>
                    <div class="value">156</div>
                </div>
            </div>

            <!-- Transaction Table (Mirrored from Admin) -->
            <div class="table-container animate-up delay-3">
                <div style="padding: 20px; border-bottom: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 16px;">Active Transactions</h3>
                    <div style="display: flex; gap: 10px;">
                        <select style="padding: 6px 12px; border-radius: 6px; border: 1px solid var(--border-light); font-size: 13px; font-family: inherit;">
                            <option>All Status</option>
                            <option>Active</option>
                            <option>Overdue</option>
                        </select>
                    </div>
                </div>
                <table class="circ-table">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Borrower</th>
                            <th>Issue Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Clean Code</strong></td>
                            <td>Mark Davis (ST-2401)</td>
                            <td>May 01, 2026</td>
                            <td><strong>May 08, 2026</strong></td>
                            <td>
                                <div class="status-indicator status-active">
                                    <div class="indicator-dot"></div> Active
                                </div>
                            </td>
                            <td>
                                <button class="btn-primary" style="padding: 5px 12px; font-size: 11px;">Return</button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Advanced PHP</strong></td>
                            <td>Alice Johnson (ST-2402)</td>
                            <td>Apr 20, 2026</td>
                            <td><strong style="color: #ef4444;">Apr 27, 2026</strong></td>
                            <td>
                                <div class="status-indicator status-overdue">
                                    <div class="indicator-dot"></div> Overdue
                                </div>
                            </td>
                            <td>
                                <button class="btn-primary" style="padding: 5px 12px; font-size: 11px; background: #ef4444;">Remind</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="../../../../src/js/dashboard.js"></script>
</body>

</html>