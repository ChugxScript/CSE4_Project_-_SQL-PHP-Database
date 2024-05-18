<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet">
    <title>Database Project using SQL on phpMyAdmin</title>
</head>
<body>
    <?php 
        include('config/function.php');
        $conn = getDB();
        $tables = getTables($conn);
    ?>
    <div class="canvas" id="canvas">
        <div class="sidebar">
            <div class="sidebar-top">
                <h1>CSE4-PROJECT</h1>
            </div>
            <div class="sidebar-mid">
                <p class="menu-item" data-content="create_container">CREATE</p>
                <p class="menu-item" data-content="read_container">READ</p>
                <p class="menu-item" data-content="update_container">UPDATE</p>
                <p class="menu-item" data-content="delete_container">DELETE</p>
                <p class="menu-item" data-content="query_container">QUERY</p>
            </div>
            <div class="sidebar-bottom">
                <p>CREATED BY: OLORS</p>
            </div>
        </div>


        <!-- main content -->

        <div class="main-contents">
        <!-- CREATE -->
            <div class="crud_create" id="create_container">
                <h1>DATABASE CREATE ROW IN TABLE</h1>
                <div class="table-category">
                    <?php
                    foreach ($tables as $table) {
                        $selectedClass = ($table == 'advisor') ? 'selected-table-c' : '';
                        echo '<span class="table-select-c ' . $selectedClass . '" data-table-c="' . $table . '">' . strtoupper($table) . '</span>';
                    }
                    ?>
                </div>
                <div id="create-form-container">
                    <!-- form will display here -->
                </div>
            </div>

        <!-- READ -->
            <div class="db-tables" id="read_container">
                <h1>DATABASE VIEW TABLES</h1>
                <div class="table-category">
                    <?php
                    foreach ($tables as $table) {
                        $selectedClass = ($table == 'advisor') ? 'selected-table' : '';
                        echo '<span class="table-select ' . $selectedClass . '" data-table="' . $table . '">' . strtoupper($table) . '</span>';
                    }
                    ?>
                </div>
                <div id="table-data-container">
                    <!-- Table data will be displayed here -->
                </div>
            </div>

        <!-- UPDATE -->
            <div class="crud-update" id="update_container">
                <h1>DATABASE UPDATE ROW</h1>
                <div class="table-category">
                    <?php
                    foreach ($tables as $table) {
                        $selectedClass = ($table == 'advisor') ? 'selected-table-u' : '';
                        echo '<span class="table-select-u ' . $selectedClass . '" data-table-u="' . $table . '">' . strtoupper($table) . '</span>';
                    }
                    ?>
                </div>
                <div id="update-form-container">
                    <!-- form will display here -->
                </div>
            </div>
        
        <!-- DELETE -->
            <div class="crud-delete" id="delete_container">
                <h1>DATABASE DELETE ROW</h1>
                <div class="table-category">
                    <?php
                    foreach ($tables as $table) {
                        $selectedClass = ($table == 'advisor') ? 'selected-table-d' : '';
                        echo '<span class="table-select-d ' . $selectedClass . '" data-table-d="' . $table . '">' . strtoupper($table) . '</span>';
                    }
                    ?>
                </div>
                <div id="delete-form-container">
                    <!-- form will display here -->
                </div>
            </div>
        
        
        <!-- QUERY -->
            <div class="query" id="query_container">
                <h1>DATABASE QUERIES (RELATIONSHIPS)</h1>
                <div class="table-category">
                    <span class="table-select-q" data-table-q="STUDENT-ADVISOR" id="STUDENT-ADVISOR">STUDENT-ADVISOR</span>
                    <span class="table-select-q" data-table-q="ADVISOR-DEPARTMENT">ADVISOR-DEPARTMENT</span>
                    <span class="table-select-q" data-table-q="COURSE">COURSE</span>
                </div>
                <div id="query-table-container">
                    <!-- table will display here -->
                </div>
            </div>
            
        </div>
    </div>


    <script src="assets/script.js"></script>
    <!-- <script src="assets/handle_row_form.js"></script> -->
    <script src="assets/create_row.js"></script>
    <script src="assets/read_tables.js"></script>
    <script src="assets/update_row.js"></script>
    <script src="assets/delete_row.js"></script>
    <script src="assets/query_db.js"></script>
    <script src="assets/menu_items.js"></script>
</body>
</html>