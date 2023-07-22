<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Cat_product;
use App\Slider;
use App\Banner;
use App\Blog;
use FontLib\Table\Type\name;

class HomeController extends Controller
{
    function index()
    {
        // $result = '';
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
                            $result .= render_menu($data, '', 'sub-menu', $v['slug'], $v['id'], $lever + 1);
                        }
                    }
                    $result .= "</li>";
                }
            }
            $result .= "</ul>";
            return $result;
        }

        $sliders = Slider::orderBy('sort', 'asc')->get();
        $banners = Banner::orderBy('sort', 'asc')->get();
        $data = Cat_product::all();
        $render_menu =  render_menu($data, '', 'list-item');
        // return dd($render_menu);

        $featured_products = Product::where('discount', '>', 0)->get();

        $list_cat_parent = Cat_product::where('parent_id', 0)->get();

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
                // Đệ qui: Lấy sản phẩm của các danh mục con
                $subCatProducts = getProductsByParentId($cat->id);
                $productIds = array_merge($productIds, $subCatProducts->pluck('id')->toArray());
            }
            // return dd($productIds);
            $products = Product::where('status', 1)->whereIn('id', $productIds)->paginate(20);
            return $products;
        }

        function getCatParentName($catProduct)
        {
            if ($catProduct->parent_id == 0) {
                return $catProduct->name;
            } else {
                $parentCatProduct = Cat_product::find($catProduct->parent_id);
                return getCatParentName($parentCatProduct);
            }
        }

        $results = [];
        foreach ($list_cat_parent as $catParent) {
            $products =  getProductsByParentId($catParent->id);
            foreach ($products as $product) {
                $product->cat_name = getCatParentName($product->Cat_product);
                $results[] = $product;
            }
        }
        $groupedProducts = collect($results)->groupBy('cat_name');
        // return dd($groupedProducts);

        $listPostEnvironment = Blog::where('cat_parent', '19')
            ->inRandomOrder()
            ->take(2)
            ->select('name', 'thumb_main')
            ->get();
        $listPost = Blog::inRandomOrder()
            ->take(2)
            ->get();
        // return $listPost;
        return view('client.home', compact('featured_products', 'render_menu', 'sliders', 'banners', 'products', 'groupedProducts', 'listPostEnvironment', 'listPost'));
    }
}
