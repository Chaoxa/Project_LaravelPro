@extends('layouts.client')
@section('content')
<section id="myContent">
    <div class="container">
        <div class="col-md-12">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{route('home')}}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Chi tiết sản phẩm</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 sidebar d-none d-md-block">
                @include('inc.sbHome')
            </div>
            <div class="col-md-9">
                <div id="wp-detail-product">
                    <div class="section-detail">
                        <div class="show-product">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="thumb_main">
                                        <img src="{{asset($product->thumb_main)}}" alt="">
                                    </div>
                                    <div class="list_thumb mt-3">
                                        <div class="owl-carousel owl-theme">
                                            @foreach ($thumb_detail as $thumb)
                                            <div class="item">
                                                <img src="{{asset($thumb)}}" alt="">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="product_name">
                                        {{$product->name}}
                                    </div>
                                    @php
                                    $lengthString = strlen($product->desc_quick);
                                    @endphp
                                    <div class="desc-quick fs-6 my-2">
                                        {!!Str::limit($product->desc_quick, $limit = 200, $end =
                                        '...')!!}
                                    </div>
                                    @if ($lengthString > 150)
                                    <button type="button" class="btn btn-sm btn-outline-secondary mb-1"
                                        data-toggle="modal" data-target="#exampleModalLong">
                                        Xem thêm
                                    </button>
                                    @endif
                                    <form action="{{route('client.cart.add',$product->slug)}}" method="GET">
                                        @csrf
                                        @empty(!$configs)
                                        <div class="option-buttons my-1">
                                            @foreach ($configs as $value)
                                            <a class="option-button btn-sm" option-id="{{$value->id}}"
                                                data-id="{{$product->id}}"
                                                onclick="selectOption(event, {{$value->id}})">
                                                {{$value->memory}}GB
                                            </a>
                                            @endforeach
                                            <input type="hidden" name="selected_option_id" id="selected_option_id"
                                                value="">
                                        </div>
                                        @endempty

                                        <div class="price price-product-detail">
                                            <p class="new-price text-danger d-inline-block">
                                                {{number_format($product->new_price, 0, '.','.').' VNĐ'}}</p>
                                            <del class="old-price d-inline-block">{{number_format($product->old_price,
                                                0,
                                                '.','.').' VNĐ'}}</del>
                                        </div>
                                        <div id="num-order-wp">
                                            <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                            <input type="text" name="num-order" value="1" id="num-order">
                                            <a title="" id="plus"><i class="fa fa-plus"></i></a>
                                        </div>
                                        <button type="submit" class="add-cart btn btn-success text-white">Thêm giỏ
                                            hàng</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wp-desc-detail mt-3">
                        <div class="title">
                            <p>MÔ TẢ SẢN PHẨM</p>
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
                    <div class="wp-same-category mb-4">
                        <div class="title">
                            <p>CÙNG CHUYÊN MỤC</p>
                        </div>
                        <div class="list_product mt-3">
                            <ul class="owl-carousel same-category owl-theme">
                                @foreach ($categoryProducts as $categoryProduct)
                                <li class="item">
                                    <div class="thumb-product">
                                        <a href=""><img src="{{asset($categoryProduct->thumb_main)}}" alt=""></a>
                                    </div>
                                    <div class="view&code d-flex justify-content-between mb-2">
                                        <div class="code">
                                            Mã SP <span>TQ#1</span>
                                        </div>
                                        <div class="view d-flex">
                                            <div class="icon"><i class="fas fa-eye"></i></div>
                                            2500
                                        </div>
                                    </div>
                                    <div class="name-product">
                                        <p>{{Str::limit($categoryProduct->name, $limit = 35,
                                            $end =
                                            '...')}}</p>
                                    </div>
                                    <div class="price">
                                        <div class="new-price d-inline-block">
                                            {{number_format($categoryProduct->new_price, 0, '.','.').'đ'}}</div>
                                        @empty(!$categoryProduct->discount)
                                        <small
                                            class="old-price d-inline-block">{{number_format($categoryProduct->old_price,
                                            0, '.','.').'đ'}}</small>
                                        @endempty
                                    </div>
                                    <div class="action mt-2 d-flex justify-content-between">
                                        <a href="" title="" class="btn btn-style add-cart fl-left"><span>Thêm
                                                giỏ
                                                hàng</span></a>
                                        <a href="" title="" class="btn btn-style buy-now fl-right"><span>Mua
                                                ngay</span></a>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
        </div>
    </div>
</section>

<script>
    //ajax giỏ hàng
$(document).ready(function () {
    $(".option-button").click(function () {
        var id = $(this).attr("data-id");
        var idOption = $(this).attr("option-id");
        var data = {
            id: id,
            idOption: idOption,
            _token: "{{ csrf_token() }}",
        };
        // console.log(data);
        $.ajax({
            url: "{{route('client.product.option')}}",
            method: "POST",
            data: data,
            dataType: "json",
            success: function (data) {
                $(".price-product-detail .new-price").text(data.price);
                // console.log(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
        });
    });
});
</script>
@endsection