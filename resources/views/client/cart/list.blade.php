@extends('layouts.client')
@section('content')
<div id="main-content-wp" class="cart-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{route('home')}}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Giỏ hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @if ((Cart::count() !== 0))
    <div id="wrapper" class="wp-inner clearfix">
        <div class="section" id="info-cart-wp">
            <div class="section-detail table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Mã sản phẩm</td>
                            <td>Ảnh sản phẩm</td>
                            <td>Tên sản phẩm</td>
                            <td>Phiên bản</td>
                            <td>Giá sản phẩm</td>
                            <td>Số lượng</td>
                            <td>Thành tiền</td>
                            <td>Tác vụ</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Cart::Content() as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>
                                <a href="{{route('client.product.detail',$product -> options -> slug)}}" title=""
                                    class="thumb">
                                    <img src="{{asset($product -> options -> thumb_main)}}" alt="">
                                </a>
                            </td>
                            <td>
                                <a href="{{route('client.product.detail',$product -> options -> slug)}}" title=""
                                    class="name-product">{{Str::limit($product->name,
                                    $limit = 30, $end =
                                    '...')}}</a>
                            </td>
                            <td>
                                @if (optional($product->options)->option)
                                <p class="bg-success d-inline-block rounded text-white m-0">{{
                                    $product->options->option
                                    }}</p>
                                @else
                                <p class="bg-secondary d-inline-block rounded text-white m-0">Thường</p>
                                @endif
                            </td>
                            <td>{{number_format($product->price, 0, '.','.').'đ'}}</td>
                            <td>
                                <input type="number" name="num-order" rowId="{{$product->rowId}}"
                                    value="{{$product ->qty}}" class="num-order" style="width:45px" min="1">
                            </td>
                            <td class="sub-total-{{$product->rowId}}">{{number_format($product ->
                                total,'0','','.')}}đ</td>

                            <td>
                                <a href="{{route('client.cart.delete',$product->rowId)}}" title=""
                                    class="del-product px-2  py-1 rounded text-white bg-danger"><i
                                        class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9">
                                <div class="clearfix">
                                    <p id="total-price" class="fl-right">Tổng giá: <span>{{Cart::total()}} VNĐ</span>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9">
                                <div class="clearfix">
                                    <div class="fl-right">
                                        <a href="{{route('client.cart.checkout')}}" title="" id="checkout-cart">Thanh
                                            toán</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="section" id="action-cart-wp">
            <div class="section-detail">
                <p class="title">Click vào <span>“Cập nhật giỏ hàng”</span> để cập nhật số lượng. Nhập vào số lượng
                    <span>0</span> để xóa sản phẩm khỏi giỏ hàng. Nhấn vào thanh toán để hoàn tất mua hàng.
                </p>
                <a href="{{route('home')}}" title="" id="buy-more">Mua tiếp</a><br />
                <a href="{{route('client.cart.destroy')}}" title="" id="delete-cart">Xóa giỏ hàng</a>
            </div>
        </div>
    </div>
    @else
    <div class="cart-empty text-center">
        <a href="{{ route('home') }}" class="d-flex justify-content-center align-items-center">
            <img src="https://bizweb.dktcdn.net/100/320/202/themes/714916/assets/empty-cart.png?1650292912948" alt=""
                width="600px">
        </a>
        <p class="mt-2">Giỏ hàng hiện tại đang không có sản phẩm nào trong giỏ hàng vui lòng click <b><a
                    href="{{ route('home') }}">vào đây</a></b> để tiếp tục mua hàng!</p>
    </div>

    @endif
</div>
<script>
    $(document).ready(function() {
    $(".num-order").change(function() {
        var rowId = $(this).attr("rowId");
        var qty = $(this).val();
        var data = {
            rowId: rowId,
            qty: qty,
            _token: '{{ csrf_token() }}'
        };
        // console.log(data);
        $.ajax({
            url: "{{route('client.cart.update')}}",
            method: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
                // console.log(data);
                $(".sub-total-" + rowId).text(data.sub_total);
                $("#total-price span").text(data.total);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
        });
    });
});
//========>>>>>
</script>
@endsection