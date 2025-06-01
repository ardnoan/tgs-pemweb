<?php
// auth.php - Enhanced Authentication System
session_start();

class Auth {
    private $conn;
    
    public function __construct($connection) {
        $this->conn = $connection;
    }
    
    public function login($email, $password) {
        try {
            // Use prepared statement to prevent SQL injection
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE Email = :email AND Active = 1");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            
            $user = $stmt->fetch();
            
            if ($user) {
                // Check if password is using old MD5 (for backward compatibility)
                if (strlen($user['Password']) === 32 && ctype_xdigit($user['Password'])) {
                    // Old MD5 password
                    if (md5($password) === $user['Password']) {
                        // Update to new password hash
                        $this->updatePasswordHash($user['email'], $password);
                        return $this->createSession($user);
                    }
                } else {
                    // New password_hash verification
                    if (password_verify($password, $user['Password'])) {
                        return $this->createSession($user);
                    }
                }
            }
            
            return false;
            
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }
    
    private function updatePasswordHash($email, $plainPassword) {
        try {
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("UPDATE user SET Password = :password WHERE email = :email");
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Password update error: " . $e->getMessage());
        }
    }
    
    private function createSession($user) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        session_regenerate_id(true); // Prevent session fixation attacks

        $_SESSION['email'] = $user['Email'];
        $_SESSION['name'] = isset($user['Nama']) && !empty($user['Nama']) ? $user['Nama'] : $user['Email'];
        $_SESSION['login_time'] = time();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    public function logout() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Clear all session data
        $_SESSION = array();

        // Destroy session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        return true;
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['email']) && !empty($_SESSION['email']);
    }
    
    public function requireAuth() {
        if (!$this->isLoggedIn()) {
            header("Location: login.php");
            exit();
        }
        
        // Check session timeout (24 hours)
        if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 86400)) {
            $this->logout();
            header("Location: login.php?timeout=1");
            exit();
        }
    }
    
    public function getCsrfToken() {
        return $_SESSION['csrf_token'] ?? '';
    }
    
    public function validateCsrfToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            return [
                'email' => $_SESSION['email'],
            ];
        }
        return null;
    }
}

// Create global auth instance
require_once 'db.php';
$auth = new Auth($conn);
?>