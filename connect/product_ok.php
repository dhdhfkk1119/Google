<<<<<<< HEAD
<?php
include "./connect.php";

$userid = $_SESSION['id'];
$pname = $_POST['pname'];
$price = $_POST['price'];
$categori = $_POST['categori'];
$content = $_POST['content'];
$datetime = date("Y-m-d H:i:s");
$color = $_POST['color'];
$ea = $_POST['ea'];

if ($pname == "" || $price == "" || $categori == "" || $color == "" || $ea == "") {
    echo "상품 이름, 가격, 카테고리 , 색상 , 판매수량을 모두 입력해 주세요.";
    exit;
}

$uploaded_files = [];

// 파일 업로드 처리
if (isset($_FILES['productimg']) && count($_FILES['productimg']['name']) > 0) {
    for ($i = 0; $i < count($_FILES['productimg']['name']); $i++) {
        if ($_FILES['productimg']['error'][$i] == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['productimg']['tmp_name'][$i];
            $name = basename($_FILES['productimg']['name'][$i]);
            $upload_dir = '../product/';
            $upload_file = $upload_dir . $name;

            // 디렉토리가 존재하지 않으면 생성
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // 파일 이동
            if (move_uploaded_file($tmp_name, $upload_file)) {
                $uploaded_files[] = $name; // 경로 없이 파일명만 저장
            } else {
                echo "파일 업로드 중 오류가 발생했습니다.";
                exit;
            }
        } else {
            echo "파일 업로드 중 오류가 발생했습니다. Error code: " . $_FILES['productimg']['error'][$i];
            exit;
        }
    }
} else {
    echo "하나 이상의 상품 이미지를 업로드해 주세요.";
    exit;
}

if (count($uploaded_files) == 0) {
    echo "하나 이상의 상품 이미지를 업로드해 주세요.";
    exit;
}

if (count($uploaded_files) > 5) {
    echo "최대 5개의 이미지만 등록할 수 있습니다.";
    exit;
}

$files = implode(',', $uploaded_files); // 파일명을 쉼표로 연결

$sql = "INSERT INTO product (pname, price, categori, content, file, userid, datetime , color, ea) VALUES 
('$pname', '$price', '$categori', '$content', '$files', '$userid', '$datetime' ,'$color' , '$ea')";

if ($connect->query($sql) === TRUE) {
    echo "상품이 성공적으로 등록되었습니다.";
    header("Location: ../index.php");
} else {
    echo "상품 등록 중 오류가 발생했습니다: " . $connect->error;
}

$connect->close();
?>
=======
<?php
include "./connect.php";

$userid = $_SESSION['id'];
$pname = $_POST['pname'];
$price = $_POST['price'];
$categori = $_POST['categori'];
$content = $_POST['content'];
$datetime = date("Y-m-d H:i:s");
$color = $_POST['color'];
$ea = $_POST['ea'];

if ($pname == "" || $price == "" || $categori == "" || $color == "" || $ea == "") {
    echo "상품 이름, 가격, 카테고리 , 색상 , 판매수량을 모두 입력해 주세요.";
    exit;
}

$uploaded_files = [];

// 파일 업로드 처리
if (isset($_FILES['productimg']) && count($_FILES['productimg']['name']) > 0) {
    for ($i = 0; $i < count($_FILES['productimg']['name']); $i++) {
        if ($_FILES['productimg']['error'][$i] == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['productimg']['tmp_name'][$i];
            $name = basename($_FILES['productimg']['name'][$i]);
            $upload_dir = '../product/';
            $upload_file = $upload_dir . $name;

            // 디렉토리가 존재하지 않으면 생성
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // 파일 이동
            if (move_uploaded_file($tmp_name, $upload_file)) {
                $uploaded_files[] = $name; // 경로 없이 파일명만 저장
            } else {
                echo "파일 업로드 중 오류가 발생했습니다.";
                exit;
            }
        } else {
            echo "파일 업로드 중 오류가 발생했습니다. Error code: " . $_FILES['productimg']['error'][$i];
            exit;
        }
    }
} else {
    echo "하나 이상의 상품 이미지를 업로드해 주세요.";
    exit;
}

if (count($uploaded_files) == 0) {
    echo "하나 이상의 상품 이미지를 업로드해 주세요.";
    exit;
}

if (count($uploaded_files) > 5) {
    echo "최대 5개의 이미지만 등록할 수 있습니다.";
    exit;
}

$files = implode(',', $uploaded_files); // 파일명을 쉼표로 연결

$sql = "INSERT INTO product (pname, price, categori, content, file, userid, datetime , color, ea) VALUES 
('$pname', '$price', '$categori', '$content', '$files', '$userid', '$datetime' ,'$color' , '$ea')";

if ($connect->query($sql) === TRUE) {
    echo "상품이 성공적으로 등록되었습니다.";
    header("Location: ../index.php");
} else {
    echo "상품 등록 중 오류가 발생했습니다: " . $connect->error;
}

$connect->close();
?>
>>>>>>> 1efd9678224ab80abd03cba06f17a37042c2d95e
