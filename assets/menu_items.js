let previousCategory = null;
const initialMenuItem = document.querySelector('.menu-item[data-content="create_container"]');
const menuItems = document.querySelectorAll('.menu-item');
menuItems.forEach(menuItem => {
    menuItem.addEventListener('click', async function() {
        const contentId = this.getAttribute('data-content');
        const content = document.getElementById(contentId);
        const category = this.textContent;

        if (previousCategory !== null) {
            // If the previous category is the same as the current one
            if (previousCategory === content) {
                // Toggle the display of the content
                content.style.display = content.style.display === 'none' ? 'flex' : 'none';
                // Update the previous category to null since it's toggled
                previousCategory = null;
            } else {
                // Hide the previous category
                previousCategory.style.display = 'none';
                // Show the clicked category
                content.style.display = 'flex';
                // Update the previous category to the current one
                previousCategory = content;
            }
        } else {
            // Show the clicked category if there's no previous category
            content.style.display = 'flex';
            // Update the previous category to the current one
            previousCategory = content;
        }

        if (category === 'CREATE' && content.style.display === 'flex') {
            create_row_from_col();
        }
        if (category === 'READ' && content.style.display === 'flex') {
            read_tables();
        }
        
        // Toggle active class
        menuItems.forEach(item => {
            item.classList.remove('active');
        });
        this.classList.toggle('active');
    });
});
if (initialMenuItem) {
    initialMenuItem.click();
}