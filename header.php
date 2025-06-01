<?php
require_once 'auth.php';

// Protect all pages that include this header
$auth->requireAuth();

$currentUser = $auth->getCurrentUser();
$title = "Toko 123 - Management System";
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Security Headers -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    
    <!-- CSS Dependencies -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <title><?php echo htmlspecialchars($title); ?></title>
    
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        .navbar-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }
        
        .navbar-brand img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .user-info {
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.3);
        }
        
        .container-fluid {
            margin-top: 20px;
        }
        
        .sidebar {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 20px;
            margin-bottom: 20px;
            height: fit-content;
            position: sticky;
            top: 20px;
        }
        
        .content {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 0;
            margin-bottom: 20px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            font-weight: 600;
            padding: 20px;
            border-bottom: none;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .footer {
            background: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            color: var(--dark-color);
        }
        
        /* Dashboard boxes */
        .dashboard-box {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            text-align: center;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary-color);
        }
        
        .dashboard-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .dashboard-box h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
            color: var(--dark-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .dashboard-box .count {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }
        
        .dashboard-box .icon {
            font-size: 48px;
            color: var(--primary-color);
            opacity: 0.1;
            position: absolute;
            right: 20px;
            top: 20px;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 10px;
            }
            
            .sidebar {
                margin-bottom: 20px;
                position: static;
            }
            
            .dashboard-box {
                margin-bottom: 15px;
            }
        }
        
        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Chart container */
        .chart-container {
            position: relative;
            height: 400px;
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
    </style>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="content.php">
                <img src="logo.png" alt="Logo" onerror="this.style.display='none'">
                <?php echo htmlspecialchars($title); ?>
            </a>
            
            <div class="user-info">
                <img src="profile.png" alt="Profile" class="user-avatar">
                <div>
                    <div style="font-size: 14px; opacity: 0.9;">Welcome,</div>
                    <div style="font-weight: 600;"><?php echo htmlspecialchars($currentUser['name']); ?></div>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- CSRF Token for forms -->
    <script>
        window.csrfToken = '<?php echo $auth->getCsrfToken(); ?>';
    </script>