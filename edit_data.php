<?php
require 'db.php';
$table_name = $_GET["table"];
// Validate table name to prevent SQL injection
if (!preg_match('/^[a-zA-Z0-9_]+$/', $table_name)) {
  die('Invalid table name');
}
try {
  // Get the column names and primary key
  $stmt = $conn->query("SHOW COLUMNS FROM $table_name");
  $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // Extract column names and detect primary key
  $columnNames = [];
  $primaryKey = null;
  foreach ($columns as $column) {
    $columnNames[] = $column['Field'];
    if ($column['Key'] === 'PRI') {
      $primaryKey = $column['Field'];
    }
  }
  // Check if primary key is detected
  if (!$primaryKey) {
    die('Primary key not found');
  }
  // Prepare the update statement
  $columnPlaceholders = array_map(function ($column) {
    return "$column = :$column";
  }, $columnNames);
  $sql = "UPDATE $table_name SET " . implode(', ', $columnPlaceholders) . " WHERE $primaryKey = :$primaryKey";
  $stmt = $conn->prepare($sql);
  // Bind the form values to the statement
  foreach ($columnNames as $column) {
    $stmt->bindValue(":$column", $_POST[$column]);
  }
  // Execute the statement
  if ($stmt->execute()) {
    header("Location: list.php?table=$table_name&message=Data updated successfully");
    exit();
  } else {
    echo 'Error updating data';
  }
} catch (PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}
