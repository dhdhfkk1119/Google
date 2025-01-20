<?php
include('connect.php');

// JSON 요청 데이터 가져오기
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['idx']) && isset($data['quantity'])) {
    $idx = $data['idx'];
    $quantity = $data['quantity'];
    $userId = $_SESSION['id'];

    // 수량 업데이트 쿼리
    $updateSql = "UPDATE cart SET ceach = $quantity WHERE idx = $idx AND logid = '$userId'";
    if (mysqli_query($connect, $updateSql)) {
        // Subtotal 계산
        $subtotalSql = "SELECT SUM(ceach * cprice) AS subtotal FROM cart WHERE logid = '$userId'";
        $subtotalResult = mysqli_query($connect, $subtotalSql);
        $subtotalRow = mysqli_fetch_assoc($subtotalResult);
        $subtotal = $subtotalRow['subtotal'];

        echo json_encode(['success' => true, 'subtotal' => $subtotal]);
    } else {
        echo json_encode(['success' => false, 'message' => '수량 업데이트 실패']);
    }
} else {
    echo json_encode(['success' => false, 'message' => '잘못된 요청 데이터']);
}

mysqli_close($connect);
?>
