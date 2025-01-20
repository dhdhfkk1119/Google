<?php
include "connect.php"; // 세션 포함 되어있음

$itemidx = $_POST['itemidx'];
$userid = $_POST['userid'];
$pname = $_POST['pname'];
$categori = $_POST['categori'];
$price = $_POST['total_price'];
$ea = $_POST['pop_out'];
$color = $_POST['color'];
$img = $_POST['img'];
$logid = $_SESSION['id'] ?? null; // 세션 ID가 없으면 null로 설정
$buytime = date("Y-m-d H:i:s");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['action'])) {
        echo '유효하지 않은 요청입니다.';
        exit;
    }

    // 로그인 여부 확인
    if ($logid === null) {
        echo '로그인 해주시기 바랍니다.';
        exit;
    }

    // 수량과 색상 선택 여부 확인
    if ($ea <= 0 || $color == null) {
        echo '수량 및 색상을 선택해주시기 바랍니다.';
        exit;
    }

    // 자기 물품 등록 여부 확인
    if ($userid == $logid) {
        echo "자기가 등록한 물품은 구매 및 장바구니가 안됩니다.";
        exit;
    }

    if ($_POST['action'] == 'add_to_cart') {
        // 장바구니 중복 체크
        $sql2 = "SELECT logid FROM cart WHERE logid = '$logid' AND itemidx = '$itemidx'";
        $result = $connect->query($sql2);

        if ($result && $result->num_rows > 0) {
            // 이미 장바구니에 있는 상품인 경우
            echo '이미 장바구니에 있는 상품입니다.';
        } else {
            // 장바구니에 상품 추가
            $sql = "INSERT INTO cart(cuserid, cname, cprice, ccolor, ccategori, ceach, img, logid, itemidx) 
                    VALUES ('$userid', '$pname', '$price', '$color', '$categori', '$ea', '$img', '$logid', '$itemidx')";
            if ($connect->query($sql)) {
                echo '장바구니에 담았습니다.';
            } else {
                echo '장바구니 추가 중 오류가 발생했습니다.';
            }
        }
    } elseif ($_POST['action'] == 'buy_now') {
        // 구매하기 처리
        $sql = "INSERT INTO buy(buserid, bname, bprice, bcolor, bcategori, beach, img, logid, itemidx, buytime) 
                VALUES ('$userid', '$pname', '$price', '$color', '$categori', '$ea', '$img', '$logid', '$itemidx' ,'$buytime')";
        if ($connect->query($sql)) {
            echo '상품을 구매했습니다.';
        } else {
            echo '구매 처리 중 오류가 발생했습니다.';
        }
    }
}
?>
