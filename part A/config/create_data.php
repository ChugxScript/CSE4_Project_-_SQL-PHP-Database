<?php
include('function.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['table_name']) && !empty($_POST['table_name'])) {
        $conn = getDB();

        switch ($_POST['table_name']) {
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
                echo "[ERROR] Invalid 'table_name'";
                break;
        }
    } else {
        echo "[ERROR] Invalid 'table_name'";
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

function createStudent($conn){
    $student_id = $_POST['student_id'];
    $advisor_id = $_POST['advisor_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $message = '';

    if (preg_match("/^TUPM-\d{2}-\d{4}$/", $student_id) && !empty($advisor_id) && !empty($first_name) && !empty($last_name)){
        
        // check if advisor_id exist
        $sql = "SELECT * FROM advisor WHERE advisor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $advisor_id); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $stmt->close();

            // check if student_id already exist
            $sql = "SELECT * FROM student WHERE student_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $student_id); 
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0){
                $stmt->close();

                $sql = "INSERT INTO student (student_id, advisor_id, first_name, last_name)
                        VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $student_id, $advisor_id, $first_name, $last_name);
                if ($stmt->execute()) {
                    $message = '[SUCCESS]: Data has been updated.';
                } else {
                    $message = '[ERROR]: Updating data: ' . $stmt->error;
                }
            } else {
                $message = '[ERROR] student_id alredy exist.';
            }
        } else {
            $message = '[ERROR] Invalid advisor_id.';
        }
    } else {
        $message = '[ERROR] Invalid student input data.';
    }

    $stmt->close();
    $conn->close();
    return $message;
}
?>
