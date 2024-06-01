<?php
include '../../config/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['table']) && !empty($_POST['table'])) {

        switch ($_POST['table']) {
            case 'advisor':
                echo updateAdvisor($conn);
                break;
            case 'course':
                echo updateCourse($conn);
                break;
            case 'department':
                echo updateDepartment($conn);
                break;
            case 'student':
                echo updateStudent($conn);
                break;
            default:
                $message = "[ERROR] Invalid 'table'";
                echo $message;
                break;
        }
    } else {
        $message = "[ERROR] Invalid 'table'";
        echo $message;
    }
} else {
    $message = "[ERROR] Invalid request method";
    echo $message;
}

function updateStudent($conn) {
    $student_id = $_POST['update_student_id'];
    $first_name = $_POST['update_first_name'];
    $last_name = $_POST['update_last_name'];
    $assigned_sex = $_POST['update_sex_s'];
    $advisor_id = $_POST['update_advisor_id'];
    $user_id = $_POST['update_user_id'];
    $username = $_POST['update_username_s'];
    $password = $_POST['update_password_s'];
    $message = '';

    $required_fields = [$first_name, $last_name, $username, $password];
    foreach ($required_fields as $field) {
        if (empty($field)) {
            return '[ERROR] All fields are required.';
        }
    }

    // Check if username already exists
    $sql = "SELECT 1 FROM users WHERE username = ? AND user_id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $username, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return '[ERROR] username already exists.';
    }
    $stmt->close();

    $sql = "SELECT * FROM student WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE student 
                SET advisor_id = ?, user_id = ?, first_name = ?, last_name = ?, assigned_sex = ?
                WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sissss", $advisor_id, $user_id, $first_name, $last_name, $assigned_sex, $student_id);
        if ($stmt->execute()) {
            $message = '[SUCCESS]: Data has been updated.';
        } else {
            $message = '[ERROR]: Updating data: ' . $stmt->error;
        }
    } else {
        $message = '[ERROR]: student not found.';
    }

    $stmt->close();

    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE users 
                SET username = ?, password = ?
                WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $username, $password, $user_id);
        if ($stmt->execute()) {
            $message = '[SUCCESS] Data has been updated.';
        } else {
            $message = '[ERROR] Updating data: ' . $stmt->error;
        }
    } else {
        $message = '[ERROR] user ID not found.';
    }

    $stmt->close();
    $conn->close();
    return $message;
}

function updateAdvisor($conn) {
    $advisor_id = $_POST['update_advisor_id_a'];
    $department_id = $_POST['update_dept_id_a'];
    $first_name = $_POST['update_first_name_a'];
    $last_name = $_POST['update_last_name_a'];
    $assigned_sex = $_POST['update_sex_a'];
    $user_id = $_POST['update_user_id_a'];
    $username = $_POST['update_username_a'];
    $password = $_POST['update_password_a'];
    $message = '';

    $required_fields = [$first_name, $last_name, $username, $password];
    foreach ($required_fields as $field) {
        if (empty($field)) {
            return '[ERROR] All fields are required.';
        }
    }

    // Check if username already exists
    $sql = "SELECT 1 FROM users WHERE username = ? AND user_id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $username, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return '[ERROR] username already exists.';
    }
    $stmt->close();

    // Prepare and execute a SELECT query to check if the advisor exists
    $sql = "SELECT * FROM advisor WHERE advisor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $advisor_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE advisor 
                SET department_id = ?, first_name = ?, last_name = ?, assigned_sex = ?
                WHERE advisor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $department_id, $first_name, $last_name, $assigned_sex, $advisor_id);
        if ($stmt->execute()) {
            $message = '[SUCCESS] Data has been updated.';
        } else {
            $message = '[ERROR] Updating data: ' . $stmt->error;
        }
    } else {
        $message = '[ERROR] Advisor not found.';
    }

    $stmt->close();

    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE users 
                SET username = ?, password = ?
                WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $username, $password, $user_id);
        if ($stmt->execute()) {
            $message = '[SUCCESS] Data has been updated.';
        } else {
            $message = '[ERROR] Updating data: ' . $stmt->error;
        }
    } else {
        $message = '[ERROR] user ID not found.';
    }

    $stmt->close();
    $conn->close();

    // Return message
    return $message;
}

function updateDepartment($conn) {
    $department_id = $_POST['update_dept_id_d'];
    $course_id = $_POST['update_course_id_d'];
    $department_name = $_POST['update_dept_name_d'];
    $location = $_POST['update_location_d'];
    $message = '';

    // Check if department_name already exists
    $sql = "SELECT 1 FROM department WHERE department_name = ? AND department_id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $department_name, $department_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return '[ERROR] department_name already exists.';
    }
    $stmt->close();

    $sql = "SELECT * FROM department WHERE department_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $department_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE department 
                SET course_id = ?, department_name = ?, location = ?
                WHERE department_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $course_id, $department_name, $location, $department_id);
        if ($stmt->execute()) {
            $message = '[SUCCESS] Data has been updated.';
        } else {
            $message = '[ERROR] Updating data: ' . $stmt->error;
        }
    } else {
        $message = '[ERROR] department not found.';
    }

    $stmt->close();
    $conn->close();
    return $message;
}

function updateCourse($conn) {
    $course_id = $_POST['update_course_id_c'];
    $course_name = $_POST['update_course_name_c'];
    $credits = $_POST['update_course_credits_c'];
    $message = '';

    // Check if course_name already exists
    $sql = "SELECT 1 FROM course WHERE course_name = ? AND course_id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $course_name, $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return '[ERROR] course_name already exists.';
    }
    $stmt->close();

    $sql = "SELECT * FROM course WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $course_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE course 
                SET course_name = ?, credits = ?
                WHERE course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $course_name, $credits, $course_id);
        if ($stmt->execute()) {
            $message = '[SUCCESS] Data has been updated.';
        } else {
            $message = '[ERROR] Updating data: ' . $stmt->error;
        }
    } else {
        $message = '[ERROR] course not found.';
    }

    $stmt->close();
    $conn->close();
    return $message;
}

function checkIfExists($conn, $table, $column, $value, $current_id) {
    $sql = "SELECT 1 FROM $table WHERE $column = ? AND user_id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    return $exists;
}
?>
