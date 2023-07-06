@extends('layouts.client')
@section('content')
<div id="main-content-wp" class="clearfix category-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{route('home')}}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">{{$cat_name == ''?'':$cat_name }}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-product-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title fl-left">{{$cat_name == ''?'':$cat_name }}</h3>
                    <div class="filter-wp fl-right">
                        <div class="form-filter">
                            <form method="POST" action="" class="d-flex">
                                <select name="select" class="form-control">
                                    <option value="0">Sắp xếp</option>
                                    <option value="1">Từ A-Z</option>
                                    <option value="2">Từ Z-A</option>
                                    <option value="3">Giá cao xuống thấp</option>
                                    <option value="3">Giá thấp lên cao</option>
                                </select>
                                <button type="submit" class="btn ml-2">Lọc</button>
                            </form>
                            <p class="desc">Hiển thị {{$products -> count()}} trên 50 sản phẩm</p>
                        </div>
                    </div>
                </div>
                @if ($products->count() > 0)
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        @foreach ($products as $product)
                        <li>
                            <a href="{{url('san-pham'.'/'.$product->slug.'.'.'html')}}" title="" class="thumb">
                                <img src="{{asset($product->thumb_main)}}">
                            </a>
                            <a href="{{url('san-pham'.'/'.$product->slug.'.'.'html')}}" title=""
                                class="product-name">{{Str::limit($product->name, $limit = 35, $end =
                                '...')}}</a>
                            <div class="price">
                                <span class="new">{{number_format($product->new_price, 0, '.','.').'đ'}}</span>
                                <small class="old">{{number_format($product->old_price, 0, '.','.').'đ'}}</small>
                            </div>
                            <div class="action clearfix">
                                <span> <a title="Thêm giỏ hàng" class="btn-style btn add-cart fl-left">Thêm
                                        giỏ
                                        hàng</a></span>
                                <span> <a href="?page=checkout" title="Mua ngay"
                                        class="btn-style btn buy-now fl-right">Mua
                                        ngay</a></span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @else
                <p>Không có sản phẩm nào!</p>
                @endif
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        {{$products ->links()}}
                    </ul>
                </div>
            </div>
        </div>
        <div class="sidebar fl-left">
            @include('inc.sbCatProduct');
        </div>
    </div>
</div>
@endsection