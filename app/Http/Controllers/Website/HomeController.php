<?php

namespace App\Http\Controllers\Website;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\SubCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

        $category_list = Category::with(['subcategories'])->get();
        $sub_category_list = SubCategory::where('status', 1)->limit(5)->get();
        $new_products = Product::orderBy('id', 'desc')->take(8)->get();

        return view('enzo_site.home', compact('category_list', 'sub_category_list', 'new_products'));
    }

    static function getProductsBySubcategoryId($sub_cat_id, $limit){
        return $new_products = Product::where('sub_category_id', $sub_cat_id)->orderBy('id', 'desc')->take($limit)->get();
    }
}
