<<<<<<< HEAD
<?php 
include "./connect.php";

$id = $_POST['decide_id'];
$name = $_POST['name'];
$password = $_POST['password'];
$repassword = $_POST['repassword'];
$cell = $_POST['cell'];

function msg($alert){
    echo "<p class='intro__text'>$alert</p>";
}

//이름 유효성 검사
// $check_name = preg_match("/^[가-힣]{2,4}$/", $name);
// if($check_name == false){
//     msg("이름은 한글로 2자 이상 5자 미만이어야 합니다.");
//     exit;
// }

// 비밀번호 확인
if($password !== $repassword){
    msg("비밀번호가 일치하지 않습니다. 다시 한번 더 확인해 주세요.");
    exit;
}

//전화번호 유효성
$check_number = preg_match("/^(010|011|016|017|018|019)-[0-9]{3,4}-[0-9]{4}$/", $cell);
if($check_number == false){
    msg("번호가 정확하지 않습니다. 올바른 번호(000-0000-0000) 형식으로 작성해 주세요!");
    exit;
}

$isIdCheck = false;
$sql = "SELECT id FROM sign WHERE id = '$id'";
$result = $connect->query($sql);

// 회원가입 중복 검사 
if($result){
    $count = $result->num_rows;
    if($count == 0){
        $isIdCheck = true;
    } else {
        msg("이미 회원가입이 되어있습니다.");
        exit;
    }
} else {
    msg("에러 발생");
    exit;
}

// 휴대폰 중복 검사
$isPhoneCheck = false;
$sql = "SELECT cell FROM sign WHERE cell = '$cell'";
$result = $connect->query($sql);

// 회원가입 중복 검사 
if($result){
    $count = $result->num_rows;
    if($count == 0){
        $isPhoneCheck = true;
    } else {
        msg("이미 중복된 전화 번호입니다.");
        exit;
    }
} else {
    msg("에러 발생");
    exit;
}

if($isIdCheck == true && $isPhoneCheck == true){
    $sql = "INSERT INTO sign(name, id, password, cell) VALUES ('$name', '$id','$password','$cell')";
    $result = $connect->query($sql);

    if($result){
        msg("회원가입을 축하합니다. 로그인 해주세요.");
        echo "<script>location.href='../index.php'</script>";
        exit;
    } else {
        msg("에러 발생");
        exit;
    }
} else {
    msg("이미 회원가입 되어 있습니다.");
    exit;
}
?>
=======
<?php 
include "./connect.php";

$id = $_POST['decide_id'];
$name = $_POST['name'];
$password = $_POST['password'];
$repassword = $_POST['repassword'];
$cell = $_POST['cell'];

function msg($alert){
    echo "<p class='intro__text'>$alert</p>";
}

//이름 유효성 검사
// $check_name = preg_match("/^[가-힣]{2,4}$/", $name);
// if($check_name == false){
//     msg("이름은 한글로 2자 이상 5자 미만이어야 합니다.");
//     exit;
// }

// 비밀번호 확인
if($password !== $repassword){
    msg("비밀번호가 일치하지 않습니다. 다시 한번 더 확인해 주세요.");
    exit;
}

//전화번호 유효성
$check_number = preg_match("/^(010|011|016|017|018|019)-[0-9]{3,4}-[0-9]{4}$/", $cell);
if($check_number == false){
    msg("번호가 정확하지 않습니다. 올바른 번호(000-0000-0000) 형식으로 작성해 주세요!");
    exit;
}

$isIdCheck = false;
$sql = "SELECT id FROM sign WHERE id = '$id'";
$result = $connect->query($sql);

// 회원가입 중복 검사 
if($result){
    $count = $result->num_rows;
    if($count == 0){
        $isIdCheck = true;
    } else {
        msg("이미 회원가입이 되어있습니다.");
        exit;
    }
} else {
    msg("에러 발생");
    exit;
}

// 휴대폰 중복 검사
$isPhoneCheck = false;
$sql = "SELECT cell FROM sign WHERE cell = '$cell'";
$result = $connect->query($sql);

// 회원가입 중복 검사 
if($result){
    $count = $result->num_rows;
    if($count == 0){
        $isPhoneCheck = true;
    } else {
        msg("이미 중복된 전화 번호입니다.");
        exit;
    }
} else {
    msg("에러 발생");
    exit;
}

if($isIdCheck == true && $isPhoneCheck == true){
    $sql = "INSERT INTO sign(name, id, password, cell) VALUES ('$name', '$id','$password','$cell')";
    $result = $connect->query($sql);

    if($result){
        msg("회원가입을 축하합니다. 로그인 해주세요.");
        echo "<script>location.href='../index.php'</script>";
        exit;
    } else {
        msg("에러 발생");
        exit;
    }
} else {
    msg("이미 회원가입 되어 있습니다.");
    exit;
}
?>
>>>>>>> 1efd9678224ab80abd03cba06f17a37042c2d95e
