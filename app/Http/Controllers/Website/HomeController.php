<?php

namespace App\Http\Controllers\Website;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductColor;
use App\ProductImage;
use App\ProductSize;
use App\ProductSpecification;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $category_list = $this->menuCategoryItems();
        $sub_category_list = $this->menuSubCategoryItems();

        $new_products = Product::orderBy('id', 'desc')->take(8)->get();

        return view('enzo_site.home', compact('category_list', 'sub_category_list', 'new_products'));
    }

    public function menuCategoryItems(){
        return $category_list = Category::with(['subcategories'])->get();
    }

    public function menuSubCategoryItems(){
        return $sub_category_list = SubCategory::where('status', 1)->limit(5)->get();
    }

    static function getProductsBySubcategoryId($sub_cat_id, $limit){
        return $new_products = Product::where('sub_category_id', $sub_cat_id)->orderBy('id', 'desc')->take($limit)->get();
    }

    public function getProductsById(Request $request){
        $product_id = $request->product_id;

        $product_info = DB::select("SELECT t1.*, t2.id AS color_id, t2.color, t2.color_code, t3.image_url
                        FROM (SELECT * FROM `products` WHERE id=$product_id) AS t1
                        
                        LEFT JOIN
                        (SELECT * FROM `product_colors` WHERE status=1) AS t2
                        ON t1.id=t2.product_id
                               
                        LEFT JOIN
                        (SELECT * FROM `product_images` WHERE product_id=$product_id LIMIT 1) AS t3
                        ON t1.id=t3.product_id");

        return response()->json($product_info, 200);
    }

    public function getProductImages(Request $request){
        $product_id = $request->product_id;
        $color_id = $request->color_id;

        $product_images = DB::select("SELECT * FROM `product_images` WHERE product_id=$product_id AND color_id=$color_id");

        return response()->json($product_images, 200);
    }

    public function viewSingleProduct($id=null, $color_id=null){
        $category_list = $this->menuCategoryItems();
        $sub_category_list = $this->menuSubCategoryItems();

        $product_info = Product::find($id);
        $product_colors = ProductColor::where('product_id', $id)->where('status', 1)->get();

        if($color_id == null){
            $product_images = DB::select("SELECT * FROM product_images 
                            WHERE product_id=$id 
                            AND color_id = (SELECT color_id FROM `product_images` 
                            WHERE product_id=$id GROUP BY color_id LIMIT 1)");
        }else{
            $product_images = DB::select("SELECT * FROM product_images 
                            WHERE product_id=$id 
                            AND color_id = $color_id");
        }


        $product_sizes = ProductSize::where('product_id', $id)->where('status', 1)->get();
        $product_specifications = ProductSpecification::where('product_id', $id)->where('status', 1)->get();

        return view('enzo_site.single_product', compact('category_list', 'sub_category_list', 'product_info', 'product_colors', 'product_images', 'product_sizes', 'product_specifications'));
    }
}