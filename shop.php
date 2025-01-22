<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">

    <head>
        <?php include "./head.php" ?>
        <?php 
            include "./connect/connect.php";

            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'latest';
            $categori = isset($_GET['categori']) ? $_GET['categori'] : '';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $items_per_page = 9;
            $start = ($page - 1) * $items_per_page;
            $keywords = isset($_GET['keywords']) ? $_GET['keywords'] : '';

            $sql = "SELECT * FROM product WHERE 1=1";

            if(!empty($keywords)){
                $keywords = mysqli_real_escape_string($connect,$keywords); 
                $sql .= " AND (pname LIKE '%$keywords%' OR content LIKE '%$keywords%' OR categori LIKE '%$keywords%')";
            }

            if ($categori != '') {
                $sql .= " WHERE categori = '$categori'";
            }

            if ($sort == 'latest') {
                $sql .= " ORDER BY datetime DESC";
            } elseif ($sort == 'popular') {
                $sql .= " ORDER BY is_like DESC";
            } elseif ($sort == 'sales') {
                $sql .= " ORDER BY buyit DESC";
            }

            $sql .= " LIMIT $start, $items_per_page";
            $result = mysqli_query($connect, $sql);

            $total_items_sql = "SELECT COUNT(*) FROM product WHERE 1=1";
            if (!empty($keywords)) {
                $total_items_sql .= " AND (pname LIKE '%$keywords%' OR content LIKE '%$keywords%' OR categori LIKE '%$keywords%')";
            }

            if ($categori != '') {
                $total_items_sql .= " WHERE categori = '$categori'";
            }
            $total_items_result = mysqli_query($connect, $total_items_sql);
            $total_items = mysqli_fetch_array($total_items_result)[0];
            $total_pages = ceil($total_items / $items_per_page);        
        
        ?>
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
                        <div class="input-group w-100 mx-auto d-flex">
                            <form method="GET" action="shop.php" class="d-flex w-100">
                                <input type="search" class="form-control p-3" name="keywords" placeholder="keywords">
                                <button type="submit" class="btn btn-primary px-3">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->


        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Shop</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Cart</a></li>
                <li class="breadcrumb-item active text-white">Shop</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <h1 class="mb-4">Fresh fruits shop</h1>
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row g-4">
                            <div class="col-xl-3">
                                <div class="input-group w-100 mx-auto d-flex">
                                    <form method="GET" action="shop.php" class="d-flex w-100">
                                        <input type="search" class="form-control p-3" name="keywords" placeholder="keywords" value="<?=$keywords?>">
                                        <button type="submit" class="btn btn-primary px-3">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-6"></div>
                            <!-- 정렬 옵션 -->
                            <div class="col-xl-3">
                                <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                                    <label for="fruits">Default Sorting:</label>
                                    <select id="fruits" name="fruitlist" class="border-0 form-select-sm bg-light me-3" onchange="location = this.value;">
                                        <option value="shop.php?sort=latest&categori=<?=$categori;?>" <?= $sort == 'latest' ? 'selected' : ''; ?>>최신순</option>
                                        <option value="shop.php?sort=popular&categori=<?=$categori;?>" <?= $sort == 'popular' ? 'selected' : ''; ?>>인기순</option>
                                        <option value="shop.php?sort=sales&categori=<?=$categori;?>" <?= $sort == 'sales' ? 'selected' : ''; ?>>판매순</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-lg-3">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                    <div class="mb-3">
                                        <!-- 카테고리 리스트  -->
                                        <h4>Categories</h4>
                                        <ul class="list-unstyled fruite-categorie">
                                            <?php 
                                                // 전체 상품 가져오기 
                                                $total_sql = "SELECT COUNT(*) as total_count FROM product";
                                                $total_result = mysqli_query($connect,$total_sql);
                                                $total_row = mysqli_fetch_assoc($total_result);
                                                $total_count = $total_row['total_count'];
                                            ?>
                                            <li>
                                                <div class="d-flex justify-content-between fruite-name">
                                                    <!-- 전체 상품 링크 추가 -->
                                                    <a href="shop.php">전체 상품</a>
                                                    <span>(<?=$total_count; ?>)</span> <!-- 전체 상품 개수 표시 -->
                                                </div>
                                            </li>                                            
                                            <?php
                                                $category_sql = "SELECT categori, COUNT(*) as count FROM product GROUP BY categori";
                                                $category_result = mysqli_query($connect, $category_sql);
                                                while ($row = mysqli_fetch_assoc($category_result)) {
                                            ?>
                                            <li>
                                                <div class="d-flex justify-content-between fruite-name">
                                                    <a href="shop.php?categori=<?=$row['categori']; ?>"><?=$row['categori']; ?></a>
                                                    <span>(<?=$row['count']; ?>)</span>
                                                </div>
                                            </li>
                                            <?php
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h4 class="mb-2">Price</h4>
                                            <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput" min="0" max="500" value="0" oninput="amount.value=rangeInput.value">
                                            <output id="amount" name="amount" min-velue="0" max-value="500" for="rangeInput">0</output>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12">
                                        <div class="position-relative">
                                            <img src="img/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                            <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                                                <h3 class="text-secondary fw-bold">Fresh <br> Fruits <br> Banner</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="row g-4 justify-content-center">
                                    <!-- 상품 리스트 이미지 반복 시작 -->
                                    <?php
                                    if(mysqli_num_rows($result) > 0){
                                        while($row = mysqli_fetch_array($result)){
                                            $images = explode(',', $row['file']);
                                            // 배열의 첫 번째 이미지를 선택
                                            $first_image = $images[0];
                                    ?>
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <a href="detail.php?idx=<?=$row['idx']; ?>" onclick="increaseView(<?=$row['idx']; ?>);">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="product/<?=$first_image; ?>" class="img-fluid w-100 rounded-top" alt="<?=$row['pname']; ?>">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?=$row['categori']; ?></div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4><?=$row['pname']; ?></h4>
                                                    <p><?=$row['content']; ?></p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0"><?=$row['price']; ?>원</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i>Add</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php 
                                        }
                                    }else {
                                        ?>
                                        <div class="col-12 col-12 text-center" style="padding-top:100px;">
                                            <h1>"<span style="color:rgb(149, 206, 47);"><?=$keywords?></span>"에 대한 검색 결과가 없습니다.</h1>
                                        </div>                                            
                                        <?php
                                        }
                                    ?>
                                    <!-- 상품 이미지 반복 끝 -->
                                    
                                    <!-- 페이지네이션 -->                                    
                                    <div class="col-12">
                                        <div class="pagination d-flex justify-content-center mt-5">
                                            <a href="?page=1&sort=<?= $sort; ?>&categori=<?= $categori; ?>&keywords=<?= $keywords; ?>" class="rounded">&laquo;</a>
                                            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                                <a href="?page=<?= $i; ?>&sort=<?= $sort; ?>&categori=<?= $categori; ?>&keywords=<?= $keywords; ?>" class="rounded <?= $i == $page ? 'active' : ''; ?>">
                                                    <?= $i; ?>
                                                </a>
                                            <?php endfor; ?>
                                            <a href="?page=<?= $total_pages; ?>&sort=<?= $sort; ?>&categori=<?= $categori; ?>&keywords=<?= $keywords; ?>" class="rounded">&raquo;</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fruits Shop End-->


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
    <script src="js/main.js">
        // 클릭 이벤트: 상세 페이지로 이동하기 전에 조회수 증가
        function increaseView(productId) {
            $.ajax({
                url: "../connect/product_view.php", // 조회수 증가 처리 파일
                method: "POST",
                data: { idx: productId },
                success: function(response) {
                    console.log("조회수 증가 완료:", response);
                    // 상세 페이지로 이동
                    window.location.href = `detail.php?idx=${productId}`;
                },
                error: function(error) {
                    console.log("조회수 증가 실패:", error);
                }
            });
        }
    </script>
    
    </body>

=======
<!DOCTYPE html>
<html lang="en">

    <head>
        <?php include "./head.php" ?>
        <?php 
            include "./connect/connect.php";

            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'latest';
            $categori = isset($_GET['categori']) ? $_GET['categori'] : '';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $items_per_page = 9;
            $start = ($page - 1) * $items_per_page;

            $sql = "SELECT * FROM product";
            if ($categori != '') {
                $sql .= " WHERE categori = '$categori'";
            }

            if ($sort == 'latest') {
                $sql .= " ORDER BY datetime DESC";
            } elseif ($sort == 'popular') {
                $sql .= " ORDER BY views DESC";
            } elseif ($sort == 'sales') {
                $sql .= " ORDER BY sales DESC";
            }

            $sql .= " LIMIT $start, $items_per_page";
            $result = mysqli_query($connect, $sql);

            $total_items_sql = "SELECT COUNT(*) FROM product";
            if ($categori != '') {
                $total_items_sql .= " WHERE categori = '$categori'";
            }
            $total_items_result = mysqli_query($connect, $total_items_sql);
            $total_items = mysqli_fetch_array($total_items_result)[0];
            $total_pages = ceil($total_items / $items_per_page);        
        
        ?>
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
            <h1 class="text-center text-white display-6">Shop</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Cart</a></li>
                <li class="breadcrumb-item active text-white">Shop</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <h1 class="mb-4">Fresh fruits shop</h1>
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row g-4">
                            <div class="col-xl-3">
                                <div class="input-group w-100 mx-auto d-flex">
                                    <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                            <div class="col-6"></div>
                            <!-- 정렬 옵션 -->
                            <div class="col-xl-3">
                                <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                                    <label for="fruits">Default Sorting:</label>
                                    <select id="fruits" name="fruitlist" class="border-0 form-select-sm bg-light me-3" onchange="location = this.value;">
                                        <option value="shop.php?sort=latest&categori=<?=$categori;?>">최신순</option>
                                        <option value="shop.php?sort=popular&categori=<?=$categori;?>">인기순</option>
                                        <option value="shop.php?sort=sales&categori=<?=$categori;?>">판매순</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-lg-3">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                    <div class="mb-3">
                                        <!-- 카테고리 리스트  -->
                                        <h4>Categories</h4>
                                        <ul class="list-unstyled fruite-categorie">
                                            <?php 
                                            // 전체 상품 가져오기 
                                            $total_sql = "SELECT COUNT(*) as total_count FROM product";
                                            $total_result = mysqli_query($connect,$total_sql);
                                            $total_row = mysqli_fetch_assoc($total_result);
                                            $total_count = $total_row['total_count'];
                                            ?>
                                            <li>
                                                <div class="d-flex justify-content-between fruite-name">
                                                    <!-- 전체 상품 링크 추가 -->
                                                    <a href="shop.php">전체 상품</a>
                                                    <span>(<?=$total_count; ?>)</span> <!-- 전체 상품 개수 표시 -->
                                                </div>
                                            </li>                                            
                                            <?php
                                                $category_sql = "SELECT categori, COUNT(*) as count FROM product GROUP BY categori";
                                                $category_result = mysqli_query($connect, $category_sql);
                                                while ($row = mysqli_fetch_assoc($category_result)) {
                                            ?>
                                            <li>
                                                <div class="d-flex justify-content-between fruite-name">
                                                    <a href="shop.php?categori=<?=$row['categori']; ?>"><?=$row['categori']; ?></a>
                                                    <span>(<?=$row['count']; ?>)</span>
                                                </div>
                                            </li>
                                            <?php
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h4 class="mb-2">Price</h4>
                                            <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput" min="0" max="500" value="0" oninput="amount.value=rangeInput.value">
                                            <output id="amount" name="amount" min-velue="0" max-value="500" for="rangeInput">0</output>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12">
                                        <div class="position-relative">
                                            <img src="img/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                            <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                                                <h3 class="text-secondary fw-bold">Fresh <br> Fruits <br> Banner</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="row g-4 justify-content-center">
                                    <!-- 상품 리스트 이미지 반복 시작 -->
                                    <?php
                                        while($row = mysqli_fetch_array($result)){
                                            $images = explode(',', $row['file']);
                                            // 배열의 첫 번째 이미지를 선택
                                            $first_image = $images[0];
                                    ?>
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <a href="detail.php?idx=<?=$row['idx']; ?>">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="product/<?=$first_image; ?>" class="img-fluid w-100 rounded-top" alt="<?=$row['pname']; ?>">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?=$row['categori']; ?></div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4><?=$row['pname']; ?></h4>
                                                    <p><?=$row['content']; ?></p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0"><?=$row['price']; ?>원</p>
                                                        <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i>Add</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php 
                                        }
                                    ?>
                                    <!-- 상품 이미지 반복 끝 -->
                                    
                                    <!-- 페이지네이션 -->                                    
                                    <div class="col-12">
                                        <div class="pagination d-flex justify-content-center mt-5">
                                            <a href="?page=1&sort=<?=$sort;?>&categori=<?=$categori;?>" class="rounded">&laquo;</a>
                                            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                                <a href="?page=<?=$i;?>&sort=<?=$sort;?>&categori=<?=$categori;?>" class="rounded <?=$i == $page ? 'active' : '';?>"><?=$i;?></a>
                                            <?php } ?>
                                            <a href="?page=<?=$total_pages;?>&sort=<?=$sort;?>&categori=<?=$categori;?>" class="rounded">&raquo;</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fruits Shop End-->


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
    </body>

>>>>>>> 1efd9678224ab80abd03cba06f17a37042c2d95e
</html>