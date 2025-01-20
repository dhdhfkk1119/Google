<?php
    include "connect.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idx = $_POST['idx'];

        if (!empty($idx) && is_numeric($idx)) {
            // 여러 쿼리를 문자열로 연결
            $sql = "
                DELETE FROM product WHERE idx=$idx;
                DELETE FROM cart WHERE itemidx=$idx;
                DELETE FROM item_like WHERE l_itemidx=$idx;
            ";

            if ($connect->multi_query($sql)) {
                echo "<script>alert('삭제가 완료되었습니다.'); location.href='shop.php';</script>";
            } else {
                echo "<script>alert('삭제 중 오류가 발생했습니다.'); history.back();</script>";
            }
        } else {
            echo "<script>alert('유효하지 않은 요청입니다.'); history.back();</script>";
        }
    } else {
        echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    }
?>
