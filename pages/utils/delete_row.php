<?php
include '../../config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table = isset($_POST['table']) ? $_POST['table'] : null; 
    $id = isset($_POST['id']) ? $_POST['id'] : null; ; 
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null; ; 

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
        } 

        if ($primaryKey) {
            $message = '';
            $sql = "DELETE FROM $table WHERE $primaryKey = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $id);
            if (!$stmt->execute()) {
                $stmt->close();
                $message = '[ERROR] Deleting user: ' . $stmt->error;
            } else {
                $message = "[SUCCESS] Record deleted successfully";
            }
            $stmt->close();

            if ($table === 'student' || $table === 'advisor'){
                $sql = "DELETE FROM users WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $user_id);

                if ($stmt->execute()) {
                    $message = "[SUCCESS] Record deleted successfully";
                } else {
                    $message = "[ERROR] Error deleting record: " . $conn->error;
                }
                $stmt->close();
            }
            echo $message;

        } else {
            echo "[ERROR] Invalid table: " . $table . " id: " . $id;
        }
    } else {
        echo "[ERROR] Missing table or id";
    }

    $conn->close();
}
?>
