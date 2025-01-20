<?php
    include "./connect/connect.php";

    $id= $_GET["id"];  //GET으로 넘긴 userid
    $sql= "SELECT * FROM sign WHERE id='$id'";
    $result = $connect->query($sql);

    if($result->num_rows == 0){
        echo "<span style='color:blue;'>$id</span> 는 사용 가능한 아이디입니다.";
        ?>
        <p><input type="button" value="이 ID 사용" onclick="opener.parent.decide(); window.close();"></p>
        <?php
    } else {
        echo "<span style='color:red;'>$id</span> 는 중복된 아이디입니다.";
        ?>
        <p><input type="button" value="다른 ID 사용" onclick="opener.parent.change(); window.close();"></p>
        <?php
    }
?>
