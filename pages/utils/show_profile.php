<?php
include '../../config/connect.php';

if (isset($_GET['user_id']) && isset($_GET['user'])) {
    $user_id = $_GET['user_id'];
    $user = $_GET['user'];
    
    switch($user){
        case "student":
            echo student_profile($conn, $user_id);
            break;
        case "advisor":
            echo advisor_profile($conn, $user_id);
            break;
    }
} else {
    echo "<p class='text-red-500'>[ERROR] No profile found for the given user ID.</p>";
}

function student_profile($conn, $user_id){
    $sql = "SELECT s.student_id, 
                    s.first_name AS student_first_name, 
                    s.last_name AS student_last_name, 
                    s.assigned_sex AS student_assigned_sex,
                    a.advisor_id, 
                    a.first_name AS advisor_first_name, 
                    a.last_name AS advisor_last_name, 
                    a.assigned_sex AS advisor_assigned_sex, 
                    u.user_id, 
                    u.username, 
                    u.password 
            FROM student s 
            JOIN advisor a ON s.advisor_id = a.advisor_id 
            JOIN users u ON s.user_id = u.user_id
            WHERE s.user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $profile = $result->fetch_assoc();

    if ($profile) {
        $html = '';
        $html .= '
        <div class="bg-slate-800 md:mx-auto rounded shadow-xl w-full overflow-hidden">
            <div class="h-[170px] bg-gradient-to-r from-cyan-900 to-slate-900"></div>
            <div class="px-5 py-2 flex flex-col gap-3 pb-6">
                <div class="h-[200px] shadow-md w-[200px] rounded-full border-4 overflow-hidden -mt-14 border-white"><img src="https://media.tenor.com/WugWpCOeHOQAAAAi/ricardo-ricardo-flick.gif" class="w-full h-full rounded-full object-center object-cover"></div>
                <div class="">
                    <h3 class="text-xl text-slate-200 relative font-bold leading-6">' . $profile["student_first_name"] . ' ' . $profile["student_last_name"] . '</h3>
                    <a class="text-sm text-gray-400" href="https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database" target="BLANK()">@' . $profile["student_first_name"] . '' . $profile["student_last_name"] . '</a>
                </div> 
                <div class="flex gap-3 flex-wrap">
                    <span class="rounded-sm bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-800">
                        Developer
                    </span>
                    <span class="rounded-sm bg-green-100 px-3 py-1 text-xs font-medium text-green-800">
                        Design
                    </span>
                    <span class="rounded-sm bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800">
                        Managements
                    </span>
                    <span class="rounded-sm bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-800">
                        Projects
                    </span>
                </div>
                <h4 class="text-md text-slate-200 font-medium leading-3">About</h4>
                <table class="table-fixed w-full rounded">
                    <thead>
                        <tr class="bg-slate-950">
                            <th class="w-1/4 px-4 py-2 text-left text-white">Student ID</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">First Name</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">Last Name</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">Assigned Sex</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-slate-900 even:bg-slate-800">
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["student_id"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["student_first_name"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["student_last_name"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["student_assigned_sex"] . '</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table-fixed w-full rounded">
                    <thead>
                        <tr class="bg-slate-950">
                            <th class="w-1/4 px-4 py-2 text-left text-white">Advisor ID</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">First Name</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">Last Name</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">Assigned Sex</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-slate-900 even:bg-slate-800">
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["advisor_id"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["advisor_first_name"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["advisor_last_name"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["advisor_assigned_sex"] . '</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table-fixed w-full rounded">
                    <thead>
                        <tr class="bg-slate-950">
                            <th class="w-1/4 px-4 py-2 text-left text-white">Student User ID</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">Username</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-slate-900 even:bg-slate-800">
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["user_id"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["username"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["password"] . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        ';

        return $html;
    } else {
        return "<p class='text-red-500'>[ERROR] No profile found for the given user ID.</p>";
    }
}

function advisor_profile($conn, $user_id){
    $sql = "SELECT a.advisor_id, 
                    a.first_name AS advisor_first_name, 
                    a.last_name AS advisor_last_name, 
                    a.assigned_sex AS advisor_assigned_sex, 
                    d.department_id, 
                    d.department_name AS dept_dept_name, 
                    d.course_id AS dept_dept_course_id, 
                    d.location AS dept_dept_location, 
                    u.user_id, 
                    u.username, 
                    u.password 
            FROM advisor a 
            JOIN department d ON a.department_id = d.department_id 
            JOIN users u ON a.user_id = u.user_id
            WHERE a.user_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $profile = $result->fetch_assoc();

    if ($profile) {
        $html = '';
        $html .= '
        <div class="bg-slate-800 md:mx-auto rounded shadow-xl w-full overflow-hidden">
            <div class="h-[170px] bg-gradient-to-r from-cyan-900 to-slate-900"></div>
            <div class="px-5 py-2 flex flex-col gap-3 pb-6">
                <div class="h-[200px] shadow-md w-[200px] rounded-full border-4 overflow-hidden -mt-14 border-white"><img src="https://media1.tenor.com/m/mtiOW6O-k8YAAAAC/shrek-shrek-rizz.gif" class="w-full h-full rounded-full object-center object-cover"></div>
                <div class="">
                    <h3 class="text-xl text-slate-200 relative font-bold leading-6">' . $profile["advisor_first_name"] . ' ' . $profile["advisor_last_name"] . '</h3>
                    <a class="text-sm text-gray-400" href="https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database" target="BLANK()">@' . $profile["advisor_first_name"] . '' . $profile["advisor_last_name"] . '</a>
                </div> 
                <div class="flex gap-3 flex-wrap">
                    <span class="rounded-sm bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-800">
                        Developer
                    </span>
                    <span class="rounded-sm bg-green-100 px-3 py-1 text-xs font-medium text-green-800">
                        Design
                    </span>
                    <span class="rounded-sm bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800">
                        Managements
                    </span>
                    <span class="rounded-sm bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-800">
                        Projects
                    </span>
                </div>
                <h4 class="text-md text-slate-200 font-medium leading-3">About</h4>
                <table class="table-fixed w-full rounded">
                    <thead>
                        <tr class="bg-slate-950">
                            <th class="w-1/4 px-4 py-2 text-left text-white">Advisor ID</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">First Name</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">Last Name</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">Assigned Sex</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-slate-900 even:bg-slate-800">
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["advisor_id"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["advisor_first_name"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["advisor_last_name"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["advisor_assigned_sex"] . '</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table-fixed w-full rounded">
                    <thead>
                        <tr class="bg-slate-950">
                            <th class="w-1/4 px-4 py-2 text-left text-white">Department ID</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">Department Name</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">Department Course</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-slate-900 even:bg-slate-800">
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["department_id"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["dept_dept_name"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["dept_dept_course_id"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["dept_dept_location"] . '</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table-fixed w-full rounded">
                    <thead>
                        <tr class="bg-slate-950">
                            <th class="w-1/4 px-4 py-2 text-left text-white">Advisor User ID</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">Username</th>
                            <th class="w-1/4 px-4 py-2 text-left text-white">Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-slate-900 even:bg-slate-800">
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["user_id"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["username"] . '</td>
                            <td class="px-4 py-2 text-left text-white fixed-width word-wrap">' . $profile["password"] . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        ';

        return $html;
    } else {
        return "<p class='text-red-500'>[ERROR] No profile found for the given user ID.</p>";
    }
}
?>