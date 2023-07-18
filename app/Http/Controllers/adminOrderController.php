<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class adminOrderController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
            return $next($request);
        });
    }
    function index()
    {
        $orders = Order::orderBy('id', 'asc')->paginate(10);
        return view('admin.order.list', compact('orders'));
    }

    function detail(Order $order)
    {
        // return $order;
        // return json_decode($order->product, true);
        $method_pay = $order->method_pay == 0 ? 'Thanh toán tại nhà' : 'Thanh toán tại cửa hàng';
        $total = number_format($order->total, 0, '', '.') . ' VNĐ';
        $note = $order->note == '' ? 'Không có ghi chú nào!' : $order->note;
        $data = array(
            'fullname' => $order->fullname,
            'address' => $order->address,
            'phone' => $order->phone,
            'note' => $note,
            'email' => $order->email,
            'amount' => $order->amount,
            'total' => $total,
            'method_pay' => $method_pay,
            'code_bill' => $order->code_bill,
            'progress' => $order->progress,
            'product' => json_decode($order->product, true),
            'created_at' => $order->created_at,
        );
        echo json_encode($data);
    }
}
