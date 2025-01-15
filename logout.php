<?php
    include "./connect/connect.php";
    unset ($_SESSION['id']);
    unset ($_SESSION['name']);

    
    Header("Location: ./index.php");
    
?>