
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

document.getElementById("login_btn").addEventListener("click", function(){
    event.preventDefault();
    const form = document.getElementById('loginForm');
    const formData = new FormData(form);

    formData.forEach((value, key) => {
        console.log(key + ": " + value);
    });
    
    $.ajax({
        url: './pages/utils/login_user.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            const { role, user_id, message } = response;
            if (message.startsWith('[SUCCESS]')) {
                const msg = message.replace('[SUCCESS]', '').trim();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: msg ,
                }).then(() => {
                    window.location.href = `./pages/${role}.php?user_id=${user_id}`;
                });
            } else if (message.startsWith('[ERROR]')) {
                const msg = message.replace('[ERROR]', '').trim();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg,
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Unexpected response from server. Please try again.',
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error: " + textStatus + " - " + errorThrown);
            console.log(jqXHR.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to process request. Please try again.',
            });
        }
    });
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