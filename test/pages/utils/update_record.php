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


function updateAdvisor($conn) {
    // Get the values from the POST request
    $advisor_id = $_POST['advisor_id'];
    $department_id = $_POST['department_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $message = '';

    // Prepare and execute a SELECT query to check if the advisor exists
    $sql = "SELECT * FROM advisor WHERE advisor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $advisor_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    // If the advisor exists, update the record
    if ($result->num_rows > 0) {
        $sql = "UPDATE advisor 
                SET department_id = ?, first_name = ?, last_name = ?
                WHERE advisor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $department_id, $first_name, $last_name, $advisor_id);
        if ($stmt->execute()) {
            $message = '[SUCCESS]: Data has been updated.';
        } else {
            $message = '[ERROR]: Updating data: ' . $stmt->error;
        }
    } else {
        // If the advisor doesn't exist, show an error message
        $message = '[ERROR]: Advisor not found.';
    }

    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();

    // Return message
    return $message;
}

function updateCourse($conn) {
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $credits = $_POST['credits'];
    $message = '';

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
            $message = '[SUCCESS]: Data has been updated.';
        } else {
            $message = '[ERROR]: Updating data: ' . $stmt->error;
        }
    } else {
        $message = '[ERROR]: course not found.';
    }

    $stmt->close();
    $conn->close();
    return $message;
}

function updateDepartment($conn) {
    $department_id = $_POST['department_id'];
    $department_name = $_POST['department_name'];
    $location = $_POST['location'];
    $message = '';

    $sql = "SELECT * FROM department WHERE department_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $department_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE department 
                SET department_name = ?, location = ?
                WHERE department_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $department_name, $location, $department_id);
        if ($stmt->execute()) {
            $message = '[SUCCESS]: Data has been updated.';
        } else {
            $message = '[ERROR]: Updating data: ' . $stmt->error;
        }
    } else {
        $message = '[ERROR]: department not found.';
    }

    $stmt->close();
    $conn->close();
    return $message;
}

function updateStudent($conn) {
    $student_id = $_POST['update_student_id'];
    $advisor_id = $_POST['update_advisor_id'];
    $user_id = $_POST['update_user_id'];
    $first_name = $_POST['update_first_name'];
    $last_name = $_POST['update_last_name'];
    $message = '';

    $sql = "SELECT * FROM student WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE student 
                SET advisor_id = ?, user_id = ?, first_name = ?, last_name = ?
                WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisss", $advisor_id, $user_id, $first_name, $last_name, $student_id);
        if ($stmt->execute()) {
            $message = '[SUCCESS]: Data has been updated.';
        } else {
            $message = '[ERROR]: Updating data: ' . $stmt->error;
        }
    } else {
        $message = '[ERROR]: student not found.';
    }

    $stmt->close();
    $conn->close();
    return $message;
}
?>
