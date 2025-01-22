<<<<<<< HEAD
<?php
include "../connect/connect.php";

$l_user = $_POST['l_user'];
$l_itemidx = $_POST['l_itemidx'];

// 로그인 상태 확인
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => '회원만 가능합니다. 로그인 후 사용해주세요.']);
    exit;
}

if (!$l_itemidx || !$l_user) {
    echo json_encode(['status' => 'error', 'message' => '값이 제대로 넘어오지 않았습니다.']);
    exit;
}

$sql = "SELECT idx FROM item_like WHERE l_user = '{$l_user}' AND l_itemidx = '{$l_itemidx}'";
$result = $connect->query($sql);
$cnt = $result->num_rows;

if ($cnt > 0) {
    //기존에 아이디가 있으면 찜하기 삭제
    $delete_sql = "DELETE FROM item_like WHERE l_user = '{$l_user}' AND l_itemidx = '{$l_itemidx}'";
    $connect->query($delete_sql);

    //기존에 있으면 클릭시 하나빼기
    $update_sql = "UPDATE product SET is_like = GREATEST(COALESCE(is_like, 0) - 1, 0) WHERE idx = '{$l_itemidx}'";
    $connect->query($update_sql);

    $status = 'removed';

} else {
    //찜하기 추가하기
    $insert_sql = "INSERT INTO item_like (l_user, l_itemidx) VALUES ('{$l_user}', '{$l_itemidx}')";
    $connect->query($insert_sql);

    //클릭시 클릭시 더하기 
    $update_sql = "UPDATE product SET is_like = COALESCE(is_like, 0) + 1 WHERE idx = '{$l_itemidx}'";
    $connect->query($update_sql);
    $status = 'added';
}

$sql_get = "SELECT is_like FROM product WHERE idx = '{$l_itemidx}'";
$result_get = $connect->query($sql_get);
$row = $result_get->fetch_assoc();
$new_is_like = $row['is_like'];

echo json_encode(['status' => $status, 'is_like' => $new_is_like]);
?>
=======
<?php
include "../connect/connect.php";

$l_user = $_POST['l_user'];
$l_itemidx = $_POST['l_itemidx'];

// 로그인 상태 확인
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => '회원만 가능합니다. 로그인 후 사용해주세요.']);
    exit;
}

if (!$l_itemidx || !$l_user) {
    echo json_encode(['status' => 'error', 'message' => '값이 제대로 넘어오지 않았습니다.']);
    exit;
}

$sql = "SELECT idx FROM item_like WHERE l_user = '{$l_user}' AND l_itemidx = '{$l_itemidx}'";
$result = $connect->query($sql);
$cnt = $result->num_rows;

if ($cnt > 0) {
    //기존에 아이디가 있으면 찜하기 삭제
    $delete_sql = "DELETE FROM item_like WHERE l_user = '{$l_user}' AND l_itemidx = '{$l_itemidx}'";
    $connect->query($delete_sql);

    //기존에 있으면 클릭시 하나빼기
    $update_sql = "UPDATE product SET is_like = GREATEST(COALESCE(is_like, 0) - 1, 0) WHERE idx = '{$l_itemidx}'";
    $connect->query($update_sql);

    $status = 'removed';

} else {
    //찜하기 추가하기
    $insert_sql = "INSERT INTO item_like (l_user, l_itemidx) VALUES ('{$l_user}', '{$l_itemidx}')";
    $connect->query($insert_sql);

    //클릭시 클릭시 더하기 
    $update_sql = "UPDATE product SET is_like = COALESCE(is_like, 0) + 1 WHERE idx = '{$l_itemidx}'";
    $connect->query($update_sql);
    $status = 'added';
}

$sql_get = "SELECT is_like FROM product WHERE idx = '{$l_itemidx}'";
$result_get = $connect->query($sql_get);
$row = $result_get->fetch_assoc();
$new_is_like = $row['is_like'];

echo json_encode(['status' => $status, 'is_like' => $new_is_like]);
?>
>>>>>>> 1efd9678224ab80abd03cba06f17a37042c2d95e
