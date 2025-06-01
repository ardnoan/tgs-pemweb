<?php include("header.php"); ?>
<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 sidebar">
      <?php include("menu.php"); ?>
    </nav>
    <main class="col-md-10 content">
      <div class="card">
        <div class="card-header">
          <?php echo $_GET["table"]; ?>
        </div>
        <div class="card-body">
          <?php //isi 
          ?>
          <!-- Main content -->
          <main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-4 content">
            <form method="post" class="mb-4">
              <div class="input-group">
                <input type="text" id="search" name="search" class="form-control"
                  placeholder="Search" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></
                      button>
                </div>
              </div>
            </form>
            <button class="btn btn-success btn-sm" data-toggle="modal" data
              target="#insertModal"><i class="fas fa-plus"></i>&nbsp;Insert</button>
            <br><br>
            <?php
            require 'db.php';
            $table_name = $_GET["table"];
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

            $search = isset($_POST['search']) ? $_POST['search'] : '';
            $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
            $records_per_page = 10;
            $offset = ($page - 1) * $records_per_page;
            // Validate table name to prevent SQL injection
            if (preg_match('/^[a-zA-Z0-9_]+$/', $table_name)) {
              try {
                // Get the column names
                $stmt = $conn->query("SHOW COLUMNS FROM $table_name");
                $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
                if ($columns) {
                  // Build the search query
                  $searchQuery = "";
                  if ($search) {
                    $searchQuery = " WHERE ";
                    $conditions = [];
                    foreach ($columns as $column) {
                      $conditions[] = "$column LIKE :search";
                    }
                    $searchQuery .= implode(" OR ", $conditions);
                  }
                  // Get the total number of records
                  $totalStmt = $conn->prepare("SELECT COUNT(*) FROM $table_name $searchQuery");
                  if ($search) {
                    $totalStmt->execute(['search' => "%$search%"]);
                  } else {
                    $totalStmt->execute();
                  }
                  $total_rows = $totalStmt->fetchColumn();
                  // Prepare and execute the query
                  $stmt = $conn->prepare("SELECT * FROM $table_name $searchQuery LIMIT :limit OFFSET :offset");
                  if ($search) {
                    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
                  }
                  $stmt->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
                  $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                  $stmt->execute();
                  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  if ($rows) {
                    echo '<div class="table-responsive">';
                    echo '<table class="table table-bordered table-striped">';
                    echo '<thead class="thead-dark">';
                    echo '<tr>';
                    foreach (array_keys($rows[0]) as $column_name) {
                      echo "<th scope='col'>$column_name</th>";
                    }
                    echo '<th scope="col">Action</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    foreach ($rows as $row) {
                      $row_json = htmlspecialchars(json_encode($row));
                      echo '<tr>';
                      foreach ($row as $cell) {
                        echo "<td>$cell</td>";
                      }
                      echo '<td>
                              <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#viewModal" data-row="' . $row_json . '"><i class="fas fa-eye"></i>&nbsp;View</button>
                              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal" data-row="' . $row_json . '"><i class="fas fa-edit"></i>&nbsp;Edit</button>
                              <a href="delete.php?table=' . $table_name . '&id=' . $row[$primaryKey] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\');"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                            </td>';
                      echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                    // Display pagination
                    $total_pages = ceil($total_rows / $records_per_page);
                    echo '<nav>';
                    echo '<ul class="pagination">';
                    for ($i = 1; $i <= $total_pages; $i++) {
                      $active = $i == $page ? 'active' : '';
                      echo "<li class='page-item $active'><form method='post' style='display: inl ine;'><input type='hidden' name='table_name' value='" . htmlspecialchars($table_name) . "'><input type='hidden' name='search' value='" . htmlspecialchars($search) . "'><button type='submit' name='page' value='$i' class='page-link'>$i</button></form></li>";
                    }
                    echo '</ul>';
                    echo '</nav>';
                  } else {
                    echo '<div class="alert alert-warning">No data found in the table.</div>';
                  }
                } else {
                  echo '<div class="alert alert-danger">Invalid table name.</div>';
                }
              } catch (PDOException $e) {
                echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
              }
            } else {
              echo '<div class="alert alert-danger">Invalid table name.</div>';
            }
            ?>
          </main>
          <?php //akhir isi 
          ?>
        </div>
      </div>
    </main>
  </div>
</div>
<!-- Insert Modal -->
<div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria
  labelledby="insertModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="insertModalLabel">Insert Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for inserting data -->
        <form id="insertForm" action="insert_data.php?table=<?php echo htmlspecialchars($table_name); ?>" method="post">
          <?php
          foreach ($columns as $column) {
            if ($column != 'id') { // Assuming 'id' is an auto-increment column
              echo '<div class="form-group">';
              echo '<label for="' . $column . '">' . ucfirst($column) . ':</label>';
              echo '<input type="text" class="form-control" id="' . $column . '" name="' . $column . '" required>';
              echo '</div>';
            }
          }
          ?>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria
  labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for editing data -->
        <form id="editForm" action="edit_data.php?table=<?php echo htmlspecialchars($table_name); ?>" method="post">
          <?php
          foreach ($columns as $column) {
            echo '<div class="form-group">';
            echo '<label for="edi t_' .
              $column . '">' . ucfirst($column) . ':</label>';
            echo '<input type="text" class="form-control" id="edit_' . $column . '" name="' . $column . '" required>';
            echo '</div>';
          }
          ?>
          <input type="hidden" id="edit_<?php echo $primaryKey; ?>" name="<?php echo $primaryKey; ?>">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</
                button>
              <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria
  labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel">View Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for viewing data -->
        <form id="viewForm">
          <?php
          foreach ($columnNames as $column) {
            echo '<div class="form-group">';
            echo '<label for="view_' . $column . '">' . ucfirst($column) . ':</label>';
            echo '<input type="text" class="form-control" id="view_' . $column . '" name="' .
              $column . '" readonly>';
            echo '</div>';
          }
          ?>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</
                button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include("footer.php"); ?>
<script>
  $('#editModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var row = button.data('row'); // Extract info from data-* attributes
    var modal = $(this);
    // Populate the form fields in the modal with the data from the row
    for (var key in row) {
      if (row.hasOwnProperty(key)) {
        modal.find('#edit_' + key).val(row[key]);
      }
    }
  });
  $('#viewModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var row = button.data('row'); // Extract info from data-* attributes
    var modal = $(this);
    // Populate the form fields in the modal with the data from the row
    for (var key in row) {
      if (row.hasOwnProperty(key)) {
        modal.find('#view_' + key).val(row[key]);
      }
    }
  });
</script>