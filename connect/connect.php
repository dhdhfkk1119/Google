<?php 
    $host = "localhost";
    $user = "root";
    $pw = "1234";
    $db = "php";

    // MySQLi 연결
    $connect = new mysqli($host, $user, $pw, $db);

    // 연결 확인
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }

    session_start();
?>
