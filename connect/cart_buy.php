<?php
    include('connect.php');

    // JSON 요청 데이터 가져오기
    $data = json_decode(file_get_contents('php://input'), true);

    // 로그인된 사용자의 ID
    $userid = $_SESSION['id']; 

    // 카트에서 상품 정보 가져오기
    $sql = "SELECT * FROM cart WHERE logid = '$userid'";
    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $buserid = $row['cuserid'];  // 상품 등록자 (판매자)
            $bname = $row['cname'];
            $bprice = $row['cprice'];
            $bcolor = $row['ccolor'];
            $bcategori = $row['ccategori'];
            $beach = $row['ceach'];
            $img = $row['img'];
            $logid = $row['logid']; // 구매자 ID (사용자)
            $itemidx = $row['itemidx'];
            $buytime = date("Y-m-d H:i:s");

            // 'buy' 테이블에 구매 기록 추가
            $insertSql = "INSERT INTO buy (buserid, bname, bprice, bcolor, bcategori, beach, img, logid, itemidx, buytime) 
                        VALUES ('$buserid', '$bname', '$bprice', '$bcolor', '$bcategori', '$beach', '$img', '$logid', '$itemidx', '$buytime')";
            mysqli_query($connect, $insertSql);
        }

        // 장바구니 비우기
        $deleteSql = "DELETE FROM cart WHERE logid = '$userid'";
        mysqli_query($connect, $deleteSql);

        // 성공 응답
        echo json_encode(['success' => true]);
    } else {
        // 장바구니가 비었을 경우 응답
        echo json_encode(['success' => false, 'message' => '장바구니가 비어 있습니다.']);
    }
?>
