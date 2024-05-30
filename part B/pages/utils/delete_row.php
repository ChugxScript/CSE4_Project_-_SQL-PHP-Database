<?php
include '../../config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = isset($_POST['table']) ? $_POST['table'] : null; 
    $id = isset($_POST['id']) ? $_POST['id'] : null; ; 

    // Check if $table and $id are not null
    if ($table !== null && $id !== null) {
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
                echo "[SUCCESS] Record deleted successfully";
            } else {
                echo "[ERROR] Error deleting record: " . $conn->error;
            }

            $stmt->close();
        } else {
            echo "[ERROR] Invalid table: " . $table . " id: " . $id;
        }
    } else {
        echo "[ERROR] Missing table or id";
    }

    $conn->close();
}
?>
