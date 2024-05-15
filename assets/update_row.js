function update_row_from_col() {
    const tableSelects = document.querySelectorAll('.table-select-u');
    const updateFormContainer = document.getElementById('update-form-container');
    const initialTable_u = document.querySelector('.selected-table-u');

    tableSelects.forEach(tableSelect => {
        tableSelect.addEventListener('click', function () {
            tableSelects.forEach(select => {
                select.classList.remove('active');
            });
            this.classList.add('active');
            activeTable = this;
            
            const tableName = this.getAttribute('data-table-u');
            console.log(">>", tableName);

            fetch('config/update_form.php', {
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
                updateFormContainer.innerHTML = data;
                update_attach_form(tableName);
                setupUpdateFormSubmission(tableName);
            })
            .catch(error => {
                console.error('Error fetching form:', error);
                updateFormContainer.innerHTML = `Error fetching form: ${error.message}`;
            });
        });
    });

    // Simulate click on the initial table
    if (initialTable_u) {
        initialTable_u.click();
    }
}

function setupUpdateFormSubmission(tableName) {
    const form = document.getElementById('update-form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('table_name', tableName);

        fetch('config/update_data.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            update_row_from_col();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
}

function update_attach_form(tableName) {
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
            'advisor_upID': {
                "up_first_name": "adv-first-name",
                "up_last_name": "adv-last-name"
            }
        },
        'course': {
            'course_upID': {
                "course_upName": "crs-name",
                "up_credits": "crs-credits"
            }
        },
        'department': {
            'department_upID': {
                "department_upName": "dept-name",
                "up_location": "dept-location"
            }
        },
        'student': {
            'student_upID': {
                "student_first_name": "std-first-name",
                "student_last_name": "std-last-name"
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