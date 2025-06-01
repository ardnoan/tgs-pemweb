<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Toko 123</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px;
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo-container img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .login-title {
            color: #333;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
        }
        
        .form-floating {
            margin-bottom: 20px;
        }
        
        .form-control {
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            margin-bottom: 20px;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 10;
        }
        
        .input-group {
            position: relative;
        }
        
        .loading {
            display: none;
        }
        
        .loading.show {
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="logo-container">
                <img src="logo.png" alt="Logo" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAiIGhlaWdodD0iODAiIHZpZXdCb3g9IjAgMCA4MCA4MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iNDAiIGN5PSI0MCIgcj0iNDAiIGZpbGw9IiM2NjdlZWEiLz4KPHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0id2hpdGUiIHg9IjIwIiB5PSIyMCI+CjxwYXRoIGQ9Ik0xMiAyQzYuNDggMiAyIDYuNDggMiAxMnM0LjQ4IDEwIDEwIDEwIDEwLTQuNDggMTAtMTBTMTcuNTIgMiAxMiAyem0tMiAxNWwtNS01IDEuNDEtMS40MUwxMCAxNC4xN2w3LjU5LTcuNTlMMTkgOGwtOSA5eiIvPgo8L3N2Zz4KPC9zdmc+'" />
            </div>
            
            <h2 class="login-title">TOKO 123</h2>
            
            <?php
            require_once 'auth.php';

            // Tambahkan fungsi sanitizeInput
            function sanitizeInput($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
                return $data;
            }
            
            $error = '';
            $success = '';
            
            // Check for timeout message
            if (isset($_GET['timeout'])) {
                $error = 'Sesi Anda telah berakhir. Silakan login kembali.';
            }
            
            // Check for logout message
            if (isset($_GET['logout'])) {
                $success = 'Anda telah berhasil logout.';
            }
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = sanitizeInput($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                
                if (empty($email) || empty($password)) {
                    $error = 'Email dan password harus diisi.';
                } else {
                    if ($auth->login($email, $password)) {
                        header("Location: content.php");
                        exit();
                    } else {
                        $error = 'Email atau password salah.';
                    }
                }
            }
            ?>
            
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= htmlspecialchars($success) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <form method="post" id="loginForm">
                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                    <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
                </div>
                
                <div class="form-floating">
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                    <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                </div>
                
                <button type="submit" class="btn btn-primary btn-login">
                    <span class="loading spinner-border spinner-border-sm me-2" role="status"></span>
                    <span class="btn-text">Login</span>
                </button>
            </form>
            
            <div class="text-center mt-3">
                <small class="text-muted">
                    &copy; <?= date('Y') ?> Toko 123. All rights reserved.
                </small>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        document.getElementById('loginForm').addEventListener('submit', function() {
            const loading = document.querySelector('.loading');
            const btnText = document.querySelector('.btn-text');
            
            loading.classList.add('show');
            btnText.textContent = 'Logging in...';
            
            document.querySelector('.btn-login').disabled = true;
        });
        
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>