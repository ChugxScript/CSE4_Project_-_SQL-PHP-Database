<!-- config/save_data.php -->
<?php
<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log errors to a file
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

include('function.php');

$response = array('status' => 'error', 'message' => 'An error occurred');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = getDB();
    $tableName = $_POST['table_name']; 

    switch ($tableName) {
        case 'advisor':
            $advisor_id = $_POST['advisor_id'];
            $department_id = $_POST['department_id'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];

            if (preg_match("/^TUPM-P-\d{2}-\d{4}$/", $advisor_id) && !empty($department_id) && !empty($first_name) && !empty($last_name)) {
                // Check if the advisor already exists
                $checkQuery = "SELECT 1 FROM advisor WHERE advisor_id = ?";
                $stmt = $conn->prepare($checkQuery);
                $stmt->bind_param("s", $advisor_id);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $response['message'] = 'Advisor ID already exists';
                } else {
                    $stmt->close();
                    // Insert new advisor
                    $query = "INSERT INTO advisor (advisor_id, department_id, first_name, last_name) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ssss", $advisor_id, $department_id, $first_name, $last_name);
                    if ($stmt->execute()) {
                        $response = ['status' => 'success', 'message' => 'Advisor data saved successfully'];
                    } else {
                        $response['message'] = 'Failed to save advisor data';
                    }
                }
                $stmt->close();
            } else {
                $response['message'] = 'Invalid advisor input data';
            }
            break;
            
        case 'course':
            $course_id = $_POST['course_id'];
            $course_name = $_POST['course_name'];
            $credits = $_POST['credits'];

            if (!empty($course_id) && !empty($course_name) && !empty($credits)) {
                // Check if the course already exists
                $checkQuery = "SELECT 1 FROM course WHERE course_id = ?";
                $stmt = $conn->prepare($checkQuery);
                $stmt->bind_param("s", $course_id);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $response['message'] = 'Course ID already exists';
                } else {
                    $stmt->close();
                    // Insert new course
                    $query = "INSERT INTO course (course_id, course_name, credits) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ssi", $course_id, $course_name, $credits);
                    if ($stmt->execute()) {
                        $response = ['status' => 'success', 'message' => 'Course data saved successfully'];
                    } else {
                        $response['message'] = 'Failed to save course data';
                    }
                }
                $stmt->close();
            } else {
                $response['message'] = 'Invalid course input data';
            }
            break;
            
        case 'department':
            $department_id = $_POST['department_id'];
            $department_name = $_POST['department_name'];
            $location = $_POST['location'];

            if (preg_match("/^TUPM-D-\d{4}$/", $department_id) && !empty($department_id) && !empty($department_name) && !empty($location)) {
                // Check if the department already exists
                $checkQuery = "SELECT 1 FROM department WHERE department_id = ?";
                $stmt = $conn->prepare($checkQuery);
                $stmt->bind_param("s", $department_id);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $response['message'] = 'Department ID already exists';
                } else {
                    $stmt->close();
                    // Insert new department
                    $query = "INSERT INTO department (department_id, department_name, location) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("sss", $department_id, $department_name, $location);
                    if ($stmt->execute()) {
                        $response = ['status' => 'success', 'message' => 'Department data saved successfully'];
                    } else {
                        $response['message'] = 'Failed to save department data';
                    }
                }
                $stmt->close();
            } else {
                $response['message'] = 'Invalid department input data';
            }
            break;
            
        case 'student':
            $student_id = $_POST['student_id'];
            $advisor_id = $_POST['advisor_id'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];

            if (preg_match("/^TUPM-\d{2}-\d{4}$/", $student_id) && !empty($advisor_id) && !empty($first_name) && !empty($last_name)) {
                // Check if the student already exists
                $checkQuery = "SELECT 1 FROM student WHERE student_id = ?";
                $stmt = $conn->prepare($checkQuery);
                $stmt->bind_param("s", $student_id);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $response['message'] = 'Student ID already exists';
                } else {
                    $stmt->close();
                    // Insert new student
                    $query = "INSERT INTO student (student_id, advisor_id, first_name, last_name) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ssss", $student_id, $advisor_id, $first_name, $last_name);
                    if ($stmt->execute()) {
                        $response = ['status' => 'success', 'message' => 'Student data saved successfully'];
                    } else {
                        $response['message'] = 'Failed to save student data';
                    }
                }
                $stmt->close();
            } else {
                $response['message'] = 'Invalid student input data';
            }
            break;

        default:
            $response['message'] = 'Invalid table name';
            break;
    }

    $conn->close();
} else {
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
