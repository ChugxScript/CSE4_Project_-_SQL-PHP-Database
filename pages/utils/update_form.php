<?php
include '../../config/connect.php';
$table = isset($_GET['table']) ? $_GET['table'] : 'student';
$row_id = isset($_GET['row_id']) ? $_GET['row_id'] : '';

if (isset($_GET['table'])) {
    $table = $_GET['table'] ? $_GET['table'] : 'student';
    $row_id = $_GET['row_id'] ? $_GET['row_id'] : '';

    $valid_tables = ['student', 'advisor', 'department', 'course'];
    if (!in_array($table, $valid_tables)) {
        die("Invalid table name");
    }

    switch ($_GET['table']) {
        case 'student':
            echo update_student_form($conn, $row_id);
            break;
        case 'advisor':
            echo update_advisor_form($conn, $row_id);
            break;
        case 'department':
            echo update_dept_form($conn, $row_id);
            break;
        case 'course':
            echo update_course_form($conn, $row_id);
            break;
        default:
            echo "[ERROR] Invalid 'table'";
            break;
    }
} else {
    echo "[ERROR] Invalid 'table'";
}

function update_student_form($conn, $row_id){
    $form = '<form id="updateForm" data-form="student" class="bg-white rounded px-8 pt-6 pb-8">';
            
            $safe_row_id = $conn->real_escape_string($row_id);
            $s_query = "SELECT user_id, first_name, last_name FROM student WHERE student_id = '$safe_row_id'";
            $s_result = $conn->query($s_query);
            if ($s_result) {
                $s_row = $s_result->fetch_assoc();
            } else {
                return "[ERROR] executing query: " . $conn->error;
            }

            $t_username = $s_row['user_id'];
            $s_query = "SELECT username, password FROM users WHERE user_id = '$t_username'";
            $s_result = $conn->query($s_query);
            if ($s_result) {
                $s_user_row = $s_result->fetch_assoc();
            } else {
                return "[ERROR] executing query: " . $conn->error;
            }
    
    $form .= '<div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_student_id">
                    Student ID *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-200 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_student_id" 
                    name="update_student_id" 
                    type="text" 
                    value="' . $row_id . '"
                    readonly>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_advisor_id">
                    Advisor ID *
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
                    User ID *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-200 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_user_id" 
                    name="update_user_id" 
                    type="text" 
                    value="' . $s_row['user_id'] . '"
                    readonly>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_first_name">
                    First Name *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_first_name" 
                    name="update_first_name" 
                    type="text" 
                    value="' . $s_row['first_name'] . '"
                    required>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_last_name">
                    Last Name *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_last_name" 
                    name="update_last_name" 
                    type="text" 
                    value="' . $s_row['last_name'] . '"
                    required>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_sex_s">
                    Assigned Sex *
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_sex_s" 
                    name="update_sex_s"
                    required>
                    <option value="Male"> Male </option>
                    <option value="Female"> Female </option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 lower-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_username_s">
                    Username *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_username_s" 
                    name="update_username_s" 
                    type="text" 
                    value="' . $s_user_row['username'] . '"
                    required>
            </div>
            <div class="relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_password_s">
                    Password *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_password_s" 
                    name="update_password_s" 
                    type="text" 
                    value="' . $s_user_row['password'] . '"
                    required>
            </div>
        </form>';
    return $form;
}

function update_advisor_form($conn, $row_id){
    $form = '<form id="updateForm" data-form="advisor" class="bg-white rounded px-8 pt-6 pb-8">';
            
            $safe_row_id = $conn->real_escape_string($row_id);
            $s_query = "SELECT user_id, first_name, last_name FROM advisor WHERE advisor_id = '$safe_row_id'";
            $s_result = $conn->query($s_query);
            if ($s_result) {
                $s_row = $s_result->fetch_assoc();
            } else {
                return "[ERROR] executing query: " . $conn->error;
            }

            $t_username = $s_row['user_id'];
            $s_query = "SELECT username, password FROM users WHERE user_id = '$t_username'";
            $s_result = $conn->query($s_query);
            if ($s_result) {
                $s_user_row = $s_result->fetch_assoc();
            } else {
                return "[ERROR] executing query: " . $conn->error;
            }
    
    $form .= '<div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_advisor_id_a">
                    Advisor ID *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-200 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_advisor_id_a" 
                    name="update_advisor_id_a" 
                    type="text" 
                    value="' . $row_id . '"
                    readonly>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_dept_id_a">
                Department ID *
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_dept_id_a" 
                    name="update_dept_id_a">';

                    $query = "SELECT department_id, department_name FROM department";
                    $result = $conn->query($query);
                    while ($row = $result->fetch_assoc()) {
                        $form .= '<option value="' . $row['department_id'] . '">' . $row['department_id'] . ' - ' . $row['department_name'] . '</option>';
                    }
    $form .=    '</select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 lower-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_user_id_a">
                    User ID *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-200 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_user_id_a" 
                    name="update_user_id_a" 
                    type="text" 
                    value="' . $s_row['user_id'] . '"
                    readonly>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_first_name_a">
                    First Name *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_first_name_a" 
                    name="update_first_name_a" 
                    type="text" 
                    value="' . $s_row['first_name'] . '"
                    required>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_last_name_a">
                    Last Name *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_last_name_a" 
                    name="update_last_name_a" 
                    type="text" 
                    value="' . $s_row['last_name'] . '"
                    required>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_sex_a">
                    Assigned Sex *
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_sex_a" 
                    name="update_sex_a"
                    required>
                    <option value="Male"> Male </option>
                    <option value="Female"> Female </option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 lower-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_username_a">
                    Username *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_username_a" 
                    name="update_username_a" 
                    type="text" 
                    value="' . $s_user_row['username'] . '"
                    required>
            </div>
            <div class="relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_password_a">
                    Password *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_password_a" 
                    name="update_password_a" 
                    type="text" 
                    value="' . $s_user_row['password'] . '"
                    required>
            </div>
        </form>';
    return $form;
}

function update_dept_form($conn, $row_id){
    $form = '<form id="updateForm" data-form="department" class="bg-white rounded px-8 pt-6 pb-8">';
            
            $safe_row_id = $conn->real_escape_string($row_id);
            $s_query = "SELECT department_name, course_id, location FROM department WHERE department_id = '$safe_row_id'";
            $s_result = $conn->query($s_query);
            if ($s_result) {
                $s_row = $s_result->fetch_assoc();
            } else {
                return "[ERROR] executing query: " . $conn->error;
            }
    
    $form .= '<div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_dept_id_d">
                    Department ID *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-200 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_dept_id_d" 
                    name="update_dept_id_d" 
                    type="text" 
                    value="' . $row_id . '"
                    readonly>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_course_id_d">
                    Course ID *
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_course_id_d" 
                    name="update_course_id_d">';

                    $query = "SELECT course_id, course_name FROM course";
                    $result = $conn->query($query);
                    while ($row = $result->fetch_assoc()) {
                        $form .= '<option value="' . $row['course_id'] . '">' . $row['course_id'] . ' - ' . $row['course_name'] . '</option>';
                    }
    $form .=    '</select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 lower-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_dept_name_d">
                    Department Name *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_dept_name_d" 
                    name="update_dept_name_d" 
                    type="text" 
                    value="' . $s_row['department_name'] . '"
                    required>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_location_d">
                    Location *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_location_d" 
                    name="update_location_d" 
                    type="text" 
                    value="' . $s_row['location'] . '"
                    required>
            </div>
        </form>';
    return $form;
}

function update_course_form($conn, $row_id){
    $form = '<form id="updateForm" data-form="course" class="bg-white rounded px-8 pt-6 pb-8">';
            
            $safe_row_id = $conn->real_escape_string($row_id);
            $s_query = "SELECT course_name FROM course WHERE course_id = '$safe_row_id'";
            $s_result = $conn->query($s_query);
            if ($s_result) {
                $s_row = $s_result->fetch_assoc();
            } else {
                return "[ERROR] executing query: " . $conn->error;
            }
    
    $form .= '<div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_course_id_c">
                    Course ID *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-200 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_course_id_c" 
                    name="update_course_id_c" 
                    type="text" 
                    value="' . $row_id . '"
                    readonly>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_course_name_c">
                    Course Name *
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_course_name_c" 
                    name="update_course_name_c" 
                    type="text" 
                    value="' . $s_row['course_name'] . '"
                    required>
            </div>
            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="update_course_credits_c">
                    Credits *
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="update_course_credits_c" 
                    name="update_course_credits_c"
                    required>
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 lower-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>
        </form>';
    return $form;
}


$conn->close();
?>
