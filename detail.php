<<<<<<< HEAD
<?php
include "./connect/connect.php";
include "./head.php";

if (isset($_GET['idx'])) {
    $product_id = $_GET['idx'];
    
    $sql = "SELECT * FROM product WHERE idx = '$product_id'";
    $result = mysqli_query($connect, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $images = explode(',', $product['file']); // 파일명을 쉼표로 분리하여 배열로 만듦
    } else {
        echo "상품을 찾을 수 없습니다.";
        exit;
    }
} else {
    echo "잘못된 접근입니다.";
    exit;
}

// 첫 번째 SQL 쿼리 실행
$sql = "SELECT COUNT(idx) as count FROM item_like WHERE l_itemidx = '{$product['idx']}' AND l_user = '{$_SESSION['id']}'";
$result = $connect->query($sql); 

// 첫 번째 결과 처리
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cnt = $row['count'];
} else {
    $cnt = 0; // 결과가 없을 경우 기본값 설정
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>상품 상세 정보</title>
    <link href="css/product.css" rel="stylesheet">
    <style>
        /* 슬라이더 스타일 */
        .slider-container {
            position: relative;
            max-width: 500px;
            margin: auto;
            overflow: hidden;
            height: 500px; /* 슬라이더 높이 고정 */
        }
        .slider-images {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 100%;
            height: 100%;
        }
        .slider-images img {
            width: 500px; /* 이미지 너비 고정 */
            height: 500px; /* 이미지 높이 고정 */
            object-fit: cover; /* 이미지 비율을 유지하면서 크기 조정 */
        }
        .slider-buttons {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }
        .slider-buttons button {
            background-color: rgba(0, 0, 0, 0.5);
            border: none;
            color: white;
            padding: 10px;
            cursor: pointer;
        }
        /* 구매 하는 수량  */
        .plus {
            border:0px;
        }
        .minus {
            border:0px;
        }

        /* 찜하기 버튼 */
        .heart {
            width: 20px;
            height: 20px;
            background: gray;
            position: relative;
            transform: rotate(45deg);
            margin: 10px 10px 0 0;
            cursor: pointer;
            transition: background 0.5s ease;
        }

        .heart::before, .heart::after {
            content: "";
            width: 20px;
            height: 20px;
            position: absolute;
            border-radius: 50%;
            background: gray;
            transition: background 0.5s ease;
        }

        .heart::before {
            left: -50%;
        }

        .heart::after {
            top: -50%;
        }

        .heart.active {
            background: #ea2027;
        }

        .heart.active::before,
        .heart.active::after {
            background: #ea2027;
        }

        /* 구매하기 버튼 */
        .cell {
            text-align:right;
            bottom:0;
        }
        .productcell {
            background-color: #81c408 !important;
            color:white;
            padding: 10px 15px;
            border-radius: 4px;
            border:0px;
        }
        .cart {
            background-color: #81c408 !important;
            color:white;
            padding: 10px 15px;
            border-radius: 4px;
            border:0px;
        }
        .td-6 {
            display:flex;
        }
    </style>
</head>
<body>
    <?php include "./header.php" ?>
    <div class="product">
        <h3>상품 상세 정보</h3>
        <hr>
        <div class="product-in">
            <div class="product-img">
                <h5>상품 이미지</h5>
                <div class="slider-container">
                    <div class="slider-images">
                        <?php foreach ($images as $img) { ?>
                            <img src="./product/<?=$img; ?>" alt="<?=$product['pname']; ?>">
                            <input type="hidden" name="img" value="<?=$img; ?>">
                        <?php } ?>
                    </div>
                    <div class="slider-buttons">
                        <button id="prevBtn">&lt;</button>
                        <button id="nextBtn">&gt;</button>
                    </div>
                </div>
            </div>
            <div class="product-info">
                <h5>판매 정보</h5>  
                <!-- 판매 아이템 idx 정보 -->
                <input type="hidden" name="itemidx" value="<?=$product['idx']; ?>">
                <table>
                    <tr>
                        <td class="product-1">판매자 :</td>
                        <td class="product-2"><?=$product['userid']; ?><input type="hidden" name="userid" value="<?=$product['userid']; ?>"></td>
                    </tr>
                    <tr>
                        <td class="product-1">상품 이름 :</td>
                        <td class="product-2"><?=$product['pname']; ?><input type="hidden" name="pname" value="<?=$product['pname']; ?>"></td>
                    </tr>
                    <tr>
                        <td class="product-1">상품 가격 :</td>
                        <td class="product-2"><?=$product['price']; ?>원</td>
                    </tr>
                    <tr>
                        <td class="product-1">상품 카테고리 :</td>
                        <td class="product-2"><?=$product['categori']; ?><input type="hidden" name="categori" value="<?=$product['categori']; ?>"></td>
                    </tr>
                    <tr>
                        <td class="product-1">상품 상세 설명 :</td>
                        <td class="product-2"><?=$product['content']; ?></td>
                    </tr>
                    <tr>
                        <td class="product-1" style="line-height:40px">상품 장바구니 찜하기 :</td>
                        <td class="td-6">
                        <div class="heart <?php echo ($cnt > 0) ? 'active' : ''; ?>" id="heart<?php echo $product['idx']; ?>"></div>
                        <span id="like-count-<?php echo $product['idx']; ?>">
                            <?php
                                if ($product['is_like'] === null) {
                                    echo 0;
                                } else {
                                    echo $product['is_like'];
                                }
                            ?>
                        </span>

                        </td>
                    </tr>
                    <tr>
                        <td class="product-1">색상 :
                        </td>
                        <td>
                            <select name="color" id="">
                                <?php
                                    // 데이터베이스에서 가져온 색상을 쉼표(,)로 나누어 배열로 변환
                                    $colors = explode(',', $product['color']); 
                                    
                                    // 배열의 각 항목을 옵션으로 생성
                                    foreach ($colors as $color) {
                                        // 각 색상에 대해 option 태그 생성
                                        echo "<option value='" . trim($color) . "'>" . trim($color) . "</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="product-1">수량 :</td>
                        <td>
                            <button class="plus" type="button" onclick="fnCalCount('p', this, <?=$product['price']; ?>);">+</button>
                            <input type="text" name="pop_out" value="0" readonly="readonly" style="text-align:center;" />
                            <button class="minus" type="button" onclick="fnCalCount('m', this, <?=$product['price']; ?>);">-</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="product-1">가격 :</td>
                        <td>
                            <span class="total-price">0</span>원
                            <input type="hidden" name="cprice" value="<?=$product['price'];?>">
                            <input type="hidden" name="total_price" value="0">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="cell">
                                <button type="button" class="productcell">구매하기</button>
                                <button type="button" class="cart">장바구니</button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <hr>
    </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>              
    <script>
        // 상품 이미지 슬라이드 
        const sliderImages = document.querySelector('.slider-images');
        const images = document.querySelectorAll('.slider-images img');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        let currentIndex = 0;

        function showImage(index) {
            if (index < 0) {
                currentIndex = images.length - 1;
            } else if (index >= images.length) {
                currentIndex = 0;
            } else {
                currentIndex = index;
            }
            sliderImages.style.transform = `translateX(-${currentIndex * 500}px)`; // 500px씩 이동
        }

        prevBtn.addEventListener('click', () => {
            showImage(currentIndex - 1);
        });

        nextBtn.addEventListener('click', () => {
            showImage(currentIndex + 1);
        });

        // 수량 올리기 스크립트 
        function fnCalCount(type, ths, price) {
            var input = ths.parentElement.querySelector("input[name='pop_out']");
            var tCount = parseInt(input.value);

            // bseq_ea 요소 찾기
            var eqCountElement = ths.closest("tr").querySelector("td.bseq_ea");
            var tEqCount = eqCountElement ? parseInt(eqCountElement.textContent) : Infinity;

            if (type === 'p') {
                if (tCount < tEqCount) input.value = tCount + 1;
            } else {
                if (tCount > 0) input.value = tCount - 1;
            }
            
            tCount = parseInt(input.value); //업데이트 수량
            var totalPrice = tCount * price; // 총 가격 계산

            // html 넣기
            var totalPriceElement = ths.closest('tr').nextElementSibling.querySelector(".total-price");
            totalPriceElement.textContent = totalPrice.toLocaleString(); // 숫자에 콤마 추가         
            
            // hidden input에 총 가격 설정
            var totalPriceInput = ths.closest('tr').nextElementSibling.querySelector("input[name='total_price']");
            totalPriceInput.value = totalPrice; // 히든 인풋에 총 가격 설정
        }
        
        $(document).ready(function() {
            // 찜하기 클릭 시 Ajax로 처리
            $('#heart<?php echo $product['idx']?>').click(function() {
                var heart = $(this);
                var itemIdx = heart.attr('id').replace('heart', '');
                var userId = "<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>";

                $.ajax({
                    type: 'POST',
                    url: '../connect/item_like.php',
                    data: {
                        l_itemidx: itemIdx,
                        l_user: userId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'error') {
                            alert(response.message);
                            window.location.href = './login.php';
                        } else if (response.status === 'added') {
                            heart.addClass('active');
                            $('#like-count-<?php echo $product['idx'];?>').text(response.is_like);
                        } else if (response.status === 'removed') {
                            heart.removeClass('active');
                            $('#like-count-<?php echo $product['idx'];?>').text(response.is_like);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX 요청 실패:', error);
                    }
                });
            });

            // 구매하기 및 장바구니 클릭 이벤트 처리
            $('.cart, .productcell').on('click', function () {
                var button = $(this); // 클릭한 버튼
                var action = button.hasClass('cart') ? 'add_to_cart' : 'buy_now';

                // 요청 중복 방지: 버튼을 비활성화
                if (button.prop('disabled')) {
                    return; // 이미 요청 중인 경우 함수 종료
                }
                button.prop('disabled', true); // 버튼 비활성화

                handleSubmit(action, function () {
                    // 요청 완료 후 버튼 다시 활성화
                    button.prop('disabled', false);
                });
            });
        });

        // 전역 범위에서 함수 정의
        // handleSubmit 함수
        function handleSubmit(action, callback) {
            var itemidx = document.querySelector('input[name="itemidx"]').value;
            var userid = "<?= $product['userid']; ?>";
            var pname = "<?= $product['pname']; ?>";
            var categori = "<?= $product['categori']; ?>";
            var cprice = "<?= $product['price']; ?>";
            var price = document.querySelector('input[name="total_price"]').value;
            var ea = document.querySelector('input[name="pop_out"]').value;
            var color = document.querySelector('select[name="color"]').value;
            var img = "<?= $img; ?>";

            // 수량과 색상 선택 확인
            if (ea <= 0 || !color) {
                alert('수량 및 색상을 선택해주시기 바랍니다.');
                callback(); // 비활성화 해제
                return;
            }

            // Ajax 요청
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../connect/addit.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText.trim();
                    alert(response);

                    if (action === 'buy_now' || action === 'add_to_cart') {
                        <?php if(!isset($_SESSION['id'])){ ?>
                            location.href="login.php";
                        <?php } else { ?>
                            openPopup();
                        <?php } ?>
                    }

                    if (callback) callback(); // 요청 완료 후 콜백 실행
                }
            };

            // 요청 전송
            xhr.send(
                'itemidx=' + encodeURIComponent(itemidx) +
                '&userid=' + encodeURIComponent(userid) +
                '&pname=' + encodeURIComponent(pname) +
                '&categori=' + encodeURIComponent(categori) +
                '&cprice=' + encodeURIComponent(cprice) +
                '&total_price=' + encodeURIComponent(price) +
                '&pop_out=' + encodeURIComponent(ea) +
                '&color=' + encodeURIComponent(color) +
                '&img=' + encodeURIComponent(img) +
                '&action=' + encodeURIComponent(action)
            );
        }

    function openPopup() {
        var popup = window.open('', '_blank', 'width=300,height=300');
        
        // 팝업의 내용을 작성
        var content = "<p>구매가 완료되었습니다.</p>" +
                      "<p><a href='shop.php'>계속 쇼핑하기</a></p>" +
                      "<p><a href='mypage.php'>마이페이지로 가기</a></p>";

        popup.document.write(content); // 팝업 내용 작성
        popup.document.close(); // 팝업 창 닫기
    }
    </script>
=======
<?php
include "./connect/connect.php";
include "./head.php";

if (isset($_GET['idx'])) {
    $product_id = $_GET['idx'];
    
    $sql = "SELECT * FROM product WHERE idx = '$product_id'";
    $result = mysqli_query($connect, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $images = explode(',', $product['file']); // 파일명을 쉼표로 분리하여 배열로 만듦
    } else {
        echo "상품을 찾을 수 없습니다.";
        exit;
    }
} else {
    echo "잘못된 접근입니다.";
    exit;
}


// 첫 번째 SQL 쿼리 실행
$sql = "SELECT COUNT(idx) as count FROM item_like WHERE l_itemidx = '{$product['idx']}' AND l_user = '{$_SESSION['id']}'";
$result = $connect->query($sql); 

// 첫 번째 결과 처리
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cnt = $row['count'];
} else {
    $cnt = 0; // 결과가 없을 경우 기본값 설정
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>상품 상세 정보</title>
    <link href="css/product.css" rel="stylesheet">
    <style>
        /* 슬라이더 스타일 */
        .slider-container {
            position: relative;
            max-width: 500px;
            margin: auto;
            overflow: hidden;
            height: 500px; /* 슬라이더 높이 고정 */
        }
        .slider-images {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 100%;
            height: 100%;
        }
        .slider-images img {
            width: 500px; /* 이미지 너비 고정 */
            height: 500px; /* 이미지 높이 고정 */
            object-fit: cover; /* 이미지 비율을 유지하면서 크기 조정 */
        }
        .slider-buttons {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }
        .slider-buttons button {
            background-color: rgba(0, 0, 0, 0.5);
            border: none;
            color: white;
            padding: 10px;
            cursor: pointer;
        }
        /* 구매 하는 수량  */
        .plus {
            border:0px;
        }
        .minus {
            border:0px;
        }

        /* 찜하기 버튼 */
        .heart {
            width: 20px;
            height: 20px;
            background: gray;
            position: relative;
            transform: rotate(45deg);
            margin: 10px 10px 0 0;
            cursor: pointer;
            transition: background 0.5s ease;
        }

        .heart::before, .heart::after {
            content: "";
            width: 20px;
            height: 20px;
            position: absolute;
            border-radius: 50%;
            background: gray;
            transition: background 0.5s ease;
        }

        .heart::before {
            left: -50%;
        }

        .heart::after {
            top: -50%;
        }

        .heart.active {
            background: #ea2027;
        }

        .heart.active::before,
        .heart.active::after {
            background: #ea2027;
        }

        /* 구매하기 버튼 */
        .cell {
            text-align:right;
            bottom:0;
        }
        .productcell {
            background-color: #81c408 !important;
            color:white;
            padding: 10px 15px;
            border-radius: 4px;
            border:0px;
        }
        .cart {
            background-color: #81c408 !important;
            color:white;
            padding: 10px 15px;
            border-radius: 4px;
            border:0px;
        }
        .td-6 {
            display:flex;
        }
    </style>
</head>
<body>
    <?php include "./header.php" ?>
    <div class="product">
        <h3>상품 상세 정보</h3>
        <hr>
        <div class="product-in">
            <div class="product-img">
                <h5>상품 이미지</h5>
                <div class="slider-container">
                    <div class="slider-images">
                        <?php foreach ($images as $img) { ?>
                            <img src="./product/<?=$img; ?>" alt="<?=$product['pname']; ?>">
                            <input type="hidden" name="img" value="<?=$img; ?>">
                        <?php } ?>
                    </div>
                    <div class="slider-buttons">
                        <button id="prevBtn">&lt;</button>
                        <button id="nextBtn">&gt;</button>
                    </div>
                </div>
            </div>
            <div class="product-info">
                <h5>판매 정보</h5>  
                <!-- 판매 아이템 idx 정보 -->
                <input type="hidden" name="itemidx" value="<?=$product['idx']; ?>">
                <table>
                    <tr>
                        <td class="product-1">판매자 :</td>
                        <td class="product-2"><?=$product['userid']; ?><input type="hidden" name="userid" value="<?=$product['userid']; ?>"></td>
                    </tr>
                    <tr>
                        <td class="product-1">상품 이름 :</td>
                        <td class="product-2"><?=$product['pname']; ?><input type="hidden" name="pname" value="<?=$product['pname']; ?>"></td>
                    </tr>
                    <tr>
                        <td class="product-1">상품 가격 :</td>
                        <td class="product-2"><?=$product['price']; ?>원</td>
                    </tr>
                    <tr>
                        <td class="product-1">상품 카테고리 :</td>
                        <td class="product-2"><?=$product['categori']; ?><input type="hidden" name="categori" value="<?=$product['categori']; ?>"></td>
                    </tr>
                    <tr>
                        <td class="product-1">상품 상세 설명 :</td>
                        <td class="product-2"><?=$product['content']; ?></td>
                    </tr>
                    <tr>
                        <td class="product-1" style="line-height:40px">상품 장바구니 찜하기 :</td>
                        <td class="td-6">
                        <div class="heart <?php echo ($cnt > 0) ? 'active' : ''; ?>" id="heart<?php echo $product['idx']; ?>"></div>
                        <span id="like-count-<?php echo $product['idx']; ?>">
                            <?php
                                if ($product['is_like'] === null) {
                                    echo 0;
                                } else {
                                    echo $product['is_like'];
                                }
                            ?>
                        </span>

                        </td>
                    </tr>
                    <tr>
                        <td class="product-1">색상 :
                        </td>
                        <td>
                            <select name="color" id="">
                                <?php
                                    // 데이터베이스에서 가져온 색상을 쉼표(,)로 나누어 배열로 변환
                                    $colors = explode(',', $product['color']); 
                                    
                                    // 배열의 각 항목을 옵션으로 생성
                                    foreach ($colors as $color) {
                                        // 각 색상에 대해 option 태그 생성
                                        echo "<option value='" . trim($color) . "'>" . trim($color) . "</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="product-1">수량 :</td>
                        <td>
                            <button class="plus" type="button" onclick="fnCalCount('p', this, <?=$product['price']; ?>);">+</button>
                            <input type="text" name="pop_out" value="0" readonly="readonly" style="text-align:center;" />
                            <button class="minus" type="button" onclick="fnCalCount('m', this, <?=$product['price']; ?>);">-</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="product-1">가격 :</td>
                        <td>
                            <span class="total-price">0</span>원
                            <input type="hidden" name="total_price" value="0">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="cell">
                                <button type="button" class="productcell">구매하기</button>
                                <button type="button" class="cart">장바구니</button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <hr>
    </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>              
    <script>
        // 상품 이미지 슬라이드 
        const sliderImages = document.querySelector('.slider-images');
        const images = document.querySelectorAll('.slider-images img');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        let currentIndex = 0;

        function showImage(index) {
            if (index < 0) {
                currentIndex = images.length - 1;
            } else if (index >= images.length) {
                currentIndex = 0;
            } else {
                currentIndex = index;
            }
            sliderImages.style.transform = `translateX(-${currentIndex * 500}px)`; // 500px씩 이동
        }

        prevBtn.addEventListener('click', () => {
            showImage(currentIndex - 1);
        });

        nextBtn.addEventListener('click', () => {
            showImage(currentIndex + 1);
        });

        // 수량 올리기 스크립트 
        function fnCalCount(type, ths, price) {
            var input = ths.parentElement.querySelector("input[name='pop_out']");
            var tCount = parseInt(input.value);

            // bseq_ea 요소 찾기
            var eqCountElement = ths.closest("tr").querySelector("td.bseq_ea");
            var tEqCount = eqCountElement ? parseInt(eqCountElement.textContent) : Infinity;

            if (type === 'p') {
                if (tCount < tEqCount) input.value = tCount + 1;
            } else {
                if (tCount > 0) input.value = tCount - 1;
            }
            
            tCount = parseInt(input.value); //업데이트 수량
            var totalPrice = tCount * price; // 총 가격 계산

            // html 넣기
            var totalPriceElement = ths.closest('tr').nextElementSibling.querySelector(".total-price");
            totalPriceElement.textContent = totalPrice.toLocaleString(); // 숫자에 콤마 추가         
            
            // hidden input에 총 가격 설정
            var totalPriceInput = ths.closest('tr').nextElementSibling.querySelector("input[name='total_price']");
            totalPriceInput.value = totalPrice; // 히든 인풋에 총 가격 설정
        }
        
        $(document).ready(function() {
            // 찜하기 클릭 시 Ajax로 처리
            $('#heart<?php echo $product['idx']?>').click(function() {
                var heart = $(this);
                var itemIdx = heart.attr('id').replace('heart', '');
                var userId = "<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>";

                $.ajax({
                    type: 'POST',
                    url: '../connect/item_like.php',
                    data: {
                        l_itemidx: itemIdx,
                        l_user: userId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'error') {
                            alert(response.message);
                            window.location.href = './login.php';
                        } else if (response.status === 'added') {
                            heart.addClass('active');
                            $('#like-count-<?php echo $product['idx'];?>').text(response.is_like);
                        } else if (response.status === 'removed') {
                            heart.removeClass('active');
                            $('#like-count-<?php echo $product['idx'];?>').text(response.is_like);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX 요청 실패:', error);
                    }
                });
            });

            // 구매하기 및 장바구니 클릭 이벤트 처리
            $('.cart, .productcell').on('click', function () {
                var button = $(this); // 클릭한 버튼
                var action = button.hasClass('cart') ? 'add_to_cart' : 'buy_now';

                // 요청 중복 방지: 버튼을 비활성화
                if (button.prop('disabled')) {
                    return; // 이미 요청 중인 경우 함수 종료
                }
                button.prop('disabled', true); // 버튼 비활성화

                handleSubmit(action, function () {
                    // 요청 완료 후 버튼 다시 활성화
                    button.prop('disabled', false);
                });
            });
        });

        // 전역 범위에서 함수 정의
        // handleSubmit 함수
        function handleSubmit(action, callback) {
            var itemidx = document.querySelector('input[name="itemidx"]').value;
            var userid = "<?= $product['userid']; ?>";
            var pname = "<?= $product['pname']; ?>";
            var categori = "<?= $product['categori']; ?>";
            var price = document.querySelector('input[name="total_price"]').value;
            var ea = document.querySelector('input[name="pop_out"]').value;
            var color = document.querySelector('select[name="color"]').value;
            var img = "<?= $img; ?>";

            // 수량과 색상 선택 확인
            if (ea <= 0 || !color) {
                alert('수량 및 색상을 선택해주시기 바랍니다.');
                callback(); // 비활성화 해제
                return;
            }

            // Ajax 요청
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../connect/addit.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText.trim();
                    alert(response);

                    if (action === 'buy_now') {
                        openPopup();
                    }

                    if (callback) callback(); // 요청 완료 후 콜백 실행
                }
            };

            // 요청 전송
            xhr.send(
                'itemidx=' + encodeURIComponent(itemidx) +
                '&userid=' + encodeURIComponent(userid) +
                '&pname=' + encodeURIComponent(pname) +
                '&categori=' + encodeURIComponent(categori) +
                '&total_price=' + encodeURIComponent(price) +
                '&pop_out=' + encodeURIComponent(ea) +
                '&color=' + encodeURIComponent(color) +
                '&img=' + encodeURIComponent(img) +
                '&action=' + encodeURIComponent(action)
            );
        }

    function openPopup() {
        var popup = window.open('', '_blank', 'width=300,height=300');
        
        // 팝업의 내용을 작성
        var content = "<p>구매가 완료되었습니다.</p>" +
                      "<p><a href='continue-shopping-url'>계속 쇼핑하기</a></p>" +
                      "<p><a href='my-page-url'>마이페이지로 가기</a></p>";

        popup.document.write(content); // 팝업 내용 작성
        popup.document.close(); // 팝업 창 닫기
    }
    </script>
>>>>>>> 1efd9678224ab80abd03cba06f17a37042c2d95e
