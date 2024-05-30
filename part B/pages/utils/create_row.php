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

function createAdvisor($conn){
    $advisor_id = $_POST['advisor_id'];
    $department_id = $_POST['department_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $message = '';

    if (preg_match("/^TUPM-P-\d{2}-\d{4}$/", $advisor_id) && !empty($department_id) && !empty($first_name) && !empty($last_name)){
        $sql = "SELECT * FROM department WHERE department_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $department_id); 
        $stmt->execute();
        $result = $stmt->get_result();

        // check if department_id exist
        if ($result->num_rows > 0) {
            $stmt->close();

            // check if advisor_id already exist
            $sql = "SELECT * FROM advisor WHERE advisor_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $advisor_id); 
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0){
                $stmt->close();

                $sql = "INSERT INTO advisor (advisor_id, department_id, first_name, last_name)
                        VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $advisor_id, $department_id, $first_name, $last_name);
                if ($stmt->execute()) {
                    $message = '[SUCCESS]: Data has been updated.';
                } else {
                    $message = '[ERROR]: Updating data: ' . $stmt->error;
                }
            } else {
                $message = '[ERROR] advisor_id alredy exist.';
            }
        } else {
            $message = '[ERROR] Invalid department_id.';
        }
    } else {
        $message = '[ERROR] Invalid advisor input data.';
    }

    $stmt->close();
    $conn->close();
    return $message;
}

function createCourse($conn){
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $credits = $_POST['credits'];
    $message = '';

    if (!empty($course_id) && !empty($course_name) && !empty($credits)) {
        
        // check if course_id already exist
        $sql = "SELECT * FROM course WHERE course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $course_id); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            $sql = "INSERT INTO course (course_id, course_name, credits)
                    VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $course_id, $course_name, $credits);
            if ($stmt->execute()) {
                $message = '[SUCCESS]: Data has been updated.';
            } else {
                $message = '[ERROR]: Updating data: ' . $stmt->error;
            }
        } else {
            $message = '[ERROR] course_id already exist.';
        }
    } else {
        $message = '[ERROR] Invalid course input data.';
    }

    $stmt->close();
    $conn->close();
    return $message;
}

function createDepartment($conn){
    $department_id = $_POST['department_id'];
    $department_name = $_POST['department_name'];
    $location = $_POST['location'];
    $message = '';

    if (preg_match("/^TUPM-D-\d{4}$/", $department_id) && !empty($department_id) && !empty($department_name) && !empty($location)) {
        
        // check if department_id already exist
        $sql = "SELECT * FROM department WHERE department_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $department_id); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            $sql = "INSERT INTO department (department_id, department_name, location)
                    VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $department_id, $department_name, $location);
            if ($stmt->execute()) {
                $message = '[SUCCESS]: Data has been updated.';
            } else {
                $message = '[ERROR]: Updating data: ' . $stmt->error;
            }
        } else {
            $message = '[ERROR] course_id already exist.';
        }
    } else {
        $message = '[ERROR] Invalid department input data.';
    }

    $stmt->close();
    $conn->close();
    return $message;
}

function createStudent($conn) {
    $student_id = $_POST['create_student_id'];
    $advisor_id = $_POST['create_advisor_id_s'];
    $first_name = $_POST['create_first_name_s'];
    $last_name = $_POST['create_last_name_s'];
    $users_user_name = $_POST['create_user_username'];
    $users_password = $_POST['create_user_password'];
    $users_role = $_POST['create_users_role'];
    $message = '';

    // Validate inputs
    if (!preg_match("/^TUPM-\d{2}-\d{4}$/", $student_id)) {
        return '[ERROR] Invalid student_id format.';
    }

    $required_fields = [$advisor_id, $first_name, $last_name, $users_user_name, $users_password, $users_role];
    foreach ($required_fields as $field) {
        if (empty($field)) {
            return '[ERROR] All fields are required.';
        }
    }

    // Check if advisor_id exists
    if (!checkIfExists($conn, 'advisor', 'advisor_id', $advisor_id)) {
        return '[ERROR] Invalid advisor_id.';
    }

    // Check if student_id already exists
    if (checkIfExists($conn, 'student', 'student_id', $student_id)) {
        return '[ERROR] student_id already exists.';
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
    $sql = "INSERT INTO student (student_id, advisor_id, user_id, first_name, last_name) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $student_id, $advisor_id, $user_id, $first_name, $last_name);
    if ($stmt->execute()) {
        $message = '[SUCCESS]: Student has been created.';
    } else {
        $message = '[ERROR]: Creating student: ' . $stmt->error;
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
