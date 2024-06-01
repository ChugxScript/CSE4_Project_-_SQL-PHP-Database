<?php
include '../../config/connect.php';

if (isset($_GET['table'])) {
    $table = $_GET['table'] ? $_GET['table'] : 'student';

    $valid_tables = ['student', 'advisor', 'department', 'course'];
    if (!in_array($table, $valid_tables)) {
        die("Invalid table name");
    }

    switch ($_GET['table']) {
        case 'student':
            echo create_student_form($conn);
            break;
        case 'advisor':
            echo create_advisor_form($conn);
            break;
        case 'department':
            echo create_dept_form($conn);
            break;
        case 'course':
            echo create_course_form($conn);
            break;
        default:
            echo "[ERROR] Invalid 'table'";
            break;
    }
} else {
    echo "[ERROR] Invalid 'table'";
}

function create_student_form($conn){
    $form = '<form id="createForm" data-form="student" class="bg-white rounded px-8 pt-6 pb-8">
                <div class="mb-4 relative">
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
    $form .=        '</select>
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
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_sex_s">
                        Assigned Sex *
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_sex_s" 
                        name="create_sex_s"
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
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-200 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_users_role" 
                        name="create_users_role" 
                        type="text" 
                        value="student"
                        readonly>
                </div>
            </form>';
    return $form;
}

function create_advisor_form($conn){
    $form = '<form id="createForm" data-form="advisor" class="bg-white rounded px-8 pt-6 pb-8">
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_advisor_id_a">
                        Advisor ID *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_advisor_id_a" 
                        name="create_advisor_id_a" 
                        type="text" 
                        pattern="^TUPM-P-\\d{2}-\\d{4}$" 
                        placeholder="format: TUPM-P-XX-XXXX" 
                        required>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_dept_id_a">
                        Department ID *
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_dept_id_a" 
                        name="create_dept_id_a">';
                        $query = "SELECT department_id, department_name FROM department";
                        $result = $conn->query($query);
                        while ($row = $result->fetch_assoc()) {
                            $form .= '<option value="' . $row['department_id'] . '">' . $row['department_id'] . ' - ' . $row['department_name'] . '</option>';
                        }
    $form .=        '</select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 lower-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_first_name_a">
                        First Name *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_first_name_a" 
                        name="create_first_name_a" 
                        type="text" 
                        placeholder="e.g.: Andrew" 
                        maxlength="255" 
                        required>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_last_name_a">
                        Last Name *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_last_name_a" 
                        name="create_last_name_a" 
                        type="text" 
                        placeholder="e.g.: Oloroso" 
                        maxlength="255" 
                        required>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_sex_a">
                        Assigned Sex *
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_sex_a" 
                        name="create_sex_a"
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
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_user_username_a">
                        Username *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_user_username_a" 
                        name="create_user_username_a" 
                        type="email" 
                        placeholder="e.g.: example@tup.edu.ph" 
                        maxlength="255" 
                        required>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_user_password_a">
                        Password *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_user_password_a" 
                        name="create_user_password_a" 
                        type="text" 
                        placeholder="e.g.: Password123" 
                        maxlength="255" 
                        required>
                </div>
                <div class="relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_users_role_a">
                        User role *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 bg-gray-200 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_users_role_a" 
                        name="create_users_role_a" 
                        type="text" 
                        value="advisor"
                        readonly>
                </div>
            </form>';
    return $form;
}

function create_dept_form($conn){
    $form = '<form id="createForm" data-form="department" class="bg-white rounded px-8 pt-6 pb-8">
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_dept_id_d">
                        Department ID *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_dept_id_d" 
                        name="create_dept_id_d" 
                        type="text" 
                        pattern="^TUPM-D-\\d{4}$" 
                        placeholder="format: TUPM-D-XXXX" 
                        required>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_course_id_d">
                        Course ID *
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_course_id_d" 
                        name="create_course_id_d">';
                        $query = "SELECT course_id, course_name FROM course";
                        $result = $conn->query($query);
                        while ($row = $result->fetch_assoc()) {
                            $form .= '<option value="' . $row['course_id'] . '">' . $row['course_id'] . ' - ' . $row['course_name'] . '</option>';
                        }
    $form .=        '</select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 lower-svg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_dept_name_d">
                        Department Name *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_dept_name_d" 
                        name="create_dept_name_d" 
                        type="text" 
                        placeholder="e.g.: Math" 
                        maxlength="255" 
                        required>
                </div>
                <div class="relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_location_d">
                        Location *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_location_d" 
                        name="create_location_d" 
                        type="text" 
                        placeholder="e.g.: Hallway" 
                        maxlength="255" 
                        required>
                </div>
            </form>';
    return $form;
}

function create_course_form($conn){
    $form = '<form id="createForm" data-form="course" class="bg-white rounded px-8 pt-6 pb-8">
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_course_id_c">
                        Course ID *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_course_id_c" 
                        name="create_course_id_c" 
                        type="text" 
                        placeholder="MATH" 
                        required>
                </div>
                <div class="mb-4 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_course_name_c">
                        Course Name *
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_course_name_c" 
                        name="create_course_name_c" 
                        type="text" 
                        placeholder="e.g.: Math" 
                        maxlength="255" 
                        required>
                </div>
                <div class="relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="create_credits_c">
                        Credits *
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="create_credits_c" 
                        name="create_credits_c"
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
