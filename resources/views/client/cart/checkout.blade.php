@extends('layouts.client')
@section('content')
<div id="main-content-wp" class="checkout-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="?page=home" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Thanh toán</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="wrapper" class="wp-inner clearfix">
        {!! Form::open(['route' => 'client.cart.checkoutHandle', 'method' => 'POST', 'name' =>
        'form-checkout']) !!}
        <div class="section" id="customer-info-wp">
            <div class="section-head">
                <h1 class="section-title">Thông tin khách hàng</h1>
            </div>
            <div class="section-detail">
                <div class="form-row clearfix">
                    <div class="form-col fl-left">
                        {!! Form::label('fullname', 'Họ tên') !!}
                        {!! Form::text('fullname', null, ['id' => 'fullname']) !!}
                        @error('fullname')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-col fl-right">
                        {!! Form::label('email', 'Email') !!}
                        {!! Form::email('email', null, ['id' => 'email']) !!}
                        @error('email')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-row clearfix">
                    <div class="form-col fl-left">
                        {!! Form::label('address', 'Địa chỉ') !!}
                        {!! Form::text('address', null, ['id' => 'address']) !!}
                        @error('address')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-col fl-right">
                        {!! Form::label('phone', 'Số điện thoại') !!}
                        {!! Form::tel('phone', null, ['id' => 'phone']) !!}
                        @error('phone')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        {!! Form::label('notes', 'Ghi chú') !!}
                        {!! Form::textarea('note') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="section" id="order-review-wp">
            <div class="section-head">
                <h1 class="section-title">Thông tin đơn hàng</h1>
            </div>
            <div class="section-detail">
                <table class="shop-table">
                    <thead>
                        <tr>
                            <td>Sản phẩm</td>
                            <td>Tổng</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="cart-item">
                            <td class="product-name">Son môi nữ cá tính<strong class="product-quantity">x 1</strong>
                            </td>
                            <td class="product-total">350.000đ</td>
                        </tr>
                        <tr class="cart-item">
                            <td class="product-name">Đồ tẩy trang nhập khẩu Mỹ<strong class="product-quantity">x
                                    2</strong></td>
                            <td class="product-total">500.000đ</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="order-total">
                            <td>Tổng đơn hàng:</td>
                            <td><strong class="total-price">800.000đ</strong></td>
                        </tr>
                    </tfoot>
                </table>
                <div id="payment-checkout-wp">
                    <ul id="payment_methods">
                        <li>
                            <input type="radio" id="payment-home" checked name="payment-method" value="0">
                            <label for="payment-home">Thanh toán tại nhà</label>
                        </li>
                        <li>
                            <input type="radio" id="direct-payment" name="payment-method" value="1">
                            <label for="direct-payment">Thanh toán tại cửa hàng</label>
                        </li>
                    </ul>
                </div>
                <div class="place-order-wp clearfix">
                    <input type="submit" id="order-now" value="Đặt hàng">
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection