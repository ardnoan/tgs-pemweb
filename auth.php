<?php
// auth.php - Enhanced Authentication System
session_start();

class Auth
{
  private $conn;
  private $maxLoginAttempts = 5;
  private $lockoutTime = 900; // 15 minutes in seconds

  public function __construct($connection)
  {
    $this->conn = $connection;
    $this->createLoginAttemptsTable();
  }

  /**
   * Create login attempts table if it doesn't exist
   */
  private function createLoginAttemptsTable()
  {
    try {
      $sql = "CREATE TABLE IF NOT EXISTS login_attempts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(100) NOT NULL,
                ip_address VARCHAR(45) NOT NULL,
                attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                success BOOLEAN DEFAULT FALSE,
                INDEX idx_email_time (email, attempt_time),
                INDEX idx_ip_time (ip_address, attempt_time)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

      $this->conn->exec($sql);
    } catch (PDOException $e) {
      error_log("Failed to create login_attempts table: " . $e->getMessage());
    }
  }

  /**
   * Check if account is locked due to too many failed attempts
   */
  private function isAccountLocked($email)
  {
    try {
      $stmt = $this->conn->prepare("
                SELECT COUNT(*) as failed_attempts 
                FROM login_attempts 
                WHERE email = :email 
                AND success = FALSE 
                AND attempt_time > DATE_SUB(NOW(), INTERVAL :lockout_time SECOND)
            ");
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':lockout_time', $this->lockoutTime, PDO::PARAM_INT);
      $stmt->execute();

      $result = $stmt->fetch();
      return $result['failed_attempts'] >= $this->maxLoginAttempts;
    } catch (PDOException $e) {
      error_log("Error checking account lock status: " . $e->getMessage());
      return false;
    }
  }

  /**
   * Log login attempt
   */
  private function logLoginAttempt($email, $success = false)
  {
    try {
      $ipAddress = $this->getClientIP();
      $stmt = $this->conn->prepare("
                INSERT INTO login_attempts (email, ip_address, success) 
                VALUES (:email, :ip_address, :success)
            ");
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':ip_address', $ipAddress, PDO::PARAM_STR);
      $stmt->bindParam(':success', $success, PDO::PARAM_BOOL);
      $stmt->execute();
    } catch (PDOException $e) {
      error_log("Error logging login attempt: " . $e->getMessage());
    }
  }

  /**
   * Get client IP address
   */
  private function getClientIP()
  {
    $ipKeys = ['HTTP_CF_CONNECTING_IP', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
    foreach ($ipKeys as $key) {
      if (!empty($_SERVER[$key])) {
        $ip = $_SERVER[$key];
        if (strpos($ip, ',') !== false) {
          $ip = trim(explode(',', $ip)[0]);
        }
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
          return $ip;
        }
      }
    }
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
  }

  /**
   * Enhanced login method with improved security
   */
  public function login($email, $password)
  {
    // Input validation
    if (empty($email) || empty($password)) {
      return ['success' => false, 'message' => 'Email dan password harus diisi.'];
    }

    // Email format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !$this->isValidUsername($email)) {
      return ['success' => false, 'message' => 'Format email tidak valid.'];
    }

    // Check if account is locked
    if ($this->isAccountLocked($email)) {
      $this->logLoginAttempt($email, false);
      return [
        'success' => false,
        'message' => 'Akun terkunci karena terlalu banyak percobaan login yang gagal. Coba lagi dalam 15 menit.'
      ];
    }

    try {
      // Use prepared statement to prevent SQL injection
      $stmt = $this->conn->prepare("SELECT * FROM user WHERE Email = :email AND Active = 1");
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->execute();

      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        $passwordValid = false;

        // Check if password is using old MD5 (for backward compatibility)
        if (strlen($user['Password']) === 32 && ctype_xdigit($user['Password'])) {
          // Old MD5 password
          if (hash_equals($user['Password'], md5($password))) {
            $passwordValid = true;
            // Update to new password hash for security
            $this->updatePasswordHash($user['Email'], $password);
          }
        } else {
          // New password_hash verification
          if (password_verify($password, $user['Password'])) {
            $passwordValid = true;
          }
        }

        if ($passwordValid) {
          $this->logLoginAttempt($email, true);
          $this->createSession($user);
          return ['success' => true, 'message' => 'Login berhasil.'];
        }
      }

      // Login failed
      $this->logLoginAttempt($email, false);
      return ['success' => false, 'message' => 'Email atau password salah.'];
    } catch (PDOException $e) {
      error_log("Login error: " . $e->getMessage());
      return ['success' => false, 'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'];
    }
  }

  /**
   * Check if username is valid (for non-email usernames like 'admin', 'kasir')
   */
  private function isValidUsername($username)
  {
    return preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username);
  }

  /**
   * Update password hash to modern secure format
   */
  private function updatePasswordHash($email, $plainPassword)
  {
    try {
      $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
      $stmt = $this->conn->prepare("UPDATE user SET Password = :password WHERE Email = :email");
      $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->execute();

      error_log("Password updated to secure hash for user: " . $email);
    } catch (PDOException $e) {
      error_log("Password update error: " . $e->getMessage());
    }
  }

  /**
   * Create secure session
   */
  private function createSession($user)
  {
    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
    }

    // Prevent session fixation attacks
    session_regenerate_id(true);

    // Store user information in session
    $_SESSION['email'] = $user['Email'];
    $_SESSION['name'] = isset($user['Nama']) && !empty($user['Nama']) ? $user['Nama'] : $user['Email'];
    $_SESSION['login_time'] = time();
    $_SESSION['last_activity'] = time();
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $_SESSION['ip_address'] = $this->getClientIP();
  }


  /**
   * Enhanced logout method
   */
  public function logout()
  {
    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
    }

    // Clear all session data
    $_SESSION = array();

    // Destroy session cookie
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(
        session_name(),
        '',
        time() - 3600,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
      );
    }

    session_destroy();
    return true;
  }

  /**
   * Check if user is logged in with enhanced security checks
   */
  public function isLoggedIn()
  {
    if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
      return false;
    }

    // Check session timeout (24 hours)
    if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 86400)) {
      $this->logout();
      return false;
    }

    // Check for session inactivity (2 hours)
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 7200)) {
      $this->logout();
      return false;
    }

    // Check for session hijacking
    if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] !== ($_SERVER['HTTP_USER_AGENT'] ?? '')) {
      $this->logout();
      error_log("Potential session hijacking detected for user: " . $_SESSION['email']);
      return false;
    }

    // Update last activity
    $_SESSION['last_activity'] = time();

    return true;
  }

  /**
   * Require authentication with enhanced checks
   */
  public function requireAuth($redirectUrl = 'login.php')
  {
    if (!$this->isLoggedIn()) {
      // Determine redirect reason
      $reason = '';
      if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 86400)) {
        $reason = '?timeout=1';
      } elseif (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 7200)) {
        $reason = '?inactive=1';
      }

      header("Location: " . $redirectUrl . $reason);
      exit();
    }
  }

  /**
   * Get CSRF token
   */
  public function getCsrfToken()
  {
    if (!isset($_SESSION['csrf_token'])) {
      $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
  }

  /**
   * Validate CSRF token
   */
  public function validateCsrfToken($token)
  {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
  }

  /**
   * Get current user information
   */
  public function getCurrentUser()
  {
    if ($this->isLoggedIn()) {
      return [
        'email' => $_SESSION['email'],
        'name' => $_SESSION['name'] ?? $_SESSION['email'],
        'login_time' => $_SESSION['login_time'] ?? null,
        'last_activity' => $_SESSION['last_activity'] ?? null
      ];
    }
    return null;
  }

  /**
   * Clean up old login attempts (should be called periodically)
   */
  public function cleanupLoginAttempts()
  {
    try {
      $stmt = $this->conn->prepare("
                DELETE FROM login_attempts 
                WHERE attempt_time < DATE_SUB(NOW(), INTERVAL 24 HOUR)
            ");
      $stmt->execute();
    } catch (PDOException $e) {
      error_log("Error cleaning up login attempts: " . $e->getMessage());
    }
  }

  /**
   * Get remaining lockout time for an account
   */
  public function getRemainingLockoutTime($email)
  {
    try {
      $stmt = $this->conn->prepare("
                SELECT MAX(attempt_time) as last_attempt
                FROM login_attempts 
                WHERE email = :email 
                AND success = FALSE 
                AND attempt_time > DATE_SUB(NOW(), INTERVAL :lockout_time SECOND)
            ");
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);
      $stmt->bindParam(':lockout_time', $this->lockoutTime, PDO::PARAM_INT);
      $stmt->execute();

      $result = $stmt->fetch();
      if ($result && $result['last_attempt']) {
        $lastAttempt = strtotime($result['last_attempt']);
        $unlockTime = $lastAttempt + $this->lockoutTime;
        $remaining = $unlockTime - time();
        return max(0, $remaining);
      }

      return 0;
    } catch (PDOException $e) {
      error_log("Error getting lockout time: " . $e->getMessage());
      return 0;
    }
  }
}

// Create global auth instance
require_once 'db.php';
$auth = new Auth($conn);

// Cleanup old login attempts periodically (1% chance on each page load)
if (mt_rand(1, 100) === 1) {
  $auth->cleanupLoginAttempts();
}
