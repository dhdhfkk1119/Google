<?php
    include "connect.php";

    $idx = $_POST['idx'];

    $sql = "
        DELETE FROM cart where idx=$idx
    ";
    $result = $connect->query($sql);
    if ($result) {
        echo "<script>alert('삭제가 완료되었습니다.'); location.href='cart.php';</script>";
    } else {
        echo "<script>alert('삭제 실패'); location.href='cart.php';</script>";
    }
    
?>