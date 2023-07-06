<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Cat_product;
use App\Banner;
use App\Config;

class ProductController extends Controller
{
    function render_menu($data, $menu_id = 'main-menu', $menu_class = '', $slug_parent = '', $parent_id = 0, $lever = 0)
    {
        if ($lever == 0) {
            $result = "<ul id='{$menu_id}' class='{$menu_class}'>";
        } else {
            $result = "<ul class='sub-menu'>";
        }
        foreach ($data as $v) {
            if ($v['parent_id'] == $parent_id) {
                $result .= "<li>";
                $result .= "<a href='" . route('client.product.cat', ['slug' => $v['slug']]) . "'>" . $v['name'] . "</a>";
                $v['lever'] = $lever;
                foreach ($data as $item) {
                    if ($item['parent_id'] == $v['id']) {
                        $result .= $this->render_menu($data, '', 'sub-menu', $v['slug'], $v['id'], $lever + 1);
                    }
                }
                $result .= "</li>";
            }
        }
        $result .= "</ul>";
        return $result;
    }

    function list_product()
    {
        $data = Cat_product::all();
        $render_menu =  $this->render_menu($data, '', 'list-item');
        $banners = Banner::orderBy('sort', 'asc')->get();
        $products = Product::paginate(10);
        $cat_name = 'Sản phẩm';
        return view('client.product.cat', compact('products', 'cat_name', 'render_menu', 'banners'));
    }

    function product_detail($slug)
    {
        // return $slug;
        $data = Cat_product::all();
        $render_menu =  $this->render_menu($data, '', 'list-item');

        $banners = Banner::orderBy('sort', 'asc')->get();
        $product = Product::where('slug', $slug)->first();
        $configs = $product->configs()->get();
        // return dd($configs);
        $thumb_detail = json_decode($product->thumb_detail);
        $product->increment('views');
        return view('client.product.detail', compact('product', 'banners', 'thumb_detail', 'render_menu', 'configs'));
    }

    function product_option(Request $request)
    {
        $idOption = $request->input('idOption');
        $idProduct = $request->input('id');
        $product = Product::find($idProduct);
        $configs = $product->configs()->get();
        $price =  number_format($configs->find($idOption)->pivot->price, 0, '.', '.') . ' VNĐ';
        $data = array(
            'price' => $price,
        );
        echo json_encode($data);
    }

    function product_cat($slug)
    {
        $data = Cat_product::all();
        $render_menu =  $this->render_menu($data, '', 'list-item');

        function getProductsByParentId($cat_parent_id)
        {
            $catIds = [$cat_parent_id];
            // return dd($catIds);
            $list_cat = Cat_product::whereIn('parent_id', $catIds)->get();
            if ($list_cat->count() == 0) {
                return Product::where('cat_id', $cat_parent_id)->paginate(20);
            }

            $productIds = [];
            foreach ($list_cat as $cat) {
                // $productIds = array_merge($productIds, $cat->products->pluck('id')->toArray());
                // Đệ qui: Lấy sản phẩm của các danh mục con
                $subCatProducts = getProductsByParentId($cat->id);
                $productIds = array_merge($productIds, $subCatProducts->pluck('id')->toArray());
            }
            // return dd($productIds);
            $products = Product::whereIn('id', $productIds)->paginate(20);
            return $products;
        }
        $banners = Banner::orderBy('sort', 'asc')->get();
        $cat_product = Cat_product::where('slug', $slug)->first();
        $cat_name = $cat_product->name;
        $products = getProductsByParentId($cat_product->id);
        // return dd($products);

        return view('client.product.cat', compact('products', 'cat_name', 'render_menu', 'banners'));
    }
}
