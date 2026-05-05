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
    <title>Member Management | LibroTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../../src/css/styles.css">
    <link rel="stylesheet" href="../../../../src/css/librarian_dashboard.css">
    <style>
        /* Specific styles for Member Management (Admin-Style Mirror) */
        .management-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .member-tabs {
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

        .users-table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .users-table th {
            background: #f8fafc;
            padding: 15px 20px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            border-bottom: 1px solid var(--border-light);
        }

        .users-table td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-light);
            font-size: 14px;
        }

        .user-identity {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-pfp {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
        }

        .role-pill {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            background: #eff6ff;
            color: #1d4ed8;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }

        .btn-approve { background: #10b981; color: white; }
        .btn-reject { background: #ef4444; color: white; }
        .btn-manage { background: #f1f5f9; color: var(--text-dark); border: 1px solid var(--border-light); }
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
            <a href="manage_members.php" class="menu-item active">
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
                <input type="text" placeholder="Search members by name, ID, or department...">
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
                    <div class="breadcrumb">Librarian / Member Management</div>
                    <h1>Student Directory</h1>
                </div>
                <button class="btn-primary">
                    <i class="fas fa-user-plus"></i> Register Student
                </button>
            </div>

            <!-- Role Tabs (Mirrored from Admin) -->
            <div class="member-tabs animate-up delay-2">
                <button class="tab-btn active">All Students</button>
                <button class="tab-btn" style="position: relative;">
                    Pending Verification
                    <span style="position: absolute; top: -5px; right: -10px; background: #ef4444; color: white; font-size: 10px; padding: 2px 6px; border-radius: 10px;">5</span>
                </button>
                <button class="tab-btn">Suspended Accounts</button>
            </div>

            <!-- Users Table (Mirrored from Admin) -->
            <div class="users-table-container animate-up delay-3">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Student Member</th>
                            <th>ID Number</th>
                            <th>Status</th>
                            <th>Borrowed</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="user-identity">
                                    <div class="user-pfp" style="background: #3b82f6;">JD</div>
                                    <div>
                                        <span class="user-name">John Doe</span>
                                        <span class="user-email">john.doe@university.edu</span>
                                    </div>
                                </div>
                            </td>
                            <td>CS-2024-001</td>
                            <td><span class="status-badge status-available" style="background: #f0fdf4; color: #15803d; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Active</span></td>
                            <td>3 Books</td>
                            <td>
                                <div class="actions">
                                    <button class="btn-action btn-manage">View Profile</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="user-identity">
                                    <div class="user-pfp" style="background: #f59e0b;">SM</div>
                                    <div>
                                        <span class="user-name">Sarah Miller</span>
                                        <span class="user-email">sarah.m@university.edu</span>
                                    </div>
                                </div>
                            </td>
                            <td>IT-2024-042</td>
                            <td><span class="status-badge" style="background: #fff7ed; color: #c2410c; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Pending</span></td>
                            <td>0 Books</td>
                            <td>
                                <div class="actions">
                                    <button class="btn-action btn-approve"><i class="fas fa-check"></i> Verify</button>
                                    <button class="btn-action btn-reject"><i class="fas fa-times"></i> Reject</button>
                                </div>
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