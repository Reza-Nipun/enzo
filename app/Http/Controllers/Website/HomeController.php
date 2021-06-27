<?php

namespace App\Http\Controllers\Website;

use App\Category;
use App\CompanyInfo;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductColor;
use App\ProductImage;
use App\ProductReview;
use App\ProductSize;
use App\ProductSpecification;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Session\Session;

class HomeController extends Controller
{
    public function index(){
        $title = "ENZO | Home";

        $session = new Session();

        $customer_data = array();
        $customer_data['customer_id'] = $session->get('customer_id');
        $customer_data['nick_name'] = $session->get('nick_name');
        $customer_data['email'] = $session->get('email');

        $company_info = $this->companyInfo();
        $category_list = $this->menuCategoryItems();
        $sub_category_list = $this->menuSubCategoryItems();

        $new_products = Product::where('status', 1)->orderBy('id', 'desc')->take(8)->get();

        $count_cart_items = 0;
        if(session()->has('cart')){
            $cart_items = session()->get('cart');
            $count_cart_items = sizeof($cart_items);
        }

        $meta_keywords = isset($company_info[0]->meta_keywords) ? $company_info[0]->meta_keywords : '';
        $meta_description = isset($company_info[0]->meta_description) ? $company_info[0]->meta_description : '';

        return view('enzo_site.home', compact('title', 'category_list', 'sub_category_list', 'new_products', 'company_info', 'customer_data', 'count_cart_items', 'meta_keywords', 'meta_description'));
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

    static function getProductsBySubcategoryId($sub_cat_id, $limit){
        return $new_products = Product::where('status', 1)->where('sub_category_id', $sub_cat_id)->orderBy('id', 'desc')->take($limit)->get();
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
        $product_info = Product::find($id);
        $product_sub_category_id = $product_info->sub_category_id;
        $product_meta_keywords = ($product_info->meta_keywords <> '' ? $product_info->meta_keywords : '');
        $product_meta_description = ($product_info->meta_description <> '' ? $product_info->meta_description : '');

        $title = "ENZO | ".$product_info->product_name;

        $session = new Session();

        $customer_data = array();
        $customer_data['customer_id'] = $session->get('customer_id');
        $customer_data['nick_name'] = $session->get('nick_name');
        $customer_data['email'] = $session->get('email');

        $company_info = $this->companyInfo();
        $category_list = $this->menuCategoryItems();
        $sub_category_list = $this->menuSubCategoryItems();

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

        $product_color_id = $product_images[0]->color_id;
        $product_reviews = ProductReview::join('customers', 'customers.id', '=', 'product_reviews.customer_id')
                                        ->select('product_reviews.*', 'customers.full_name')
                                        ->where('product_reviews.product_id', $id)
                                        ->where('product_reviews.color_id', $product_color_id)
                                        ->orderBy('product_reviews.id', 'desc')
                                        ->limit(5)->get();

        $product_sizes = ProductSize::where('product_id', $id)->where('status', 1)->get();
        $product_specifications = ProductSpecification::where('product_id', $id)->where('status', 1)->get();

        $related_products = Product::where('status', 1)->where('id', '<>', $id)->where('sub_category_id', $product_sub_category_id)->orderBy('id', 'desc')->take(6)->get();

        $count_cart_items = 0;
        if(session()->has('cart')){
            $cart_items = session()->get('cart');
            $count_cart_items = sizeof($cart_items);
        }

        $meta_keywords = (isset($company_info[0]->meta_keywords) ? $company_info[0]->meta_keywords.', ' : '').$product_meta_keywords;
        $meta_description = (isset($company_info[0]->meta_description) ? $company_info[0]->meta_description.' ' : '').$product_meta_description;

        return view('enzo_site.single_product', compact('title', 'category_list', 'sub_category_list', 'product_info', 'product_colors', 'product_images', 'product_sizes', 'product_specifications', 'related_products', 'company_info', 'customer_data', 'count_cart_items', 'product_reviews', 'meta_keywords', 'meta_description'));
    }

    public function getSubCategoryWiseProductList($sub_cat_id=null){
        $sub_cat_info = SubCategory::find($sub_cat_id);

        $title = "ENZO | ".$sub_cat_info->sub_category_name;

        $session = new Session();
        $customer_data = array();
        $customer_data['customer_id'] = $session->get('customer_id');
        $customer_data['nick_name'] = $session->get('nick_name');
        $customer_data['email'] = $session->get('email');

        $company_info = $this->companyInfo();
        $category_list = $this->menuCategoryItems();
        $sub_category_list = $this->menuSubCategoryItems();

        $products = Product::where('sub_category_id', $sub_cat_id)->where('status', 1)->orderBy('id', 'desc')->paginate(24);

        $count_cart_items = 0;
        if(session()->has('cart')){
            $cart_items = session()->get('cart');
            $count_cart_items = sizeof($cart_items);
        }

        $meta_keywords = isset($company_info[0]->meta_keywords) ? $company_info[0]->meta_keywords : '';
        $meta_description = isset($company_info[0]->meta_description) ? $company_info[0]->meta_description : '';

        return view('enzo_site.product_list', compact('title', 'category_list', 'sub_category_list', 'sub_cat_info', 'products', 'company_info', 'customer_data', 'count_cart_items', 'meta_keywords', 'meta_description'));
    }

    public function aboutUs(){
        $title = "ENZO | About Us";

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

        $meta_keywords = isset($company_info[0]->meta_keywords) ? $company_info[0]->meta_keywords : '';
        $meta_description = isset($company_info[0]->meta_description) ? $company_info[0]->meta_description : '';

        return view('enzo_site.about_us', compact('title', 'category_list', 'sub_category_list', 'company_info', 'customer_data', 'count_cart_items', 'meta_keywords', 'meta_description'));
    }

    public function contactUs(){
        $title = "ENZO | Contact";

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

        $meta_keywords = isset($company_info[0]->meta_keywords) ? $company_info[0]->meta_keywords : '';
        $meta_description = isset($company_info[0]->meta_description) ? $company_info[0]->meta_description : '';

        return view('enzo_site.contact_us', compact('title', 'category_list', 'sub_category_list', 'company_info', 'customer_data', 'count_cart_items', 'meta_keywords', 'meta_description'));
    }

    public function contactMessage(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email_address' => 'required|email',
            'query_message' => 'required',
        ]);

        $email = 'info@enzo.fashion';
        $cc_email = $request->email_address;

        $data = array(
            'name' => $request->name,
            'contact_no' => $request->contact_no,
            'email_address' => $request->email_address,
            'query_message' => nl2br(htmlspecialchars($request->query_message)),
        );

        Mail::send('emails.message_contact_form', $data, function($message) use($email, $cc_email)
        {
            $message
                ->to($email)
                ->cc($cc_email)
                ->subject("Message From Contact Form!");
        });

        \Session::flash('message', "Your message is successfully sent to ENZO. Thank you for your query.");

        return redirect()->back();
    }
}