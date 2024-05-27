<?php
include 'connect.php';

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

        // Direct comparison if passwords are not hashed (not recommended)
        if ($password === $user['password']) {
            $role = $user['role'];
            $user_id = $user['user_id'];
            echo '<script type="text/javascript">';
            echo 'alert("Login successful!");';
            echo 'window.location.href = "../pages/' . $role . '.php?user_id=' . $user_id . '";';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Incorrect username or password.");';
            echo 'window.location.href = "../index.php?login=error";';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Incorrect username or password.");';
        echo 'window.location.href = "../index.php?login=error";';
        echo '</script>';
    }

    $stmt->close();
}

$conn->close();
?>
