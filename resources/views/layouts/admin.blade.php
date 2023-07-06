<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://www.hdtgroup.vn/images/resort-icon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/solid.min.css">
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/9zvlmm63vtiuu9i3wnr44t7ploxgrkb6fclj3ilmsfqvi1c4/tinymce/4/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        var editor_config = {
              path_absolute : "http://localhost/LaravelPro/TQStore/",
              selector: "textarea.edit",
              
              plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern textcolor colorpicker"
              ],
              toolbar: "fontselect | formatselect |forecolor backcolor |insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
              relative_urls: false,
              file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
          
                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                  cmsURL = cmsURL + "&type=Images";
                } else {
                  cmsURL = cmsURL + "&type=Files";
                }
          
                tinyMCE.activeEditor.windowManager.open({
                  file : cmsURL,
                  title : 'Filemanager',
                  width : x * 0.8,
                  height : y * 0.8,
                  resizable : "yes",
                  close_previous : "no"
                });
              }
            };
          
            tinymce.init(editor_config);
    </script>
    <link rel="stylesheet" href="{{asset('admin/css/style.css')}}">
    <title>AdminTQ</title>
</head>

<body>
    <div id="warpper" class="nav-fixed">
        <nav class="topnav shadow navbar-light bg-white d-flex">
            <div class="navbar-brand"><a href="{{url('admin/dashboard')}}"><img
                        src="https://icon-library.com/images/admin-user-icon/admin-user-icon-3.jpg" alt="" width="30px">
                    Admin</a></div>
            <div class="nav-right ">
                <div class="btn-group mr-auto">
                    <button type="button" class="btn dropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="plus-icon fas fa-plus-circle"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{route('admin.page.add')}}">Thêm trang</a>
                        <a class="dropdown-item" href="">Thêm bài viết</a>
                        <a class="dropdown-item" href="{{route('product.add')}}">Thêm sản phẩm</a>
                        <a class="dropdown-item" href="{{route('admin.banner.add')}}">Thêm banner</a>
                        <a class="dropdown-item" href="{{route('admin.slider.add')}}">Thêm slider</a>
                        <a class="dropdown-item" href="{{route('admin.user.add')}}">Thêm quản trị</a>
                        <a class="dropdown-item" href="{{route('admin.role.add')}}">Thêm quyền</a>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        {{session('username')}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Tài khoản</a>
                        <a class="dropdown-item" href="{{url('logout')}}">Đăng xuất</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end nav  -->
        <div id="page-body" class="d-flex">
            <div id="sidebar" class="bg-white">
                <ul id="sidebar-menu">
                    <li class="nav-link {{session('module_active')== 'dashboard'?'active':''}}">
                        <a href="{{url('admin/dashboard')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Dashboard
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                    </li>
                    <li class="nav-link {{session('module_active')== 'page'?'active':''}}">
                        <a href="{{route('admin.page.show')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Trang
                        </a>
                        <i class="arrow fas fa-angle-right"></i>

                        <ul class="sub-menu">
                            <li><a href="{{url('admin/page/add')}}">Thêm mới</a></li>
                            <li><a href="{{route('admin.page.show')}}">Danh sách trang</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{session('module_active')=='blog' ?'active':''}}">
                        <a href="{{url('admin/post/list')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Bài viết
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{url('admin/post/add')}}">Thêm mới</a></li>
                            <li><a href="{{url('admin/post/list')}}">Danh sách bài viết</a></li>
                            <li><a href="{{url('admin/post/cat/add')}}">Thêm danh mục</a></li>
                            <li><a href="{{url('admin/post/cat/list')}}">Danh sách danh mục</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{session('module_active')== 'product'?'active':''}}">
                        <a href="{{url('admin/product/list')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Sản phẩm
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{url('admin/product/add')}}">Thêm mới</a></li>
                            <li><a href="{{url('admin/product/list')}}">Danh sách</a></li>
                            <li><a href="{{url('admin/product/cat')}}">Danh mục</a></li>
                            <li><a href="{{url('admin/product/color')}}">Màu sắc</a></li>
                            <li><a href="{{url('admin/product/config')}}">Cấu hình</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{session('module_active')== 'order'?'active':''}}">
                        <a href="{{url('admin/order/list')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Bán hàng
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{url('admin/order/list')}}">Danh sách đơn hàng</a></li>
                            <li><a href="{{url('admin/guest/list')}}">Khách hàng thân thiết</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{session('module_active')== 'banner'?'active':''}} ">
                        <a href="{{url('admin/banner/list')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Banner
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{url('admin/banner/add')}}">Thêm mới</a></li>
                            <li><a href="{{url('admin/banner/list')}}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{session('module_active')== 'slider'?'active':''}}">
                        <a href="{{url('admin/slider/list')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Slider
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{url('admin/slider/add')}}">Thêm mới</a></li>
                            <li><a href="{{url('admin/slider/list')}}">Danh sách</a></li>
                        </ul>
                    </li>
                    @if(\App\Helpers\PermissionHelper::hasPermission(['user.add', 'user.view']))
                    <li class="nav-link {{session('module_active')== 'user'?'active':''}}">
                        <a href="{{url('admin/user/list')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Users
                        </a>
                        <i class="arrow fas fa-angle-right"></i>

                        <ul class="sub-menu">
                            <li><a href="{{url('admin/user/add')}}">Thêm mới</a></li>
                            <li><a href="{{url('admin/user/list')}}">Danh sách quản trị</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(\App\Helpers\PermissionHelper::hasPermission(['permission.add', 'role.add', 'role.view']))
                    <li class="nav-link {{session('module_active')== 'role'?'active':''}}">
                        <a href="{{url('admin/permission/add')}}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Phân quyền
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            @if(\App\Helpers\PermissionHelper::hasPermission(['permission.add']))
                            <li><a href="{{url('admin/permission/add')}}">Quyền</a></li>
                            @endif
                            <li><a href="{{url('admin/role/add')}}">Thêm vai trò</a></li>
                            <li><a href="{{url('admin/role/list')}}">Danh sách vai trò</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
            <div id="wp-content">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{asset('admin/js/app.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>