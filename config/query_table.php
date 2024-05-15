<?php
include('function.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['table_name']) && !empty($_POST['table_name']) && isset($_POST['page']) && !empty($_POST['page'])) {
        $conn = getDB();
        $page = (int)$_POST['page'];
        $rowsPerPage = 10;
        $offset = ($page - 1) * $rowsPerPage;

        switch ($_POST['table_name']) {
            case 'STUDENT-ADVISOR':
                $result = queryStudentToAdvisor($conn, $rowsPerPage, $offset);
                break;
            case 'ADVISOR-DEPARTMENT':
                $result = queryAdvisorToDepartment($conn, $rowsPerPage, $offset);
                break;
            case 'COURSE':
                $result = queryCourse($conn, $rowsPerPage, $offset);
                break;
            default:
                echo "[ERROR] Invalid 'query'";
                exit;
        }

        // Get total number of rows
        $totalRows = getTotalRows($conn, $_POST['table_name']);

        // Calculate total number of pages
        $totalPages = ceil($totalRows / $rowsPerPage);

        // Output the results
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
                echo "<span class='page-link-b' data-page='$i'>$i</span> ";
            }
            echo "</div>";
        } else {
            echo "No records found";
        }
    } else {
        echo "[ERROR] Invalid 'query'";
    }
} else {
    echo "[ERROR] Invalid request method";
}

function getTotalRows($conn, $tableName) {
    switch ($tableName) {
        case 'STUDENT-ADVISOR':
            $sql = "SELECT COUNT(*) as total FROM `student` LEFT JOIN `advisor` ON `student`.`advisor_id` = `advisor`.`advisor_id`";
            break;
        case 'ADVISOR-DEPARTMENT':
            $sql = "SELECT COUNT(*) as total FROM `advisor` LEFT JOIN `department` ON `advisor`.`department_id` = `department`.`department_id`";
            break;
        case 'COURSE':
            $sql = "SELECT COUNT(*) as total FROM `course`";
            break;
        default:
            return 0;
    }

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}

function queryStudentToAdvisor($conn, $rowsPerPage, $offset){
    $sql = "SELECT `student`.*, `advisor`.`advisor_id` AS `advisor.advisor_id`, `advisor`.`department_id`, `advisor`.`first_name` AS `advisor.first_name`, `advisor`.`last_name` AS `advisor.last_name` 
            FROM `student` 
            LEFT JOIN `advisor` ON `student`.`advisor_id` = `advisor`.`advisor_id`
            LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $offset, $rowsPerPage);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    return $result;
}

function queryAdvisorToDepartment($conn, $rowsPerPage, $offset){
    $sql = "SELECT `advisor`.*, `department`.`department_id` AS `department.id`, `department`.`department_name` AS `department.name`, `department`.`location`
            FROM `advisor`
            LEFT JOIN `department` ON `advisor`.`department_id` = `department`.`department_id`
            LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $offset, $rowsPerPage);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    return $result;
}

function queryCourse($conn, $rowsPerPage, $offset){
    $sql = "SELECT * FROM `course`
            LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $offset, $rowsPerPage);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    return $result;
}
?>
