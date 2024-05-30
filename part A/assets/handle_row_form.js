function handleRowForm(tableClass, containerId, endpoint) {
    const tableSelects = document.querySelectorAll(`.${tableClass}`);
    const formContainer = document.getElementById(containerId);
    const initialTable = document.querySelector(`.selected-${tableClass.split('-')[1]}`);

    tableSelects.forEach(tableSelect => {
        tableSelect.addEventListener('click', function() {
            const tableName = this.getAttribute(`data-table-${tableClass.split('-')[1]}`);
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
                    formContainer.innerHTML = data;
                    const form = document.getElementById('create-form');
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const formData = new FormData(this);
                        formData.append('table_name', tableName); 
                        
                        fetch(`config/${endpoint}`, {
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
                            alert(result.message);
                            if (result.status === 'success') {
                                form.reset();
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
                formContainer.innerHTML = `Error fetching form: ${error.message}`;
            });
        });
    });

    if (initialTable) {
        initialTable.click();
    }
}

// Initialize for create and update
handleRowForm('table-select-c', 'create-form-container', 'save_data.php');
handleRowForm('table-select-u', 'update-form-container', 'save_data.php');
