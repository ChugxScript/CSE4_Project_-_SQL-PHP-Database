<?php
include '../../config/connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from form
    $username = $_POST['lgn_username'];
    $password = $_POST['lgn_password'];

    // Prepare SQL statement to select user from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $role = $user['role'];
        $user_id = $user['user_id'];

        // Direct comparison if passwords are not hashed (not recommended)
        if ($password === $user['password']) {
            $response = [
                "role" => $role,
                "user_id" => $user_id,
                "message" => "[SUCCESS] Login successful!"
            ];
            echo json_encode($response);
        } else {
            // echo '<script type="text/javascript">';
            // echo 'alert("Incorrect username or password.");';
            // echo 'window.location.href = "../index.php?login=error";';
            // echo '</script>';
            $response = [
                "role" => '',
                "user_id" => '',
                "message" => "[ERROR] Incorrect username or password."
            ];
            echo json_encode($response);
        }
    } else {
        // echo '<script type="text/javascript">';
        // echo 'alert("Incorrect username or password.");';
        // echo 'window.location.href = "../index.php?login=error";';
        // echo '</script>';
        $response = [
            "role" => '',
            "user_id" => '',
            "message" => "[ERROR] Incorrect username or password."
        ];
        echo json_encode($response);
    }

    $stmt->close();
}

$conn->close();
?>
