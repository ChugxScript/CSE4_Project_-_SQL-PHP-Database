function attachEventListeners() {
    // details
    document.querySelectorAll('.action-button.view').forEach(button => {
        button.addEventListener('click', function() {
            const table = this.getAttribute('data-table');
            const row = this.closest('tr');
            let detailsHTML = `<table class="w-full text-left border-collapse table-fixed border-4 border-sky-950 rounded-md">
                                <thead class="bg-sky-950 text-white">
                                    <tr>
                                        <th class="border px-4 py-2">Field</th>
                                        <th class="border px-4 py-2">Value</th>
                                    </tr>
                                </thead><tbody>`;
    
            if (table === 'department') {
                detailsHTML += `<tr class="bg-sky-200"><td class="border px-4 py-2">Department ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(1)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Department Name</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(2)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Course ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(3)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Course Name</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(4)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Location</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(5)').textContent}</td></tr>`;
            } else if (table === 'course') {
                detailsHTML += `<tr class="bg-sky-200"><td class="border px-4 py-2">Course ID</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(1)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Course Name</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(2)').textContent}</td></tr>
                                <tr class="bg-sky-200"><td class="border px-4 py-2">Credits</td><td class="border px-4 py-2">${row.querySelector('td:nth-child(3)').textContent}</td></tr>`;
            } 
    
            detailsHTML += '</tbody></table>';
    
            document.getElementById('TD_DetailsModalContainer').innerHTML = detailsHTML;
            document.getElementById('TD_DetailsModal').classList.remove('hidden');
        });
    });   

    

    // side bar
    document.getElementById("dashboard_link").addEventListener("click", function(event) {
        event.preventDefault();
        switch_tab("DASHBOARD");
    });

    document.getElementById("profile_link").addEventListener("click", function(event) {
        event.preventDefault();
        switch_tab("PROFILE");
        loadProfile('advisor');
    });

    document.getElementById("dept_link").addEventListener("click", function(event) {
        event.preventDefault();
        switch_tab("DEPARTMENT");
        loadPage('advisor', 'department', 1);
    });

    document.getElementById("course_link").addEventListener("click", function(event) {
        event.preventDefault();
        switch_tab("COURSE");
        loadPage('advisor', 'course', 1);
    });
}

function switch_tab(curr_tab){
    switch(curr_tab){
        case "DASHBOARD":
            document.getElementById("dashboard_container").classList.remove("hidden");
            document.getElementById("s_profile_container").classList.add("hidden");
            document.getElementById("dept_container").classList.add("hidden");
            document.getElementById("course_container").classList.add("hidden");
            break;
        case "PROFILE":
            document.getElementById("dashboard_container").classList.add("hidden");
            document.getElementById("s_profile_container").classList.remove("hidden");
            document.getElementById("dept_container").classList.add("hidden");
            document.getElementById("course_container").classList.add("hidden");
            break;
        case "DEPARTMENT":
            document.getElementById("dashboard_container").classList.add("hidden");
            document.getElementById("s_profile_container").classList.add("hidden");
            document.getElementById("dept_container").classList.remove("hidden");
            document.getElementById("course_container").classList.add("hidden");
            break;
        case "COURSE":
            document.getElementById("dashboard_container").classList.add("hidden");
            document.getElementById("s_profile_container").classList.add("hidden");
            document.getElementById("dept_container").classList.add("hidden");
            document.getElementById("course_container").classList.remove("hidden");
            break;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    attachEventListeners();

    // Search functionality
    document.getElementById('dept_search').addEventListener('click', function() {
        const searchTerm = document.getElementById('dept_searchBox').value.trim();
        const s_table = this.getAttribute('data-table');
        if (searchTerm) {
            searchRow('advisor', searchTerm, s_table, 1);
        } else {
            loadPage('advisor', s_table, 1);
        }
    });

    document.getElementById('dept_searchBox').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            const searchTerm = document.getElementById('dept_searchBox').value.trim();
            const s_table = this.getAttribute('data-table');
            if (searchTerm) {
                searchRow('advisor', searchTerm, s_table, 1);
            } else {
                loadPage('advisor', s_table, 1);
            }
        }
    });

    document.getElementById('course_search').addEventListener('click', function() {
        const searchTerm = document.getElementById('course_searchBox').value.trim();
        const s_table = this.getAttribute('data-table');
        if (searchTerm) {
            searchRow('advisor', searchTerm, s_table, 1);
        } else {
            loadPage('advisor', s_table, 1);
        }
    });

    document.getElementById('course_searchBox').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            const searchTerm = document.getElementById('course_searchBox').value.trim();
            const s_table = this.getAttribute('data-table');
            if (searchTerm) {
                searchRow('advisor', searchTerm, s_table, 1);
            } else {
                loadPage('advisor', s_table, 1);
            }
        }
    });

    // details
    document.getElementById('closeDetails').addEventListener('click', function() {
        document.getElementById('TD_DetailsModal').classList.add('hidden');
    });
});

function searchRow(user, searchTerm, s_table, page) {
    $.ajax({
        url: '../pages/utils/search_row.php',
        type: 'GET',
        data: { user: user, table: s_table, query: searchTerm, page: page },
        success: function(response) {
            if (response.startsWith('[ERROR]')){
                const message = response.replace('[ERROR]', '').trim();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message,
                });

            } else {
                switch(s_table){
                    case 'department':
                        $('#dept_table').html('');
                        $('#dept_table').html(response);
                        break;
                    case 'course':
                        $('#course_table').html('');
                        $('#course_table').html(response);
                        break;
                }
                attachEventListeners(); 
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error: " + textStatus + " - " + errorThrown);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to search data. Please try again.',
            });
        }
    });
}

function loadPage(user, table, page) {
    $.ajax({
        url: '../pages/utils/read_tables.php',
        type: 'GET',
        data: { user: user, table: table, page: page },
        success: function(response) {
            switch(table){
                case 'department':
                    $('#dept_table').html(response);
                    break;
                case 'course':
                    $('#course_table').html(response);
                    break;
            }
            attachEventListeners();
        }
    });
}

function loadProfile(user) {
    const url = new URL(window.location.href);
    const userId = url.searchParams.get('user_id');
    $.ajax({
        url: '../pages/utils/show_profile.php',
        type: 'GET',
        data: { user: user, user_id: userId },
        success: function(response) {
            $('#s_profile_subcon').html(response);
            attachEventListeners();
        }
    });
}