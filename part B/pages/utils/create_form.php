<?php
include '../../config/connect.php';
$table = isset($_GET['table']) ? $_GET['table'] : 'student';

$valid_tables = ['student', 'advisor', 'department', 'course'];
if (!in_array($table, $valid_tables)) {
    die("Invalid table name");
}

function generateCreateForm($conn, $table) {
    $form = '<form id="createForm" data-form="' . $table . '" class="bg-white rounded px-8 pt-6 pb-8">';

    if ($table === 'student') {
        $form .= '<div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_student_id">
                        Student ID *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_student_id" 
                        name="create_student_id" 
                        type="text" 
                        pattern="^TUPM-\\d{2}-\\d{4}$" 
                        placeholder="format: TUPM-XX-XXXX" 
                        required>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_advisor_id_s">
                        Advisor ID *
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_advisor_id_s" 
                        name="create_advisor_id_s">';
    
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
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_first_name_s">
                        First Name *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_first_name_s" 
                        name="create_first_name_s" 
                        type="text" 
                        placeholder="e.g.: Andrew" 
                        maxlength="255" 
                        required>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_last_name_s">
                        Last Name *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_last_name_s" 
                        name="create_last_name_s" 
                        type="text" 
                        placeholder="e.g.: Oloroso" 
                        maxlength="255" 
                        required>
                </div>
                
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_user_username">
                        Username *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_user_username" 
                        name="create_user_username" 
                        type="email" 
                        placeholder="e.g.: example@tup.edu.ph" 
                        maxlength="255" 
                        required>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_user_password">
                        Password *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_user_password" 
                        name="create_user_password" 
                        type="text" 
                        placeholder="e.g.: Password123" 
                        maxlength="255" 
                        required>
                </div>
                <div class="relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_users_role">
                        User role *
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_users_role" 
                        name="create_users_role"
                        required>
                        <option value="" disabled selected>Select a role</option>
                        <option value="admin">Admin</option>
                        <option value="registrar">Registrar</option>
                        <option value="student">Student</option>
                        <option value="advisor">Advisor</option>
                    </select>
                </div>
            ';
                
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

echo generateCreateForm($conn, $table);
$conn->close();
?>
