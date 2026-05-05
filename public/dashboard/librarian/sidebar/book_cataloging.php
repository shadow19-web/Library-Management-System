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
    <title>Book Cataloging | LibroTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../../src/css/styles.css">
    <link rel="stylesheet" href="../../../../src/css/librarian_dashboard.css">
    <style>
        /* Specific styles for Cataloging (Admin-Style Mirror) */
        .management-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .filter-bar {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            display: flex;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-group label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .filter-group select,
        .filter-group input {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid var(--border-light);
            outline: none;
            min-width: 150px;
            font-family: inherit;
        }

        .catalog-table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .catalog-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .catalog-table th {
            background: #f8fafc;
            padding: 15px 20px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            border-bottom: 1px solid var(--border-light);
        }

        .catalog-table td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-light);
            font-size: 14px;
        }

        .book-info-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .book-cover-mini {
            width: 40px;
            height: 55px;
            background: #f1f5f9;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            border: 1px solid var(--border-light);
        }

        .book-title {
            display: block;
            font-weight: 600;
            color: var(--text-dark);
        }

        .book-isbn {
            display: block;
            font-size: 12px;
            color: var(--text-muted);
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-edit { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
        .btn-delete { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .btn-view { background: rgba(16, 185, 129, 0.1); color: #10b981; }

        .action-btn:hover {
            transform: translateY(-2px);
            filter: brightness(0.9);
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-available { background: #f0fdf4; color: #15803d; }
        .status-borrowed { background: #fff7ed; color: #c2410c; }
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
            <a href="book_cataloging.php" class="menu-item active">
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
                <input type="text" placeholder="Search for books in catalog...">
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
                    <div class="breadcrumb">Librarian / Book Cataloging</div>
                    <h1>Book Inventory</h1>
                </div>
                <button class="btn-primary">
                    <i class="fas fa-plus"></i> Add New Book
                </button>
            </div>

            <!-- Filter Bar (Mirrored from Admin) -->
            <div class="filter-bar animate-up delay-2">
                <div class="filter-group">
                    <label>Category</label>
                    <select>
                        <option value="">All Categories</option>
                        <option value="cs">Computer Science</option>
                        <option value="it">Information Tech</option>
                        <option value="eng">Engineering</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Status</label>
                    <select>
                        <option value="">All Status</option>
                        <option value="available">Available</option>
                        <option value="borrowed">Borrowed</option>
                    </select>
                </div>
                <div class="filter-group" style="flex: 1;">
                    <label>Quick Search</label>
                    <input type="text" placeholder="Title, Author, or ISBN..." style="width: 100%;">
                </div>
            </div>

            <!-- Catalog Table (Mirrored from Admin) -->
            <div class="catalog-table-container animate-up delay-3">
                <table class="catalog-table">
                    <thead>
                        <tr>
                            <th>Book Details</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="book-info-cell">
                                    <div class="book-cover-mini"><i class="fas fa-book-open"></i></div>
                                    <div>
                                        <span class="book-title">Advanced PHP Development</span>
                                        <span class="book-isbn">ISBN: 978-3-16-148</span>
                                    </div>
                                </div>
                            </td>
                            <td>John Smith</td>
                            <td>Computer Science</td>
                            <td><span class="status-badge status-available">Available</span></td>
                            <td>
                                <div class="actions">
                                    <a href="#" class="action-btn btn-view"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="action-btn btn-edit"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="action-btn btn-delete"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="book-info-cell">
                                    <div class="book-cover-mini"><i class="fas fa-code"></i></div>
                                    <div>
                                        <span class="book-title">Modern JavaScript</span>
                                        <span class="book-isbn">ISBN: 978-1-491-95</span>
                                    </div>
                                </div>
                            </td>
                            <td>Jane Doe</td>
                            <td>Web Dev</td>
                            <td><span class="status-badge status-borrowed">Borrowed</span></td>
                            <td>
                                <div class="actions">
                                    <a href="#" class="action-btn btn-view"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="action-btn btn-edit"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="action-btn btn-delete"><i class="fas fa-trash"></i></a>
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