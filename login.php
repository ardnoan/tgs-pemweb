<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background: url('background.jpg') no-repeat center center fixed;
      background-size: cover;
    }

    .login-container {
      max-width: 400px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      text-align: center;
    }

    .login-container h2 {
      margin-bottom: 20px;
    }

    .login-container input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      box-sizing: border-box;
    }

    .login-container button {
      width: 100%;
      padding: 10px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .login-container button:hover {
      background-color: #0056b3;
    }

    img {
      display: block;
      margin: 0 auto 20px;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <img src="teguh.jpg" height="200" alt="Logo">
    <h2>TOKO 123</h2>
    <form action="login.php" method="post">
      <input type="text" name="Email" placeholder="Nama" required>
      <input type="password" name="Password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      require 'db.php';
      $Email = $_POST['Email'];
      $Password = md5($_POST['Password']); // Hash password dengan md5
      try {
        $stmt = $conn->prepare("SELECT * FROM user WHERE Email = :Email AND Password = :Password and Active=1");
        $stmt->bindParam(':Email', $Email);
        $stmt->bindParam(':Password', $Password);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
          // Start the session and store user information
          session_start();
          $_SESSION['Email'] = $result['Email'];
          header("Location: content.php");
          exit();
        } else {
          echo "<p style='color:red;'>Invalid Email or password.</p>";
        }
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    }
    ?>
  </div>
</body>

</html>