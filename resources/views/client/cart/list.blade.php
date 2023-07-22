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
                            <a href="" title="">Giỏ hàng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @if ((Cart::count() !== 0))
        <div id="wp-cart">
            <div class="cart-detail">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Mã SP</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên SP</th>
                            <th scope="col">Phiên bản</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thành tiền</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Cart::Content() as $product)
                        <tr>
                            <td scope="row" class="codeProduct">{{$product->id}}</td>
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
                            <td> @if (optional($product->options)->option)
                                <p class="bg-success d-inline-block rounded text-white m-0 p-1">{{
                                    $product->options->option
                                    }}</p>
                                @else
                                <p class="bg-secondary d-inline-block rounded text-white m-0 p-1">Thường</p>
                                @endif
                            </td>
                            <td>{{number_format($product->price, 0, '.','.').'đ'}}</td>
                            <td> <input type="number" name="num-order" rowId="{{$product->rowId}}"
                                    value="{{$product ->qty}}" class="num-order form-control ms-5" style="width:60px"
                                    min="1"></td>
                            <td class="sub-total-{{$product->rowId}} sub-total">{{number_format($product ->
                                total,'0','','.')}}đ</td>
                            <td>
                                <a href="{{route('client.cart.delete',$product->rowId)}}" title=""
                                    class="del-product px-2  py-1 rounded text-white bg-danger"><i
                                        class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="wp-total-cart" class="text-end">
                    <p id="total-price" class="fl-right">Tổng giá: <span class=""><span>{{Cart::total().' VNĐ'}}</span>
                    </p>
                    <div class="pay">
                        <a href="{{route('client.cart.checkout')}}" title="" id="checkout-cart">THANH TOÁN</a>
                    </div>
                </div>
                <div id="btn-control-cart" class="py-2">
                    <p class="text-black my-2">Click vào <b>“Xóa giỏ hàng”</b> để xóa toàn bộ sản phẩm
                        trong giỏ. Nhấn vào
                        <b>“Thanh toán”</b>
                        để hoàn tất mua hàng.
                    </p>
                    <a href="{{route('home')}}" class="d-block text-decoration-underline">Mua tiếp</a>
                    <a href="{{route('client.cart.destroy')}}" class="d-block text-decoration-underline">Xóa giỏ
                        hàng</a>
                </div>
            </div>
        </div>
        @else
        <div class="cart-empty text-center pb-5">
            <a href="{{ route('home') }}" class="d-flex justify-content-center align-items-center">
                <img src="https://bizweb.dktcdn.net/100/320/202/themes/714916/assets/empty-cart.png?1650292912948"
                    alt="" width="600px">
            </a>
            <p class="mt-2">Giỏ hàng hiện tại đang không có sản phẩm nào trong giỏ hàng vui lòng click <b><a
                        href="{{ route('home') }}">vào đây</a></b> để tiếp tục mua hàng!</p>
        </div>

        @endif
    </div>
</section>
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
</script>
@endsection