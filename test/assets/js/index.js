
function renderAdvisorStudentRatioChart(advisorStudentRatio) {
    var ctx = document.getElementById('advisorStudentRatioChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['ADVISOR'],
            datasets: [{
                label: 'Ratio',
                data: [advisorStudentRatio],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'STUDENTS',
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Advisor-Student Ratio',
                    }
                }
            }
        }
    });
}

function renderDepartmentOverviewChart(departmentData) {
    var ctx = document.getElementById('departmentOverviewChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: departmentData.labels,
            datasets: [{
                label: 'Number of Advisor',
                data: departmentData.studentCounts,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Advisor',
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Department',
                    }
                }
            }
        }
    });
}

const loginBtn = document.getElementById('loginBtn');
const loginModal = document.getElementById('loginModal');

// Function to show the login modal
function showLoginModal() {
    loginModal.classList.remove('hidden');
}

// Function to hide the login modal
function hideLoginModal() {
    loginModal.classList.add('hidden');
}

// Add click event listener to the login button
loginBtn.addEventListener('click', showLoginModal);


// Function to get query parameters
function getQueryParam(param) {
    let params = new URLSearchParams(window.location.search);
    return params.get(param);
}

// Check if 'login' query parameter is 'error'
if (getQueryParam('login') === 'error') {
    document.getElementById('loginModal').classList.remove('hidden');
}

// Function to close the modal
function closeModal() {
    document.getElementById('loginModal').classList.add('hidden');
}

// Add event listener to close button
document.getElementById('closeModal').addEventListener('click', closeModal);

// Add event listener for 'Escape' key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});


tailwind.config = {
    theme: {
        extend: {
            colors: {
                shadow: 'rgb(17 24 39)',
            }
        }
    }
}