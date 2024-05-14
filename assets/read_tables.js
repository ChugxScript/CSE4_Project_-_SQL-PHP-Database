// assets/handle_tables.js

function read_tables(){
    const tableSelects = document.querySelectorAll('.table-select');
    const tableDataContainer = document.getElementById('table-data-container');
    const initialTable = document.querySelector('.selected-table');
    
    // READ
    tableSelects.forEach(tableSelect => {
        tableSelect.addEventListener('click', function () {
            const tableName = this.getAttribute('data-table');
            fetchTableData(tableName, 1);
        });
    });

    function fetchTableData(tableName, page) {
        fetch('config/load_table.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `table_name=${tableName}&page=${page}`
        })
        .then(response => response.text())
        .then(data => {
            tableDataContainer.innerHTML = data;
            const pageLinks = document.querySelectorAll('.page-link');
            pageLinks.forEach(pageLink => {
                pageLink.addEventListener('click', function () {
                    const page = this.getAttribute('data-page');
                    fetchTableData(tableName, page);
                });
            });
        })
        .catch(error => {
            console.error('Error:', error);
            tableDataContainer.innerHTML = 'Error fetching table data';
        });
    }

    // Simulate click on the initial table
    if (initialTable) {
        initialTable.click();
    }
}
