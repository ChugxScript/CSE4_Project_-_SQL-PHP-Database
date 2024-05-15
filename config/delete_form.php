<?php
include('function.php');

function delete_advisor_form($conn){
    $formHtml = '<form id="delete-form" class="form-advisor">';
    
    $formHtml .= '<label for="advisor_id">Advisor ID *</label>';
    $formHtml .= '<select id="del_advisor_id" name="advisor_id" required>';
    $query = "SELECT advisor_id, department_id, first_name, last_name FROM advisor";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $formHtml .= '<option value="' . $row['advisor_id'] . '" 
            adv-dept-id="' . $row['department_id'] . '" adv-first-name="' . $row['first_name'] . '"  adv-last-name="' . $row['last_name'] . '">'
            . $row['advisor_id'] . '</option>';
    }
    $formHtml .= '</select>';

    $formHtml .= '<label for="department_id">Department ID</label>';
    $formHtml .= '<input type="text" id="dela_department_id" name="department_id" value="" readonly>';
    $formHtml .= '<label for="first_name">First Name</label>';
    $formHtml .= '<input type="text" id="dela_first_name" name="first_name" value="" readonly>';
    $formHtml .= '<label for="last_name">Last Name</label>';
    $formHtml .= '<input type="text" id="dela_last_name" name="last_name" value="" readonly>';
    
    $formHtml .= '<button type="submit">Submit</button></form>';

    return $formHtml;
}

function delete_course_form($conn){
    $formHtml = '<form id="delete-form" class="form-advisor">';
    
    $formHtml .= '<label for="course_id">Course ID *</label>';
    $formHtml .= '<select id="del_course_id" name="course_id" required>';
    $query = "SELECT course_id, course_name, credits FROM course";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $formHtml .= '<option value="' . $row['course_id'] . '" 
            crs-name="' . $row['course_name'] . '" crs-credits="' . $row['credits'] . '">'
            . $row['course_id'] . '</option>';
    }
    $formHtml .= '</select>';

    $formHtml .= '<label for="course_name">Course Name</label>';
    $formHtml .= '<input type="text" id="del_course_name" name="course_name" value="" readonly>';
    $formHtml .= '<label for="credits">Credits</label>';
    $formHtml .= '<input type="text" id="del_credits" name="credits" value="" readonly>';

    $formHtml .= '<button type="submit">Submit</button></form>';

    return $formHtml;
}

function delete_department_form($conn){
    $formHtml = '<form id="delete-form" class="form-advisor">';
    
    $formHtml .= '<label for="department_id">Department ID *</label>';
    $formHtml .= '<select id="del_department_id" name="department_id" required>';
    $query = "SELECT department_id, department_name, location FROM department";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $formHtml .= '<option value="' . $row['department_id'] . '" 
            dept-name="' . $row['department_name'] . '" dept-location="' . $row['location'] . '">'
            . $row['department_id'] . '</option>';
    }
    $formHtml .= '</select>';

    $formHtml .= '<label for="department_name">Department Name</label>';
    $formHtml .= '<input type="text" id="del_department_name" name="department_name" value="" readonly>';
    $formHtml .= '<label for="location">Location</label>';
    $formHtml .= '<input type="text" id="del_location" name="location" value="" readonly>';

    $formHtml .= '<button type="submit">Submit</button></form>';

    return $formHtml;
}

function delete_student_form($conn){
    $formHtml = '<form id="delete-form" class="form-advisor">';
    
    $formHtml .= '<label for="student_id">Student ID *</label>';
    $formHtml .= '<select id="del_student_id" name="student_id" required>';
    $query = "SELECT student_id, advisor_id, first_name, last_name FROM student";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $formHtml .= '<option value="' . $row['student_id'] . '" 
            std-advisor-id="' . $row['advisor_id'] . '" std-first-name="' . $row['first_name'] . '" std-last-name="' . $row['last_name'] . '">'
            . $row['student_id'] . '</option>';
    }
    $formHtml .= '</select>';

    $formHtml .= '<label for="advisor_id">Advisor ID</label>';
    $formHtml .= '<input type="text" id="dels_advisor_id" name="advisor_id" value="" readonly>';
    $formHtml .= '<label for="first_name">First Name</label>';
    $formHtml .= '<input type="text" id="dels_first_name" name="first_name" value="" readonly>';
    $formHtml .= '<label for="last_name">Last Name</label>';
    $formHtml .= '<input type="text" id="dels_last_name" name="last_name" value="" readonly>';

    $formHtml .= '<button type="submit">Submit</button></form>';

    return $formHtml;
}

if (isset($_POST['table_name'])) {
    $conn = getDB();
    $tableName = $_POST['table_name'];

    switch($tableName){
        case 'advisor':
            echo delete_advisor_form($conn);
            break;
        case 'course':
            echo delete_course_form($conn);
            break;
        case 'department':
            echo delete_department_form($conn);
            break;
        case 'student':
            echo delete_student_form($conn);
            break;
        default:
            echo 'No data found';
            break;
    }
} else {
    echo "Table name or page not provided";
}
?>