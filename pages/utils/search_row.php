<?php
include '../../config/connect.php';

if (isset($_GET['user']) && isset($_GET['query']) && isset($_GET['table']) && isset($_GET['page'])) {
    $user = $_GET['user'];
    $searchTerm = $_GET['query'];
    $table = $_GET['table'];
    $page = $_GET['page'] ? intval($_GET['page']) : 1;

    switch($table){
        case "student":
            echo search_student_table($conn, $searchTerm, $page, $user);
            break;
        case "advisor":
            echo search_advisor_table($conn, $searchTerm, $page, $user);
            break;
        case "department":
            echo search_dept_table($conn, $searchTerm, $page, $user);
            break;
        case "course":
            echo search_course_table($conn, $searchTerm, $page, $user);
            break;
        default:
            echo "[ERROR] Invalid table or search does not exist.";
            break;
    }
    
} else {
    echo "[ERROR] Invalid query or search does not exist or page not found.";
}

function search_student_table($conn, $searchTerm, $page, $user) {
    $limit = 10;
    $offset = ($page - 1) * $limit;
    $searchTerm = "%" . $conn->real_escape_string($searchTerm) . "%";

    // Count the total number of results
    $count_sql = "SELECT COUNT(*) AS total
                  FROM student s 
                  JOIN advisor a ON s.advisor_id = a.advisor_id 
                  JOIN users u ON s.user_id = u.user_id 
                  WHERE s.student_id LIKE ? 
                  OR s.first_name LIKE ? 
                  OR s.last_name LIKE ? 
                  OR s.assigned_sex LIKE ? 
                  OR a.advisor_id LIKE ? 
                  OR a.first_name LIKE ? 
                  OR a.last_name LIKE ? 
                  OR a.assigned_sex LIKE ? 
                  OR u.user_id LIKE ? 
                  OR u.username LIKE ? 
                  OR u.password LIKE ?";
    
    $stmt = $conn->prepare($count_sql);
    $stmt->bind_param("sssssssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $count_result = $stmt->get_result();
    $total_results = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_results / $limit);

    $sql = "SELECT s.student_id, 
                   s.first_name AS student_first_name, 
                   s.last_name AS student_last_name, 
                   s.assigned_sex AS student_assigned_sex,
                   a.advisor_id, 
                   a.first_name AS advisor_first_name, 
                   a.last_name AS advisor_last_name, 
                   a.assigned_sex AS advisor_assigned_sex,
                   u.user_id, 
                   u.username, 
                   u.password 
            FROM student s 
            JOIN advisor a ON s.advisor_id = a.advisor_id 
            JOIN users u ON s.user_id = u.user_id 
            WHERE s.student_id LIKE ? 
            OR s.first_name LIKE ? 
            OR s.last_name LIKE ? 
            OR s.assigned_sex LIKE ? 
            OR a.advisor_id LIKE ? 
            OR a.first_name LIKE ? 
            OR a.last_name LIKE ? 
            OR a.assigned_sex LIKE ? 
            OR u.user_id LIKE ? 
            OR u.username LIKE ? 
            OR u.password LIKE ?
            LIMIT ?, ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssii", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $html = '<table class="table-fixed w-full rounded">
            <thead>
                <tr class="bg-slate-950">
                    <th class="w-1/4 px-2 py-2 text-left text-white">Student ID</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">First Name (Student)</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Last Name (Student)</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Assigned Sex</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Advisor ID</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">First Name (Advisor)</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Last Name (Advisor)</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Assigned Sex</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Student User ID</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Username</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Password</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Action</th>
                </tr>
            </thead>
            <tbody>';

        switch($user){
            case "admin":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_first_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_last_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_assigned_sex"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_first_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_last_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_assigned_sex"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["user_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["username"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["password"] . "</td>
                                <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
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
                break;

            case "registrar":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_first_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_last_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_assigned_sex"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_first_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_last_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_assigned_sex"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["user_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["username"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["password"] . "</td>
                                <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
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
                break;

            case "student":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_id"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_first_name"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_last_name"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_assigned_sex"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_id"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_first_name"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_last_name"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_assigned_sex"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["user_id"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["username"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["password"] . "</td>
                                    <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
                                    <button class='action-button view' data-table='student'>
                                        <i class='fas fa-eye'></i>
                                        <span class='tooltip'>VIEW DETAILS</span>
                                    </button>
                                </td>
                            </tr>";
                }
                break;

            case "advisor":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_id"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_first_name"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_last_name"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["student_assigned_sex"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_id"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_first_name"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_last_name"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_assigned_sex"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["user_id"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["username"] . "</td>
                                    <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["password"] . "</td>
                                    <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
                                    <button class='action-button view' data-table='student'>
                                        <i class='fas fa-eye'></i>
                                        <span class='tooltip'>VIEW DETAILS</span>
                                    </button>
                                </td>
                            </tr>";
                }
                break;
        }
        
        $html .= "</tbody></table>";

        // Pagination
        $html .= '<div class="pagination mt-4">
                    <div class="pagination-container">';
        for ($i = 1; $i <= $total_pages; $i++) {
            $active_class = $i == $page ? 'bg-gray-800' : 'bg-gray-600';
            $html .= "<button onclick='searchRow(\"" . htmlspecialchars($user) . "\", \"" . htmlspecialchars($searchTerm) . "\", \"student\", $i)' class='px-3 py-1 rounded $active_class text-white'>$i</button>";
        }
        $html .= '</div></div>';

        return $html;
    } else {
        return '[ERROR] No results found.';
    }
}

function search_advisor_table($conn, $searchTerm, $page, $user) {
    $limit = 10;
    $offset = ($page - 1) * $limit;
    $searchTerm = "%" . $conn->real_escape_string($searchTerm) . "%";

    // Count the total number of results
    $count_sql = "SELECT COUNT(*) AS total
                  FROM advisor a 
                  JOIN department d ON a.department_id = d.department_id 
                  JOIN users u ON a.user_id = u.user_id 
                  WHERE a.advisor_id LIKE ? 
                  OR a.first_name LIKE ? 
                  OR a.last_name LIKE ? 
                  OR a.assigned_sex LIKE ? 
                  OR d.department_id LIKE ? 
                  OR d.department_name LIKE ? 
                  OR d.course_id LIKE ? 
                  OR d.location LIKE ? 
                  OR u.user_id LIKE ? 
                  OR u.username LIKE ? 
                  OR u.password LIKE ?";
    
    $stmt = $conn->prepare($count_sql);
    $stmt->bind_param("sssssssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $count_result = $stmt->get_result();
    $total_results = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_results / $limit);

    $total_pages = ceil($total_results / $limit);

    $sql = "SELECT a.advisor_id, 
                    a.first_name AS advisor_first_name, 
                    a.last_name AS advisor_last_name, 
                    a.assigned_sex AS advisor_assigned_sex,
                    d.department_id, 
                    d.department_name AS dept_dept_name, 
                    d.course_id AS dept_dept_course_id, 
                    d.location AS dept_dept_location, 
                    u.user_id, 
                    u.username, 
                    u.password 
            FROM advisor a 
            JOIN department d ON a.department_id = d.department_id 
            JOIN users u ON a.user_id = u.user_id
            WHERE a.advisor_id LIKE ? 
            OR a.first_name LIKE ? 
            OR a.last_name LIKE ? 
            OR a.assigned_sex LIKE ? 
            OR d.department_id LIKE ? 
            OR d.department_name LIKE ? 
            OR d.course_id LIKE ? 
            OR d.location LIKE ? 
            OR u.user_id LIKE ? 
            OR u.username LIKE ? 
            OR u.password LIKE ?
            LIMIT ?, ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssii", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $html = '<table class="table-fixed w-full rounded">
            <thead>
                <tr class="bg-slate-950">
                    <th class="w-1/4 px-2 py-2 text-left text-white">Advisor ID</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">First Name</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Last Name</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Assigned Sex</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Dept ID</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Dept Name</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Dept Course</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Location</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Advisor User ID</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Username</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Password</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Action</th>
                </tr>
            </thead>
            <tbody>';

        switch($user){
            case "admin":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_first_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_last_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_assigned_sex"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["department_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["dept_dept_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["dept_dept_course_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["dept_dept_location"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["user_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["username"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["password"] . "</td>
                                <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
                                    <button class='action-button delete' data-table='advisor'>
                                        <i class='fas fa-trash-alt'></i>
                                        <span class='tooltip'>DELETE</span>
                                    </button>
                                    <button class='action-button update' data-table='advisor'>
                                        <i class='fas fa-pencil-alt'></i>
                                        <span class='tooltip'>UPDATE</span>
                                    </button>
                                    <button class='action-button view' data-table='advisor'>
                                        <i class='fas fa-eye'></i>
                                        <span class='tooltip'>VIEW DETAILS</span>
                                    </button>
                                </td>
                            </tr>";
                }
                break;

            case "registrar":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_first_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_last_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_assigned_sex"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["department_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["dept_dept_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["dept_dept_course_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["dept_dept_location"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["user_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["username"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["password"] . "</td>
                                <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
                                    <button class='action-button update' data-table='advisor'>
                                        <i class='fas fa-pencil-alt'></i>
                                        <span class='tooltip'>UPDATE</span>
                                    </button>
                                    <button class='action-button view' data-table='advisor'>
                                        <i class='fas fa-eye'></i>
                                        <span class='tooltip'>VIEW DETAILS</span>
                                    </button>
                                </td>
                            </tr>";
                }
                break;

            case "student":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_first_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_last_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_assigned_sex"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["department_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["dept_dept_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["dept_dept_course_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["dept_dept_location"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["user_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["username"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["password"] . "</td>
                                <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
                                    <button class='action-button view' data-table='advisor'>
                                        <i class='fas fa-eye'></i>
                                        <span class='tooltip'>VIEW DETAILS</span>
                                    </button>
                                </td>
                            </tr>";
                }
                break;
            case "advisor":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_first_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_last_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["advisor_assigned_sex"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["department_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["dept_dept_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["dept_dept_course_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["dept_dept_location"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["user_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["username"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["password"] . "</td>
                                <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
                                    <button class='action-button view' data-table='advisor'>
                                        <i class='fas fa-eye'></i>
                                        <span class='tooltip'>VIEW DETAILS</span>
                                    </button>
                                </td>
                            </tr>";
                }
                break;
        }
        $html .= "</tbody></table>";

        // Pagination
        $html .= '<div class="pagination mt-4">
                    <div class="pagination-container">';
        for ($i = 1; $i <= $total_pages; $i++) {
            $active_class = $i == $page ? 'bg-gray-800' : 'bg-gray-600';
            $html .= "<button onclick='searchRow(\"" . htmlspecialchars($user) . "\", \"" . htmlspecialchars($searchTerm) . "\", \"student\", $i)' class='px-3 py-1 rounded $active_class text-white'>$i</button>";
        }
        $html .= '</div></div>';

        return $html;
    } else {
        return '[ERROR] No results found.';
    }
}

function search_dept_table($conn, $searchTerm, $page, $user) {
    $limit = 10;
    $offset = ($page - 1) * $limit;
    $searchTerm = "%" . $conn->real_escape_string($searchTerm) . "%";

    // Count the total number of results
    $count_sql = "SELECT COUNT(*) AS total 
                  FROM department d
                  JOIN course c ON d.course_id = c.course_id
                  WHERE d.department_id LIKE ? 
                  OR d.department_name LIKE ? 
                  OR c.course_id LIKE ? 
                  OR c.course_name LIKE ? 
                  OR d.location LIKE ?";
    
    $stmt = $conn->prepare($count_sql);
    $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $count_result = $stmt->get_result();
    $total_results = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_results / $limit);

    $sql = "SELECT d.department_id, 
                    d.department_name, 
                    c.course_id, 
                    c.course_name AS crs_course_name, 
                    d.location
            FROM department d 
            JOIN course c ON d.course_id = c.course_id
            WHERE d.department_id LIKE ? 
            OR d.department_name LIKE ? 
            OR c.course_id LIKE ? 
            OR c.course_name LIKE ? 
            OR d.location LIKE ?
            LIMIT ?, ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssii", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $html = '<table class="table-fixed w-full rounded">
            <thead>
                <tr class="bg-slate-950">
                    <th class="w-1/4 px-2 py-2 text-left text-white">Dept ID</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Dept Name</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Dept Course</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Course Name</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Location</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Action</th>
                </tr>
            </thead>
            <tbody>';

        switch($user){
            case "admin":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["department_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["department_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["course_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["crs_course_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["location"] . "</td>
                                <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
                                    <button class='action-button delete' data-table='department'>
                                        <i class='fas fa-trash-alt'></i>
                                        <span class='tooltip'>DELETE</span>
                                    </button>
                                    <button class='action-button update' data-table='department'>
                                        <i class='fas fa-pencil-alt'></i>
                                        <span class='tooltip'>UPDATE</span>
                                    </button>
                                    <button class='action-button view' data-table='department'>
                                        <i class='fas fa-eye'></i>
                                        <span class='tooltip'>VIEW DETAILS</span>
                                    </button>
                                </td>
                            </tr>";
                }
                break;

            case "registrar":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["department_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["department_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["course_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["crs_course_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["location"] . "</td>
                                <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
                                    <button class='action-button update' data-table='department'>
                                        <i class='fas fa-pencil-alt'></i>
                                        <span class='tooltip'>UPDATE</span>
                                    </button>
                                    <button class='action-button view' data-table='department'>
                                        <i class='fas fa-eye'></i>
                                        <span class='tooltip'>VIEW DETAILS</span>
                                    </button>
                                </td>
                            </tr>";
                }
                break;

            case "student":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["department_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["department_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["course_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["crs_course_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["location"] . "</td>
                                <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
                                    <button class='action-button view' data-table='department'>
                                        <i class='fas fa-eye'></i>
                                        <span class='tooltip'>VIEW DETAILS</span>
                                    </button>
                                </td>
                            </tr>";
                }
                break;

            case "advisor":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["department_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["department_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["course_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["crs_course_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["location"] . "</td>
                                <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
                                    <button class='action-button view' data-table='department'>
                                        <i class='fas fa-eye'></i>
                                        <span class='tooltip'>VIEW DETAILS</span>
                                    </button>
                                </td>
                            </tr>";
                }
                break;
        }
        
        $html .= "</tbody></table>";

        // Pagination
        $html .= '<div class="pagination mt-4">
                    <div class="pagination-container">';
        for ($i = 1; $i <= $total_pages; $i++) {
            $active_class = $i == $page ? 'bg-gray-800' : 'bg-gray-600';
            $html .= "<button onclick='searchRow(\"" . htmlspecialchars($user) . "\", \"" . htmlspecialchars($searchTerm) . "\", \"department\", $i)' class='px-3 py-1 rounded $active_class text-white'>$i</button>";
        }
        $html .= '</div></div>';

        return $html;
    } else {
        return '[ERROR] No results found.';
    }
}

function search_course_table($conn, $searchTerm, $page, $user) {
    $limit = 10;
    $offset = ($page - 1) * $limit;
    $searchTerm = "%" . $conn->real_escape_string($searchTerm) . "%";

    // Count the total number of results
    $count_sql = "SELECT COUNT(*) AS total 
                  FROM course 
                  WHERE course_id LIKE ? 
                  OR course_name LIKE ? 
                  OR credits LIKE ?";
    
    $stmt = $conn->prepare($count_sql);
    $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $count_result = $stmt->get_result();
    $total_results = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_results / $limit);

    // Main query
    $sql = "SELECT course_id, 
                   course_name, 
                   credits
            FROM course 
            WHERE course_id LIKE ? 
            OR course_name LIKE ? 
            OR credits LIKE ?
            LIMIT ?, ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssii', $searchTerm, $searchTerm, $searchTerm, $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $html = '<table class="table-fixed w-full rounded">
            <thead>
                <tr class="bg-slate-950">
                    <th class="w-1/4 px-2 py-2 text-left text-white">Course ID</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Course Name</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Credits</th>
                    <th class="w-1/4 px-2 py-2 text-left text-white">Action</th>
                </tr>
            </thead>
            <tbody>';
        
        switch($user){
            case "admin":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["course_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["course_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["credits"] . "</td>
                                <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
                                    <button class='action-button delete' data-table='course'>
                                        <i class='fas fa-trash-alt'></i>
                                        <span class='tooltip'>DELETE</span>
                                    </button>
                                    <button class='action-button update' data-table='course'>
                                        <i class='fas fa-pencil-alt'></i>
                                        <span class='tooltip'>UPDATE</span>
                                    </button>
                                    <button class='action-button view' data-table='course'>
                                        <i class='fas fa-eye'></i>
                                        <span class='tooltip'>VIEW DETAILS</span>
                                    </button>
                                </td>
                            </tr>";
                }
                break;

            case "registrar":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["course_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["course_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["credits"] . "</td>
                                <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
                                    <button class='action-button update' data-table='course'>
                                        <i class='fas fa-pencil-alt'></i>
                                        <span class='tooltip'>UPDATE</span>
                                    </button>
                                    <button class='action-button view' data-table='course'>
                                        <i class='fas fa-eye'></i>
                                        <span class='tooltip'>VIEW DETAILS</span>
                                    </button>
                                </td>
                            </tr>";
                }
                break;

            case "student":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["course_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["course_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["credits"] . "</td>
                                <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
                                    <button class='action-button view' data-table='course'>
                                        <i class='fas fa-eye'></i>
                                        <span class='tooltip'>VIEW DETAILS</span>
                                    </button>
                                </td>
                            </tr>";
                }
                break;

            case "advisor":
                while ($row = $result->fetch_assoc()) {
                    $html .= "<tr class='odd:bg-slate-900 even:bg-slate-800'>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["course_id"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["course_name"] . "</td>
                                <td class='px-2 py-2 text-left text-white fixed-width'>" . $row["credits"] . "</td>
                                <td class='px-2 py-2 text-left text-white flex-initial flex-auto'>
                                    <button class='action-button view' data-table='course'>
                                        <i class='fas fa-eye'></i>
                                        <span class='tooltip'>VIEW DETAILS</span>
                                    </button>
                                </td>
                            </tr>";
                }
                break;
        }

        
        $html .= "</tbody></table>";

        // Pagination
        $html .= '<div class="pagination mt-4">
                    <div class="pagination-container">';
        for ($i = 1; $i <= $total_pages; $i++) {
            $active_class = $i == $page ? 'bg-gray-800' : 'bg-gray-600';
            $html .= "<button onclick='searchRow(\"" . htmlspecialchars($user) . "\", \"" . htmlspecialchars($searchTerm) . "\", \"course\", $i)' class='px-3 py-1 rounded $active_class text-white'>$i</button>";
        }
        $html .= '</div></div>';

        return $html;
    } else {
        return '[ERROR] No results found.';
    }
}

?>
