<!DOCTYPE html>
<html lang="en">
<head>
    <?php session_start(); // 세션 시작?>
    <?php include "./head.php" ?>
    <link href="css/mypage.css" rel="stylesheet">
</head>
<body>

    <?php include "./header.php" ?>

    <?php
    $id = $_SESSION['id'];
    $sql = "SELECT profile FROM sign WHERE id = '$id'";
    $result = $connect->query($sql);
    $profile_img = '';
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $profile_img = $row['profile'];
    }
    ?>

    <div class="mypage">
        <h3>마이 페이지</h3>
        <div class="mypage-in">
            <div class="profile">
                <div class="profile-img">
                    <!-- 프로필 이미지  -->
                    <img src="<?=$profile_img ?>" alt="프로필 이미지" width="190px" height="200px" style="border-radius:100px">
                </div>
                <div class="profile-info">
                    <!-- 로그인한 유저의 정보 -->
                    <form id="profileForm" action="./connect/upload_profile.php" method="post" enctype="multipart/form-data">
                        <ul style="margin:0;">
                            <li>이름 : <?=$_SESSION['name']; ?></li>
                            <li>아이디 : <?=$_SESSION['id']; ?></li>
                            <li>전화번호 : <?=$_SESSION['cell']; ?></li>
                            <li><label class="input-file" className="input-file-button" onchange="showSubmitButton();" for="profileInput" >프로필 변경</label></li>
                            <li><input type="file" name="profile" id="profileInput" style="display:none;"></li>
                            <li><input type="submit" id="submitBtn" value="저장"></li>
                            <?php
                                if($_SESSION['id'] == 'admin'){
                            ?>
                            <li style=""><a href="./product_registration.php" class="submitPro">상품등록</a></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </form>
                </div>
            </div>
            <div class="history">
                <!-- 현재까지 구매한 가격 및 좋아요 갯수 그리고 아이템 구매 갯수 -->
                <div class="history-in">
                    <ul>
                        <li>구매 가격</li>
                        <li>$1312321313123131</li>
                    </ul>
                </div> 
                <div class="history-inner">
                    <div>
                        <p>구매 갯수</p>
                        <div>1</div>
                    </div>
                    <div>
                        <p>찜 갯수</p>
                        <div>2</div>
                    </div>
                    <div>
                        <p>배송중</p>
                        <div>3</div>
                    </div>
                    <div>
                        <p>배송완료</p>
                        <div>4</div>
                    </div>
                 </div>                 
            </div>
        </div>
        <?php 
            if($_SESSION['id'] != 'admin'){
        ?>                            
        <div class="buy">
            <div class="buy-in">
                <!-- 현재까지 구매한 상품에 대한 정보 -->
                 <h4>구매 물품</h4>
                 <div class="buy-list">
                    <div>
                        <img src="" alt="" width="70px" height="84px">
                    </div>
                    <div>
                        <ul>
                            <li>이름</li>
                            <li>날짜</li>
                            <li>상세 설정</li>
                            <li>가격</li>
                        </ul>
                    </div>
                 </div>
            </div>
        </div>

        <div class="buy">
            <div class="buy-in">
                <!-- 현재까지 환불한 상품에 대한 정보 -->
                 <h4>환불 물품</h4>
                 <div class="buy-list">
                    <div>
                        <img src="" alt="" width="70px" height="84px">
                    </div>
                    <div>
                        <ul>
                            <li>이름</li>
                            <li>날짜</li>
                            <li>상세 설정</li>
                            <li>가격</li>
                        </ul>
                    </div>
                 </div>
            </div>
        </div>

        <?php      
        }
        ?>    
        <div class="buy up">
            <div class="buy-in up-in">
                <!-- 현재까지 등록한 상품에 대한 정보 -->
                 <h4>등록 물품</h4>
                 <?php
                        $sql = "SELECT * FROM product";
                        $row = mysqli_query($connect,$sql);
                        mysqli_num_rows($row);
                        while($result = mysqli_fetch_array($row)){
                            if($result['userid'] == $_SESSION['id']){
                        ?>
                 <form action="../connect/item_delete.php" method="POST" onsubmit="return confirm('정말로 삭제하시겠습니까?')">
                 <div class="buy-list up-list">
                    <input type="hidden" name="idx" value="<?=$result['idx']?>">
                    <div class="up-list-ch1">
                        <img src="./product/<?=$result['file']; ?>" alt="" width="84px" height="84px">
                    </div>
                    <div class="up-list-ch2">
                        <ul>
                            <li><a href="detail.php?idx=<?=$result['idx']; ?>"><?=$result['pname'];?></a> | <span><?=$result['datetime'];?></span></li>
                            <li><?=$result['content'];?> | <span><?=$result['price'];?>원</span></li>
                        </ul>
                    </div>
                    <div class="up-list-ch3">
                        <a href="../connect/item_delete.php?idx=<?=$result['idx']; ?>"><button class="delete-button">삭제</button></a>
                    </div>
                 </div>
                 </form>
                 <?php }} ?>
            </div>
        </div>

    </div>
</body>
</html>
<script>
    function showSubmitButton() {
        document.getElementById('submitBtn').style.display = 'block';
    }
</script>
