<?php
include "./connect.php";

$id = $_SESSION['id'];

// 파일 업로드 처리
if ($_FILES['profile']['error'] == UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['profile']['tmp_name'];
    $name = basename($_FILES['profile']['name']);
    $upload_dir = '../uploads/';
    $upload_file = $upload_dir . $name;

    // 디렉토리가 존재하지 않으면 생성
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // 파일 이동
    if (move_uploaded_file($tmp_name, $upload_file)) {
        // 파일 경로를 데이터베이스에 저장
        $sql = "UPDATE sign SET profile = '$upload_file' WHERE id = '$id'";
        if ($connect->query($sql) === TRUE) {
            $_SESSION['profile'] = $upload_file;
            header("Location: mypage.php");
            exit;
        } else {
            echo "데이터베이스에 저장하는 동안 오류가 발생했습니다.";
        }
    } else {
        echo "파일 업로드 중 오류가 발생했습니다.";
    }
} else {
    echo "파일 업로드 오류가 발생했습니다.";
}
?>
