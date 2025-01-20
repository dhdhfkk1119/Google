<?php
    include "./connect.php";

    $id = $_POST['id'];
    $password = $_POST['password'];

    function msg($alert){
        echo "<p class='intro__text'>$alert</p>";
    }

    $sql = "SELECT id, password, name, cell FROM sign WHERE id = '$id' AND password = '$password'";
    $result = $connect->query($sql);
    if($result){
        $count = $result->num_rows;
        if($count == 0){
            msg("이메일 또는 비밀번호가 틀렸습니다. 다시 한번 확인해주세요!<br><div class='intro__btn'><a href='../login/login.php'>로그인</a></div>");
        } else {
            // 로그인 성공
            $memberInfo = $result->fetch_array(MYSQLI_ASSOC);

            // 세션 
            $_SESSION['id'] = $memberInfo['id'];
            $_SESSION['name'] = $memberInfo['name'];
            $_SESSION['cell'] = $memberInfo['cell'];

            Header("Location: ../index.php");
        }
    } else {
        msg("에러 발생");
    }
?>
