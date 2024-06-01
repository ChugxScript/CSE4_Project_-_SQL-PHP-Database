# CSE4_Project_-_SQL-PHP-Database

This project involves migrating a previously completed MS Access Database Project to phpMyAdmin and implementing SQL. The focus will be on transferring tables, relationships, and logical constructs.

_This repository serves as Database Project in subject CSE4-M - CS Professional Elective 4_

## USAGE

- git clone `https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database.git`
- install `XAMPP` application
- (optional) install `MySQL` and `MySQL Workbench` and create user account
- start `Apache` and `MySQL` in `XAMPP`
- login in `phpMyAdmin` using `localhost/phpmyadmin`
- install `PHP Server` extension in vs code
- in `index.php` do `PHP Server: Serve Project`

## COMPONENTS

- Tables 
  - Verify that all tables have been successfully migrated
    - READ functions from `read_tables.php`
- SQL Queries
  - Evaluate the implementation of SQL queries for data retrieval and manipulation
    - CREATE functions from `create_data.php`
    - UPDATE functions from `update_data.php`
    - DELETE functions from `delete_data.php`
- Relationships
  - Ensure that relationships between tables are accurately represented
    - QUERY functions from `query_table.php`
- Forms and Reports
  - Forms and reports will be assessed for functionality and usability
    - CREATE from `create_form.php` for form functions and `create_data.php` for data manipulation and `read_tables.ph` for viewing the data
    - UPDATE from `update_form.php` for form functions and `update_data.php` for data manipulation and `read_tables.ph` for viewing the data 
    - DELETE from `delete_form.php` for form functions and `delete_data.php` for data manipulation and `read_tables.ph` for viewing the data

## DEMO

> [DEMO VIDEO](https://drive.google.com/file/d/1WKf13LWY6IGKR21PBK9QVyikMHXTLdBP/view?usp=sharing)


## SCREENSHOTS

- CREATE
  - ADVISOR
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/56254534-1430-43cc-b120-14e4c05613e6)

  - COURSE
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/0b33fa99-3222-4320-afd2-8cfbc3da33a0)

  - DEPARTMENT
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/725932c8-7091-4314-a534-bc0daef827fa)

  - STUDENT
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/fa2de6ad-3fb8-46a6-a359-e91e3bee9bdc)

- READ
  - ADVISOR
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/ee831273-8369-42dc-a05a-a01e53bf7af7)

  - COURSE
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/c9b8212d-78be-4acb-b11e-182a29f39623)

  - DEPARTMENT
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/297d3e14-d730-4682-b4da-28ed179573f1)

  - STUDENT
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/da3bb4a2-a56b-45ce-a367-336519a7fb30)

- UPDATE
  - ADVISOR
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/21db8b9c-9ba5-4225-9cca-3b4ded4d19e5)

  - COURSE
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/c7b4b698-ea42-43a0-b79c-2c1d2c4e535e)

  - DEPARTMENT
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/71959d74-c06f-4142-9a00-9bafb1f821f1)

  - STUDENT
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/439c3745-339a-41fc-a042-3d004594e19c)

- DELETE
  - ADVISOR
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/a2cf0a92-2e2e-41a9-a6a5-97b234d381ea)

  - COURSE
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/ebf1b7bb-50ec-4092-885f-bb5323b88980)

  - DEPARTMENT
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/cf48ccfd-e31e-44d6-95c8-e71f569e8f08)

  - STUDENT
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/a4f25b60-451e-4583-8fe2-e6af3c8ee2fd)

- QUERY
  - STUDENT to ADVISOR
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/511880fe-2f16-43a3-aee5-b7b1c2318ac6)

  - ADVISOR to DEPARTMENT
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/922897c9-443d-4b50-9c42-51d083a82217)

  - COURSE (course table don't have any relationship to any table)
    ![image](https://github.com/ChugxScript/CSE4_Project_-_SQL-PHP-Database/assets/101156843/f3a46175-f11f-42c6-bc4c-f26667f1e035)
