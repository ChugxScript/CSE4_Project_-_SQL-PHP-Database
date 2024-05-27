<?php
include '../../config/connect.php';

$limit = 10; // Number of rows per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page number, default is 1
$start = ($page - 1) * $limit; // Calculate starting row for the query
$table = isset($_GET['table']) ? $_GET['table'] : 'student'; // Get table name, default is 'student'

// Validate table name to prevent SQL injection
$valid_tables = ['student', 'advisor', 'department', 'course'];
if (!in_array($table, $valid_tables)) {
    die("Invalid table name");
}

function fetchTableData($conn, $table, $start, $limit) {
    $sql = "SELECT * FROM $table LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $start, $limit);
    $stmt->execute();
    return $stmt->get_result();
}

function generateTableHTML($result, $table) {
    $html = '<table class="table-fixed w-full rounded">
        <thead>
            <tr class="bg-slate-950">';
    
    // Add table headers based on the table name
    if ($table === 'student') {
        $html .= '<th class="w-1/4 px-4 py-2 text-left text-white">Student ID</th>
                  <th class="w-1/4 px-4 py-2 text-left text-white">Advisor ID</th>
                  <th class="w-1/4 px-4 py-2 text-left text-white">User ID</th>
                  <th class="w-1/4 px-4 py-2 text-left text-white">First Name</th>
                  <th class="w-1/4 px-4 py-2 text-left text-white">Last Name</th>
                  <th class="w-1/4 px-4 py-2 text-left text-white">Action</th>';
    }
    // Add other tables headers here
    // else if ($table === 'advisor') { ... }

    $html .= '</tr></thead><tbody>';
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $html .= '<tr class="odd:bg-slate-900 even:bg-slate-800">';
            if ($table === 'student') {
                $html .= "<td class='px-4 py-2 text-left text-white'>" . $row["student_id"] . "</td>
                            <td class='px-4 py-2 text-left text-white'>" . $row["advisor_id"] . "</td>
                            <td class='px-4 py-2 text-left text-white'>" . $row["user_id"] . "</td>
                            <td class='px-4 py-2 text-left text-white'>" . $row["first_name"] . "</td>
                            <td class='px-4 py-2 text-left text-white'>" . $row["last_name"] . "</td>
                            <td class='px-4 py-2 text-left text-white flex-initial flex-auto'>
                                <button class='action-button delete' data-table='student'>
                                    <i class='fas fa-trash-alt'></i>
                                    <span class='tooltip'>DELETE</span>
                                </button>
                                <button class='action-button update' data-table='student'>
                                    <i class='fas fa-pencil-alt'></i>
                                    <span class='tooltip'>UPDATE</span>
                                </button>
                            </td>";
            }
            // Add other tables data here
            // else if ($table === 'advisor') { ... }

            $html .= "</tr>";
        }
    } else {
        $html .= "<tr><td colspan='6' class='px-4 py-2 text-left text-white'>No data found</td></tr>";
    }

    $html .= '</tbody></table>';
    return $html;
}

$result = fetchTableData($conn, $table, $start, $limit);
echo generateTableHTML($result, $table);

$conn->close();
?>


