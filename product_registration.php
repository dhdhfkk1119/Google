<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "./connect/connect.php"; ?>
    <?php include "./head.php" ?>
    <title>Document</title>
    <link href="css/product.css" rel="stylesheet">
</head>
<body>
    <?php include "./header.php" ?>
    <div class="product">
        <h3>상품등록</h3>
        <hr>
        <div class="product-in">
            <div class="product-img">
                <h5>상품 이미지</h5>
                <div class="product-img-preview" id="productImgPreview">
                    <div class="img-container" id="defaultImgContainer">
                        <img src="default.jpg" alt="기본 이미지" id="defaultImg">
                    </div>
                    <div class="slider-controls" id="sliderControls">
                        <button type="button" id="prevBtn">&lt;</button>
                        <button type="button" id="nextBtn">&gt;</button>
                    </div>
                </div>
            </div>

            <!-- 상품 정보 폼 시작 -->
            <div class="product-info">
                <form action="./connect/product_ok.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <h5>판매 정보</h5>  
                    <table>
                        <tr>
                            <td class="product-1">판매자 :</td>
                            <td class="product-2"><?=$_SESSION['name'] ?><input type="text" value="<?=$_SESSION['name'] ?>" style="display:none;"></td>
                        </tr>
                        <tr>
                            <td class="product-1">상품 이름 :</td>
                            <td class="product-2"><input type="text" name="pname" id="pname"><br><span class="error-message" id="pnameerror"></span></td>
                        </tr>
                        <tr>
                            <td class="product-1">상품 가격 :</td>
                            <td class="product-2"><input type="number" name="price" id="price" onkeypress='return checkNumber(event)'><span class="error-message" id="priceerror"></span></td>
                        </tr>
                        <tr>
                            <td class="product-1">상품 카테고리</td>
                            <td class="product-2"><select name="categori" id="categori">
                                <option value="outer">outer</option>
                                <option value="pants">pants</option>
                                <option value="shirts">shirts</option>
                                <option value="dress">dress</option>
                                <option value="skirt">skirt</option>
                            </select></td>
                        </tr>
                        <tr>
                            <td class="product-1">상품 상세 설명 :</td>
                            <td class="product-2"><textarea name="content" id="content"></textarea><span class="error-message" id="contenterror"></span></td>
                        </tr>
                        <tr>
                            <td class="product-1">상품 색상 및 종류:</td>
                            <td class="product-2"><input type="text" name="color" id="color" placeholder="색상을 적어주세요 ',' 로 구별해서 적어주시면 됩니다."><br><span class="error-message" id="coloreerror"></td>
                        </tr>
                        <tr>
                            <td class="product-1">상품 판매 수량 :</td>
                            <td class="product-2"><input type="number" name="ea" id="ea" placeholder="판매 수량을 적어주세요"></td>
                        </tr>
                        <tr>
                            <td class="product-1" style="line-height:40px">상품 이미지 등록 :</td>
                            <td class="product-2">
                                <label for="ex_file" class="ex_file">파일 등록</label>
                                <input type="file" name="productimg[]" id="ex_file" style="display:none;" multiple>
                                <span class="error-message" id="productimgerror"></span>
                            </td>
                        </tr>
                    </table>
                    <div class="submit-container">
                        <input type="submit" value="상품등록">
                    </div>
                </form>
            </div>
            <!-- 상품 정보 폼 끝 -->

        </div>
        <hr>
    </div>

    <script>
        let uploadedImages = []; // Array to store uploaded images
        let currentIndex = 0;

        // 가격 숫자만 입력
        function checkNumber(event) {
            const char = String.fromCharCode(event.which);
            if (!(/[0-9]/.test(char) || event.key === '.' || event.key === '-')) {
                event.preventDefault();
            }
        }

        function validateForm() {
            let isValid = true;

            // Clear previous error messages
            document.getElementById('pnameerror').textContent = '';
            document.getElementById('priceerror').textContent = '';
            document.getElementById('contenterror').textContent = '';
            document.getElementById('productimgerror').textContent = '';
            
            // Validate 상품 이름
            const pname = document.getElementById('pname').value;
            if (pname == "") {
                document.getElementById('pnameerror').textContent = '상품명은 입력해주셔야합니다.';
                isValid = false;
            }

            // Validate 상품 가격
            const price = document.getElementById('price').value;
            if (price == "") {
                document.getElementById('priceerror').textContent = '가격은 적어주셔야합니다.';
                isValid = false;
            }

            // Validate 상품 상세 설명
            const content = document.getElementById('content').value;
            if (content == "") {
                document.getElementById('contenterror').textContent = '상세정보를 적어 주세요';
                isValid = false;
            }

            // Validate 상품 이미지
            if (uploadedImages.length === 0) {
                document.getElementById('productimgerror').textContent = '하나 이상의 상품 이미지를 업로드해 주세요.';
                isValid = false;
            }

            return isValid;
        }

        document.getElementById('ex_file').addEventListener('change', function() {
            const files = this.files;

            if (files.length > 5) {
                alert('최대 5개의 이미지만 등록할 수 있습니다.');
                this.value = ''; // Clear the input
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('img-container');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    imgContainer.appendChild(img);

                    const removeButton = document.createElement('button');
                    removeButton.textContent = 'x';
                    removeButton.classList.add('remove-img');
                    removeButton.addEventListener('click', function() {
                        uploadedImages = uploadedImages.filter(imgSrc => imgSrc !== img.src);
                        imgContainer.remove();
                        updateSlider(); // Reinitialize slider after removing an image
                    });
                    imgContainer.appendChild(removeButton);

                    uploadedImages.push(img.src);
                    updateSlider(); // Reinitialize slider after adding an image
                };

                reader.readAsDataURL(file);
            }
        });

        function updateSlider() {
            const slider = document.getElementById('productImgPreview');
            slider.innerHTML = ''; // Clear previous previews and remove default image

            uploadedImages.forEach(imgSrc => {
                const imgContainer = document.createElement('div');
                imgContainer.classList.add('img-container');

                const img = document.createElement('img');
                img.src = imgSrc;
                imgContainer.appendChild(img);

                const removeButton = document.createElement('button');
                removeButton.textContent = 'x';
                removeButton.classList.add('remove-img');
                removeButton.addEventListener('click', function() {
                    uploadedImages = uploadedImages.filter(src => src !== imgSrc);
                    imgContainer.remove();
                    updateSlider(); // Reinitialize slider after removing an image
                });
                imgContainer.appendChild(removeButton);

                slider.appendChild(imgContainer);
            });

            // Add slider controls if not already added
            let sliderControls = document.getElementById('sliderControls');
            if (!sliderControls) {
                sliderControls = document.createElement('div');
                sliderControls.classList.add('slider-controls');
                sliderControls.id = 'sliderControls';

                const prevBtn = document.createElement('button');
                prevBtn.id = 'prevBtn';
                prevBtn.textContent = '<';
                sliderControls.appendChild(prevBtn);

                const nextBtn = document.createElement('button');
                nextBtn.id = 'nextBtn';
                nextBtn.textContent = '>';
                sliderControls.appendChild(nextBtn);

                slider.appendChild(sliderControls);

                prevBtn.addEventListener('click', function() {
                    if (currentIndex > 0) {
                        currentIndex--;
                        updateSliderPosition();
                    }
                });

                nextBtn.addEventListener('click', function() {
                    if (currentIndex < uploadedImages.length - 1) {
                        currentIndex++;
                        updateSliderPosition();
                    }
                });
            }

            // Initialize slider position
            updateSliderPosition();
        }

        function updateSliderPosition() {
            const slider = document.getElementById('productImgPreview');
            const imgContainers = slider.getElementsByClassName('img-container');

            const offset = -currentIndex * 100;
            for (let i = 0; i < imgContainers.length; i++) {
                imgContainers[i].style.transform = `translateX(${offset}%)`;
            }
        }
    </script>
</body>
</html>
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "./connect/connect.php"; ?>
    <?php include "./head.php" ?>
    <title>Document</title>
    <link href="css/product.css" rel="stylesheet">
</head>
<body>
    <?php include "./header.php" ?>
    <div class="product">
        <h3>상품등록</h3>
        <hr>
        <div class="product-in">
            <div class="product-img">
                <h5>상품 이미지</h5>
                <div class="product-img-preview" id="productImgPreview">
                    <div class="img-container" id="defaultImgContainer">
                        <img src="default.jpg" alt="기본 이미지" id="defaultImg">
                    </div>
                    <div class="slider-controls" id="sliderControls">
                        <button type="button" id="prevBtn">&lt;</button>
                        <button type="button" id="nextBtn">&gt;</button>
                    </div>
                </div>
            </div>

            <!-- 상품 정보 폼 시작 -->
            <div class="product-info">
                <form action="./connect/product_ok.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <h5>판매 정보</h5>  
                    <table>
                        <tr>
                            <td class="product-1">판매자 :</td>
                            <td class="product-2"><?=$_SESSION['name'] ?><input type="text" value="<?=$_SESSION['name'] ?>" style="display:none;"></td>
                        </tr>
                        <tr>
                            <td class="product-1">상품 이름 :</td>
                            <td class="product-2"><input type="text" name="pname" id="pname"><br><span class="error-message" id="pnameerror"></span></td>
                        </tr>
                        <tr>
                            <td class="product-1">상품 가격 :</td>
                            <td class="product-2"><input type="number" name="price" id="price" onkeypress='return checkNumber(event)'><span class="error-message" id="priceerror"></span></td>
                        </tr>
                        <tr>
                            <td class="product-1">상품 카테고리</td>
                            <td class="product-2"><select name="categori" id="categori">
                                <option value="outer">outer</option>
                                <option value="pants">pants</option>
                                <option value="shirts">shirts</option>
                                <option value="dress">dress</option>
                                <option value="skirt">skirt</option>
                            </select></td>
                        </tr>
                        <tr>
                            <td class="product-1">상품 상세 설명 :</td>
                            <td class="product-2"><textarea name="content" id="content"></textarea><span class="error-message" id="contenterror"></span></td>
                        </tr>
                        <tr>
                            <td class="product-1">상품 색상 및 종류:</td>
                            <td class="product-2"><input type="text" name="color" id="color" placeholder="색상을 적어주세요 ',' 로 구별해서 적어주시면 됩니다."><br><span class="error-message" id="coloreerror"></td>
                        </tr>
                        <tr>
                            <td class="product-1">상품 판매 수량 :</td>
                            <td class="product-2"><input type="number" name="ea" id="ea" placeholder="판매 수량을 적어주세요"></td>
                        </tr>
                        <tr>
                            <td class="product-1" style="line-height:40px">상품 이미지 등록 :</td>
                            <td class="product-2">
                                <label for="ex_file" class="ex_file">파일 등록</label>
                                <input type="file" name="productimg[]" id="ex_file" style="display:none;" multiple>
                                <span class="error-message" id="productimgerror"></span>
                            </td>
                        </tr>
                    </table>
                    <div class="submit-container">
                        <input type="submit" value="상품등록">
                    </div>
                </form>
            </div>
            <!-- 상품 정보 폼 끝 -->

        </div>
        <hr>
    </div>

    <script>
        let uploadedImages = []; // Array to store uploaded images
        let currentIndex = 0;

        // 가격 숫자만 입력
        function checkNumber(event) {
            const char = String.fromCharCode(event.which);
            if (!(/[0-9]/.test(char) || event.key === '.' || event.key === '-')) {
                event.preventDefault();
            }
        }

        function validateForm() {
            let isValid = true;

            // Clear previous error messages
            document.getElementById('pnameerror').textContent = '';
            document.getElementById('priceerror').textContent = '';
            document.getElementById('contenterror').textContent = '';
            document.getElementById('productimgerror').textContent = '';
            
            // Validate 상품 이름
            const pname = document.getElementById('pname').value;
            if (pname == "") {
                document.getElementById('pnameerror').textContent = '상품명은 입력해주셔야합니다.';
                isValid = false;
            }

            // Validate 상품 가격
            const price = document.getElementById('price').value;
            if (price == "") {
                document.getElementById('priceerror').textContent = '가격은 적어주셔야합니다.';
                isValid = false;
            }

            // Validate 상품 상세 설명
            const content = document.getElementById('content').value;
            if (content == "") {
                document.getElementById('contenterror').textContent = '상세정보를 적어 주세요';
                isValid = false;
            }

            // Validate 상품 이미지
            if (uploadedImages.length === 0) {
                document.getElementById('productimgerror').textContent = '하나 이상의 상품 이미지를 업로드해 주세요.';
                isValid = false;
            }

            return isValid;
        }

        document.getElementById('ex_file').addEventListener('change', function() {
            const files = this.files;

            if (files.length > 5) {
                alert('최대 5개의 이미지만 등록할 수 있습니다.');
                this.value = ''; // Clear the input
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('img-container');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    imgContainer.appendChild(img);

                    const removeButton = document.createElement('button');
                    removeButton.textContent = 'x';
                    removeButton.classList.add('remove-img');
                    removeButton.addEventListener('click', function() {
                        uploadedImages = uploadedImages.filter(imgSrc => imgSrc !== img.src);
                        imgContainer.remove();
                        updateSlider(); // Reinitialize slider after removing an image
                    });
                    imgContainer.appendChild(removeButton);

                    uploadedImages.push(img.src);
                    updateSlider(); // Reinitialize slider after adding an image
                };

                reader.readAsDataURL(file);
            }
        });

        function updateSlider() {
            const slider = document.getElementById('productImgPreview');
            slider.innerHTML = ''; // Clear previous previews and remove default image

            uploadedImages.forEach(imgSrc => {
                const imgContainer = document.createElement('div');
                imgContainer.classList.add('img-container');

                const img = document.createElement('img');
                img.src = imgSrc;
                imgContainer.appendChild(img);

                const removeButton = document.createElement('button');
                removeButton.textContent = 'x';
                removeButton.classList.add('remove-img');
                removeButton.addEventListener('click', function() {
                    uploadedImages = uploadedImages.filter(src => src !== imgSrc);
                    imgContainer.remove();
                    updateSlider(); // Reinitialize slider after removing an image
                });
                imgContainer.appendChild(removeButton);

                slider.appendChild(imgContainer);
            });

            // Add slider controls if not already added
            let sliderControls = document.getElementById('sliderControls');
            if (!sliderControls) {
                sliderControls = document.createElement('div');
                sliderControls.classList.add('slider-controls');
                sliderControls.id = 'sliderControls';

                const prevBtn = document.createElement('button');
                prevBtn.id = 'prevBtn';
                prevBtn.textContent = '<';
                sliderControls.appendChild(prevBtn);

                const nextBtn = document.createElement('button');
                nextBtn.id = 'nextBtn';
                nextBtn.textContent = '>';
                sliderControls.appendChild(nextBtn);

                slider.appendChild(sliderControls);

                prevBtn.addEventListener('click', function() {
                    if (currentIndex > 0) {
                        currentIndex--;
                        updateSliderPosition();
                    }
                });

                nextBtn.addEventListener('click', function() {
                    if (currentIndex < uploadedImages.length - 1) {
                        currentIndex++;
                        updateSliderPosition();
                    }
                });
            }

            // Initialize slider position
            updateSliderPosition();
        }

        function updateSliderPosition() {
            const slider = document.getElementById('productImgPreview');
            const imgContainers = slider.getElementsByClassName('img-container');

            const offset = -currentIndex * 100;
            for (let i = 0; i < imgContainers.length; i++) {
                imgContainers[i].style.transform = `translateX(${offset}%)`;
            }
        }
    </script>
</body>
</html>
>>>>>>> 1efd9678224ab80abd03cba06f17a37042c2d95e
