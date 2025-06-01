<?php
require 'db.php';
$table_name = $_GET["table"];
// Validate table name to prevent SQL injection
if (!preg_match('/^[a-zA-Z0-9_]+$/', $table_name)) {
  die('Invalid table name');
}
try {
  // Get the column names
  $stmt = $conn->query("SHOW COLUMNS FROM $table_name");
  $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
  // Prepare the insert statement
  $columnNames = array_filter($columns, function ($column) {
    return $column != 'id'; // Assuming 'id' is an auto-increment column
  });
  $columnPlaceholders = array_map(function ($column) {
    return ":$column";
  }, $columnNames);
  $sql = "INSERT INTO $table_name (" . implode(', ', $columnNames) . ") VALUES (" . implode(',', $columnPlaceholders) . ")";
  $stmt = $conn->prepare($sql);
  // Bind the form values to the statement
  foreach ($columnNames as $column) {
    $stmt->bindValue(":$column", $_POST[$column]);
  }
  // Execute the statement
  if ($stmt->execute()) {
    header("Location: list.php?table=$table_name&message=Data inserted successfully");
    exit();
  } else {
    echo 'Error inserting data';
  }
} catch (PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}
