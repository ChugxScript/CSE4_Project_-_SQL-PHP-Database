<?php
// Include database connection
include 'connect.php';

// Function to fetch total number of students
function getTotalStudents($conn) {
    $result = $conn->query("SELECT COUNT(*) AS total_students FROM student");
    $row = $result->fetch_assoc();
    return $row['total_students'];
}

// Function to fetch total number of advisors
function getTotalAdvisors($conn) {
    $result = $conn->query("SELECT COUNT(*) AS total_advisors FROM advisor");
    $row = $result->fetch_assoc();
    return $row['total_advisors'];
}

// Function to fetch total number of departments
function getTotalDepartments($conn) {
    $result = $conn->query("SELECT COUNT(*) AS total_departments FROM department");
    $row = $result->fetch_assoc();
    return $row['total_departments'];
}

// Function to fetch total number of courses
function getTotalCourses($conn) {
    $result = $conn->query("SELECT COUNT(*) AS total_courses FROM course");
    $row = $result->fetch_assoc();
    return $row['total_courses'];
}

function getAdvisorStudentRatio($conn) {
    $total_students = getTotalStudents($conn);
    $total_advisors = getTotalAdvisors($conn);
    if ($total_advisors > 0) {
        return $total_students / $total_advisors;
    } else {
        return "N/A";
    }
}

// Function to fetch data for Department Overview chart
function getDepartmentOverviewData($conn) {
    $departmentData = array();
    $result = $conn->query("SELECT d.department_name, COUNT(*) AS student_count 
                            FROM student s
                            INNER JOIN advisor a ON s.advisor_id = a.advisor_id
                            INNER JOIN department d ON a.department_id = d.department_id
                            GROUP BY d.department_id");
    while ($row = $result->fetch_assoc()) {
        $departmentData['labels'][] = $row['department_name'];
        $departmentData['studentCounts'][] = $row['student_count'];
    }
    return $departmentData;
}



?>
