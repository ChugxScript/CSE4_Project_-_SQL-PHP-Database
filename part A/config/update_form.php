<?php
include('function.php');

function update_advisor_form($conn){
    $formHtml = '<form id="update-form" class="form-advisor">';
    
    $formHtml .= '<label for="advisor_id">Advisor ID *</label>';
    $formHtml .= '<select id="advisor_upID" name="advisor_id" required>';
    $query = "SELECT advisor_id, first_name, last_name FROM advisor";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $formHtml .= '<option value="' . $row['advisor_id'] . '" 
            adv-first-name="' . $row['first_name'] . '" adv-last-name="' . $row['last_name'] . '">'
            . $row['advisor_id'] . '</option>';
    }
    $formHtml .= '</select>';

    $formHtml .= '<label for="department_id">Department ID</label>';
    $formHtml .= '<select id="department_upID" name="department_id" required>';
    $query = "SELECT department_id, department_name FROM department";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $formHtml .= '<option value="' . $row['department_id'] . '">' 
            . $row['department_id'] . ' - ' . $row['department_name'] . '</option>';
    }
    $formHtml .= '</select>';

    $formHtml .= '<label for="first_name">First Name *</label>';
    $formHtml .= '<input type="text" id="up_first_name" name="first_name" placeholder="e.g.: Sir Val" maxlength="255" required>';
    $formHtml .= '<label for="last_name">Last Name *</label>';
    $formHtml .= '<input type="text" id="up_last_name" name="last_name" placeholder="e.g.: Fabregas" maxlength="255" required>';
    $formHtml .= '<button type="submit">Submit</button></form>';

    return $formHtml;
}

function update_course_form($conn){
    $formHtml = '<form id="update-form" class="form-advisor">';
    $formHtml .= '<label for="course_id">Course ID *</label>';
    $formHtml .= '<select id="course_upID" name="course_id" required>';
    $query = "SELECT course_id, course_name, credits FROM course";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $formHtml .= '<option value="' . $row['course_id'] . '" 
            crs-name="' . $row['course_name'] . '" crs-credits="' . $row['credits'] . '">'
            . $row['course_id'] . '</option>';
    }
    $formHtml .= '</select>';

    $formHtml .= '<label for="course_name">Course Name *</label>';
    $formHtml .= '<input type="text" id="course_upName" name="course_name" maxlength="255" placeholder="e.g.: Introduction to Letters" required>';
    $formHtml .= '<label for="credits">Credits *</label>';
    $formHtml .= '<input type="number" id="up_credits" name="credits" placeholder="e.g.: 3" required>';

    $formHtml .= '<button type="submit">Submit</button></form>';

    return $formHtml;
}

function update_department_form($conn){
    $formHtml = '<form id="update-form" class="form-advisor">';
    $formHtml .= '<label for="department_id">Department ID *</label>';
    $formHtml .= '<select id="department_upID" name="department_id" required>';
    $query = "SELECT department_id, department_name, location FROM department";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $formHtml .= '<option value="' . $row['department_id'] . '" 
            dept-name="' . $row['department_name'] . '" dept-location="' . $row['location'] . '">'
            . $row['department_id'] . '</option>';
    }
    $formHtml .= '</select>';

    $formHtml .= '<label for="department_name">Department Name *</label>';
    $formHtml .= '<input type="text" id="department_upName" name="department_name" placeholder="e.g.: Database Management" maxlength="255" required>';
    $formHtml .= '<label for="location">Location *</label>';
    $formHtml .= '<input type="text" id="up_location" name="location" placeholder="e.g.: COS Building 3rd floor" maxlength="255" required>';
    $formHtml .= '<button type="submit">Submit</button></form>';

    return $formHtml;
}

function update_student_form($conn){
    $formHtml = '<form id="update-form" class="form-advisor">';

    $formHtml .= '<label for="student_id">Student ID *</label>';
    $formHtml .= '<select id="student_upID" name="student_id" required>';
    $query = "SELECT student_id, first_name, last_name FROM student";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $formHtml .= '<option value="' . $row['student_id'] . '"
            std-first-name="' . $row['first_name'] . '" std-last-name="' . $row['last_name'] . '">'
            . $row['student_id'] . '</option>';
    }
    $formHtml .= '</select>';

    $formHtml .= '<label for="advisor_id">Advisor ID *</label>';
    $formHtml .= '<select id="advisor_upID" name="advisor_id" required>';
    $query = "SELECT advisor_id, first_name, last_name FROM advisor";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $formHtml .= '<option value="' . $row['advisor_id'] . '">' . $row['advisor_id'] . ' - ' . $row['first_name'] . ' ' . $row['last_name'] . '</option>';
    }
    $formHtml .= '</select>';

    $formHtml .= '<label for="first_name">First Name *</label>';
    $formHtml .= '<input type="text" id="student_first_name" name="first_name" placeholder="e.g.: Andrew" maxlength="255" required>';
    $formHtml .= '<label for="last_name">Last Name *</label>';
    $formHtml .= '<input type="text" id="student_last_name" name="last_name" placeholder="e.g.: Oloroso" maxlength="255" required>';
    $formHtml .= '<button type="submit">Submit</button></form>';

    return $formHtml;
}

if (isset($_POST['table_name'])) {
    $conn = getDB();
    $tableName = $_POST['table_name'];

    switch($tableName){
        case 'advisor':
            echo update_advisor_form($conn);
            break;
        case 'course':
            echo update_course_form($conn);
            break;
        case 'department':
            echo update_department_form($conn);
            break;
        case 'student':
            echo update_student_form($conn);
            break;
        default:
            echo 'No data found';
            break;
    }
} else {
    echo "Table name or page not provided";
}
?>
