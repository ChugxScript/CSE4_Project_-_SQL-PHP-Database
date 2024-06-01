<?php
include '../../config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['table']) && !empty($_POST['table'])) {

        switch ($_POST['table']) {
            case 'advisor':
                echo createAdvisor($conn);
                break;
            case 'course':
                echo createCourse($conn);
                break;
            case 'department':
                echo createDepartment($conn);
                break;
            case 'student':
                echo createStudent($conn);
                break;
            default:
                echo "[ERROR] Invalid 'table'";
                break;
        }
    } else {
        echo "[ERROR] Invalid 'table'";
    }
} else {
    echo "[ERROR] Invalid request method";
}

function createStudent($conn) {
    $student_id = $_POST['create_student_id'];
    $advisor_id = $_POST['create_advisor_id_s'];
    $first_name = $_POST['create_first_name_s'];
    $last_name = $_POST['create_last_name_s'];
    $assigned_sex = $_POST['create_sex_s'];
    $users_user_name = $_POST['create_user_username'];
    $users_password = $_POST['create_user_password'];
    $users_role = $_POST['create_users_role'];
    $message = '';

    // Validate inputs
    if (!preg_match("/^TUPM-\d{2}-\d{4}$/", $student_id)) {
        return '[ERROR] Invalid student_id format.';
    }

    $required_fields = [$advisor_id, $first_name, $last_name, $assigned_sex, $users_user_name, $users_password, $users_role];
    foreach ($required_fields as $field) {
        if (empty($field)) {
            return '[ERROR] All fields are required.';
        }
    }

    // Check if advisor_id exists
    if (!checkIfExists($conn, 'advisor', 'advisor_id', $advisor_id)) {
        return '[ERROR] Advisor ID does not exist.';
    }

    // Check if student_id already exists
    if (checkIfExists($conn, 'student', 'student_id', $student_id)) {
        return '[ERROR] student ID already exists.';
    }

    // Check if username already exists
    if (checkIfExists($conn, 'users', 'username', $users_user_name)) {
        return '[ERROR] username already exists.';
    }

    // Insert new user into the users table
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $users_user_name, $users_password, $users_role);
    if (!$stmt->execute()) {
        $stmt->close();
        return '[ERROR] Creating user: ' . $stmt->error;
    }
    
    // Get the user_id of the newly inserted user
    $user_id = $stmt->insert_id;
    $stmt->close();

    // Insert new student into the students table
    $sql = "INSERT INTO student (student_id, advisor_id, user_id, first_name, last_name, assigned_sex) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisss", $student_id, $advisor_id, $user_id, $first_name, $last_name, $assigned_sex);
    if ($stmt->execute()) {
        $message = '[SUCCESS] Student has been created.';
    } else {
        $message = '[ERROR] Creating student: ' . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    return $message;
}

function createAdvisor($conn){
    $advisor_id = $_POST['create_advisor_id_a'];
    $department_id = $_POST['create_dept_id_a'];
    $first_name = $_POST['create_first_name_a'];
    $last_name = $_POST['create_last_name_a'];
    $assigned_sex = $_POST['create_sex_a'];
    $users_user_name = $_POST['create_user_username_a'];
    $users_password = $_POST['create_user_password_a'];
    $users_role = $_POST['create_users_role_a'];
    $message = '';

    if (!preg_match("/^TUPM-P-\d{2}-\d{4}$/", $advisor_id)) {
        return '[ERROR] Invalid advisor ID format.';
    }

    $required_fields = [$advisor_id, $department_id, $first_name, $last_name, $assigned_sex, $users_user_name, $users_password, $users_role];
    foreach ($required_fields as $field) {
        if (empty($field)) {
            return '[ERROR] All fields are required.';
        }
    }

    // Check if department_id exists
    if (!checkIfExists($conn, 'department', 'department_id', $department_id)) {
        return '[ERROR] Department ID does not exist.';
    }

    // Check if advisor_id already exists
    if (checkIfExists($conn, 'advisor', 'advisor_id', $advisor_id)) {
        return '[ERROR] advisor ID already exists.';
    }

    // Check if username already exists
    if (checkIfExists($conn, 'users', 'username', $users_user_name)) {
        return '[ERROR] username already exists.';
    }


    // Insert new user into the users table
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $users_user_name, $users_password, $users_role);
    if (!$stmt->execute()) {
        $stmt->close();
        return '[ERROR] Creating user: ' . $stmt->error;
    }
    
    // Get the user_id of the newly inserted user
    $user_id = $stmt->insert_id;
    $stmt->close();

    // Insert new advisor into the advisor table
    $sql = "INSERT INTO advisor (advisor_id, department_id, user_id, first_name, last_name, assigned_sex) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisss", $advisor_id, $department_id, $user_id, $first_name, $last_name, $assigned_sex);
    if ($stmt->execute()) {
        $message = '[SUCCESS] Advisor has been created.';
    } else {
        $message = '[ERROR] Creating advisor: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    return $message;
}

function createDepartment($conn) {
    $department_id = $_POST['create_dept_id_d'];
    $course_id = $_POST['create_course_id_d'];
    $department_name = $_POST['create_dept_name_d'];
    $location = $_POST['create_location_d'];
    $message = '';

    // Validate inputs
    if (!preg_match("/^TUPM-D-\d{4}$/", $department_id)) {
        return '[ERROR] Invalid department_id format.';
    }

    $required_fields = [$department_id, $course_id, $department_name, $location];
    foreach ($required_fields as $field) {
        if (empty($field)) {
            return '[ERROR] All fields are required.';
        }
    }

    // Check if course_id exists
    if (!checkIfExists($conn, 'course', 'course_id', $course_id)) {
        return '[ERROR] Course ID does not exist.';
    }

    // Check if department_id already exists
    if (checkIfExists($conn, 'department', 'department_id', $department_id)) {
        return '[ERROR] department ID already exists.';
    }

    // Check if department name already exists
    if (checkIfExists($conn, 'department', 'department_name', $department_name)) {
        return '[ERROR] department name already exists.';
    }

    // Insert new department into the department table
    $sql = "INSERT INTO department (department_id, course_id, department_name, location) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $department_id, $course_id, $department_name, $location);
    if ($stmt->execute()) {
        $message = '[SUCCESS] Department has been created.';
    } else {
        $message = '[ERROR] Creating department: ' . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    return $message;
}

function createCourse($conn) {
    $course_id = $_POST['create_course_id_c'];
    $course_name = $_POST['create_course_name_c'];
    $credits = $_POST['create_credits_c'];
    $message = '';

    $required_fields = [$course_id, $course_name, $credits];
    foreach ($required_fields as $field) {
        if (empty($field)) {
            return '[ERROR] All fields are required.';
        }
    }

    // Check if course_id exists
    if (checkIfExists($conn, 'course', 'course_id', $course_id)) {
        return '[ERROR] Course ID already exist.';
    }

    // Check if course name already exists
    if (checkIfExists($conn, 'course', 'course_name', $course_name)) {
        return '[ERROR] course name already exists.';
    }

    // Insert new course into the course table
    $sql = "INSERT INTO course (course_id, course_name, credits) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $course_id, $course_name, $credits);
    if ($stmt->execute()) {
        $message = '[SUCCESS] Course has been created.';
    } else {
        $message = '[ERROR] Creating course: ' . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    return $message;
}

// Helper function to check if a record exists in a given table
function checkIfExists($conn, $table, $column, $value) {
    $sql = "SELECT 1 FROM $table WHERE $column = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    return $exists;
}


?>
