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
    switch($table) {
        case "student":
            $sql = "SELECT s.student_id, 
                            s.first_name AS student_first_name, 
                            s.last_name AS student_last_name, 
                            a.advisor_id, 
                            a.first_name AS advisor_first_name, 
                            a.last_name AS advisor_last_name, 
                            u.user_id, 
                            u.username, 
                            u.password 
                    FROM student s 
                    JOIN advisor a ON s.advisor_id = a.advisor_id 
                    JOIN users u ON s.user_id = u.user_id 
                    LIMIT ?, ?";
            break;
        case "advisor":
            // Define SQL for advisor table
            $sql = "SELECT * FROM advisor LIMIT ?, ?";
            break;
        case "department":
            // Define SQL for department table
            $sql = "SELECT * FROM department LIMIT ?, ?";
            break;
        case "course":
            // Define SQL for course table
            $sql = "SELECT * FROM course LIMIT ?, ?";
            break;
        default:
            // Handle invalid table case
            die("Invalid table name");
    }

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
                  <th class="w-1/4 px-4 py-2 text-left text-white">First Name (Student)</th>
                  <th class="w-1/4 px-4 py-2 text-left text-white">Last Name (Student)</th>
                  <th class="w-1/4 px-4 py-2 text-left text-white">Advisor ID</th>
                  <th class="w-1/4 px-4 py-2 text-left text-white">First Name (Advisor)</th>
                  <th class="w-1/4 px-4 py-2 text-left text-white">Last Name (Advisor)</th>
                  <th class="w-1/4 px-4 py-2 text-left text-white">Student User ID</th>
                  <th class="w-1/4 px-4 py-2 text-left text-white">Username</th>
                  <th class="w-1/4 px-4 py-2 text-left text-white">Password</th>
                  <th class="w-1/4 px-4 py-2 text-left text-white">Action</th>';
    }
    // Add other tables headers here
    // else if ($table === 'advisor') { ... }

    $html .= '</tr></thead><tbody>';
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $html .= '<tr class="odd:bg-slate-900 even:bg-slate-800">';
            if ($table === 'student') {
                $html .= "<td class='px-4 py-2 text-left text-white fixed-width'>" . $row["student_id"] . "</td>
                            <td class='px-4 py-2 text-left text-white fixed-width'>" . $row["student_first_name"] . "</td>
                            <td class='px-4 py-2 text-left text-white fixed-width'>" . $row["student_last_name"] . "</td>
                            <td class='px-4 py-2 text-left text-white fixed-width'>" . $row["advisor_id"] . "</td>
                            <td class='px-4 py-2 text-left text-white fixed-width'>" . $row["advisor_first_name"] . "</td>
                            <td class='px-4 py-2 text-left text-white fixed-width'>" . $row["advisor_last_name"] . "</td>
                            <td class='px-4 py-2 text-left text-white fixed-width'>" . $row["user_id"] . "</td>
                            <td class='px-4 py-2 text-left text-white fixed-width'>" . $row["username"] . "</td>
                            <td class='px-4 py-2 text-left text-white fixed-width'>" . $row["password"] . "</td>
                            <td class='px-4 py-2 text-left text-white flex-initial flex-auto'>
                                <button class='action-button delete' data-table='student'>
                                    <i class='fas fa-trash-alt'></i>
                                    <span class='tooltip'>DELETE</span>
                                </button>
                                <button class='action-button update' data-table='student'>
                                    <i class='fas fa-pencil-alt'></i>
                                    <span class='tooltip'>UPDATE</span>
                                </button>
                                <button class='action-button view' data-table='student'>
                                    <i class='fas fa-eye'></i>
                                    <span class='tooltip'>VIEW DETAILS</span>
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


