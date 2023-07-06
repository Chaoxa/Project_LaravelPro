<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

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
                'id' => $product->code,
                'name' => $product->name,
                'qty' => $qty,
                'price' => $price,
                'options' => ['thumb_main' => $product->thumb_main, 'slug' => $product->slug, 'option' => $product->configs->find($optionId)->name]
            ]);
        } else {
            $price = $product->new_price;
            Cart::add([
                'id' => $product->code,
                'name' => $product->name,
                'qty' => $qty,
                'price' => $price,
                'options' => ['thumb_main' => $product->thumb_main, 'slug' => $product->slug,]
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
}
