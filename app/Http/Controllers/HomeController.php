<?php

namespace App\Http\Controllers;

use App\CompanyInfo;
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

        $company_info = CompanyInfo::all();
        $new_orders = Order::where('status', 1)->count();

        return view('enzo_admin.dashboard', compact('title', 'company_info', 'new_orders'));
    }
}
