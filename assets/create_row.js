// assets/create_row.js

function create_row_from_col() {
    const tableSelects = document.querySelectorAll('.table-select-c');
    const createFormContainer = document.getElementById('create-form-container');
    const initialTable_c = document.querySelector('.selected-table-c');

    tableSelects.forEach(tableSelect => {
        tableSelect.addEventListener('click', function() {
            const tableName = this.getAttribute('data-table-c');
            console.log(">>", tableName);

            fetch('config/get_dropdown_options.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `table_name=${tableName}`
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok: ${response.statusText}`);
                }
                return response.text();
            })
            .then(data => {
                if (data) {
                    createFormContainer.innerHTML = data;

                    // Form submission event
                    const form = document.getElementById('create-form');
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(this);
                        formData.append('table_name', tableName); 
                        
                        fetch('config/save_data.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`Network response was not ok: ${response.statusText}`);
                            }
                            return response.json();
                        })
                        .then(result => {
                            if (result.status === 'success') {
                                alert(result.message);
                                // Optionally, reset the form or update the UI
                                form.reset();
                            } else {
                                alert(result.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error saving data:', error);
                        });
                    });
                } else {
                    throw new Error('Form data is empty or undefined');
                }
            })
            .catch(error => {
                console.error('Error fetching form:', error);
                createFormContainer.innerHTML = `Error fetching form: ${error.message}`;
            });
        });
    });

    // Simulate click on the initial table
    if (initialTable_c) {
        initialTable_c.click();
    }
}

create_row_from_col();
