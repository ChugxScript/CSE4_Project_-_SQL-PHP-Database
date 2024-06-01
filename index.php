<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- <link rel="stylesheet" href="assets/css/index.css"> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-800">
    <!-- Navigation -->
    <nav class="bg-gray-900 p-4 text-white shadow-lg shadow-shadow">
        <div class="container mx-auto">
            <div class="flex justify-between items-center">
                <div class="text-xl font-bold">CSE4-PROJECT</div>
                <ul class="flex space-x-4">
                    <li><a href="index.php" class="hover:text-gray-300">Home</a></li>
                    <li><a href="#" class="hover:text-gray-300">About</a></li>
                    <li><a href="#" class="hover:text-gray-300" id="loginBtn">Log in</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-8">
        <div class="grid grid-cols-6 gap-4">
            <!-- Sidebar -->
            <div class="col-span-1 bg-gray-900 p-4 rounded shadow-lg shadow-shadow">
                <div class="mb-4">
                    <p class="text-lg font-bold text-white">Hi, guest!</p>
                </div>
                <ul>
                    <li><a href="index.php" class="block py-2 px-4 hover:bg-gray-300 hover:text-black rounded text-white">Dashboard</a></li>
                </ul>
            </div>
            <!-- Main Content Area -->
            <div class="col-span-5 bg-gray-900 p-4 rounded shadow-lg shadow-shadow">
                <h1 class="text-2xl font-bold mb-4 text-white">Welcome to the Dashboard</h1>
                <div class="mt-4 grid grid-cols-2 gap-4">
                    <?php
                        include 'config/table_count.php';
                        $total_students = getTotalStudents($conn);
                        $total_advisors = getTotalAdvisors($conn);
                        $total_departments = getTotalDepartments($conn);
                        $total_courses = getTotalCourses($conn);

                    ?>

                    <!-- Total Students -->
                    <div class="bg-gray-800 p-4 rounded flex items-center text-white">
                        <div class="mr-5">
                            <i class="fas fa-user-graduate text-3xl text-blue-500"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold mb-2">Total Students</h2>
                            <p class="text-3xl font-bold"><?php echo $total_students; ?></p>
                        </div>
                    </div>

                    <!-- Total Advisors -->
                    <div class="bg-gray-800 p-4 rounded flex items-center text-white">
                        <div class="mr-5">
                            <i class="fas fa-chalkboard-teacher text-3xl text-green-500"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold mb-2">Total Advisors</h2>
                            <p class="text-3xl font-bold"><?php echo $total_advisors; ?></p>
                        </div>
                    </div>

                    <!-- Total Departments -->
                    <div class="bg-gray-800 p-4 rounded flex items-center text-white">
                        <div class="mr-5">
                            <i class="fas fa-building text-3xl text-yellow-500"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold mb-2">Total Departments</h2>
                            <p class="text-3xl font-bold"><?php echo $total_departments; ?></p>
                        </div>
                    </div>

                    <!-- Total Courses -->
                    <div class="bg-gray-800 p-4 rounded flex items-center text-white">
                        <div class="mr-5">
                            <i class="fas fa-book-open text-3xl text-red-500"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold mb-2">Total Courses</h2>
                            <p class="text-3xl font-bold"><?php echo $total_courses; ?></p>
                        </div>
                    </div>

                    <!-- student male and female -->
                    <div class="bg-gray-800 p-4 rounded text-white">
                        <h2 class="text-lg font-semibold mb-2">Student Gender Distribution</h2>
                        <canvas id="studentGenderChart"></canvas>
                    </div>

                    <!-- adviser male and female -->
                    <div class="bg-gray-800 p-4 rounded text-white">
                        <h2 class="text-lg font-semibold mb-2">Advisor Gender Distribution</h2>
                        <canvas id="advisorGenderChart"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Login -->
    <div id="loginModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex justify-center items-center hidden">
        <div class="bg-white p-8 rounded shadow-lg shadow-shadow w-96 relative">
            <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                &times;
            </button>
            <h2 class="text-2xl font-bold mb-4 text-center">Login</h2>
            <form id="loginForm" method="post">
                <div class="mb-4">
                    <label for="lgn_username" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="lgn_username" name="lgn_username" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-6">
                    <label for="lgn_password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" id="lgn_password" name="lgn_password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex items-center justify-center">
                    <button type="submit" id="login_btn" name="submit-login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Login</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Footer -->
    <footer class="bg-gray-900 text-white text-center py-4 mt-8 shadow-lg shadow-shadow">
        <div class="container mx-auto">
            &copy; <?php echo date("Y"); ?> All rights reserved.
        </div>
    </footer>

    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./assets/js/index.js"></script>

    <script>
        var total_male_student = <?php echo getTotalMaleStudent($conn); ?>;
        var total_female_student = <?php echo getTotalFemaleStudent($conn); ?>;
        var total_male_advisor = <?php echo getTotalMaleAdvisor($conn); ?>;
        var total_female_advisor = <?php echo getTotalFemaleAdvisor($conn); ?>;
        console.log(`total_male_student: ${total_male_student}`);
        console.log(`total_female_student: ${total_female_student}`);
        console.log(`total_male_advisor: ${total_male_advisor}`);
        console.log(`total_female_advisor: ${total_female_advisor}`);
        renderStudentGenderChart(total_male_student, total_female_student);
        renderAdvisorGenderChart(total_male_advisor, total_female_advisor);
    </script>
</body>
</html>
