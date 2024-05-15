function delete_row_from_col(){
    const tableSelects = document.querySelectorAll('.table-select-d');
    const deleteFormContainer = document.getElementById('delete-form-container');
    const initialTable_d = document.querySelector('.selected-table-d');

    tableSelects.forEach(tableSelect => {
        tableSelect.addEventListener('click', function () {
            tableSelects.forEach(select => {
                select.classList.remove('active');
            });
            this.classList.add('active');
            activeTable = this;
            
            const tableName = this.getAttribute('data-table-d');
            console.log(">>", tableName);

            fetch('config/delete_form.php', {
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
                deleteFormContainer.innerHTML = data;
                update_attach_delete_form(tableName);
                setup_delete_form_submission(tableName);
            })
            .catch(error => {
                console.error('Error fetching form:', error);
                deleteFormContainer.innerHTML = `Error fetching form: ${error.message}`;
            });
        });
    });

    // Simulate click on the initial table
    if (initialTable_d) {
        initialTable_d.click();
    }
}

function setup_delete_form_submission(tableName) {
    const form = document.getElementById('delete-form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('table_name', tableName);

        fetch('config/delete_data.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            delete_row_from_col();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
}

function update_attach_delete_form(tableName) {
    function updateFields(selectElementId, fieldsMap) {
        const selectElement = document.getElementById(selectElementId);
        if (!selectElement) return;

        function updateFieldsFromSelectedOption() {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            for (const [fieldId, attrName] of Object.entries(fieldsMap)) {
                const fieldValue = selectedOption.getAttribute(attrName);
                const fieldElement = document.getElementById(fieldId);
                if (fieldElement) {
                    fieldElement.value = fieldValue || "";
                }
            }
        }

        updateFieldsFromSelectedOption();
        selectElement.addEventListener("change", updateFieldsFromSelectedOption);
    }

    const fieldMaps = {
        'advisor': {
            'del_advisor_id': {
                "dela_department_id": "adv-dept-id",
                "dela_first_name": "adv-first-name",
                "dela_last_name": "adv-last-name"
            }
        },
        'course': {
            'del_course_id': {
                "del_course_name": "crs-name",
                "del_credits": "crs-credits"
            }
        },
        'department': {
            'del_department_id': {
                "del_department_name": "dept-name",
                "del_location": "dept-location"
            }
        },
        'student': {
            'del_student_id': {
                "dels_advisor_id": "std-advisor-id",
                "dels_first_name": "std-first-name",
                "dels_last_name": "std-last-name"
            }
        }
    };

    const fieldMap = fieldMaps[tableName];
    if (fieldMap) {
        for (const [selectElementId, fieldsMap] of Object.entries(fieldMap)) {
            updateFields(selectElementId, fieldsMap);
        }
    }
}