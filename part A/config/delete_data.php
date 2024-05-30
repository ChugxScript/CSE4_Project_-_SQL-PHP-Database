<?php
include('function.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['table_name']) && !empty($_POST['table_name'])) {
        $conn = getDB();

        switch ($_POST['table_name']) {
            case 'advisor':
                echo deleteAdvisor($conn);
                break;
            case 'course':
                echo deleteCourse($conn);
                break;
            case 'department':
                echo deleteDepartment($conn);
                break;
            case 'student':
                echo deleteStudent($conn);
                break;
            default:
                echo "[ERROR] Invalid 'table_name'";
                break;
        }
    } else {
        echo "[ERROR] Invalid 'table_name'";
    }
} else {
    echo "[ERROR] Invalid request method";
}

function deleteAdvisor($conn){
    $advisor_id = $_POST['advisor_id'];
    $message = '';

    $sql = "SELECT * FROM advisor WHERE advisor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $advisor_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    // If the advisor exists, delete the record
    if ($result->num_rows > 0) {
        $sql = "DELETE FROM advisor WHERE advisor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $advisor_id);
        if ($stmt->execute()) {
            $message = '[SUCCESS]: Data has been deleted.';
        } else {
            $message = '[ERROR]: Deleting data: ' . $stmt->error;
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

function deleteCourse($conn){
    $course_id = $_POST['course_id'];
    $message = '';

    $sql = "SELECT * FROM course WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $course_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "DELETE FROM course WHERE course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $course_id); 
        if ($stmt->execute()) {
            $message = '[SUCCESS]: Data has been deleted.';
        } else {
            $message = '[ERROR]: Deleting data: ' . $stmt->error;
        }
    } else {
        $message = '[ERROR]: course not found.';
    }

    $stmt->close();
    $conn->close();
    return $message;
}

function deleteDepartment($conn){
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
        $sql = "DELETE FROM department WHERE department_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $department_id); 
        if ($stmt->execute()) {
            $message = '[SUCCESS]: Data has been deleted.';
        } else {
            $message = '[ERROR]: Deleting data: ' . $stmt->error;
        }
    } else {
        $message = '[ERROR]: department not found.';
    }

    $stmt->close();
    $conn->close();
    return $message;
}

function deleteStudent($conn){
    $student_id = $_POST['student_id'];
    $message = '';

    $sql = "SELECT * FROM student WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "DELETE FROM student WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $student_id); 
        if ($stmt->execute()) {
            $message = '[SUCCESS]: Data has been deleted.';
        } else {
            $message = '[ERROR]: Deleting data: ' . $stmt->error;
        }
    } else {
        $message = '[ERROR]: student not found.';
    }

    $stmt->close();
    $conn->close();
    return $message;
}

?>