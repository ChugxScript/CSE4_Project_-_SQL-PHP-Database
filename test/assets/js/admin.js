
function attachEventListeners() {
    document.querySelectorAll('.action-button.delete').forEach(button => {
        button.addEventListener('click', function() {
            const table = this.getAttribute('data-table');
            const row = this.closest('tr');
            let details = '';

            if (table === 'student') {
                details = `Student ID: ${row.querySelector('td:nth-child(1)').textContent}<br>
                           Advisor ID: ${row.querySelector('td:nth-child(2)').textContent}<br>
                           User ID: ${row.querySelector('td:nth-child(3)').textContent}<br>
                           First Name: ${row.querySelector('td:nth-child(4)').textContent}<br>
                           Last Name: ${row.querySelector('td:nth-child(5)').textContent}`;
            } else if (table === 'advisor') {
                details = `Advisor ID: ${row.querySelector('td:nth-child(1)').textContent}<br>
                           Department ID: ${row.querySelector('td:nth-child(2)').textContent}<br>
                           User ID: ${row.querySelector('td:nth-child(3)').textContent}<br>
                           First Name: ${row.querySelector('td:nth-child(4)').textContent}<br>
                           Last Name: ${row.querySelector('td:nth-child(5)').textContent}`;
            } else if (table === 'department') {
                details = `Department ID: ${row.querySelector('td:nth-child(1)').textContent}<br>
                           Department Name: ${row.querySelector('td:nth-child(2)').textContent}<br>
                           Course ID: ${row.querySelector('td:nth-child(3)').textContent}<br>
                           Location: ${row.querySelector('td:nth-child(4)').textContent}`;
            } else if (table === 'course') {
                details = `Course ID: ${row.querySelector('td:nth-child(1)').textContent}<br>
                           Course Name: ${row.querySelector('td:nth-child(2)').textContent}<br>
                           Credits: ${row.querySelector('td:nth-child(3)').textContent}`;
            } else if (table === 'users') {
                details = `User ID: ${row.querySelector('td:nth-child(1)').textContent}<br>
                           Username: ${row.querySelector('td:nth-child(2)').textContent}<br>
                           Role: ${row.querySelector('td:nth-child(3)').textContent}`;
            }

            document.getElementById('recordDetails').innerHTML = details;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('confirmDelete').setAttribute('data-table', table);
            document.getElementById('confirmDelete').setAttribute('data-id', row.querySelector('td:nth-child(1)').textContent);
        });
    });

    document.querySelectorAll('.action-button.update').forEach(button => {
        button.addEventListener('click', function() {
            const table = this.getAttribute('data-table');
            const row = this.closest('tr');
            const d_id = row.querySelector('td:nth-child(1)').textContent;
            loadUpdateForm(table, d_id);
        });
    });

    document.getElementById("dashboard_link").addEventListener("click", function(event) {
        event.preventDefault();
        document.getElementById("dashboard_container").classList.toggle("hidden");
        document.getElementById("student_container").classList.add("hidden");
    });

    document.getElementById("student_link").addEventListener("click", function(event) {
        event.preventDefault();
        document.getElementById("student_container").classList.toggle("hidden");
        document.getElementById("dashboard_container").classList.add("hidden");
        loadPage('student', 1);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    attachEventListeners(); // Initial load

    // delete
    document.getElementById('cancelDelete').addEventListener('click', function() {
        document.getElementById('deleteModal').classList.add('hidden');
    });

    document.getElementById('confirmDelete').addEventListener('click', function() {
        const table = this.getAttribute('data-table');
        const id = this.getAttribute('data-id');

        // Make an AJAX request to delete the record
        $.ajax({
            url: '../pages/utils/delete_record.php',
            type: 'POST',
            data: { table: table, id: id },
            success: function(response) {
                document.getElementById('deleteModal').classList.add('hidden');
                loadPage(table, 1);
            }
        });
    });

    // update
    document.getElementById('cancelUpdate').addEventListener('click', function() {
        document.getElementById('updateModal').classList.add('hidden');
    });

    document.getElementById('confirmUpdate').addEventListener('click', function() {
        const form = document.getElementById('updateForm');
        const formData = new FormData(form);

        const table = form.getAttribute('data-form');

        formData.append('table', table);
        formData.forEach((value, key) => {
            console.log(key + ": " + value);
        });

        $.ajax({
            url: '../pages/utils/update_record.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert("DATA UPDATED SUCCESSFULLY");
                document.getElementById('updateModal').classList.add('hidden');
                loadPage(table, 1);
            }
        });
    });
});

function loadUpdateForm(table, rowId) {
    $.ajax({
        url: '../pages/utils/fetch_update_form.php',
        type: 'GET',
        data: { table: table, row_id: rowId },
        success: function(response) {
            $('#updateFormContainer').html(response);
            $('#updateModal').removeClass('hidden');
            attachEventListeners();
        }
    });
}


function loadPage(table, page) {
    $.ajax({
        url: '../pages/utils/fetch_tables.php',
        type: 'GET',
        data: { table: table, page: page },
        success: function(response) {
            $('#student_table').html(response);
            attachEventListeners(); // Re-attach event listeners after AJAX load
        }
    });
}

