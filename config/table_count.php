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

function getTotalMaleStudent($conn) {
    $sql_male = "SELECT COUNT(*) AS male_count FROM student WHERE assigned_sex = 'Male'";
    $result_male = $conn->query($sql_male);
    return $result_male->fetch_assoc()['male_count'];
}

function getTotalFemaleStudent($conn) {
    $sql_female = "SELECT COUNT(*) AS female_count FROM student WHERE assigned_sex = 'Female'";
    $result_female = $conn->query($sql_female);
    return $result_female->fetch_assoc()['female_count'];
}

function getTotalMaleAdvisor($conn) {
    $sql_male = "SELECT COUNT(*) AS male_count FROM advisor WHERE assigned_sex = 'Male'";
    $result_male = $conn->query($sql_male);
    return $result_male->fetch_assoc()['male_count'];
}

function getTotalFemaleAdvisor($conn) {
    $sql_female = "SELECT COUNT(*) AS female_count FROM advisor WHERE assigned_sex = 'Female'";
    $result_female = $conn->query($sql_female);
    return $result_female->fetch_assoc()['female_count'];
}
?>
