<<<<<<< HEAD
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
=======
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
>>>>>>> 1efd9678224ab80abd03cba06f17a37042c2d95e
