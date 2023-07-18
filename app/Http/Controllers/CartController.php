<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Carbon\Carbon;

class CartController extends Controller
{
    function index()
    {
        return view('client.cart.list');
    }

    function add(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();
        // return $request->input();
        $qty =   $request->input('num-order') ?  $request->input('num-order') : 1;
        if (!empty($request->input('selected_option_id'))) {
            $optionId = $request->input('selected_option_id');
            $price = $product->configs->find($optionId)->pivot->price;
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $qty,
                'price' => $price,
                'options' => ['thumb_main' => $product->thumb_main, 'slug' => $product->slug, 'code' => $product->code, 'option' => $product->configs->find($optionId)->name]
            ]);
        } else {
            $price = $product->new_price;
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $qty,
                'price' => $price,
                'options' => ['thumb_main' => $product->thumb_main, 'slug' => $product->slug, 'code' => $product->code]
            ]);
        }

        // return Cart::content();
        return redirect()->route('client.cart.show');
    }

    function update_ajax(Request $request)
    {
        $rowId = $request->input('rowId');
        $qty = $request->input('qty');

        Cart::update($rowId, $qty);
        $sub_total = Cart::get($rowId)->subtotal();
        $total = Cart::total();
        $data = array(
            'sub_total' => $sub_total . 'đ',
            'total' => $total . 'đ'
        );
        echo json_encode($data);
    }

    function delete($rowId)
    {
        Cart::remove($rowId);
        toastr()->success('Đã xóa sản phẩm khỏi giỏ hàng!');
        return redirect()->route('client.cart.show');
    }

    function destroy()
    {
        Cart::destroy();
        toastr()->success('Đã xóa bỏ toàn bộ giỏ hàng!');
        return redirect()->route('client.cart.show');
    }

    function checkout()
    {
        return view('client.cart.checkout');
    }

    function checkoutHandle(Request $request)
    {
        $request->validate(
            [
                'fullname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email'],
                'address' => ['required'],
                'phone' => ['required', 'numeric'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'email' => 'Đây phải là một email!',
                'phone' => 'Hãy nhập vào là số điện thoại!'
            ],
            [
                'fullname' => 'Họ tên',
                'email' => 'Email',
                'address' => 'Địa chỉ',
                'phone' => 'Số điện thoại',
            ]
        );
        // return $request->input();
        $currentDateTime = Carbon::now();
        $code_bill = 'bill#' . $currentDateTime->format('dHis');
        $cart_json = Cart::content();
        $total_cart = str_replace('.', "", Cart::total());
        $cart_qty = Cart::count();
        $data = array(
            'fullname' => $request->input('fullname'),
            'email'   => $request->input('email'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'method_pay' => $request->input('payment-method'),
            'note' => $request->input('note'),
            'product' => $cart_json,
            'code_bill' => $code_bill,
            'total' => $total_cart,
            'amount' =>  $cart_qty
        );
        Order::create($data);
        // return Cart::content();
    }
}
