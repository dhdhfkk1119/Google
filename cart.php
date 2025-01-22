<!DOCTYPE html>
<html lang="en">

    <head>
        <?php include "./head.php" ?>
        <?php include "./connect/connect.php" ?>
    </head>

    <body>
    <?php 

    if (!isset($_SESSION['id'])) {
        echo "<script>
            alert('로그인 해주시기 바랍니다.');
            window.location.href = 'login.php';
        </script>";
        exit; // 스크립트를 종료하여 이후 코드가 실행되지 않도록 합니다.
    }else {
        
    }
    ?>
        <?php include "./header.php" ?>
        <!-- Navbar End -->


        <!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="input-group w-75 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->


        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Cart</h1>
        </div>
        <!-- Single Page Header End -->


        <!-- Cart Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Idx</th>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                            <th scope="col">Type</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $sql = "SELECT * FROM cart";
                            $row = mysqli_query($connect, $sql);
                            $subtotal = 0;
                            $has_products = false; // 상품 존재 여부 확인 변수
                            $iteminputCnt = 0; // iteminputCnt 초기화

                            while ($result = mysqli_fetch_array($row)) {
                                $itemlabelCnt = $iteminputCnt; // itemlabelCnt 값을 iteminputCnt로 설정
                                $images = explode(',', $result['img']);
                                $first_image = $images[0];

                                // 현재 사용자의 상품만 처리
                                if ($result['logid'] == $_SESSION['id']) {
                                    $has_products = true; // 상품이 있음을 표시
                                    $product_total = $result['cprice'] * $result['ceach'];
                                    $subtotal += $product_total; // Subtotal 계산
                                    ?>
                                    <!-- 상품이 있을 경우 출력 -->
                                    <tr>
                                        <td >
                                            <p class="mb-0 mt-4">
                                                <input type="checkbox" id="itembox<?= $iteminputCnt + 1 ?>" name="itcheck" value="<?= $result['idx'] ?>">
                                                <input type="hidden" name="total_price" value="<?=$product_total?>">
                                            </p>
                                        </td>
                                        <td >
                                            <label for="itembox<?= $iteminputCnt + 1 ?>">
                                                <div class="d-flex align-items-center">
                                                    <img src="./product/<?= $first_image; ?>" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="" >
                                                </div>
                                            </label>
                                        </td>
                                        <td>
                                            <a href="detail.php?idx=<?=$result['itemidx']; ?>"><p class="mb-0 mt-4"><?= $result['cname'] ?></p></a>
                                        </td>
                                        <td>
                                            <p class="mb-0 mt-4"><?= number_format($result['cprice']); ?>원</p>
                                        </td>
                                        <td>
                                            <div class="mb-0 mt-4">
                                                <!-- 수량 증가 버튼 -->
                                                <button class="plus" type="button" data-idx="<?= $result['idx']; ?>" data-price="<?= $result['cprice']; ?>" onclick="updateQuantity(this, 'p')">+</button>
                                                <!-- 수량 표시 -->
                                                <input type="number" name="pop_out" value="<?= $result['ceach']; ?>" readonly="readonly" style="text-align:center;" />
                                                <!-- 수량 감소 버튼 -->
                                                <button class="minus" type="button" data-idx="<?= $result['idx']; ?>" data-price="<?= $result['cprice']; ?>" onclick="updateQuantity(this, 'm')">-</button>
                                            </div>
                                        </td>
                                        <td>
                                        <p class="mb-0 mt-4 total-price" id="total-price-<?= $result['idx']; ?>"><?= number_format($product_total); ?>원</p>
                                        </td>
                                        <td ><p class="mb-0 mt-4"><?= $result['ccolor']; ?></p></td>
                                        <td>
                                            <form action="../connect/cart_delete.php" method="POST" onsubmit="return confirm('정말로 삭제하시겠습니까?')">
                                                <input type="hidden" name="idx" value="<?= $result['idx'] ?>">
                                                <button class="btn btn-md rounded-circle bg-light border mt-4" type="submit">
                                                    <i class="fa fa-times text-danger"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                    $iteminputCnt++; // iteminputCnt 증가
                                }
                            }

                            // 상품이 없을 경우 메시지 출력
                            if (!$has_products) {
                                ?>
                                <tr>
                                    <td colspan="12" class="text-center">
                                        <h1 style="padding: 60px 0 60px 0">장바구니에 등록된 상품이 없습니다.</h1>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>                        
                    </table>
                </div>
                <div class="mt-5">
                    <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Coupon Code">
                    <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">Apply Coupon</button>
                </div>
                <div class="row g-4 justify-content-end">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Total</h5>
                                <p class="mb-0 me-4 total-price2" data-price="<?= $result['cprice']; ?>"><?= number_format($subtotal); ?>원</p>
                            </div>
                            <button 
                            class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4 productcell" type="button" onclick="cartbuyit()">Proceed Checkout</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Cart Page End -->


        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
            <div class="container py-5">
                <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <a href="#">
                                <h1 class="text-primary mb-0">Fruitables</h1>
                                <p class="text-secondary mb-0">Fresh products</p>
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <div class="position-relative mx-auto">
                                <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="number" placeholder="Your Email">
                                <button type="submit" class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white" style="top: 0; right: 0;">Subscribe Now</button>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="d-flex justify-content-end pt-3">
                                <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                                <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Why People Like us!</h4>
                            <p class="mb-4">typesetting, remaining essentially unchanged. It was 
                                popularised in the 1960s with the like Aldus PageMaker including of Lorem Ipsum.</p>
                            <a href="" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Read More</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Shop Info</h4>
                            <a class="btn-link" href="">About Us</a>
                            <a class="btn-link" href="">Contact Us</a>
                            <a class="btn-link" href="">Privacy Policy</a>
                            <a class="btn-link" href="">Terms & Condition</a>
                            <a class="btn-link" href="">Return Policy</a>
                            <a class="btn-link" href="">FAQs & Help</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Account</h4>
                            <a class="btn-link" href="">My Account</a>
                            <a class="btn-link" href="">Shop details</a>
                            <a class="btn-link" href="">Shopping Cart</a>
                            <a class="btn-link" href="">Wishlist</a>
                            <a class="btn-link" href="">Order History</a>
                            <a class="btn-link" href="">International Orders</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Contact</h4>
                            <p>Address: 1429 Netus Rd, NY 48247</p>
                            <p>Email: Example@gmail.com</p>
                            <p>Phone: +0123 4567 8910</p>
                            <p>Payment Accepted</p>
                            <img src="img/payment.png" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Copyright Start -->
        <div class="container-fluid copyright bg-dark py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Your Site Name</a>, All right reserved.</span>
                    </div>
                    <div class="col-md-6 my-auto text-center text-md-end text-white">
                        <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                        <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                        <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> Distributed By <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->



        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        document.querySelectorAll(".plus, .minus").forEach((btn) => {
            btn.addEventListener("click", function () {
                const type = btn.classList.contains("plus") ? "p" : "m";
                const price = parseInt(btn.getAttribute("data-price"));
                fnCalCount(type, btn, price);
            });
        });

        function fnCalCount(type, ths, price) {
            // 수량 입력 필드 찾기
            const input = ths.parentElement.querySelector("input[name='pop_out']");
            let tCount = parseInt(input.value) || 0;

            // 수량 증가/감소 처리
            if (type === 'p') {
                tCount+1;
            } else if (type === 'm' && tCount > 1) {
                tCount-1; // 최소 수량을 1로 제한
            }

            // 수량 업데이트
            input.value = tCount;

            // 총 가격 계산
            const totalPrice = tCount * price;

            // 총 가격 표시 업데이트
            const totalPriceElement = ths.closest("tr").querySelector(".total-price");
            if (totalPriceElement) {
                totalPriceElement.textContent = totalPrice.toLocaleString() + "원"; // 숫자에 콤마 추가
                totalPriceElement.setAttribute("data-price", totalPrice); // data-price 속성 갱신
            }

            // 카트 전체 총합 계산 업데이트
            updateCartTotal();
        }

        function updateCartTotal() {
            let subtotal = 0;

            // 체크된 항목만 계산
            document.querySelectorAll("input[name='itcheck']:checked").forEach((checkbox) => {
                const totalPriceElement = checkbox.closest("tr").querySelector(".total-price");
                const itemTotal = parseInt(totalPriceElement.getAttribute("data-price")) || 0;
                subtotal += itemTotal;
            });

            // 총합 표시 업데이트
            const cartTotalPriceElement = document.querySelector(".total-price2");
            cartTotalPriceElement.textContent = subtotal.toLocaleString() + "원"; // 숫자에 콤마 추가
        }

        // 숫자 포맷 함수
        function number_format(number) {
            return number.toLocaleString();
        }

        // 장바구니 수량 업데이트 코드
        function updateQuantity(button, type) {
            // 상품 ID 및 현재 수량 가져오기
            const input = button.parentElement.querySelector("input[name='pop_out']");
            const idx = button.getAttribute("data-idx");
            const price = button.getAttribute("data-price");
            let quantity = parseInt(input.value);

            // 수량 업데이트
            if (type === "p") {
                quantity++;
            } else if (type === "m" && quantity > 1) {
                quantity--;
            }

            // 수량 업데이트를 즉시 반영
            input.value = quantity;

            // 서버에 업데이트 요청 보내기
            fetch("../connect/update_cart.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    idx: idx,
                    quantity: quantity,
                }),
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    // 총 가격 업데이트
                    const totalPriceElement = button.closest("tr").querySelector(".total-price");
                    const total = quantity * price;
                    totalPriceElement.textContent = total.toLocaleString() + "원";

                    // Subtotal 업데이트
                    document.querySelector(".total-price2").textContent = data.subtotal.toLocaleString() + "원";
                } else {
                    alert("수량 업데이트에 실패했습니다.");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
        }

        // 장바구니에서 구매하기 코드 JSON형식으로 보내기
        function cartbuyit() {
            const checkedItems = [];

            // 체크된 항목들만 가져오기
            document.querySelectorAll("input[name='itcheck']:checked").forEach((checkbox) => {
                checkedItems.push(checkbox.value); // 상품의 idx 값 추가
            });

            if (checkedItems.length === 0) {
                alert("구매할 상품을 선택해주세요.");
                return; // 선택된 항목이 없으면 함수 종료
            }

            // 총합 계산 (선택된 항목의 가격 합산)
            let subtotal = 0;
            checkedItems.forEach((idx) => {
                const totalPrice = document.querySelector(`#total-price-${idx}`).textContent.replace("원", "").replace(",", "");
                subtotal += parseInt(totalPrice);
            });

            // 구매 확인 메시지
            if (confirm("구매하시겠습니까?")) {
                // 확인 버튼 클릭 시 서버에 요청
                fetch('../connect/cart_buy.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ items: checkedItems, total: subtotal })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text(); // JSON 대신 텍스트로 응답 처리
                })
                .then(data => {
                    console.log('서버 응답:', data); // HTML 내용 출력
                    try {
                        const jsonData = JSON.parse(data); // JSON으로 파싱 시도
                        if (jsonData.success) {
                            alert("구매가 완료되었습니다.");
                            location.reload();
                        } else {
                            alert(jsonData.message || "구매 처리에 실패했습니다.");
                        }
                    } catch (error) {
                        console.error('JSON 파싱 에러:', error);
                        alert("서버 응답에 문제가 있습니다. 관리자에게 문의하세요.");
                    }
                })
                .catch(error => {
                    console.error('Fetch 오류:', error);
                    alert("오류가 발생했습니다. 다시 시도해주세요.");
                });
            }
        }

    </script>
    </body>

</html>