<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
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
                    <li><a href="student.php" class="hover:text-gray-300">Home</a></li>
                    <li><a href="#" class="hover:text-gray-300">About</a></li>
                    <li><a href="../index.php" class="hover:text-gray-300" id="logOutBtn">Log out</a></li>
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
                    <?php
                        include '../config/connect.php';
                        $s_curr_username = "";

                        // Retrieve user_id from query parameters
                        if (isset($_GET['user_id'])) {
                            $user_id = intval($_GET['user_id']);

                            // Prepare SQL statement to select user from database
                            $stmt = $conn->prepare("SELECT last_name FROM student WHERE user_id = ?");
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Check if user exists
                            if ($result->num_rows > 0) {
                                $s_user = $result->fetch_assoc();
                                $s_curr_username = htmlspecialchars($s_user['last_name']); 
                            }

                            $stmt->close();
                        }

                        $conn->close();
                    ?>
                    <p class="text-lg font-bold text-white">Hi, <?php echo $s_curr_username; ?>!</p>
                </div>
                <ul>
                    <ul> DASHBOARD
                        <li><a href="" id="dashboard_link" class="block py-2 px-4 hover:bg-gray-300 hover:text-black rounded text-white">DASHBOARD</a></li>
                    </ul>
                    <ul> TABLES
                        <li><a href="" id="profile_link" class="block py-2 px-4 hover:bg-gray-300 hover:text-black rounded text-white">PROFILE</a></li>
                        <li><a href="" id="dept_link" class="block py-2 px-4 hover:bg-gray-300 hover:text-black rounded text-white">DEPARTMENT</a></li>
                        <li><a href="" id="course_link" class="block py-2 px-4 hover:bg-gray-300 hover:text-black rounded text-white">COURSES</a></li>
                    </ul>
                </ul>
            </div>

            <!-- DASHBOARD  Area -->
            <div id="dashboard_container" class="col-span-5 bg-gray-900 p-4 rounded shadow-lg shadow-shadow">
                <h1 class="text-2xl font-bold mb-4 text-white">Welcome to the Dashboard</h1>
                <div class="mt-4 grid grid-cols-2 gap-4">
                    <?php
                        include '../config/table_count.php';
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

            <!-- Profile area -->
            <div id="s_profile_container" class="col-span-5 bg-gray-900 p-4 rounded shadow-lg shadow-shadow hidden">
                <!-- <h1 class="text-2xl font-bold mb-4 text-white"><?php echo $s_curr_username; ?>'s Profile</h1>
                 -->
                <div id="s_profile_subcon">
                    <!-- profile will be loaded here -->
                </div>
            </div>

            <!-- DEPARTMENT area -->
            <div id="dept_container" class="col-span-5 bg-gray-900 p-4 rounded shadow-lg shadow-shadow hidden">
                <h1 class="text-2xl font-bold mb-4 text-white">Department Table</h1>
                
                <div class="flex justify-between items-center mb-4">
                    <!-- Search bar -->
                    <div class="flex-grow flex items-center bg-gray-800 rounded mr-4">
                        <input type="text" id="dept_searchBox" data-table="department" placeholder="Search..." class="px-4 py-2 w-full bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-l" />
                        <button id="dept_search" data-table="department" class="px-4 py-2 rounded-r bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div id="dept_table">
                    <!-- department table will be loaded here -->
                </div>
            </div>

            <!-- COURSES area -->
            <div id="course_container" class="col-span-5 bg-gray-900 p-4 rounded shadow-lg shadow-shadow hidden">
                <h1 class="text-2xl font-bold mb-4 text-white">Department Table</h1>
                
                <div class="flex justify-between items-center mb-4">
                    <!-- Search bar -->
                    <div class="flex-grow flex items-center bg-gray-800 rounded mr-4">
                        <input type="text" id="course_searchBox" data-table="course" placeholder="Search..." class="px-4 py-2 w-full bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-l" />
                        <button id="course_search" data-table="course" class="px-4 py-2 rounded-r bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div id="course_table">
                    <!-- course table will be loaded here -->
                </div>
            </div>
            

            <!-- Details Modal -->
            <div id="TD_DetailsModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left sm:w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Details
                                </h3>
                                <div class="mt-2" id="TD_DetailsModalContainer">
                                    <!-- Update form will be loaded here -->
                                </div>
                            </div>
                        </div>
                        <div class="sm:flex justify-center">
                            <button type="button" id="closeDetails" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
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
    <script src="../assets/js/index.js"></script>
    <script src="../assets/js/student.js"></script>

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
