<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST 데이터로 상품 ID 받기
    $productId = isset($_POST['idx']) ? (int)$_POST['idx'] : 0;

    if ($productId > 0) {
        // 조회수 증가 쿼리 실행
        $sql = "UPDATE product SET view = view + 1 WHERE idx = $productId";
        
        if (mysqli_query($connect, $sql)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "조회수 증가 실패", "error" => mysqli_error($connect)]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid Product ID"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request Method"]);
}
?>
