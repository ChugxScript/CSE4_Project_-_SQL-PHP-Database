# CSE4_Project_-_SQL-PHP-Database

This project involves migrating a previously completed MS Access Database Project to phpMyAdmin and implementing SQL. 
The focus will be on transferring tables, relationships, and logical constructs.

_This repository serves as Database Project in subject CSE4-M - CS Professional Elective 4_

## PROJECT OVERVIEW

This project is a School Management System that manages students, advisors, departments, and course records.
This system provides different functionalities based on the account's role.
- **Admin**
  - View dashboard
  - Can create, read, update, and delete records
  - View Student, Advisor, Department, and Course records

- **Registrar**
  - View dashboard
  - Can create, read, and update records

- **Advisor**
  - View dashboard
  - Can only view the signed-in account information
  - View Department and available course records only

- **Student**
  - View dashboard
  - Can only view the signed-in account information
  - View Department and available course records only

This project also provides a `search_row` function to search for a search term.

## USAGE

1. Clone the repository:
    ```sh
    git clone https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database.git
    ```
2. Install `XAMPP`.
3. (Optional) Install `MySQL` and `MySQL Workbench` and create a user account.
4. Start `Apache` and `MySQL` in `XAMPP`.
5. Log in to `phpMyAdmin` using `localhost/phpmyadmin`.
6. Install the `PHP Server` extension in VS Code.
7. In `index.php`, select `PHP Server: Serve Project`.

## DATABASE SCHEMA AND TASK

- **Task:**
  - Design a database schema to store information about students, advisors, departments, and courses.
  - Establish relationships to represent academic advising.
    
- **Solution Database Schema:**
  - **users**
    - user_id (Primary Key)
    - password (varchar)
    - role (enum: 'admin', 'registrar', 'student', 'advisor')

  - **student**
    - student_id (Primary Key)
    - advisor_id (Foreign Key Reference to `advisor_id` in `advisor` table)
    - user_id (Foreign Key Reference to `user_id` in `users` table)
    - first_name (varchar)
    - last_name (varchar)
    - assigned_sex (enum: 'Male', 'Female')

  - **advisor**
    - advisor_id (Primary Key)
    - department_id (Foreign Key Reference to `department_id` in `department` table)
    - user_id (Foreign Key Reference to `user_id` in `users` table)
    - first_name (varchar)
    - last_name (varchar)
    - assigned_sex (enum: 'Male', 'Female')

  - **department**
    - department_id (Primary Key)
    - department_name (varchar)
    - course_id (Foreign Key Reference to `course_id` in `course` table)
    - location (varchar)

  - **course**
    - course_id (Primary Key)
    - course_name (varchar)
    - credits (int)

- ## SCREENSHOTS

- ### **phpMyAdmin database tables**
![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/a39e8bf2-0ddd-4c4c-91e8-4cc7ad306a89)

- advisor
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/e3547fe8-69dd-4ec3-bbba-f782f6e1d2e3)

- course
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/179063d1-0dfa-4b18-8186-e0003cc2aaaa)

- department
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/38c4f00f-e0ba-44e2-8bbe-e718adc336ec)

- student
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/8ba5975b-e660-409e-b7a6-856b54e2dec3)

- users
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/80ecb422-ac48-44be-8184-44389422fb61)

- ### **RELATIONSHIPS**
![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/37558868-1713-48d3-bbd0-f809f7a0c248)

- ### Web pages

**Guest Dashboard**
![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/73154eb7-e214-4405-95c6-771c3c72a507)

- Create
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/cebd7a49-6380-4cd8-acb1-e6b5c4ca552f)

- Update
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/9078774d-22fc-4303-99a7-dfd85c8a7ebe)

- Delete
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/180f7924-232b-4fb4-8803-6518fb25236c)

- View
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/7081042e-54de-4c19-ad2e-568a0e58d94f)

- Search function
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/5e07e24b-ff85-4bc7-8c9b-bd6f8d78d628)
    
- Admin (has all features)
  - Admin Dashboard (shows the current signed in user)
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/5079408a-f679-406e-b19a-5756439033bc)

  - Student table
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/0f645653-67d8-4d7c-a265-96940ef3a539)

  - Advisor table
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/1948744e-3337-4f78-a592-20f06ff70d47)

  - Department table
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/2f12996e-3377-45bf-abf4-32d1c3ab9a3e)

  - Course table
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/bbc4c41c-bb60-4dc9-a200-331c0bf37662)


- Registrar (dont have delete feature)
  - Registrar Dashboard (shows the current signed in user)
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/12fc7ab6-f932-4a03-8742-62b417ed50fe)

  - Student table
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/1ecc906e-e944-49e3-aa9d-4fdee3a139d6)

  - Advisor table
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/a9e1b5dc-e3d6-43db-8d2e-733fafc06214)

  - Department table
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/82a428d8-c6f5-4248-a457-25221c0a1d65)

  - Course table
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/f6ffc62d-6bbd-4fc0-a9a4-fd8087b39449)


- Student (has only department and courses tables and can only view rows)
  - Student Dashboard (shows the current signed in user)
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/c8c3af3d-3fff-446e-88be-3b26c6a13bb7)

  - Profile
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/68dfa888-ee4f-4139-8494-e80c41f2249e)

  - Department table
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/32805921-c5ce-4d2a-9a14-99e376958513)

  - Course table
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/0cab5de4-77c9-4ce2-bf2a-404ca9f376f4)


- Advisor (has only department and courses tables and can only view rows)
  - Registrar Dashboard (shows the current signed in user)
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/8ce4a1a3-fd4b-426b-b813-fb885eb3ca00)

  - Profile
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/4a626cd0-8b3a-4c14-a4aa-aa52d55b5c1b)

  - Department table
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/20cdb8ea-eab8-450f-bf7d-a823a2b0cce3)

  - Course table
  - ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/ede9d6d2-b171-4734-97fd-7ee2202e1c35)

