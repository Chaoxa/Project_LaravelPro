@extends('layouts.client')
@section('content')
<div id="main-content-wp" class="clearfix detail-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{route('home')}}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Điện thoại</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="detail-product-wp">
                <div class="section-detail clearfix">
                    <div class="thumb-wp fl-left">
                        <a href="" title="" id="main-thumb">
                            <img id="zoom" src="{{asset($product->thumb_main)}}" width="350px"
                                data-zoom-image="{{asset($product->thumb_main)}}">
                        </a>
                        @empty(!$product->thumb_detail)
                        <div id="list-thumb">
                            @foreach ($thumb_detail as $thumb)
                            <a href="" data-image="{{asset($thumb)}}" data-zoom-image="{{asset($thumb)}}">
                                <img id="zoom" src="{{asset($thumb)}}">
                            </a>
                            @endforeach
                        </div>
                        @endempty
                    </div>
                    <div class="thumb-respon-wp fl-left">
                        <img src="{{asset($product->thumb_main)}}" alt="ảnh lỗi">
                    </div>
                    <div class="info fl-right">
                        <h3 class="product-name">{{$product->name}}</h3>
                        <div class="desc">
                            @php
                            $lengthString = strlen($product->desc_quick);
                            @endphp
                            <div class="desc-quick"> {!! htmlspecialchars_decode($product->desc_quick)!!}</div>
                        </div>
                        @if ($lengthString > 150)
                        <button type="button" class="btn btn-sm btn-outline-secondary mb-1" data-toggle="modal"
                            data-target="#exampleModalLong">
                            Xem thêm
                        </button>
                        @endif
                        <form action="{{route('client.cart.add',$product->slug)}}" method="GET">
                            @csrf
                            @empty(!$configs)
                            <div class="option-buttons my-1">
                                @foreach ($configs as $value)
                                <a class="option-button btn-sm" option-id="{{$value->id}}" data-id="{{$product->id}}"
                                    onclick="selectOption(event, {{$value->id}})">
                                    {{$value->memory}}GB
                                </a>
                                @endforeach
                                <input type="hidden" name="selected_option_id" id="selected_option_id" value="">
                            </div>
                            @endempty
                            <p class="price price_product">{{number_format($product->new_price, 0, '.','.').' VNĐ'}}</p>
                            <div id="num-order-wp">
                                <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                <input type="text" name="num-order" value="1" id="num-order">
                                <a title="" id="plus"><i class="fa fa-plus"></i></a>
                            </div>
                            <button type="submit" class="add-cart">Thêm giỏ hàng</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="section" id="post-product-wp">
                <div class="section-head">
                    <h3 class="section-title bg-warning d-inline-block p-1 rounded">Mô tả sản phẩm</h3>
                </div>
                <div class="section-detail">
                    <div class="desc-detail-demo">
                        <div class="desc-detail">
                            {!! htmlspecialchars_decode($product->desc_detail) !!}
                        </div>
                    </div>
                    <div class="desc-detail-full">
                        {!!$product->desc_detail!!}
                    </div>
                    <div class="btn-more-info">
                        <button class="view-mode">Xem thêm</button>
                    </div>
                </div>
            </div>
            <div class="section" id="same-category-wp">
                <div class="section-head">
                    <h3 class="section-title bg-warning d-inline-block p-1 rounded">Cùng chuyên mục</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($categoryProducts as $categoryProduct)
                        <li>
                            <a href="" title="" class="thumb">
                                <a href=""> <img src="{{asset($categoryProduct->thumb_main)}}"></a>
                            </a>
                            <a href="" title="" class="product-name">{{Str::limit($categoryProduct->name, $limit = 35,
                                $end =
                                '...')}}</a>
                            <div class="price">
                                <span class="new">{{number_format($categoryProduct->new_price, 0, '.','.').'đ'}}</span>
                                @empty(!$categoryProduct->discount)
                                <small class="old">{{number_format($categoryProduct->old_price, 0,
                                    '.','.').'đ'}}</small>
                                @endempty
                            </div>
                            <div class="action clearfix">
                                <a href="{{route('client.cart.add',$categoryProduct->slug)}}" title=""
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
        </div>
        <div class="sidebar fl-left">
            @include('inc.sbHome')
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="exampleModalLongTitle">Mô tả nhanh</h5>
                <a class="close">
                    <span aria-hidden="true" class="btn btn-danger">TQ Store</span>
                </a>
            </div>
            <div class="modal-body">
                {!!$product->desc_quick!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    //ajax giỏ hàng
    $(document).ready(function() {
        $(".option-button").click(function() {
            var id = $(this).attr("data-id");
            var idOption = $(this).attr("option-id");
            var data = {
                id:id,
                idOption:idOption,
             _token: '{{ csrf_token() }}'
            };
            // console.log(data);
            $.ajax({
                url: "{{route('client.product.option')}}",
                method: "POST",
                data: data,
                dataType: "json",
                success: function(data) {
                    $(".price_product").text(data.price);
                    console.log(data);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
            });
        });
    });
</script>
@endsection