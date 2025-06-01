<?php
require 'db.php';
$table_name = $_GET["table"];
$primaryKeyValue = $_GET["id"];
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
// Validate table name to prevent SQL injection
if (!preg_match('/^[a-zA-Z0-9_]+$/', $table_name)) {
  die('Invalid table name');
}
try {
  // Prepare the delete statement
  $sql = "DELETE FROM $table_name WHERE $primaryKey = :$primaryKeyValue";
  $stmt = $conn->prepare($sql);
  // Bind the primary key value to the statement
  $stmt->bindValue(":$primaryKeyValue", $primaryKeyValue, PDO::PARAM_INT);
  // Execute the statement
  if ($stmt->execute()) {
    header("Location: list.php?table=$table_name&message=Data deleted successfully");
    exit();
  } else {
    echo 'Error deleting data';
  }
} catch (PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}
