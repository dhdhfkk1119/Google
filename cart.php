<!DOCTYPE html>
<html lang="en">

    <head>
        <?php include "./head.php" ?>
    </head>

    <body>

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
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sql = "SELECT * FROM cart";
                                $row = mysqli_query($connect, $sql);
                                while ($result = mysqli_fetch_array($row)) {
                                    $images = explode(',', $result['img']);
                                    $first_image = $images[0];
                                    if ($result['cuserid'] == $_SESSION['id']) {
                            ?>
                            <tr>
                                <form action="../connect/cart_delete.php" method="POST" onsubmit="return confirm('정말로 삭제하시겠습니까?')">
                                    <input type="hidden" name="idx" value="<?= $result['idx'] ?>">
                                    <th scope="row">
                                        <div class="d-flex align-items-center">
                                            <img src="./product/<?= $first_image; ?>" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                        </div>
                                    </th>
                                    <td>
                                        <p class="mb-0 mt-4"><?= $result['cname'] ?></p>
                                    </td>
                                    <!-- 상품 가격 표시 -->
                                    <td>
                                        <p class="mb-0 mt-4"><?= $result['cprice']; ?>원</p>
                                    </td>
                                    <td>
                                        <div class="input-group quantity mt-4" style="width: 100px;">
                                        <button class="plus" type="button" onclick="fnCalCount('p', this, <?=$result['cprice']; ?>);">+</button>
                                        <input type="text" name="pop_out" value="0" readonly="readonly" style="text-align:center;" />
                                        <button class="minus" type="button" onclick="fnCalCount('m', this, <?=$result['cprice']; ?>);">-</button>
                                        </div>
                                    </td>
                                    <!-- 총 가격 표시 -->
                                    <td>
                                        <p class="mb-0 mt-4 total-price"><?= $result['cprice']; ?>원</p>
                                    </td>
                                    <td>
                                        <button class="btn btn-md rounded-circle bg-light border mt-4" type="submit">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            <?php
                                    }
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
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">Subtotal:</h5>
                                    <p class="mb-0">$96.00</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">Shipping</h5>
                                    <div class="">
                                        <p class="mb-0">Flat rate: $3.00</p>
                                    </div>
                                </div>
                                <p class="mb-0 text-end">Shipping to Ukraine.</p>
                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Total</h5>
                                <p class="mb-0 pe-4">$99.00</p>
                            </div>
                            <button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button">Proceed Checkout</button>
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

    // 초기 설정
    function updateTotal(element, change) {
        // 부모 행 가져오기
        let row = element.closest('tr');

        // 수량 입력 필드와 총 가격 필드 찾기
        let quantityInput = row.querySelector('.quantity-input');
        let totalPriceElement = row.querySelector('.total-price');

        // 현재 수량 가져오기
        let currentQuantity = parseInt(quantityInput.value) || 1;

        // 수량 업데이트
        if (change !== 0) {
            currentQuantity = Math.max(1, currentQuantity + change); // 최소 수량 1로 제한
            quantityInput.value = currentQuantity;
        }

        // 상품 단가 가져오기
        let unitPrice = parseFloat(quantityInput.dataset.unitPrice);

        // 총 가격 계산
        let totalPrice = unitPrice * currentQuantity;

        // 총 가격 표시
        totalPriceElement.textContent = totalPrice.toLocaleString() + "원";
    }

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
    </script>
    </body>

</html>