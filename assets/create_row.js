function create_row_from_col() {
    const tableSelects = document.querySelectorAll('.table-select-c');
    const createFormContainer = document.getElementById('create-form-container');
    const initialTable_c = document.querySelector('.selected-table-c');

    tableSelects.forEach(tableSelect => {
        tableSelect.addEventListener('click', function() {
            tableSelects.forEach(select => {
                select.classList.remove('active');
            });
            this.classList.add('active');
            activeTable = this;
            
            const tableName = this.getAttribute('data-table-c');
            console.log(">>", tableName);

            fetch('config/create_form.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `table_name=${tableName}`
            })
            .then(response => response.text())
            .then(data => {
                if (!data) {
                    throw new Error('Form data is empty or undefined');
                }
                createFormContainer.innerHTML = data;
                setupCreateFormSubmission(tableName);
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

function setupCreateFormSubmission(tableName) {
    const form = document.getElementById('create-form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('table_name', tableName);

        fetch('config/create_data.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            create_row_from_col();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
}
