@extends('layouts.client')

@section('content')
<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="main-content fl-right">
            <div class="section" id="slider-wp">
                <div class="section-detail">
                    @foreach ($sliders as $slider)
                    <div class="item">
                        <a href="{{$slider->link}}"><img src="{{asset($slider->thumb_slider)}}" alt="error"></a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="section" id="support-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <div class="thumb">
                                <img src="public/client/images/icon-1.png">
                            </div>
                            <h3 class="title">Miễn phí vận chuyển</h3>
                            <p class="desc">Tới tận tay khách hàng</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/client/images/icon-2.png">
                            </div>
                            <h3 class="title">Tư vấn 24/7</h3>
                            <p class="desc">1900.9999</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/client/images/icon-3.png">
                            </div>
                            <h3 class="title">Tiết kiệm hơn</h3>
                            <p class="desc">Với nhiều ưu đãi cực lớn</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/client/images/icon-4.png">
                            </div>
                            <h3 class="title">Thanh toán nhanh</h3>
                            <p class="desc">Hỗ trợ nhiều hình thức</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/client/images/icon-5.png">
                            </div>
                            <h3 class="title">Đặt hàng online</h3>
                            <p class="desc">Thao tác đơn giản</p>
                        </li>
                    </ul>
                </div>
            </div>
            @if (!empty($featured_products))
            <div class="section" id="feature-product-wp">
                <div class="section-head">
                    <style>
                        .section-title {
                            background: red;
                            display: inline-block;
                            padding: 5px;
                            color: white;
                            margin: 20px 20px 10px 3px !important;
                        }

                        .warning {
                            color: rgb(13, 0, 255);
                        }
                    </style>
                    <h3 class="section-title">Sản phẩm nổi bật</h3>
                    <script>
                        var object = document.querySelector('.section-title')
                setInterval(function() {
                    object.classList.toggle('warning')
                }, 300)
                    </script>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($featured_products as $featured_product)
                        <li>
                            @if ($featured_product['discount'] > 0)
                            <div class="d-flex justify-content-between" id="discount">
                                <img src="https://ruoungoaigiasi.vn/image/catalog/san-pham/khuyen-mai.gif" alt=""
                                    width="60">
                                <div class="box-discount">
                                    <img id="bg-percent"
                                        src="https://www.pngkey.com/png/detail/15-151868_free-download-sale-icon.png"
                                        alt="" width="30">
                                    <h2 class="percent">
                                        <?php echo $featured_product['discount'] . '%' ?>
                                    </h2>
                                </div>
                            </div>
                            @endif
                            <a href="{{route('client.product.detail',$featured_product->slug)}}" title="" class="thumb">
                                <img src="{{asset($featured_product->thumb_main)}}">
                            </a>
                            <div class="justify-content-between d-flex">
                                <small class="code">Mã SP:{{$featured_product->code}}</small>
                                <small class=""><svg class="pt-1" xmlns="http://www.w3.org/2000/svg" height="1em"
                                        viewBox="0 0 576 512">
                                        <path
                                            d="M288 144a110.94 110.94 0 0 0-31.24 5 55.4 55.4 0 0 1 7.24 27 56 56 0 0 1-56 56 55.4 55.4 0 0 1-27-7.24A111.71 111.71 0 1 0 288 144zm284.52 97.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400c-98.65 0-189.09-55-237.93-144C98.91 167 189.34 112 288 112s189.09 55 237.93 144C477.1 345 386.66 400 288 400z" />
                                    </svg>{{$featured_product->views}}</small>
                            </div>
                            <a href="{{route('client.product.detail',$featured_product->slug)}}" title=""
                                class="product-name">{{Str::limit($featured_product->name, $limit = 35, $end =
                                '...')}}</a>
                            <div class="price">
                                <span class="new">{{number_format($featured_product->new_price, 0, '.','.').'đ'}}</span>
                                @empty(!$featured_product->discount)
                                <small class="old">{{number_format($featured_product->old_price, 0,
                                    '.','.').'đ'}}</small>
                                @endempty
                            </div>
                            <div class="action clearfix">
                                <a href="{{route('client.cart.add',$featured_product->slug)}}" title=""
                                    class="btn btn-style add-cart fl-left"><span>Thêm giỏ
                                        hàng</span></a>
                                <a href="?page=checkout" title="" class="btn btn-style buy-now fl-right"><span>Mua
                                        ngay</span></a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            @empty(!$groupedProducts)
            @foreach($groupedProducts as $k=>$v)
            <div class="section" id="list-product-wp">
                <div class="section-head">
                    <h3 class="section-title cat-product">{{$k}}</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        @foreach ($v as $item)
                        <li>
                            <a href="{{route('client.product.detail',$item->slug)}}" title="" class="thumb">
                                <img src="{{asset($item->thumb_main)}}">
                            </a>
                            <a href="{{route('client.product.detail',$item->slug)}}" title=""
                                class="product-name">{{Str::limit($item->name,
                                $limit = 35, $end =
                                '...')}}</a>
                            <div class="justify-content-between d-flex">
                                <small class="code">Mã SP:{{$item->code}}</small>
                                <small class=""><svg class="pt-1" xmlns="http://www.w3.org/2000/svg" height="1em"
                                        viewBox="0 0 576 512">
                                        <path
                                            d="M288 144a110.94 110.94 0 0 0-31.24 5 55.4 55.4 0 0 1 7.24 27 56 56 0 0 1-56 56 55.4 55.4 0 0 1-27-7.24A111.71 111.71 0 1 0 288 144zm284.52 97.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400c-98.65 0-189.09-55-237.93-144C98.91 167 189.34 112 288 112s189.09 55 237.93 144C477.1 345 386.66 400 288 400z" />
                                    </svg>{{$item->views}}</small>
                            </div>
                            <div class="price">
                                <span class="new">{{number_format($item->new_price, 0, '.','.').'đ'}}</span>
                                @empty(!$item->discount)
                                <small class="old">{{number_format($item->old_price, 0,
                                    '.','.').'đ'}}</small>
                                @endempty
                            </div>
                            <div class="action clearfix">
                                <a href="{{route('client.cart.add',$item->slug)}}" title=""
                                    class="btn btn-style add-cart fl-left"><span>Thêm giỏ
                                        hàng</span></a>
                                <a href="?page=checkout" title="" class="btn btn-style buy-now fl-right"><span>Mua
                                        ngay</span></a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
            @endempty
        </div>
        @include('inc.sbHome')
    </div>
</div>
@endsection