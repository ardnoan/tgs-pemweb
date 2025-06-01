<?php
$host = 'localhost';
$dbname = 'toko_123';
$username = 'root';
$password = 'password';
try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Could not connect to the database $dbname :" . $e->getMessage());
}
