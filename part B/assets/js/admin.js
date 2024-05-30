
function attachEventListeners() {

    // update
    document.querySelectorAll('.action-button.update').forEach(button => {
        button.addEventListener('click', function() {
            const table = this.getAttribute('data-table');
            const row = this.closest('tr');
            const d_id = row.querySelector('td:nth-child(1)').textContent;
            loadUpdateForm(table, d_id);
        });
    });

    // delete
    document.querySelectorAll('.action-button.delete').forEach(button => {
        button.addEventListener('click', function() {
            const table = this.getAttribute('data-table');
            const row = this.closest('tr');
            let detailsHTML = `<table class="w-full text-center border-collapse table-fixed border-4 border-red-950 rounded-md">
                                <thead class="bg-red-950 text-white">
                                    <tr>
                                        <th class="border px-4 py-2">Field</th>
                                        <th class="border px-4 py-2">Value</th>
                                    </tr>
                                </thead><tbody>`;
    
            if (table === 'student') {
                detailsHTML += `<tr class="bg-red-200"><td class="border px-4 py-2">Student ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(1)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">First Name (Student)</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(2)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">Last Name (Student)</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(3)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">Advisor ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(4)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">First Name (Advisor)</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(5)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">Last Name (Advisor)</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(6)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">User ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(7)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">Username</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(8)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">Password</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(9)').textContent}</td></tr>`;
            } else if (table === 'advisor') {
                detailsHTML += `<tr class="bg-red-200"><td class="border px-4 py-2">Advisor ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(1)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">Department ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(2)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">User ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(3)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">First Name</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(4)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">Last Name</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(5)').textContent}</td></tr>`;
            } else if (table === 'department') {
                detailsHTML += `<tr class="bg-red-200"><td class="border px-4 py-2">Department ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(1)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">Department Name</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(2)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">Course ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(3)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">Location</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(4)').textContent}</td></tr>`;
            } else if (table === 'course') {
                detailsHTML += `<tr class="bg-red-200"><td class="border px-4 py-2">Course ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(1)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">Course Name</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(2)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">Credits</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(3)').textContent}</td></tr>`;
            } else if (table === 'users') {
                detailsHTML += `<tr class="bg-red-200"><td class="border px-4 py-2">User ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(1)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">Username</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(2)').textContent}</td></tr>
                                <tr class="bg-red-200"><td class="border px-4 py-2">Role</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(3)').textContent}</td></tr>`;
            }
    
            detailsHTML += '</tbody></table>';
    
            document.getElementById('recordDetails').innerHTML = detailsHTML;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('confirmDelete').setAttribute('data-table', table);
            document.getElementById('confirmDelete').setAttribute('data-id', row.querySelector('td:nth-child(1)').textContent);
        });
    });    

    // details
    document.querySelectorAll('.action-button.view').forEach(button => {
        button.addEventListener('click', function() {
            const table = this.getAttribute('data-table');
            const row = this.closest('tr');
            let detailsHTML = `<table class="w-full text-center border-collapse table-fixed border-4 border-sky-950 rounded-md">
                                <thead class="bg-sky-950 text-white">
                                    <tr>
                                        <th class="border px-4 py-2">Field</th>
                                        <th class="border px-4 py-2">Value</th>
                                    </tr>
                                </thead><tbody>`;
    
            if (table === 'student') {
                detailsHTML += `<tr class="bg-sky-200"><td class="border px-4 py-2">Student ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(1)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">First Name (Student)</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(2)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Last Name (Student)</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(3)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Advisor ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(4)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">First Name (Advisor)</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(5)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Last Name (Advisor)</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(6)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">User ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(7)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Username</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(8)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Password</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(9)').textContent}</td></tr>`;
            } else if (table === 'advisor') {
                detailsHTML += `<tr class="bg-sky-200"><td class="border px-4 py-2">Advisor ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(1)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Department ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(2)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">User ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(3)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">First Name</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(4)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Last Name</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(5)').textContent}</td></tr>`;
            } else if (table === 'department') {
                detailsHTML += `<tr class="bg-sky-200"><td class="border px-4 py-2">Department ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(1)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Department Name</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(2)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Course ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(3)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Location</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(4)').textContent}</td></tr>`;
            } else if (table === 'course') {
                detailsHTML += `<tr class="bg-sky-200"><td class="border px-4 py-2">Course ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(1)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Course Name</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(2)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Credits</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(3)').textContent}</td></tr>`;
            } else if (table === 'users') {
                detailsHTML += `<tr class="bg-sky-200"><td class="border px-4 py-2">User ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(1)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Username</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(2)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Role</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(3)').textContent}</td></tr>`;
            }
    
            detailsHTML += '</tbody></table>';
    
            document.getElementById('TD_DetailsModalContainer').innerHTML = detailsHTML;
            document.getElementById('TD_DetailsModal').classList.remove('hidden');
        });
    });   

    

    // side bar
    document.getElementById("dashboard_link").addEventListener("click", function(event) {
        event.preventDefault();
        document.getElementById("dashboard_container").classList.toggle("hidden");
        document.getElementById("student_container").classList.add("hidden");
    });

    document.getElementById("student_link").addEventListener("click", function(event) {
        event.preventDefault();
        document.getElementById("student_container").classList.toggle("hidden");
        document.getElementById("dashboard_container").classList.add("hidden");
        loadPage('admin', 'student', 1);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    attachEventListeners(); // Initial load

    // details
    document.getElementById('closeDetails').addEventListener('click', function() {
        document.getElementById('TD_DetailsModal').classList.add('hidden');
    });

    // create
    document.getElementById('openModalButton').addEventListener('click', function() {
        document.getElementById('createModal').classList.remove('hidden');
        const table = this.getAttribute('data-table');
        loadCreateForm(table);
    });

    document.getElementById('cancelCreate').addEventListener('click', function() {
        document.getElementById('createModal').classList.add('hidden');
    });

    document.getElementById('confirmCreate').addEventListener('click', function() {
        const form = document.getElementById('createForm');
        const formData = new FormData(form);

        const table = form.getAttribute('data-form');

        formData.append('table', table);
        formData.forEach((value, key) => {
            console.log(key + ": " + value);
        });

        $.ajax({
            url: '../pages/utils/create_row.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.startsWith('[SUCCESS]')) {
                    const message = response.replace('[SUCCESS]', '').trim();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: message,
                    }).then(() => {
                        document.getElementById('createModal').classList.add('hidden');
                        loadPage('admin', table, 1);
                    });
                } else if (response.startsWith('[ERROR]')) {
                    const message = response.replace('[ERROR]', '').trim();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message,
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Unexpected response from server. Please try again.',
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error: " + textStatus + " - " + errorThrown);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update data. Please try again.',
                });
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
            url: '../pages/utils/update_row.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.startsWith('[SUCCESS]')) {
                    const message = response.replace('[SUCCESS]', '').trim();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: message,
                    }).then(() => {
                        document.getElementById('updateModal').classList.add('hidden');
                        loadPage('admin', table, 1);
                    });
                } else if (response.startsWith('[ERROR]')) {
                    const message = response.replace('[ERROR]', '').trim();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message,
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Unexpected response from server. Please try again.',
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error: " + textStatus + " - " + errorThrown);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update data. Please try again.',
                });
            }
        });
    });

    // delete
    document.getElementById('cancelDelete').addEventListener('click', function() {
        document.getElementById('deleteModal').classList.add('hidden');
    });

    document.getElementById('confirmDelete').addEventListener('click', function() {
        const d_table = this.getAttribute('data-table');
        const d_id = this.getAttribute('data-id');

        const formData = new FormData();
        formData.append('table', d_table);
        formData.append('id', d_id);
        formData.forEach((value, key) => {
            console.log(key + ": " + value);
        });

        $.ajax({
            url: '../pages/utils/delete_row.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.startsWith('[SUCCESS]')) {
                    const message = response.replace('[SUCCESS]', '').trim();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: message,
                    }).then(() => {
                        document.getElementById('deleteModal').classList.add('hidden');
                        loadPage('admin', d_table, 1);
                    });
                } else if (response.startsWith('[ERROR]')) {
                    const message = response.replace('[ERROR]', '').trim();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message,
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Unexpected response from server. Please try again.',
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error: " + textStatus + " - " + errorThrown);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update data. Please try again.',
                });
            }
        });
    });
});

function loadCreateForm(table) {
    $.ajax({
        url: '../pages/utils/create_form.php',
        type: 'GET',
        data: { table: table },
        success: function(response) {
            $('#createFormContainer').html(response);
            $('#createModal').removeClass('hidden');
            attachEventListeners();
        }
    });
}

function loadUpdateForm(table, rowId) {
    $.ajax({
        url: '../pages/utils/update_form.php',
        type: 'GET',
        data: { table: table, row_id: rowId },
        success: function(response) {
            $('#updateFormContainer').html(response);
            $('#updateModal').removeClass('hidden');
            attachEventListeners();
        }
    });
}

function loadPage(user, table, page) {
    $.ajax({
        url: '../pages/utils/read_tables.php',
        type: 'GET',
        data: { user: user, table: table, page: page },
        success: function(response) {
            $('#student_table').html(response);
            attachEventListeners(); // Re-attach event listeners after AJAX load
        }
    });
}

