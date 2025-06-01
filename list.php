<?php include("header.php"); ?>

<style>
/* Enhanced Main Content Styles */
.modern-content {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    padding: 20px;
}

.content-container {
    max-width: 100%;
    margin: 0 auto;
}

.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 15px;
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    margin: 0;
    text-transform: capitalize;
    letter-spacing: 1px;
}

.page-subtitle {
    font-size: 14px;
    opacity: 0.9;
    margin: 5px 0 0 0;
}

.modern-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 30px;
    border: none;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.modern-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.card-header-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 30px;
    border: none;
    font-weight: 600;
    font-size: 18px;
    position: relative;
}

.card-body-modern {
    padding: 30px;
}

/* Enhanced Search and Action Bar */
.action-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 15px;
}

.search-container {
    flex: 1;
    max-width: 400px;
    position: relative;
}

.modern-search {
    width: 100%;
    padding: 15px 20px 15px 50px;
    border: 2px solid #e0e6ed;
    border-radius: 50px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.modern-search:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    transform: translateY(-2px);
}

.search-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #667eea;
    font-size: 16px;
}

.search-btn {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 8px 15px;
    border-radius: 50px;
    color: white;
    transition: all 0.3s ease;
}

.search-btn:hover {
    transform: translateY(-50%) scale(1.05);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.btn-modern {
    padding: 12px 25px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.btn-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-modern:hover::before {
    left: 100%;
}

.btn-success-modern {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    color: white;
    box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
}

.btn-success-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
    color: white;
    text-decoration: none;
}

/* Enhanced Table Styles */
.table-container {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.modern-table {
    margin: 0;
    border: none;
}

.modern-table thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 20px 15px;
    border: none;
    position: relative;
}

.modern-table thead th::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: rgba(255, 255, 255, 0.3);
}

.modern-table tbody tr {
    transition: all 0.3s ease;
    border: none;
}

.modern-table tbody tr:nth-child(even) {
    background: #f8f9ff;
}

.modern-table tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    transform: scale(1.01);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.modern-table tbody td {
    padding: 15px;
    border: none;
    border-bottom: 1px solid #e0e6ed;
    vertical-align: middle;
    font-size: 14px;
}

/* Action Buttons Enhancement */
.action-buttons {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
}

.btn-sm-modern {
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
}

.btn-view {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
}

.btn-edit {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
    color: white;
}

.btn-delete {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
}

.btn-sm-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    color: white;
}

/* Enhanced Pagination */
.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

.modern-pagination {
    display: flex;
    gap: 5px;
    align-items: center;
}

.page-btn {
    padding: 10px 15px;
    border: 2px solid #e0e6ed;
    background: white;
    color: #667eea;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.page-btn:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
    text-decoration: none;
}

.page-btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #667eea;
}

/* Enhanced Modals */
.modal-content-modern {
    border-radius: 20px;
    border: none;
    overflow: hidden;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.modal-header-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px 30px;
    border: none;
}

.modal-title-modern {
    font-weight: 700;
    font-size: 20px;
    margin: 0;
}

.modal-body-modern {
    padding: 30px;
}

.form-group-modern {
    margin-bottom: 25px;
}

.form-label-modern {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
    display: block;
    font-size: 14px;
}

.form-control-modern {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid #e0e6ed;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #f8f9ff;
}

.form-control-modern:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: white;
}

.modal-footer-modern {
    padding: 20px 30px;
    border: none;
    background: #f8f9ff;
}

/* Alert Styles */
.alert-modern {
    border: none;
    border-radius: 15px;
    padding: 20px 25px;
    font-weight: 500;
    margin-bottom: 25px;
}

.alert-warning-modern {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    color: #856404;
}

.alert-danger-modern {
    background: linear-gradient(135deg, #f8d7da 0%, #fab1a0 100%);
    color: #721c24;
}

.alert-success-modern {
    background: linear-gradient(135deg, #d4edda 0%, #00b894 100%);
    color: #155724;
}

/* Loading Animation */
.loading {
    display: none;
    text-align: center;
    padding: 40px;
}

.loading-spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #667eea;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 0 auto 15px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .action-bar {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-container {
        max-width: none;
    }
    
    .page-header {
        padding: 20px;
        text-align: center;
    }
    
    .page-title {
        font-size: 24px;
    }
    
    .card-body-modern {
        padding: 20px;
    }
    
    .modern-table {
        font-size: 12px;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 5px;
    }
    
    .btn-sm-modern {
        width: 100%;
        justify-content: center;
    }
}

/* Animation Classes */
.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.slide-up {
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Additional CSS for enhanced styling */
.focused {
    transform: scale(1.02);
    transition: transform 0.2s ease;
}

.is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
}

.btn-delete:hover {
    background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%) !important;
}

/* Loading overlay */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    display: none;
    z-index: 9999;
    justify-content: center;
    align-items: center;
}

/* Print styles */
@media print {
    .action-buttons,
    .btn-modern,
    .search-container,
    .pagination-container {
        display: none !important;
    }
    
    .modern-card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
}

/* Enhanced responsive design */
@media (max-width: 576px) {
    .modal-dialog {
        margin: 10px;
    }
    
    .modal-body-modern {
        padding: 15px;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 8px;
    }
    
    .btn-sm-modern {
        padding: 10px;
        font-size: 12px;
    }
}
</style>

<div class="modern-content">
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 sidebar">
                <?php include("menu.php"); ?>
            </nav>
            <main class="col-md-10 content-container">
                <!-- Page Header -->
                <div class="page-header fade-in">
                    <h1 class="page-title">
                        <i class="fas fa-database"></i>
                        <?php echo htmlspecialchars(ucfirst($_GET["table"] ?? 'Data'), ENT_QUOTES); ?> Management
                    </h1>
                    <p class="page-subtitle">Manage your <?php echo htmlspecialchars($_GET["table"] ?? 'data', ENT_QUOTES); ?> records efficiently</p>
                </div>

                <!-- Main Card -->
                <div class="modern-card slide-up">
                    <div class="card-header-modern">
                        <i class="fas fa-table"></i> Data Table - <?php echo htmlspecialchars(ucfirst($_GET["table"] ?? ''), ENT_QUOTES); ?>
                    </div>
                    <div class="card-body-modern">
                        <!-- Action Bar -->
                        <div class="action-bar">
                            <!-- Search Form -->
                            <form method="post" class="search-container">
                                <div class="position-relative">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" 
                                           id="search" 
                                           name="search" 
                                           class="modern-search"
                                           placeholder="Search in all fields..." 
                                           value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search'], ENT_QUOTES) : ''; ?>">
                                    <button type="submit" class="search-btn">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>

                            <!-- Add Button -->
                            <button class="btn-modern btn-success-modern" data-toggle="modal" data-target="#insertModal">
                                <i class="fas fa-plus"></i>
                                Add New Record
                            </button>
                        </div>

                        <!-- Loading Indicator -->
                        <div class="loading" id="loadingIndicator">
                            <div class="loading-spinner"></div>
                            <p>Loading data...</p>
                        </div>

                        <!-- Data Table -->
                        <div id="tableContainer">
                            <?php
                            require 'db.php';
                            $table_name = $_GET["table"] ?? '';
                            
                            if (empty($table_name)) {
                                echo '<div class="alert-modern alert-danger-modern">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        No table specified. Please select a table from the menu.
                                      </div>';
                                exit;
                            }

                            // Validate table name to prevent SQL injection
                            if (!preg_match('/^[a-zA-Z0-9_]+$/', $table_name)) {
                                echo '<div class="alert-modern alert-danger-modern">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Invalid table name format.
                                      </div>';
                                exit;
                            }

                            try {
                                // Get the column names and primary key
                                $stmt = $conn->prepare("SHOW COLUMNS FROM `$table_name`");
                                $stmt->execute();
                                $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                if (empty($columns)) {
                                    throw new PDOException("Table not found or empty");
                                }

                                $columnNames = array_column($columns, 'Field');
                                $primaryKey = null;
                                foreach ($columns as $column) {
                                    if ($column['Key'] === 'PRI') {
                                        $primaryKey = $column['Field'];
                                        break;
                                    }
                                }

                                $search = $_POST['search'] ?? '';
                                $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
                                $records_per_page = 10;
                                $offset = ($page - 1) * $records_per_page;

                                // Build the search query
                                $searchQuery = "";
                                $params = [];
                                if ($search) {
                                    $conditions = [];
                                    foreach ($columnNames as $column) {
                                        $conditions[] = "`$column` LIKE :search";
                                    }
                                    $searchQuery = " WHERE " . implode(" OR ", $conditions);
                                    $params[':search'] = "%$search%";
                                }

                                // Get the total number of records
                                $totalStmt = $conn->prepare("SELECT COUNT(*) FROM `$table_name` $searchQuery");
                                $totalStmt->execute($params);
                                $total_rows = $totalStmt->fetchColumn();

                                // Prepare and execute the query with pagination
                                $stmt = $conn->prepare("SELECT * FROM `$table_name` $searchQuery LIMIT :limit OFFSET :offset");
                                
                                // Bind parameters
                                foreach ($params as $key => $value) {
                                    $stmt->bindValue($key, $value);
                                }
                                
                                $stmt->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
                                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                                $stmt->execute();
                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($rows) {
                                    echo '<div class="table-container">';
                                    echo '<table class="table modern-table">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    foreach (array_keys($rows[0]) as $column_name) {
                                        echo "<th>" . htmlspecialchars(ucfirst(str_replace('_', ' ', $column_name))) . "</th>";
                                    }
                                    echo '<th style="width: 200px;">Actions</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';
                                    
                                    foreach ($rows as $index => $row) {
                                        $row_json = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                                        echo '<tr style="animation-delay: ' . ($index * 0.1) . 's" class="fade-in">';
                                        foreach ($row as $cell) {
                                            $cell_display = strlen($cell) > 50 ? substr($cell, 0, 50) . '...' : $cell;
                                            echo "<td title='" . htmlspecialchars($cell, ENT_QUOTES) . "'>" . htmlspecialchars($cell_display) . "</td>";
                                        }
                                        echo '<td>
                                                <div class="action-buttons">
                                                    <button class="btn-sm-modern btn-view" 
                                                            data-toggle="modal" 
                                                            data-target="#viewModal" 
                                                            data-row="' . $row_json . '"
                                                            title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                        View
                                                    </button>
                                                    <button class="btn-sm-modern btn-edit" 
                                                            data-toggle="modal" 
                                                            data-target="#editModal" 
                                                            data-row="' . $row_json . '"
                                                            title="Edit Record">
                                                        <i class="fas fa-edit"></i>
                                                        Edit
                                                    </button>
                                                    <a href="delete.php?table=' . htmlspecialchars($table_name, ENT_QUOTES) . '&id=' . htmlspecialchars($row[$primaryKey], ENT_QUOTES) . '" 
                                                       class="btn-sm-modern btn-delete" 
                                                       onclick="return confirmDelete()"
                                                       title="Delete Record">
                                                        <i class="fas fa-trash-alt"></i>
                                                        Delete
                                                    </a>
                                                </div>
                                              </td>';
                                        echo '</tr>';
                                    }
                                    echo '</tbody>';
                                    echo '</table>';
                                    echo '</div>';

                                    // Display pagination
                                    $total_pages = ceil($total_rows / $records_per_page);
                                    if ($total_pages > 1) {
                                        echo '<div class="pagination-container">';
                                        echo '<div class="modern-pagination">';
                                        
                                        // Previous button
                                        if ($page > 1) {
                                            echo '<form method="post" style="display: inline;">
                                                    <input type="hidden" name="search" value="' . htmlspecialchars($search, ENT_QUOTES) . '">
                                                    <button type="submit" name="page" value="' . ($page-1) . '" class="page-btn">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </button>
                                                  </form>';
                                        }
                                        
                                        // Page numbers
                                        $start_page = max(1, $page - 2);
                                        $end_page = min($total_pages, $page + 2);
                                        
                                        for ($i = $start_page; $i <= $end_page; $i++) {
                                            $active = $i == $page ? 'active' : '';
                                            echo '<form method="post" style="display: inline;">
                                                    <input type="hidden" name="search" value="' . htmlspecialchars($search, ENT_QUOTES) . '">
                                                    <button type="submit" name="page" value="' . $i . '" class="page-btn ' . $active . '">' . $i . '</button>
                                                  </form>';
                                        }
                                        
                                        // Next button
                                        if ($page < $total_pages) {
                                            echo '<form method="post" style="display: inline;">
                                                    <input type="hidden" name="search" value="' . htmlspecialchars($search, ENT_QUOTES) . '">
                                                    <button type="submit" name="page" value="' . ($page+1) . '" class="page-btn">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </button>
                                                  </form>';
                                        }
                                        
                                        echo '</div>';
                                        echo '</div>';
                                    }

                                    // Display record count
                                    $start_record = ($page - 1) * $records_per_page + 1;
                                    $end_record = min($page * $records_per_page, $total_rows);
                                    echo '<div class="text-center mt-3" style="color: #666; font-size: 14px;">
                                            Showing ' . $start_record . ' to ' . $end_record . ' of ' . $total_rows . ' records
                                          </div>';
                                } else {
                                    echo '<div class="alert-modern alert-warning-modern text-center">
                                            <i class="fas fa-search"></i>
                                            <h5>No Data Found</h5>
                                            <p>No records match your search criteria. Try adjusting your search terms.</p>
                                          </div>';
                                }
                            } catch (PDOException $e) {
                                echo '<div class="alert-modern alert-danger-modern">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Database Error: ' . htmlspecialchars($e->getMessage()) . '
                                      </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

<!-- Enhanced Insert Modal -->
<div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-modern">
            <div class="modal-header modal-header-modern">
                <h5 class="modal-title modal-title-modern" id="insertModalLabel">
                    <i class="fas fa-plus-circle"></i>
                    Add New Record
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-modern">
                <form id="insertForm" action="insert_data.php?table=<?php echo htmlspecialchars($table_name, ENT_QUOTES); ?>" method="post">
                    <?php
                    if (isset($columns)) {
                        foreach ($columns as $column) {
                            if (strtolower($column['Field']) != 'id' && $column['Extra'] != 'auto_increment') {
                                echo '<div class="form-group-modern">';
                                echo '<label for="' . htmlspecialchars($column['Field']) . '" class="form-label-modern">';
                                echo '<i class="fas fa-tag"></i> ' . htmlspecialchars(ucfirst(str_replace('_', ' ', $column['Field'])));
                                if (strpos($column['Type'], 'NOT NULL') !== false) {
                                    echo ' <span style="color: #e74c3c;">*</span>';
                                }
                                echo ':</label>';
                                
                                $input_type = 'text';
                                if (strpos($column['Type'], 'date') !== false) {
                                    $input_type = 'date';
                                } elseif (strpos($column['Type'], 'email') !== false) {
                                    $input_type = 'email';
                                } elseif (strpos($column['Type'], 'int') !== false) {
                                    $input_type = 'number';
                                }
                                
                                echo '<input type="' . $input_type . '" 
                                             class="form-control-modern" 
                                             id="' . htmlspecialchars($column['Field']) . '" 
                                             name="' . htmlspecialchars($column['Field']) . '" 
                                             placeholder="Enter ' . htmlspecialchars(str_replace('_', ' ', $column['Field'])) . '"
                                             ' . (strpos($column['Type'], 'NOT NULL') !== false ? 'required' : '') . '>';
                                echo '</div>';
                            }
                        }
                    }
                    ?>
                    <div class="modal-footer modal-footer-modern">
                        <button type="button" class="btn-modern" data-dismiss="modal" style="background: #6c757d; color: white;">
                            <i class="fas fa-times"></i>
                            Cancel
                        </button>
                        <button type="submit" class="btn-modern btn-success-modern">
                            <i class="fas fa-save"></i>
                            Save Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-modern">
            <div class="modal-header modal-header-modern">
                <h5 class="modal-title modal-title-modern" id="viewModalLabel">
                    <i class="fas fa-eye"></i>
                    View Record Details
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-modern">
                <div id="viewContent">
                    <div class="row" id="viewFields">
                        <!-- Fields will be populated dynamically -->
                    </div>
                </div>
            </div>
            <div class="modal-footer modal-footer-modern">
                <button type="button" class="btn-modern" data-dismiss="modal" style="background: #6c757d; color: white;">
                    <i class="fas fa-times"></i>
                    Close
                </button>
                <button type="button" class="btn-modern btn-success-modern" onclick="editFromView()">
                    <i class="fas fa-edit"></i>
                    Edit Record
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-modern">
            <div class="modal-header modal-header-modern" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                <h5 class="modal-title modal-title-modern" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle"></i>
                    Confirm Delete
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-modern text-center">
                <div style="font-size: 48px; color: #dc3545; margin-bottom: 20px;">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <h4 style="color: #2c3e50; margin-bottom: 15px;">Are you sure?</h4>
                <p style="color: #6c757d; margin-bottom: 20px;">
                    This action cannot be undone. The record will be permanently deleted from the database.
                </p>
                <div id="deleteRecordInfo" style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin: 15px 0;">
                    <!-- Record info will be populated here -->
                </div>
            </div>
            <div class="modal-footer modal-footer-modern">
                <button type="button" class="btn-modern" data-dismiss="modal" style="background: #6c757d; color: white;">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <button type="button" class="btn-modern btn-delete" onclick="executeDelete()" id="confirmDeleteBtn">
                    <i class="fas fa-trash-alt"></i>
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Global variable to store current row data
let currentRowData = {};
let deleteUrl = '';

// Initialize modals when document is ready
$(document).ready(function() {
    // View Modal Event Handler
    $('#viewModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const rowData = button.data('row');
        currentRowData = rowData;
        
        populateViewModal(rowData);
    });

    // Delete Modal Event Handler
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        const deleteLink = $(this).attr('href');
        deleteUrl = deleteLink;
        
        // Extract record info from the row
        const row = $(this).closest('tr');
        const rowData = $(this).data('row') || extractRowData(row);
        
        populateDeleteModal(rowData);
        $('#deleteModal').modal('show');
    });

    // Form validation
    $('#insertForm').on('submit', function(e) {
        if (!validateForm(this)) {
            e.preventDefault();
            showAlert('Please fill in all required fields correctly.', 'danger');
        } else {
            showLoadingSpinner();
        }
    });

    // Real-time search functionality
    let searchTimeout;
    $('#search').on('input', function() {
        clearTimeout(searchTimeout);
        const searchTerm = $(this).val();
        
        searchTimeout = setTimeout(() => {
            if (searchTerm.length >= 2 || searchTerm.length === 0) {
                performSearch(searchTerm);
            }
        }, 500);
    });
});

// Populate View Modal with data
function populateViewModal(rowData) {
    const viewFields = $('#viewFields');
    viewFields.empty();
    
    let html = '';
    for (const [key, value] of Object.entries(rowData)) {
        const displayKey = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        const displayValue = value || '<em style="color: #999;">No data</em>';
        
        html += `
            <div class="col-md-6 mb-3">
                <div style="background: #f8f9ff; padding: 15px; border-radius: 10px; border-left: 4px solid #667eea;">
                    <label style="font-weight: 600; color: #2c3e50; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px; display: block;">
                        <i class="fas fa-tag" style="margin-right: 5px; color: #667eea;"></i>
                        ${displayKey}
                    </label>
                    <div style="color: #2c3e50; font-size: 14px; word-break: break-word;">${displayValue}</div>
                </div>
            </div>
        `;
    }
    
    viewFields.html(html);
}

// Populate Delete Modal with record info
function populateDeleteModal(rowData) {
    const deleteInfo = $('#deleteRecordInfo');
    let html = '<strong>Record to be deleted:</strong><br>';
    
    let count = 0;
    for (const [key, value] of Object.entries(rowData)) {
        if (count < 3) { // Show only first 3 fields
            const displayKey = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            html += `<small><strong>${displayKey}:</strong> ${value || 'N/A'}</small><br>`;
            count++;
        }
    }
    
    deleteInfo.html(html);
}

// Extract row data from table row (fallback method)
function extractRowData(row) {
    const data = {};
    const headers = [];
    
    // Get headers
    row.closest('table').find('thead th').each(function(index) {
        if (index < $(this).closest('table').find('thead th').length - 1) { // Exclude Actions column
            headers.push($(this).text().trim().toLowerCase().replace(/\s+/g, '_'));
        }
    });
    
    // Get row data
    row.find('td').each(function(index) {
        if (index < headers.length) {
            data[headers[index]] = $(this).text().trim();
        }
    });
    
    return data;
}

// Execute delete
function executeDelete() {
    if (deleteUrl) {
        showLoadingSpinner();
        window.location.href = deleteUrl;
    }
}

// Confirm delete (legacy function for onclick)
function confirmDelete() {
    return confirm('Are you sure you want to delete this record?');
}

// Form validation
function validateForm(form) {
    let isValid = true;
    $(form).find('input[required], select[required], textarea[required]').each(function() {
        if (!$(this).val().trim()) {
            $(this).addClass('is-invalid');
            isValid = false;
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    return isValid;
}

// Show loading spinner
function showLoadingSpinner() {
    $('#loadingIndicator').show();
    $('#tableContainer').hide();
}

// Show alert message
function showAlert(message, type = 'info') {
    const alertClass = `alert-${type}-modern`;
    const iconClass = type === 'danger' ? 'fas fa-exclamation-triangle' : 
                     type === 'success' ? 'fas fa-check-circle' : 'fas fa-info-circle';
    
    const alertHtml = `
        <div class="alert-modern ${alertClass}" style="margin-bottom: 20px;">
            <i class="${iconClass}"></i>
            ${message}
        </div>
    `;
    
    $('.card-body-modern').prepend(alertHtml);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        $('.alert-modern').first().fadeOut(() => {
            $(this).remove();
        });
    }, 5000);
}

// Perform AJAX search
function performSearch(searchTerm) {
    showLoadingSpinner();
    
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: { search: searchTerm },
        success: function(response) {
            const newTableContent = $(response).find('#tableContainer').html();
            $('#tableContainer').html(newTableContent);
            $('#loadingIndicator').hide();
            $('#tableContainer').show();
            
            // Reattach event handlers
            attachEventHandlers();
        },
        error: function() {
            showAlert('Search failed. Please try again.', 'danger');
            $('#loadingIndicator').hide();
            $('#tableContainer').show();
        }
    });
}

// Attach event handlers to dynamically loaded content
function attachEventHandlers() {
    $('.btn-delete').off('click').on('click', function(e) {
        e.preventDefault();
        const deleteLink = $(this).attr('href');
        deleteUrl = deleteLink;
        
        const row = $(this).closest('tr');
        const rowData = $(this).data('row') || extractRowData(row);
        
        populateDeleteModal(rowData);
        $('#deleteModal').modal('show');
    });
}

// Auto-hide alerts
$(document).on('click', '.alert-modern .close', function() {
    $(this).closest('.alert-modern').fadeOut();
});

// Keyboard shortcuts
$(document).keydown(function(e) {
    // Ctrl+N for new record
    if (e.ctrlKey && e.keyCode === 78) {
        e.preventDefault();
        $('#insertModal').modal('show');
    }
    
    // Escape to close modals
    if (e.keyCode === 27) {
        $('.modal').modal('hide');
    }
});

// Enhanced form styling
$(document).on('focus', '.form-control-modern', function() {
    $(this).parent().addClass('focused');
});

$(document).on('blur', '.form-control-modern', function() {
    $(this).parent().removeClass('focused');
});

// Print functionality
function printTable() {
    const printWindow = window.open('', '_blank');
    const tableContent = $('.table-container').html();
    
    printWindow.document.write(`
        <html>
        <head>
            <title>Data Table Print</title>
            <style>
                body { font-family: Arial, sans-serif; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .action-buttons { display: none; }
            </style>
        </head>
        <body>
            <h2><?php echo htmlspecialchars(ucfirst($_GET["table"] ?? ''), ENT_QUOTES); ?> Data</h2>
            ${tableContent}
        </body>
        </html>
    `);
    
    printWindow.document.close();
    printWindow.print();
}

// Export to CSV functionality
function exportToCSV() {
    const table = $('.modern-table')[0];
    let csv = [];
    
    // Get headers
    const headers = [];
    $(table).find('thead th').each(function(index) {
        if ($(this).text().trim() !== 'Actions') {
            headers.push($(this).text().trim());
        }
    });
    csv.push(headers.join(','));
    
    // Get data rows
    $(table).find('tbody tr').each(function() {
        const row = [];
        $(this).find('td').each(function(index) {
            if (index < headers.length) {
                row.push('"' + $(this).text().trim().replace(/"/g, '""') + '"');
            }
        });
        csv.push(row.join(','));
    });
    
    // Download CSV
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.setAttribute('hidden', '');
    a.setAttribute('href', url);
    a.setAttribute('download', '<?php echo htmlspecialchars($_GET["table"] ?? "data", ENT_QUOTES); ?>.csv');
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}
</script>
<?php include("footer.php"); ?>
