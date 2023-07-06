<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Config;
use App\Product;
use App\Cat_product;
use App\User;
use App\Color;

class adminProductController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }

    function data_tree($data, $parent_id = 0, $lever = 0)
    {
        $result = array();
        foreach ($data as $v) {
            if ($v['parent_id'] == $parent_id) {
                $v['lever'] = $lever;
                $result[] = $v;
                foreach ($data as $item) {
                    if ($item['parent_id'] == $v['id']) {
                        $result_child = $this->data_tree($data, $v['id'], $lever + 1);
                        $result = array_merge($result, $result_child);
                    }
                }
            }
        }
        return $result;
    }

    function list()
    {
        $products = Product::orderBy('id', 'desc')->paginate(15);
        return view('admin.product.list', compact('products'));
    }

    function add()
    {
        $colors = Color::all();
        $configs = Config::all();

        $categories = Cat_product::all();
        $categoryOptions = $this->data_tree($categories);
        // return dd($categoryOptions);
        return view('admin.product.add', compact('colors', 'configs', 'categoryOptions'));
    }

    function handle_add(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:products'],
            'old_price' => ['required'],
            'slug' => ['required', 'unique:products'],
            'amount' => ['required'],
            'cat_id' => ['required'],
            'new_price' => ['required'],
            'file' => ['required', 'max:5242880', 'image'],
        ], [
            'required' => ':attribute không được để trống!',
            'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
            'max' => ':attribute có độ dài lớn nhất :max ký tự!',
            'unique' => ':attribute đã tồn tại trong hệ thống!',
            'image' => ':attribute phải là một hình ảnh',
            'mimes' => ':attribute phải có định dạng jpg, png, jpeg, gif',
        ], [
            'name' => 'Tên sản phẩm',
            'slug' => 'Slug',
            'old_price' => 'Giá cũ',
            'amount' => 'Số lượng',
            'new_price' => 'Giá mới',
            'file' => 'Ảnh chính',
            'cat_id' => 'Danh mục cha'
        ]);

        // return dd($request->input());

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $fileName = $file->getClientOriginalName();
                session(['file' => $fileName]);
                $destinationPath = 'public/uploads';
                $file->move($destinationPath, $fileName);
            } else {
                echo 'Ảnh không hợp lệ';
            }
        }

        $result = [];
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $image) {
                if ($image->isValid()) {
                    $fileNameDetail = $image->getClientOriginalName();
                    $destinationPath = 'public/uploads';
                    $image->move($destinationPath, $fileNameDetail);
                    $result[] = "uploads/" . $fileNameDetail;
                } else {
                    $result;
                    echo 'Ảnh không hợp lệ';
                }
            }
        }

        // return dd($request->input());
        if ($result) {
            $thumb_detail = json_encode($result);
        } else {
            $thumb_detail = '';
        }
        $featured_products = $request->input('featured_products') ? 1 : 0;
        $product = Product::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'desc_quick' => $request->input('des_quick'),
            'desc_detail' => $request->input('des_detail'),
            'thumb_main' => 'uploads/' . $fileName,
            'thumb_detail' => $thumb_detail,
            'creator' => session('userID'),
            'discount' => $request->input('discount'),
            'amount' => $request->input('amount'),
            'old_price' => $request->input('old_price'),
            'new_price' => $request->input('new_price'),
            'cat_id' => $request->input('cat_id'),
            'featured_products' => $featured_products,
            'status' => $request->input('status'),
        ]);

        $product->colors()->attach($request->input('color'));
        if (!empty($config)) {
            $config = $request->input('config');
            $priceInput = $request->input('priceInput');
            $selectedConfigs = [];
            foreach ($config as $kConfig => $vConfig) {
                if ($priceInput[$kConfig] == null) {
                    unset($config[$kConfig]);
                    continue;
                }
                $selectedConfigs[] = $vConfig;
            }
            foreach ($selectedConfigs as $kConfig => $vConfig) {
                $product->configs()->attach($vConfig, ['price' => $priceInput[$kConfig]]);
            }
        }
        $product->code = 'TQ#' . $product->id;
        $product->save();
        toastr()->success('Đã thêm sản phẩm thành công!');
        return redirect('admin/product/add');
    }

    function product_edit(Product $product)
    {
        $status0 = $product->status == 0;
        $status1 = $product->status == 1;
        $colors = Color::all();
        $configs = Config::all();
        $categories = Cat_product::all();
        $categoryOptions = $this->data_tree($categories);
        $thumb_detail = json_decode($product->thumb_detail);
        // return dd($product);

        return view('admin.product.update', compact('thumb_detail', 'product', 'colors', 'configs', 'categoryOptions', 'status0', 'status1'));
    }

    function product_update(Request $request, Product $product)
    {
        // return dd($request->input());
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:products,name,' . $product->id],
            'slug' => ['required', 'unique:products,slug,' . $product->id],
            'old_price' => ['required'],
            'amount' => ['required'],
            'cat_id' => ['required'],
            'new_price' => ['required'],
        ], [
            'required' => ':attribute không được để trống!',
            'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
            'max' => ':attribute có độ dài lớn nhất :max ký tự!',
            'unique' => ':attribute đã tồn tại trong hệ thống!',
            'image' => ':attribute phải là một hình ảnh',
            'mimes' => ':attribute phải có định dạng jpg, png, jpeg, gif',
        ], [
            'name' => 'Tên sản phẩm',
            'slug' => 'Slug',
            'old_price' => 'Giá cũ',
            'amount' => 'Số lượng',
            'new_price' => 'Giá mới',
            'cat_id' => 'Danh mục cha'
        ]);

        $fileName = '';
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $fileName = $file->getClientOriginalName();
                session(['file' => $fileName]);
                $destinationPath = 'public/uploads';
                $file->move($destinationPath, $fileName);
            } else {
                echo 'Ảnh không hợp lệ';
            }
        }

        $result = [];
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $image) {
                if ($image->isValid()) {
                    $fileNameDetail = $image->getClientOriginalName();
                    $destinationPath = 'public/uploads';
                    $image->move($destinationPath, $fileNameDetail);
                    $result[] = "uploads/" . $fileNameDetail;
                } else {
                    $result;
                    echo 'Ảnh không hợp lệ';
                }
            }
        }

        if ($result) {
            $thumb_detail = json_encode($result);
        } else {
            $thumb_detail = '';
        }
        if ($fileName && $thumb_detail) {
            $featured_products = $request->input('featured_products') ? 1 : 0;
            $product->update([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'desc_quick' => $request->input('des_quick'),
                'desc_detail' => $request->input('des_detail'),
                'thumb_main' => 'uploads/' . $fileName,
                'thumb_detail' => $thumb_detail,
                'discount' => $request->input('discount'),
                'amount' => $request->input('amount'),
                'old_price' => $request->input('old_price'),
                'new_price' => $request->input('new_price'),
                'cat_id' => $request->input('cat_id'),
                'featured_products' => $featured_products,
                'status' => $request->input('status'),
            ]);
        } elseif ($fileName) {
            $featured_products = $request->input('featured_products') ? 1 : 0;
            $product->update([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'desc_quick' => $request->input('des_quick'),
                'desc_detail' => $request->input('des_detail'),
                'thumb_main' => 'uploads/' . $fileName,
                'discount' => $request->input('discount'),
                'amount' => $request->input('amount'),
                'old_price' => $request->input('old_price'),
                'new_price' => $request->input('new_price'),
                'cat_id' => $request->input('cat_id'),
                'featured_products' => $featured_products,
                'status' => $request->input('status'),
            ]);
        } elseif ($thumb_detail) {
            $featured_products = $request->input('featured_products') ? 1 : 0;
            $product->update([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'desc_quick' => $request->input('des_quick'),
                'desc_detail' => $request->input('des_detail'),
                'thumb_detail' => $thumb_detail,
                'discount' => $request->input('discount'),
                'amount' => $request->input('amount'),
                'old_price' => $request->input('old_price'),
                'new_price' => $request->input('new_price'),
                'cat_id' => $request->input('cat_id'),
                'featured_products' => $featured_products,
                'status' => $request->input('status'),
            ]);
        } else {
            $featured_products = $request->input('featured_products') ? 1 : 0;
            $product->update([
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'desc_quick' => $request->input('des_quick'),
                'desc_detail' => $request->input('des_detail'),
                'discount' => $request->input('discount'),
                'amount' => $request->input('amount'),
                'old_price' => $request->input('old_price'),
                'new_price' => $request->input('new_price'),
                'cat_id' => $request->input('cat_id'),
                'featured_products' => $featured_products,
                'status' => $request->input('status'),
            ]);
        }
        // $product->save();
        $product->colors()->sync($request->input('color'));

        $config = $request->input('config');
        $priceInput = $request->input('priceInput');

        if (!empty($config)) {
            $syncData = [];
            foreach ($config as $kConfig => $vConfig) {
                if ($priceInput[$kConfig] == null) {
                    unset($config[$kConfig]);
                    continue;
                }
                $syncData[$vConfig] = ['price' => $priceInput[$kConfig]];
            }
            $product->configs()->sync($syncData);
        }
        toastr()->success('Cập nhật sản phẩm thành công!');
        return redirect()->route('product.edit', $product->id);
    }

    function category()
    {
        $categories = Cat_product::all();
        $categoryOptions = $this->data_tree($categories);
        // return dd($categories->toArray());

        return view('admin.product.cat', compact('categoryOptions'));
    }

    function category_add(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'slug' => ['required'],
            ],
            [
                'required' => ':attribute không được để trống!',
                'string' => 'Dữ liệu nhập vào phải là một chuỗi!',
                'max' => ':attribute có độ dài lớn nhất :max ký tự!',
                'unique' => 'Vai trò đã tồn tại trong hệ thống!'
            ],
            [
                'name' => 'Tên danh mục',
                'slug' => 'Slug',
            ]
        );

        $parentId = $request->input('parent_category') ? $request->input('parent_category') : 0;
        Cat_product::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'parent_id' => $parentId,
            'creator' => session('userID'),
            'status' => $request->input('status'),
        ]);
        toastr()->success('Đã thêm danh mục thành công!');
        return redirect('admin/product/cat');
    }

    function cat_edit(Cat_product $cat)
    {
        $categories = Cat_product::all();
        $categoryOptions = $this->data_tree($categories);
        $creator = getFieldbyID(User::class, 'name', $cat->creator);
        $data = array(
            'id' => $cat->id,
            'name' => $cat->name,
            'slug' => $cat->slug,
            'parent_id' => $cat->parent_id,
            'status' => $cat->status,
            'creator' => $creator,
            'dataTree' => $categoryOptions,
            'created_at' => $cat->created_at,
            'updated_at' => $cat->updated_at,
        );
        echo json_encode($data);
    }

    function cat_update(Request $request, Cat_product $cat)
    {
        $parentId = $request->input('parent_category') ?  $request->input('parent_category') : 0;

        $cat->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'parent_id' => $parentId,
            'status' => $request->input('status'),
        ]);
        toastr()->success('Cập nhật thành công!');
        return redirect('admin/product/cat');
    }

    function cat_delete(Cat_product $cat)
    {
        $cat_products = Cat_product::all();
        $cat->delete();
        $cat_products->where('parent_id', $cat->id)->each(function ($item) {
            $item->delete();
        });
        toastr()->success('Đã xóa danh mục!');
        return redirect('admin/product/cat');
    }


    function color()
    {
        $colors = Color::all();

        return view('admin.product.color', compact('colors'));
    }

    function edit(Color $color)
    {
        $creator = getFieldbyID(User::class, 'name', $color->creator);
        $data = array(
            'id' => $color->id,
            'name' => $color->name,
            'slug' => $color->slug,
            'code' => $color->code,
            'creator' => $creator,
            'status' => $color->status,
            'created_at' => $color->created_at,
            'updated_at' => $color->updated_at,
        );
        echo json_encode($data);
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
            'creator' => session('userID'),
            'status' => $request->input('status'),
        ]);
        // return dd($request->input());
        toastr()->success('Đã thêm màu sắc thành công!');
        return redirect('admin/product/color');
    }

    function color_update(Request $request, Color $color)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:colors,name,' . $color->id],
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
        $color->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'code' => $request->input('code'),
            'status' => $request->input('status'),
        ]);
        toastr()->success('Cập nhật màu sắc thành công!');
        return redirect('admin/product/color');
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
                'slug' => ['required'],
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
                'slug' => 'Slug',
                'storage' => 'Khả năng lữu trữ',
                'price' => 'Giá tiền'
            ]
        );

        // return $request->input();
        Config::create([
            'name' => $request->input('name'),
            'memory' => $request->input('storage'),
            'creator' => session('userID'),
            'price' => $request->input('price'),
            'status' => $request->input('status')
        ]);
        toastr()->success('Đã thêm cấu hình thành công!');
        return redirect('admin/product/config');
    }

    function config_edit(Config $config)
    {
        $creator = getFieldbyID(User::class, 'name', $config->creator);
        $data = array(
            'id' => $config->id,
            'name' => $config->name,
            'price' => $config->price,
            'storage' => $config->memory,
            'creator' => $creator,
            'status' => $config->status,
            'created_at' => $config->created_at,
            'updated_at' => $config->updated_at,
        );
        echo json_encode($data);
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
        toastr()->success('Cập nhật thành công!');

        return redirect('admin/product/config');
    }

    function config_delete(Config $config)
    {
        $config->delete();
        toastr()->success('Đã xóa cấu hình!');
        return redirect()->route('product.config');
    }

    function color_delete(Color $color)
    {
        $color->delete();
        toastr()->success('Đã xóa màu sắc!');
        return redirect()->route('product.color');
    }
}
