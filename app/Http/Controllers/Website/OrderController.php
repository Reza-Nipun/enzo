<?php

namespace App\Http\Controllers\Website;

use App\Category;
use App\CompanyInfo;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use App\ProductReview;
use App\ProductStock;
use App\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Session\Session;

class OrderController extends Controller
{
    public function addToCart(Request $request)
    {
        $session = new Session();
        $customer_id = $session->get('customer_id');

        if($customer_id != ''){
            $product_id = $request->product_id;
            $product_name = $request->product_name;
            $color_id = $request->color_id;
            $color = $request->color;
            $size_id = $request->size_id;
            $size_name = $request->size_name;
            $size_description = $request->size_description;
            $order_qty = $request->order_qty;
            $price_in_bdt = $request->price_in_bdt;

            $product_stock = ProductStock::where('product_id', $product_id)->where('color_id', $color_id)->where('size_id', $size_id)->get();

            if((sizeof($product_stock) > 0) && $product_stock[0]->quantity > 0){

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
            }else{
                return response()->json('na', 200);
            }

        }else{

            return response()->json('failed', 200);

        }

    }

    public function getCartList(){
        $title = "ENZO | Cart List";

        $session = new Session();
        $customer_data = array();
        $customer_data['customer_id'] = $session->get('customer_id');
        $customer_data['nick_name'] = $session->get('nick_name');
        $customer_data['email'] = $session->get('email');

        $customer_id = $session->get('customer_id');
        $customer_info = Customer::find($customer_id);

        $company_info = $this->companyInfo();
        $category_list = $this->menuCategoryItems();
        $sub_category_list = $this->menuSubCategoryItems();

        $count_cart_items = 0;
        $cart_items=[];
        if(session()->has('cart')){
            $cart_items = session()->get('cart');
            $count_cart_items = sizeof($cart_items);
        }

        $mytime = Carbon::now();
        $now_dt_time = $mytime->toDateTimeString();
        $invoice_part_nowdatetime = Carbon::parse($now_dt_time)->format('YmdHis');

        $invoice_no = $customer_id.$invoice_part_nowdatetime;

        return view('enzo_site.cart_list', compact('title', 'category_list', 'sub_category_list', 'company_info', 'customer_data', 'count_cart_items', 'cart_items', 'invoice_no', 'customer_info'));
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

    public function placeOrder(Request $request){
        $session = new Session();
        $customer_id = $session->get('customer_id');

        $product_ids = $request->product_id;
        $color_ids = $request->color_id;
        $size_ids = $request->size_id;
        $quantitys = $request->quantity;
        $prices = $request->price;

        $invoice_no = $request->invoice_no;
        $total_amount = $request->total_amount;
        $shipment_charge = $request->shipment_charge;
        $vat_amount = $request->vat_amount;
        $net_amount = $request->net_amount;

        $contact_person_name = $request->contact_person_name;
        $contact_person_contact_no = $request->contact_person_contact_no;
        $contact_person_email = $request->contact_person_email;
        $contact_person_shipping_address = $request->contact_person_shipping_address;

        $is_invoice_no_exist = Order::where('invoice_no', $invoice_no)->get();

        if(sizeof($is_invoice_no_exist) == 0){
            $order = new Order();
            $order->invoice_no = $invoice_no;
            $order->customer_id = $customer_id;
            $order->total_amount = $total_amount;
            $order->shipment_charge = $shipment_charge;
            $order->vat_amount = $vat_amount;
            $order->net_amount = $net_amount;
            $order->payment_type = 2;
            $order->payment_status = 1;
            $order->status = 1;
            $order->contact_person_name = $contact_person_name;
            $order->contact_person_contact_no = $contact_person_contact_no;
            $order->contact_person_email = $contact_person_email;
            $order->contact_person_shipping_address = $contact_person_shipping_address;
            $order->save();

            $order_id = $order->id;

            foreach ($product_ids as $k => $product_id){

                $order_detail = new OrderDetail();

                $order_detail->order_id = $order_id;
                $order_detail->customer_id = $customer_id;
                $order_detail->product_id = $product_id;
                $order_detail->color_id = $color_ids[$k];
                $order_detail->size_id = $size_ids[$k];
                $order_detail->quantity = $quantitys[$k];
                $order_detail->price = $prices[$k];
                $order_detail->status = 0;
                $order_detail->save();
            }

            $email = $session->get('email');

            $data = array(
                'name' => $session->get('nick_name'),
                'invoice_no' => $invoice_no
            );

            Mail::send('emails.order_confirmation_email', $data, function($message) use($email, $invoice_no)
            {
                $message
                    ->to($email)
                    ->subject("Your Order#$invoice_no is placed successful!");
            });

            session()->forget('cart');

            \Session::flash('message', "Your order is successfully placed! Order No: $invoice_no");
        }else{
            \Session::flash('invalid_order_msg', "Invalid Order Request!");
        }

        return redirect()->back();
    }

    public function myOrders(){
        $title = "ENZO | Order History";

        $session = new Session();
        $customer_id = $session->get('customer_id');

        $session = new Session();
        $customer_data = array();
        $customer_data['customer_id'] = $session->get('customer_id');
        $customer_data['nick_name'] = $session->get('nick_name');
        $customer_data['email'] = $session->get('email');

        $company_info = $this->companyInfo();
        $category_list = $this->menuCategoryItems();
        $sub_category_list = $this->menuSubCategoryItems();

        $count_cart_items = 0;
        if(session()->has('cart')){
            $cart_items = session()->get('cart');
            $count_cart_items = sizeof($cart_items);
        }

        $orders = Order::where('customer_id', $customer_id)->orderBy('id', 'DESC')->paginate(15);

        return view('enzo_site.order_list', compact('title', 'category_list', 'sub_category_list', 'company_info', 'customer_data', 'count_cart_items', 'orders'));
    }

    public function orderDetail($invoice_no){
        $title = "ENZO | Order Detail";

        $session = new Session();
        $customer_id = $session->get('customer_id');

        $session = new Session();
        $customer_data = array();
        $customer_data['customer_id'] = $session->get('customer_id');
        $customer_data['nick_name'] = $session->get('nick_name');
        $customer_data['email'] = $session->get('email');

        $company_info = $this->companyInfo();
        $category_list = $this->menuCategoryItems();
        $sub_category_list = $this->menuSubCategoryItems();

        $count_cart_items = 0;
        if(session()->has('cart')){
            $cart_items = session()->get('cart');
            $count_cart_items = sizeof($cart_items);
        }

        $orders = Order::where('invoice_no', $invoice_no)->get();
        $order_id = $orders[0]->id;

        $order_detail = DB::select("SELECT t1.*, t1.id as order_id, t2.*, t3.product_name, t3.product_code, t4.color, 
                                    t5.size, t5.size_description, t6.image_url, t7.review_description, t7.rating
                                    FROM 
                                    (SELECT * FROM `orders` WHERE id=$order_id) AS t1
                                    
                                    JOIN
                                    order_details AS t2
                                    ON t1.id=t2.order_id
                                    
                                    JOIN
                                    products AS t3
                                    ON t2.product_id = t3.id
                                    
                                    JOIN
                                    product_colors AS t4
                                    ON t2.color_id = t4.id
                                    
                                    JOIN
                                    product_sizes AS t5
                                    ON t2.size_id = t5.id
                                    
                                    JOIN
                                    (SELECT * FROM product_images GROUP BY product_id, color_id) AS t6
                                    ON t2.product_id=t6.product_id AND t2.color_id = t6.color_id
                                    
                                    LEFT JOIN 
                                    product_reviews AS t7
                                    ON t2.order_id=t7.order_id AND t2.product_id=t7.product_id AND t2.color_id=t7.color_id");

        return view('enzo_site.order_detail', compact('title', 'category_list', 'sub_category_list', 'company_info', 'customer_data', 'count_cart_items', 'orders', 'order_detail', 'invoice_no'));
    }

    public function productReview(Request $request){
        $this->validate($request, [
            'product_review' => 'required'
        ]);

        $session = new Session();
        $customer_id = $session->get('customer_id');

        $product_review = new ProductReview();
        $product_review->order_id = $request->order_id;
        $product_review->customer_id = $request->customer_id;
        $product_review->product_id = $request->product_id;
        $product_review->color_id = $request->color_id;
        $product_review->review_description = $request->product_review;
        $product_review->rating = $request->product_rating;
        $product_review->rating = $request->product_rating;
        $product_review->status = 1;
        $product_review->save();

        \Session::flash('message', "Product Review is Placed Successfully!");

        return redirect()->back();
    }
}