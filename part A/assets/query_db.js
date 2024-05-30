function get_queries_from_db(){
    const tableSelects = document.querySelectorAll('.table-select-q');
    const queryFormContainer = document.getElementById('query-table-container');
    const initialTable_q = document.getElementById('STUDENT-ADVISOR');

    tableSelects.forEach(tableSelect => {
        tableSelect.addEventListener('click', function () {
            tableSelects.forEach(select => {
                select.classList.remove('active');
            });
            this.classList.add('active');
            activeTable = this;

            const tableName = this.getAttribute('data-table-q');
            fetchTableData(tableName, 1);
        });
    });

    function fetchTableData(tableName, page) {
        fetch('config/query_table.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `table_name=${tableName}&page=${page}`
        })
        .then(response => response.text())
        .then(data => {
            queryFormContainer.innerHTML = data;
            const pageLinks = document.querySelectorAll('.page-link-b');
            pageLinks.forEach(pageLink => {
                pageLink.addEventListener('click', function () {
                    const page = this.getAttribute('data-page');
                    fetchTableData(tableName, page);
                });
            });
            // Remove active class from all page links
            pageLinks.forEach(link => {
                link.classList.remove('active');
            });
            // Add active class to the clicked page link
            const clickedPageLink = document.querySelector('.page-link-b[data-page="' + page + '"]');
            if (clickedPageLink) {
                clickedPageLink.classList.add('active');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            tableDataContainer.innerHTML = 'Error fetching table data';
        });
    }

    // Simulate click on the initial table
    if (initialTable_q) {
        console.log("heyy")
        initialTable_q.click();
    }
}
