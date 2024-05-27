<?php
include '../../config/connect.php';
$table = isset($_GET['table']) ? $_GET['table'] : 'student';
$row_id = isset($_GET['row_id']) ? $_GET['row_id'] : '';


$valid_tables = ['student', 'advisor', 'department', 'course'];
if (!in_array($table, $valid_tables)) {
    die("Invalid table name");
}

function generateUpdateForm($conn, $table, $row_id) {
    $form = '<form id="updateForm" data-form="' . $table . '" class="bg-white rounded px-8 pt-6 pb-8 mb-4">';

    if ($table === 'student') {
        $safe_row_id = $conn->real_escape_string($row_id);
        $s_query = "SELECT user_id, first_name, last_name FROM student WHERE student_id = '$safe_row_id'";
        $s_result = $conn->query($s_query);
        if ($s_result) {
            $s_row = $s_result->fetch_assoc();
        } else {
            echo "Error executing query: " . $conn->error;
        }
    
        $form .= '<div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="update_student_id">
                        Student ID
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="update_student_id" 
                        name="update_student_id" 
                        type="text" 
                        value="' . $row_id . '"
                        readonly>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="update_advisor_id">
                        Advisor ID
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="update_advisor_id" 
                        name="update_advisor_id">';
    
                        $query = "SELECT advisor_id, first_name, last_name FROM advisor";
                        $result = $conn->query($query);
                        while ($row = $result->fetch_assoc()) {
                            $form .= '<option value="' . $row['advisor_id'] . '">' . $row['advisor_id'] . ' - ' . $row['first_name'] . ' ' . $row['last_name'] . '</option>';
                        }
        $form .=    '</select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 lower-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="update_user_id">
                        User ID
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="update_user_id" 
                        name="update_user_id" 
                        type="text" 
                        value="' . $s_row['user_id'] . '"
                        readonly>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="update_first_name">
                        First Name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="update_first_name" 
                        name="update_first_name" 
                        type="text" 
                        value="' . $s_row['first_name'] . '">
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="update_last_name">
                        Last Name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="update_last_name" 
                        name="update_last_name" 
                        type="text" 
                        value="' . $s_row['last_name'] . '">
                </div>';
    } else if ($table === 'advisor') {
        $form .= '<div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="advisor_id">
                        Advisor ID
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="advisor_id" name="advisor_id" type="text" placeholder="Advisor ID">
                </div>
                <!-- Add other form inputs for advisor table here -->';
    }
    // Add similar blocks for other tables

    $form .= '</form>';

    return $form;
}

echo generateUpdateForm($conn, $table, $row_id);
$conn->close();
?>
