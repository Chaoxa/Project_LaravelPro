<div class="section" id="category-product-wp">
    <div class="section-head">
        <h3 class="section-title">Danh mục sản phẩm</h3>
    </div>
    <div class="secion-detail">
        {!!$render_menu!!}
    </div>
</div>
<div class="section" id="filter-product-wp">
    <div class="section-head">
        <h3 class="section-title">Bộ lọc</h3>
    </div>
    <div class="section-detail">
        <form method="POST" action="">
            <table>
                <thead>
                    <tr>
                        <td colspan="2">Giá</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="radio" name="r-price"></td>
                        <td>Dưới 500.000đ</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="r-price"></td>
                        <td>500.000đ - 1.000.000đ</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="r-price"></td>
                        <td>1.000.000đ - 5.000.000đ</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="r-price"></td>
                        <td>5.000.000đ - 10.000.000đ</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="r-price"></td>
                        <td>Trên 10.000.000đ</td>
                    </tr>
                </tbody>
            </table>
            <table>
                <thead>
                    <tr>
                        <td colspan="2">Hãng</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="radio" name="r-brand"></td>
                        <td>Acer</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="r-brand"></td>
                        <td>Apple</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="r-brand"></td>
                        <td>Hp</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="r-brand"></td>
                        <td>Lenovo</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="r-brand"></td>
                        <td>Samsung</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="r-brand"></td>
                        <td>Toshiba</td>
                    </tr>
                </tbody>
            </table>
        </form>
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