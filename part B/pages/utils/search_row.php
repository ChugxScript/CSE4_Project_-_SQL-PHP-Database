<?php
include '../../config/connect.php';

if (isset($_GET['query']) && isset($_GET['table'])) {
    $table = $_GET['table'];
    $searchTerm = $_GET['query'];

    switch($table){
        case "student":
            echo search_student_table($conn, $searchTerm);
            break;
        case "advisor":
            echo search_advisor_table($conn, $searchTerm);
            break;
        case "department":
            echo search_dept_table($conn, $searchTerm);
            break;
        case "course":
            echo search_course_table($conn, $searchTerm);
            break;
        default:
            echo "[ERROR] Invalid table or search does not exist.";
            break;
    }
} else {
    echo "[ERROR] Invalid query or search does not exist. ";
}

function search_student_table($conn, $searchTerm) {
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
            WHERE s.student_id LIKE ? 
            OR s.first_name LIKE ? 
            OR s.last_name LIKE ? 
            OR a.advisor_id LIKE ? 
            OR a.first_name LIKE ? 
            OR a.last_name LIKE ? 
            OR u.user_id LIKE ? 
            OR u.username LIKE ? 
            OR u.password LIKE ?";
            
    $stmt = $conn->prepare($sql);
    $searchTermWithWildcards = "%" . $searchTerm . "%";
    $stmt->bind_param("sssssssss", $searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $html = '<table class="table-fixed w-full rounded">
            <thead>
                <tr class="bg-slate-950">
                    <th class="w-1/4 px-4 py-2 text-left text-white">Student ID</th>
                    <th class="w-1/4 px-4 py-2 text-left text-white">First Name (Student)</th>
                    <th class="w-1/4 px-4 py-2 text-left text-white">Last Name (Student)</th>
                    <th class="w-1/4 px-4 py-2 text-left text-white">Advisor ID</th>
                    <th class="w-1/4 px-4 py-2 text-left text-white">First Name (Advisor)</th>
                    <th class="w-1/4 px-4 py-2 text-left text-white">Last Name (Advisor)</th>
                    <th class="w-1/4 px-4 py-2 text-left text-white">Student User ID</th>
                    <th class="w-1/4 px-4 py-2 text-left text-white">Username</th>
                    <th class="w-1/4 px-4 py-2 text-left text-white">Password</th>
                    <th class="w-1/4 px-4 py-2 text-left text-white">Action</th>
                </tr>
            </thead>
            <tbody>';

        while ($row = $result->fetch_assoc()) {
            $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                        <td class='px-4 py-2 text-left text-white fixed-width'>" . $row["student_id"] . "</td>
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
                        </td>
                    </tr>";
        }
        $html .= "</tbody></table>";
        return $html;
    } else {
        return '[ERROR] No results found.';
    }
}
?>
