<?php

namespace App\Http\Controllers;

use App\CompanyInfo;
use App\Customer;
use App\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = 'ENZO | Home';

        $year = date('Y');
        $month = date('m');

        $company_info = CompanyInfo::all();
        $new_orders = Order::where('status', 1)->count();
        $current_month_sales_amount = Order::where('status', 4)
                                            ->where('payment_status', 1)
                                            ->whereYear('created_at', $year)
                                            ->whereMonth('created_at', $month)
                                            ->sum('net_amount');
        $customers = Customer::where('status', 1)->count();

        return view('enzo_admin.dashboard', compact('title', 'company_info', 'new_orders', 'current_month_sales_amount', 'customers'));
    }
}
