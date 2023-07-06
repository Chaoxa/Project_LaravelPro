<div class="sidebar fl-left">
    <div class="section" id="category-product-wp">
        <div class="section-head">
            <h3 class="section-title">Danh mục sản phẩm</h3>
        </div>
        <div class="secion-detail">
            {!!$render_menu!!}
        </div>
    </div>
    <div class="section" id="selling-wp">
        <div class="section-head">
            <h3 class="section-title">Sản phẩm bán chạy</h3>
        </div>
        <div class="section-detail">
            <ul class="list-item">
                <li class="clearfix">
                    <a href="?page=detail_product" title="" class="thumb fl-left">
                        <img src="public/client/images/img-pro-13.png" alt="">
                    </a>
                    <div class="info fl-right">
                        <a href="?page=detail_product" title="" class="product-name">Laptop Asus A540UP I5</a>
                        <div class="price">
                            <span class="new">5.190.000đ</span>
                            <span class="old">7.190.000đ</span>
                        </div>
                        <a href="" title="" class="buy-now">Mua ngay</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="section" id="banner-wp">
        <div class="section-detail">
            @empty(!$banners)
            @foreach ($banners as $banner)
            <a href="{{$banner->link}}" title="" class="thumb">
                <img src="{{asset($banner->thumb_banner)}}" alt="error" class="my-2">
            </a>
            @endforeach
            @endempty
        </div>
    </div>
</div>