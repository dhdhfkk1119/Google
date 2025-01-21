<?php
    include('connect.php');
    session_start();

    // JSON 요청 데이터 가져오기
    $data = json_decode(file_get_contents('php://input'), true);

    // 로그인된 사용자의 ID
    $userid = $_SESSION['id'];

    if (empty($data['items']) || empty($data['total'])) {
        echo json_encode(['success' => false, 'message' => '잘못된 요청입니다.']);
        exit;
    }

    $checkedItems = $data['items']; // 선택된 아이템들의 idx 배열
    $totalAmount = $data['total']; // 총액

    // 선택된 상품들에 대해서 처리
    foreach ($checkedItems as $itemidx) {
        // 카트에서 선택된 상품 정보 가져오기
        $sql = "SELECT * FROM cart WHERE logid = '$userid' AND itemidx = '$itemidx'";
        $result = mysqli_query($connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            // 각 상품 정보 가져오기
            while ($row = mysqli_fetch_array($result)) {
                $buserid = $row['cuserid'];  // 상품 등록자 (판매자)
                $bname = $row['cname'];
                $bprice = $row['cprice'];
                $bcolor = $row['ccolor'];
                $bcategori = $row['ccategori'];
                $beach = $row['ceach']; // 장바구니에서의 수량
                $img = $row['img'];
                $logid = $row['logid']; // 구매자 ID (사용자)
                $itemidx = $row['itemidx'];
                $buytime = date("Y-m-d H:i:s");

                // 'buy' 테이블에 구매 기록 추가
                $insertSql = "INSERT INTO buy (buserid, bname, bprice, bcolor, bcategori, beach, img, logid, itemidx, buytime) 
                            VALUES ('$buserid', '$bname', '$bprice', '$bcolor', '$bcategori', '$beach', '$img', '$logid', '$itemidx', '$buytime')";
                mysqli_query($connect, $insertSql);

                // 상품 수량 업데이트 (구매한 수량만큼 감소)
                $updateProductSql = "UPDATE product 
                                     SET buyit = buyit + $beach, ea = ea - $beach 
                                     WHERE idx = '$itemidx'";
                mysqli_query($connect, $updateProductSql);
            }

            // 카트에서 해당 아이템 삭제
            $deleteSql = "DELETE FROM cart WHERE logid = '$userid' AND itemidx = '$itemidx'";
            mysqli_query($connect, $deleteSql);
        }
    }

    // 성공 응답
    echo json_encode(['success' => true, 'message' => '구매가 완료되었습니다.']);
?>
