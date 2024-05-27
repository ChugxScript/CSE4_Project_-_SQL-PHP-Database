<?php
include '../../config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = $_POST['table'];
    $id = $_POST['id'];
    
    // Determine the primary key column based on the table name
    $primaryKey = '';
    if ($table === 'student') {
        $primaryKey = 'student_id';
    } else if ($table === 'advisor') {
        $primaryKey = 'advisor_id';
    } else if ($table === 'department') {
        $primaryKey = 'department_id';
    } else if ($table === 'course') {
        $primaryKey = 'course_id';
    } else if ($table === 'users') {
        $primaryKey = 'user_id';
    }

    if ($primaryKey) {
        $sql = "DELETE FROM $table WHERE $primaryKey = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $id);

        if ($stmt->execute()) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Invalid table";
    }
    $conn->close();
}
?>