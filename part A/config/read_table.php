<?php
include('function.php');

if (isset($_POST['table_name']) && isset($_POST['page'])) {
    $tableName = $_POST['table_name'];
    $page = (int)$_POST['page'];
    $rowsPerPage = 10;
    $offset = ($page - 1) * $rowsPerPage;

    $conn = getDB();
    
    // Get the total number of rows
    $totalQuery = "SELECT COUNT(*) AS total FROM $tableName";
    $totalResult = $conn->query($totalQuery);
    $totalRow = $totalResult->fetch_assoc();
    $totalRows = $totalRow['total'];
    $totalPages = ceil($totalRows / $rowsPerPage);

    // Fetch the data with limit and offset
    $query = "SELECT * FROM $tableName LIMIT $rowsPerPage OFFSET $offset";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr>";
        // Fetch field names
        $fields = $result->fetch_fields();
        foreach ($fields as $field) {
            echo "<th>" . $field->name . "</th>";
        }
        echo "</tr>";
        
        // Fetch rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        // Output pagination
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<span class='page-link' data-page='$i'>$i</span> ";
        }
        echo "</div>";
    } else {
        echo "No data found";
    }
} else {
    echo "Table name or page not provided";
}
?>
