<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Color;
use App\Config;
use App\Product;
use App\Cat_product;

class adminProductController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }
    function list()
    {

        return view('admin.product.list');
    }

    function add(Request $request)
    {
        $colors = Color::all();
        $configs = Config::all();
        return view('admin.product.add', compact('colors', 'configs'));
    }

    function handle(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'old_price' => ['required'],
                'amount' => ['required'],
                'new_price' => ['required'],
                // 'cat' => ['required'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'unique' => 'Vai trò đã tồn tại trong hệ thống!'
            ],
            [
                'name' => 'Tên người dùng',
                'old_price' => 'Giá cũ',
                'amount' => 'Số lượng',
                'new_price' => 'Giá mới',
                // 'cat' => 'Danh mục',
            ]
        );

        return dd($request->input());
        Product::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'desc_quick' => $request->input('code'),
            'desc_detail' => $request->input('status'),
            'thumb_main' => $request->input('name'),
            'thumb_detail' => $request->input('slug'),
            'old_price' => $request->input('old_price'),
            'discount' => $request->input('discount'),
            'new_price' => $request->input('new_price'),
            'amount' => $request->input('amount'),
            'featured_products' => $request->input('status'),
            'creator' => $request->input('code'),
            'status' => $request->input('status'),
        ]);
    }

    function category()
    {
        function data_tree($data, $parent_id = 0, $lever = 0)
        {
            $result = array();
            foreach ($data as $v) {
                if ($v['parent_id'] == $parent_id) {
                    $v['lever'] = $lever;
                    $result[] = $v;
                    foreach ($data as $item) {
                        if ($item['parent_id'] == $v['id']) {
                            $result_child = data_tree($data, $v['id'], $lever + 1);
                            $result = array_merge($result, $result_child);
                        }
                    }
                }
            }
            return $result;
        }


        $categories = Cat_product::all();
        $categoryOptions = data_tree($categories);
        // return dd($categories->toArray());

        return view('admin.product.cat', compact('categoryOptions'));
    }

    function category_add(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'unique' => 'Vai trò đã tồn tại trong hệ thống!'
            ],
            [
                'name' => 'Tên danh mục',
            ]
        );

        $parentId = $request->input('parent_category') ? $request->input('parent_category') : 0;
        Cat_product::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'parent_id' => $parentId,
            'creator' => session('userID'),
            'status' => $request->input('status'),
        ]);
        return redirect('admin/product/cat')->with('status', '▶Đã thêm danh mục thành công!');
    }




    function cat_delete(Cat_product $cat)
    {
        $cat_products = Cat_product::all();
        $cat->delete();
        $cat_products->where('parent_id', $cat->id)->each(function ($item) {
            $item->delete();
        });
        return redirect('admin/product/cat')->with('status', '▶Đã xóa danh mục!');
    }


    function color()
    {
        $colors = Color::all();

        return view('admin.product.color', compact('colors'));
    }

    function edit(Color $color)
    {
        $colors = Color::all();
        return view('admin.product.color_edit', compact('colors', 'color'));
    }

    function color_add(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:colors'],
                'slug' => ['required', 'string', 'max:20'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự',
                'unique' => ':attribute đã tồn tại trong cơ sở dữ liệu!',
            ],
            [
                'name' => 'Màu sắc',
                'slug' => 'Slug',
            ]
        );

        Color::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'code' => $request->input('code'),
            'status' => $request->input('status'),
        ]);
        // return dd($request->input());

        return redirect('admin/product/color')->with('status', '▶Đã thêm màu sắc thành công!');
    }

    function color_update(Request $request, Color $color)
    {
        $color->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'code' => $request->input('code'),
            'status' => $request->input('status'),
        ]);
        return redirect('admin/product/color')->with('status', '▶Cập nhật màu sắc thành công!');
    }

    function config(Request $request)
    {
        $configs = Config::all();
        return view('admin.product.config', compact('configs'));
    }

    function config_add(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:configs'],
                'storage' => ['required', 'string', 'max:20'],
                'price' => ['required', 'string', 'max:20'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự',
                'unique' => ':attribute đã tồn tại trong cơ sở dữ liệu!',
            ],
            [
                'name' => 'Màu sắc',
                'storage' => 'Khả năng lữu trữ',
                'price' => 'Giá tiền'
            ]
        );

        // return $request->input();
        Config::create([
            'name' => $request->input('name'),
            'memory' => $request->input('storage'),
            'price' => $request->input('price'),
            'status' => $request->input('status')
        ]);
        return redirect('admin/product/config')->with('status', '▶Đã thêm cấu hình thành công!');
    }

    function config_edit(Config $config)
    {
        $configs = Config::all();
        return view('admin.product.config_edit', compact('config', 'configs'));
    }

    function config_update(Request $request, Config $config)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:configs,name,' . $config->id],
                'storage' => ['required', 'string', 'max:20'],
                'price' => ['required', 'string', 'max:20'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự',
                'unique' => ':attribute đã tồn tại trong cơ sở dữ liệu!',
            ],
            [
                'name' => 'Màu sắc',
                'storage' => 'Khả năng lữu trữ',
                'price' => 'Giá tiền'
            ]
        );

        // return $request->input();
        $config->update([
            'name' => $request->input('name'),
            'memory' => $request->input('storage'),
            'price' => $request->input('price'),
            'status' => $request->input('status')
        ]);
        return redirect('admin/product/config')->with('status', '▶Đã cập nhật thành công!');
    }

    function config_delete(Config $config)
    {
        $config->delete();
        return redirect()->route('product.config')->with('status', 'Đã xóa cấu hình!');
    }
}