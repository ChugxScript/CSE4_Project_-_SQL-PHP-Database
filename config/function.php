<?php

function getDB(){
    $servername = "localhost"; 
    $username = "root"; 
    $password = "root"; 
    $database = "cse4-project"; 

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function getTables($conn){
    // This function should return an array of table names
    $tables = [];
    $result = $conn->query("SHOW TABLES");
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }
    return $tables;
}

function getTableCount($conn, $table) {
    $query = "SELECT COUNT(*) as count FROM $table";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['count'];
}