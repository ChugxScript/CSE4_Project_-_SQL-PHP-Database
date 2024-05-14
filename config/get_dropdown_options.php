<!-- config/get_dropdown_options.php -->

<?php
include('function.php');

if (isset($_POST['table_name'])) {
    $conn = getDB();
    $tableName = $_POST['table_name'];

    if ($tableName === 'advisor') {
        $formHtml = '<form id="create-form" class="form-advisor">';
        $formHtml .= '<label for="advisor_id">Advisor ID *</label>';
        $formHtml .= '<input type="text" id="advisor_id" name="advisor_id" pattern="^TUPM-P-\\d{2}-\\d{4}$" placeholder="format: TUPM-P-XX-XXXX" maxlength="20" required>';
        $formHtml .= '<label for="department_id">Department ID</label>';
        $formHtml .= '<select id="department_id" name="department_id" required>';

        $query = "SELECT department_id, department_name FROM department";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            $formHtml .= '<option value="' . $row['department_id'] . '">' . $row['department_id'] . ' - ' . $row['department_name'] . '</option>';
        }
        $formHtml .= '</select>';
        $formHtml .= '<label for="first_name">First Name *</label>';
        $formHtml .= '<input type="text" id="first_name" name="first_name" placeholder="e.g.: Sir Val" maxlength="255" required>';
        $formHtml .= '<label for="last_name">Last Name *</label>';
        $formHtml .= '<input type="text" id="last_name" name="last_name" placeholder="e.g.: Fabregas" maxlength="255" required>';
        $formHtml .= '<button type="submit">Submit</button></form>';

        echo $formHtml;

    } elseif ($tableName === 'course') {
        $formHtml = '<form id="create-form" class="form-advisor">';
        $formHtml .= '<label for="course_id">Course ID *</label>';
        $formHtml .= '<input type="text" id="course_id" name="course_id" maxlength="20" placeholder="e.g.: ABC123" required>';
        $formHtml .= '<label for="course_name">Course Name *</label>';
        $formHtml .= '<input type="text" id="course_name" name="course_name" maxlength="255" placeholder="e.g.: Introduction to Letters" required>';
        $formHtml .= '<label for="credits">Credits *</label>';
        $formHtml .= '<input type="number" id="credits" name="credits" placeholder="e.g.: 3" required>';

        $formHtml .= '<button type="submit">Submit</button></form>';

        echo $formHtml;

    } elseif ($tableName === 'department') {
        $formHtml = '<form id="create-form" class="form-advisor">';
        $formHtml .= '<label for="department_id">Department ID *</label>';
        $formHtml .= '<input type="text" id="department_id" name="department_id" pattern="^TUPM-D-\\d{4}$" placeholder="format: TUPM-D-XXXX" required>';
        $formHtml .= '<label for="department_name">Department Name *</label>';
        $formHtml .= '<input type="text" id="department_name" name="department_name" placeholder="e.g.: Database Management" maxlength="255" required>';
        $formHtml .= '<label for="location">Location *</label>';
        $formHtml .= '<input type="text" id="location" name="location" placeholder="e.g.: COS Building 3rd floor" maxlength="255" required>';
        $formHtml .= '<button type="submit">Submit</button></form>';

        echo $formHtml;

    } elseif ($tableName === 'student') {
        $formHtml = '<form id="create-form" class="form-advisor">';
        $formHtml .= '<label for="student_id">Student ID *</label>';
        $formHtml .= '<input type="text" id="student_id" name="student_id" pattern="^TUPM-\\d{2}-\\d{4}$" placeholder="format: TUPM-XX-XXXX" required>';
        $formHtml .= '<label for="advisor_id">Advisor ID *</label>';
        $formHtml .= '<select id="advisor_id" name="advisor_id" required>';

        $query = "SELECT advisor_id, first_name, last_name FROM advisor";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            $formHtml .= '<option value="' . $row['advisor_id'] . '">' . $row['advisor_id'] . ' - ' . $row['first_name'] . ' ' . $row['last_name'] . '</option>';
        }

        $formHtml .= '</select>';
        $formHtml .= '<label for="first_name">First Name *</label>';
        $formHtml .= '<input type="text" id="first_name" name="first_name" placeholder="e.g.: Andrew" maxlength="255" required>';
        $formHtml .= '<label for="last_name">Last Name *</label>';
        $formHtml .= '<input type="text" id="last_name" name="last_name" placeholder="e.g.: Oloroso" maxlength="255" required>';
        $formHtml .= '<button type="submit">Submit</button></form>';

        echo $formHtml;
    } else {
        echo "No data found";
    }
} else {
    echo "Table name or page not provided";
}
?>
