<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Facade\IgnitionContracts\HasSolutionsForThrowable;
use Illuminate\Http\Request;

use App\Customer;
use App\Category;
use App\SubCategory;
use App\CompanyInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session = new Session();

        $customer_data = array();
        $customer_data['customer_id'] = $session->get('customer_id');
        $customer_data['nick_name'] = $session->get('nick_name');
        $customer_data['email'] = $session->get('email');


        if(!empty($customer_data['customer_id'])){
            return redirect('/');
        }else{
            $title = "ENZO | Register";

            $company_info = $this->companyInfo();
            $category_list = $this->menuCategoryItems();
            $sub_category_list = $this->menuSubCategoryItems();

            return view('enzo_site.register', compact('title', 'category_list', 'sub_category_list', 'company_info', 'customer_data'));
        }

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'nick_name' => 'required',
            'full_name' => 'required',
            'contact_no' => 'required',
            'email' => 'required|email|unique:customers,email',
            'address' => 'required',
            'password' => 'required|same:confirmed_password|min:8',
        ]);

        $customer = new Customer();
        $customer->nick_name = $request->nick_name;
        $customer->full_name = $request->full_name;
        $customer->contact_no = $request->contact_no;
        $customer->address = $request->address;
        $customer->email = $request->email;
        $customer->password = Hash::make($request->password);
        $customer->status = 1;
        $customer->promotional_message = 1;
        $customer->save();

        $customer_id = $customer->id;

        $email = $request->email;

        $data = array(
            'name' => $request->nick_name,
        );

        Mail::send('emails.welcome_email', $data, function($message) use($email)
        {
            $message
                ->to($email)
                ->subject('Welcome to ENZO');
        });

        $session = new Session();
        $session->set('customer_id', $customer_id);
        $session->set('nick_name', $request->nick_name);
        $session->set('email', $request->email);

        \Session::flash('message', "Account Successfully Created!");

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function customerLogin(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        $user = Customer::where('email', $email)->first();

        if (!$user) {
            \Session::flash('error_message', "Invalid Email Address!");
        }elseif (!Hash::check($password, $user->password)) {
            \Session::flash('error_message', "Invalid Password!");
        }else{
            $session = new Session();
            $session->set('customer_id', $user->id);
            $session->set('nick_name', $user->nick_name);
            $session->set('email', $user->email);
        }

        return redirect()->back();
    }

    public function customerForgotPassword(){
        $title = "ENZO | Forgot Password";

        $company_info = $this->companyInfo();
        $category_list = $this->menuCategoryItems();
        $sub_category_list = $this->menuSubCategoryItems();

        $customer_data = array();

        $session = new Session();
        $customer_data['customer_id'] = $session->get('customer_id');
        $customer_data['nick_name'] = $session->get('nick_name');
        $customer_data['email'] = $session->get('email');


        if(!empty($customer_data['customer_id'])){
            return redirect('/');
        }else {
            return view('enzo_site.forgot_password', compact('title', 'category_list', 'sub_category_list', 'company_info', 'customer_data'));
        }
    }

    public function sendCustomerResetPasswordLink(Request $request){
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $mytime = Carbon::now();
        $now_dt_time = $mytime->toDateTimeString();
        $now_date_time = Carbon::parse($now_dt_time)
                                ->addSeconds(3600)
                                ->format('Y-m-d H:i:s');

        $email = $request->email;

        $user = Customer::where('email', $email)->first();

        DB::table('password_resets')->where('email',$email)->where('created_at','<',Carbon::now())->delete();

        if(!$user){
            \Session::flash('forgot_password_error_message', "Invalid Email Address!");
        }else{
            $token = DB::table('password_resets')
                ->where('email',$email)
                ->first();

            if(!$token){
                $new_token = Str::random(60);

                DB::table('password_resets')->insert([
                    'email' => $email,
                    'token' => $new_token, //change 60 to any length you want
                    'created_at' => $now_date_time
                ]);

                $email = $request->email;

                $data = array(
                    'name' => $user->nick_name,
                    'email' => $email,
                    'token' => $new_token,
                );

//                return $data;

                \Session::flash('message', "Reset password link is sent to your email address. Please click there within next 60 minutes.");
            }else{
                $data = array(
                    'name' => $user->nick_name,
                    'email' => $email,
                    'token' => $token->token,
                );

//                return $data;

                \Session::flash('forgot_password_error_message', "You have a pending reset password request! Reset password link is sent to your email address again.");
            }

            Mail::send('emails.reset_password_email', $data, function($message) use($email)
            {
                $message
                    ->to($email)
                    ->subject('ENZO - Reset Password Link');
            });

        }

        return redirect()->back();
    }

    public function customerResetPasswordLink($email, $token){
        $title = "ENZO | Reset Password";

        $company_info = $this->companyInfo();
        $category_list = $this->menuCategoryItems();
        $sub_category_list = $this->menuSubCategoryItems();

        $customer_data = array();

        $session = new Session();
        $customer_data['customer_id'] = $session->get('customer_id');
        $customer_data['nick_name'] = $session->get('nick_name');
        $customer_data['email'] = $session->get('email');

        $mytime = Carbon::now();
        $now_date_time = $mytime->toDateTimeString();


        $token = DB::table('password_resets')
                ->where('email',$email)
                ->where('token',$token)
                ->where('created_at','>',Carbon::now())
                ->first();

        if(!$token){
            DB::table('password_resets')->where('email',$email)->where('created_at','<',Carbon::now())->delete();

            \Session::flash('forgot_password_error_message', "Your reset password link is expired! Try again.");

            return redirect('customer_forgot_password');
        }else{
            return view('enzo_site.reset_password', compact('title', 'category_list', 'sub_category_list', 'company_info', 'customer_data', 'token'));
        }
    }

    public function changeCustomerPassword(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|same:confirmed_password|min:8',
        ]);

        Customer::where('email', $request->email)
                ->update([
                    'password' => Hash::make($request->password)
                ]);

        DB::table('password_resets')->where('email',$request->email)->delete();

        \Session::flash('message', "Your password reset operation is successful!");

        return redirect('customer_forgot_password');
    }

    public function customerLogout(){
        $session = new Session();

        $session->remove('customer_id');
        $session->remove('nick_name');
        $session->remove('email');

        return redirect()->back();
    }
}
