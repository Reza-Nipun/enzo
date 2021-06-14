<?php

namespace App\Http\Controllers\Website;

use App\Category;
use App\CompanyInfo;
use App\Http\Controllers\Controller;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Session\Session;

class OrderController extends Controller
{
    public function addToCart(Request $request)
    {
        $product_id = $request->product_id;
        $product_name = $request->product_name;
        $color_id = $request->color_id;
        $color = $request->color;
        $size_id = $request->size_id;
        $size_name = $request->size_name;
        $size_description = $request->size_description;
        $order_qty = $request->order_qty;
        $price_in_bdt = $request->price_in_bdt;

        $cart_id = $product_id.'_'.$color_id.'_'.$size_id;

        $cartData = (session()->get('cart')) ? session()->get('cart') : array();
        if (array_key_exists($cart_id, $cartData)) {
            $cartData[$cart_id]['qty'] = $order_qty;
        } else {
            $cartData[$cart_id] = array(
                'product_id' => $product_id,
                'product_name' => $product_name,
                'color_id' => $color_id,
                'color' => $color,
                'size_id' => $size_id,
                'size_name' => $size_name,
                'size_description' => $size_description,
                'qty' => $order_qty,
                'price_in_bdt' => $price_in_bdt,
            );
        }
        $request->session()->put('cart', $cartData);

        $count_cart_items = 0;
        if(session()->has('cart')){
            $cart_items = session()->get('cart');
            $count_cart_items = sizeof($cart_items);
        }

        return response()->json($count_cart_items, 200);
    }

    public function getCartList(){
        $session = new Session();
        $customer_data = array();
        $customer_data['customer_id'] = $session->get('customer_id');
        $customer_data['nick_name'] = $session->get('nick_name');
        $customer_data['email'] = $session->get('email');

        $company_info = $this->companyInfo();
        $category_list = $this->menuCategoryItems();
        $sub_category_list = $this->menuSubCategoryItems();

        $count_cart_items = 0;
        $cart_items=[];
        if(session()->has('cart')){
            $cart_items = session()->get('cart');
            $count_cart_items = sizeof($cart_items);
        }

        return view('enzo_site.cart_list', compact('title', 'category_list', 'sub_category_list', 'company_info', 'customer_data', 'count_cart_items', 'cart_items'));
    }

    public function menuCategoryItems(){
        return $category_list = Category::with(['subcategories'])->get();
    }

    public function menuSubCategoryItems(){
        return $sub_category_list = SubCategory::where('status', 1)->limit(5)->get();
    }

    public function companyInfo(){
        return $company_info = CompanyInfo::all();
    }

    static function getSingleProductImageByColor($product_id, $color){
        return $product_images = DB::select("SELECT * FROM product_images 
                                WHERE product_id=$product_id AND color_id = $color LIMIT 1");
    }

    public function removeFromCart($cart_id){
        $cartData = (session()->get('cart')) ? session()->get('cart') : array();

        if (array_key_exists($cart_id, $cartData)) {
            unset($cartData[$cart_id]);

            session()->put('cart', $cartData);
        }

        return redirect()->back();
    }
}