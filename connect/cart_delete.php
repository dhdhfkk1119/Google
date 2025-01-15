<?php
    include "connect.php";

    $idx = $_POST['idx'];

    $sql = "delete from cart where idx=$idx";
    $result = $connect->query($sql);

?>