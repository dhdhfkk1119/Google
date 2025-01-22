<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "./head.php" ?>
    <link href="css/mypage.css" rel="stylesheet">
    <link rel="stylesheet" href="lib/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="lib/owlcarousel/assets/owl.theme.default.min.css">
    <style>
        .buy_p {
            color:#81c408;
            font-weight:bold;
        }
        .buy-list-ul {
            list-style: none;
            font-size:13px;
        }
        .buy-list {
            position: relative;
        }
        .buy_detail {
            position:absolute;
            right: 10px;
            text-underline-offset: 2px;
            color: var(--gray600);
            font-size: 13px;
            border:0;
            background:none;
            font-weight: 600;
            line-height: 18px;
            text-decoration-line: underline;
        }
        .additional-details{
            font-size:14px;
            font-weight:1000;
        }
        .confirm {
            position: absolute;
            left: 15px;
            top: 0;
            font-size: 13px;
            font-weight: 600;
        }
    </style>
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
    
    // 구매한 물품 가저오기 
    $sql2 = "SELECT * FROM buy WHERE logid = '$id'";
    $buy_result = mysqli_query($connect, $sql2);  // 쿼리 실행
    $buy_num_rows = mysqli_num_rows($buy_result); // 구매한 물품의 갯수 가져오기

    // 총 금액 계산
    $total = 0;
    while($total_price = mysqli_fetch_assoc($buy_result)){
        $total += $total_price['total_price'];  // 각 구매 항목의 total_price 값을 누적
    }

    // 쿼리 포인터를 처음으로 되돌리기
    mysqli_data_seek($buy_result, 0); // 결과 포인터를 처음으로 되돌립니다.

    // 장바구니 상품 가져오기
    $sql3 = "SELECT COUNT(*) AS cart_count FROM cart WHERE logid = '$id'";
    $cart_result = mysqli_query($connect,$sql3);
    $row3 = mysqli_fetch_assoc($cart_result);
    $cart_count = $row3['cart_count'];

    // 찜 상품 가져오기
    $sql4 = "SELECT COUNT(*) AS like_count FROM item_like WHERE l_user = '$id'";
    $like_result = mysqli_query($connect,$sql4);
    $row4 = mysqli_fetch_assoc($like_result);
    $like_count = $row4['like_count'];
    
    ?>

    <div class="mypage">
        <h3>마이 페이지</h3>
        <div class="mypage-in">
            <div class="profile">
                <div class="profile-img">
                    <!-- 프로필 이미지  -->
                    <img src="<?=$profile_img ?>" alt="프로필 이미지" width="190px" height="200px" style="border-radius:100px" id="previewImage">
                </div>
                <div class="profile-info">
                    <!-- 로그인한 유저의 정보 -->
                    <form id="profileForm" action="../connect/upload_profile.php" method="post" enctype="multipart/form-data">
                        <ul style="margin:0;">
                            <li>이름 : <?=$_SESSION['name']; ?></li>
                            <li>아이디 : <?=$_SESSION['id']; ?></li>
                            <li>전화번호 : <?=$_SESSION['cell']; ?></li>
                            <li>
                                <label class="input-file input-file-button" for="profileInput">프로필 변경</label>
                            </li>
                            <li>
                                <input type="file" name="profile" id="profileInput" style="display:none;" onchange="showPreview(this); showSubmitButtons();">
                            </li>
                            <li>
                                <input type="submit" style="display:none;" id="submitBtn" value="저장">
                                <input type="button" style="display:none;" id="cancelBtn" value="취소" onclick="resetPreview();">
                            </li>
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
                        <li>총 구매 가격</li>
                        <li><?=number_format($total)?>원</li>
                    </ul>
                </div> 
                <div class="history-inner">
                    <div>
                        <p>구매 갯수</p>
                        <div><?= $buy_num_rows ?></div>
                    </div>
                    <div>
                        <p>장바구니 갯수</p>
                        <div><?= $cart_count ?></div>
                    </div>
                    <div>
                        <p>찜 갯수</p>
                        <div><?= $like_count ?></div>
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

        <h4>구매 물품</h4>
        <?php
        if($buy_num_rows > 0){
            while($row = mysqli_fetch_assoc($buy_result)){
        ?>
        <div class="buy">
            <div class="buy-in">
                <!-- 현재까지 구매한 상품에 대한 정보 -->
                 <div class="buy-list">
                    <button class="buy_detail" onclick="toggleDetails(this)"><div ><span>주문상세</span></div></button>
                    <div>
                        <div class="confirm">
                            <span>구매확정</span>
                        </div>
                        <a href="detail.php?idx=<?=$row['itemidx']; ?>">
                            <img src="../product/<?=$row['img']?>" alt="" width="80px" height="80px" style="border-radius:10px; margin-top:5px;">
                        </a>
                    </div>
                    <div>
                        <ul class="buy-list-ul">
                            <li><span class="buy_p">구매 상품 : </span><?=$row['bname']?></li>
                            <li><span class="buy_p">구매 가격 / 수량 : </span><?=number_format($row['bprice']);?>원 / <?=$row['beach']?>개</li>
                            <li><span class="buy_p">구매 색상 : </span><?=$row['bcolor']?></li>
                            <li><span class="buy_p">구매 날짜 : </span><?=$row['buytime']?></li>
                            <div class="additional-details" style="display:none;">
                                <li><span class="buy_p">카테고리 : </span><?=$row['bcategori']?></li>
                                <li><span class="buy_p">판매자 이름 : </span><?=$row['buserid']?></li>
                                <li><span class="buy_p">상품 번호 : </span><?=$row['itemidx']?>번</li>
                                <li><span class="buy_p">총합 가격 : </span><?=number_format($row['total_price'])?>원</li>
                            </div>
                        </ul>
                    </div>
                 </div>
            </div>
        </div>
        <?php
                }
            }
        }else {
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
        <?php 
                    }
                }
            } 
        ?>
            </div>
        </div>

    </div>
</body>
</html>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
<script>
    // 제출 및 취소 버튼 표시 함수
    function showSubmitButtons() {
        document.getElementById('submitBtn').style.display = 'block';
        document.getElementById('cancelBtn').style.display = 'block';
    }

    // 이미지 미리보기 함수
    function showPreview(input) {
        const previewImage = document.getElementById('previewImage');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            // 이미지 로드 완료 후 실행되는 함수
            reader.onload = function (e) {
                previewImage.src = e.target.result; // 미리보기 이미지 설정
            };

            reader.readAsDataURL(input.files[0]); // 이미지 파일 읽기
        }
    }

    // 미리보기 초기화 함수
    function resetPreview() {
        const previewImage = document.getElementById('previewImage');
        const profileInput = document.getElementById('profileInput');

        previewImage.src = "<?=$profile_img ?>"; // 기존 프로필 이미지로 되돌림
        profileInput.value = ""; // 파일 입력 초기화
        document.getElementById('submitBtn').style.display = 'none'; // 제출 버튼 숨김
        document.getElementById('cancelBtn').style.display = 'none'; // 취소 버튼 숨김
    }

    // 주문상세 버튼 클릭 시 숨겨진 내용 보이기/숨기기
    function toggleDetails(button) {
        var details = $(button).closest('.buy-list').find('.additional-details');
        
        // 슬라이드 다운/업 효과
        details.slideToggle();
    }
</script>
