<!DOCTYPE html>
<html>

<head>
    <title>TQ Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('client/style.css')}}">
    <link rel="icon" href="https://cdn.haitrieu.com/wp-content/uploads/2021/10/Logo-DH-Cong-Nghe-Dong-A-EAUT.png"
        type="image/gif" sizes="16x16">
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('client/owlcarousel/assets/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('client/owlcarousel/assets/owl.theme.default.css')}}">
    <link rel="stylesheet" href="{{asset('client/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('client/owlcarousel/assets/owl.theme.default.min.css')}}">
</head>

<body>
    <div id="header" class="d-none d-sm-block">
        <section id="myTopHeader" class="py-1">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <p class="col">Thỏa mãn nhu cầu người dùng - bán hàng toàn quốc</p>
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <div class="iconHoline me-3 text-danger"><i class="fas fa-phone"></i></div>
                            <p class="me-3">Hotline: 19006750</p>
                            <a href="" class="me-2">Hệ thống cửa hàng |</a>
                            <a href="">Tuyển dụng</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="myMainHeader">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-white">
                            <div class="logo py-3">
                                <a href="{{route('home')}}" class="mb-1 d-block"><b class="text-white fs-2">TQ
                                        Store</b></a>
                                <p>Kiến tạo không gian</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group py-4">
                            <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm">
                            <span class="input-group-text" id="basic-addon2"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        <div class="col-md-3">
                            <div class="iconUser text-white fs-4 text-center">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div>
                                <span> <a href="">Đăng nhập /</a></span>
                                <span> <a href="">Đăng kí</a></span>
                            </div>
                            <p class="mb-0 text-white">Tài khoản của bạn</p>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-center">
                        <a href="{{route('client.cart.show')}}"
                            class="iconCart fs-3 text-white justify-content-end p-1">
                            <i class="fas fa-cart-plus"></i>
                            <div class="notifyIcon text-center">6</div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section id="myMainMenu" class="text-white d-none d-sm-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <nav>
                            <ul class="d-flex float-end">
                                <li><a href="">Trang chủ</a></li>
                                <li><a href="">Sản phẩm</a></li>
                                <li><a href="">Blog</a></li>
                                <li><a href="">Liên hệ</a></li>
                                <li><a href="">Phản hồi khách hàng</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div id="headerRespon" class="d-none">
        <div class="container">
            <div class="row">
                <div class="col-6 py-3">
                    <div class="logo">
                        <a href=""><b class="text-white my-3">TQ Store</b></a>
                    </div>
                </div>
                <div class="col-6 d-flex justify-content-end my-3">
                    <a href="" class="iconUser fs-6 me-1">
                        <i class="fa-solid fa-user-tie"></i>
                    </a>
                    <a href="" class="iconCart fs-6">
                        <i class="fas fa-cart-plus me-1"></i>
                        <div class="notifyIcon text-center">6</div>
                    </a>
                    <nav class="navbar navbar-dark p-0 ms-1">
                        <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
                            aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                            <i class="fa-solid fa-bars fs-6 iconMenu"></i>
                        </a>
                        <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                            aria-labelledby="offcanvasDarkNavbarLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">TQ Store</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="#">Trang chủ</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Sản phẩm
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-dark">
                                            <li><a class="dropdown-item" href="#">Sản phẩm 1</a></li>
                                            <li><a class="dropdown-item" href="#">Sản phẩm 2</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Blog</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Giới thiệu</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Phản hồi khách hàng</a>
                                    </li>
                                </ul>
                                <form class="d-flex mt-3 d-sm-none" role="search">
                                    <input class="form-control me-2" type="search" placeholder="Search"
                                        aria-label="Search">
                                    <button class="btn btn-success" type="submit">Search</button>
                                </form>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
<div id="wp-content">
    @yield('content')
</div>
<section id="myFooter" class="text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="logo mb-3 d-none d-sm-block">
                    <a href="" class="mb-1 d-block"><b class="text-white fs-2">TQ Store</b></a>
                    <p>Kiến tạo không gian</p>
                </div>
                <div class="mb-2"><span class="me-2 mb-1"><i class="fas fa-map-marker-alt"></i></span>Đại học Công nghệ
                    Đông Á</div>
                <div class="mb-2"> <span class="me-2"><i class="fas fa-phone"></i></span>0375284572</div>
                <div class="mb-2"> <span class="me-2"><i class="far fa-envelope"></i></span>tranquy52003@gmail.com</div>
            </div>
            <div class="col-md-3 col-sm-12">
                <p class="title1 title">Tư vấn khách hàng <span class="toggle-icon d-sm-none"><i
                            class="fas fa-caret-down"></i></span></p>
                <ul class="collapse1 navbar-collapse">
                    <li><a href="">Bảng giá sản phẩm</a></li>
                    <li><a href="">Người dùng mới</a></li>
                    <li><a href="">Làm thẻ thành viên</a></li>
                    <li><a href="">Chính sách đổi mới</a></li>
                    <li><a href="">Quy trình làm việc</a></li>
                </ul>
            </div>

            <div class="col-md-3 col-sm-12">
                <p class="title2 title">Hỗ trợ / Dịch vụ <span class="toggle-icon d-sm-none"><i
                            class="fas fa-caret-down"></i></span></p>
                <ul class="collapse2 navbar-collapse">
                    <li><a href="">Hướng dẫn chung</a></li>
                    <li><a href="">Hướng dẫn bảo hành</a></li>
                    <li><a href="">Hướng dẫn kích hoạt</a></li>
                    <li><a href="">Hướng dẫn mua hàng</a></li>
                    <li><a href="">Hướng dẫn lắp đặt</a></li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-12">
                <p class="title title3">Tổng đài hỗ trợ <span class="toggle-icon d-sm-none"><i
                            class="fas fa-caret-down"></i></span></p>
                <ul class="collapse3 navbar-collapse">
                    <li>
                        <div class="row my-1">
                            <div class="d-flex">
                                <div class="col-md-3 fs-3 py-2 me-2 me-sm-0">
                                    <i class="fas fa-phone-volume"></i>
                                </div>
                                <div class="col-md-9">
                                    <b class="fs-4 m-0">1900 6750</b>
                                    <p class="m-0">Tư vấn online</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row my-1">
                            <div class="d-flex">
                                <div class="col-md-3 fs-3 py-2 me-2 me-sm-0">
                                    <i class="fas fa-phone-volume"></i>
                                </div>
                                <div class="col-md-9">
                                    <b class="fs-4 m-0">1900 6750</b>
                                    <p class="m-0">Phản ánh chất lượng</p>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <hr>
                <div class="row">
                    <p class="d-flex align-items-center mb-0"><span class="me-2 fs-3"><i
                                class="far fa-envelope"></i></span>tranquy52003@gmail.com</p>
                </div>
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="row p-0">
                <div class="col-md-6 col-sm-12 p-0">
                    <p class="mb-0 license">Bản quyền thuộc về <a href="">TQ Store</a> được thiết kế bởi Trần
                        Quý</p>
                </div>
                <div class="col-md-6 col-sm-12 p-0">
                    <div class="social d-flex float-md-end">
                        <a href="https://www.facebook.com/thaiquymomo/" class="iconFacebook mx-1 text-white"><i
                                class="fab fa-facebook-square"></i></a>
                        <a href="" class="iconYoutobe mx-1 text-white"><i class="fab fa-youtube"></i></a>
                        <a href="" class="iconInsta mx-1 text-white"><i class="fab fa-instagram-square"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('client/owlcarousel/owl.carousel.min.js')}}"></script>;
    <script src="{{asset('client/js/main.js')}}"></script>
</section>