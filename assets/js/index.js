document.getElementById("loginBtn").addEventListener("click", showLoginModal);
// document.getElementById("loginModal").addEventListener("click", hideLoginModal);
function showLoginModal() {
    loginModal.classList.remove('hidden');
}
// function hideLoginModal() {
//     loginModal.classList.add('hidden');
// }

document.getElementById('closeModal').addEventListener('click', closeModal);
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});
function closeModal() {
    document.getElementById('loginModal').classList.add('hidden');
}

document.getElementById("login_btn").addEventListener("click", function(event){
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

function renderStudentGenderChart(total_male_student, total_female_student){
    const studentData = {
        labels: ['Male', 'Female'],
        datasets: [{
            label: 'Students',
            data: [total_male_student, total_female_student], 
            backgroundColor: ['#4F46E5', '#FBBF24'],
        }]
    };

    const options = {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: '#FFFFFF'
                }
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ': ' + tooltipItem.raw;
                    }
                }
            }
        }
    };

    const studentCtx = document.getElementById('studentGenderChart').getContext('2d');
    new Chart(studentCtx, {
        type: 'pie',
        data: studentData,
        options: options
    });
}

function renderAdvisorGenderChart(total_male_advisor, total_female_advisor){
    const advisorData = {
        labels: ['Male', 'Female'],
        datasets: [{
            label: 'Advisors',
            data: [total_male_advisor, total_female_advisor],
            backgroundColor: ['#4F46E5', '#FBBF24'],
        }]
    };

    const options = {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: '#FFFFFF'
                }
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ': ' + tooltipItem.raw;
                    }
                }
            }
        }
    };

    const advisorCtx = document.getElementById('advisorGenderChart').getContext('2d');
    new Chart(advisorCtx, {
        type: 'pie',
        data: advisorData,
        options: options
    });
}


tailwind.config = {
    theme: {
        extend: {
            colors: {
                shadow: 'rgb(17 24 39)',
            }
        }
    }
}