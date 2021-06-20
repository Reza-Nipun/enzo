<?php

namespace App\Http\Controllers;

use App\CompanyInfo;
use App\Order;
use App\OrderDetail;
use App\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function newOrders(){
        $title = 'ENZO | New Orders';

        $company_info = CompanyInfo::all();
        $new_orders = Order::wherein('status', [1, 2, 3])->get();

        return view('enzo_admin.new_orders', compact('title', 'company_info', 'new_orders'));
    }

    public function newOrderDetail($order_id){
        $title = 'ENZO | Order Detail';

        $company_info = CompanyInfo::all();
        $order_info = Order::find($order_id);
        $order_detail = OrderDetail::where('order_details.order_id', $order_id)
                                        ->join('products', 'products.id', '=', 'order_details.product_id')
                                        ->join('product_colors', 'product_colors.id', '=', 'order_details.color_id')
                                        ->join('product_sizes', 'product_sizes.id', '=', 'order_details.size_id')
                                        ->select('order_details.*','products.product_name','product_colors.color',
                                            'product_sizes.size','product_sizes.size_description')
                                        ->get();

        $customer_info = Order::find($order_id)->customer()->get();

        return view('enzo_admin.order_detail', compact('title', 'company_info', 'order_info', 'order_detail', 'customer_info'));
    }

    public function orderConfirm($order_id){

        $order_details = OrderDetail::where('order_id', $order_id)->get();

        foreach ($order_details AS $order_detail){
            $product_id = $order_detail->product_id;
            $color_id = $order_detail->color_id;
            $size_id = $order_detail->size_id;
            $quantity = $order_detail->quantity;

            ProductStock::where('product_id', $product_id)
                            ->where('color_id', $color_id)
                            ->where('size_id', $size_id)
                            ->update(['quantity' => \DB::raw("quantity - $quantity")]);
        }

        $order = Order::find($order_id);
        $order->status = 2;
        $order->save();

        $order_customer = Order::find($order_id)->customer()->get();
        $nick_name = $order_customer[0]->nick_name;
        $email = $order_customer[0]->email;
        $invoice_no = $order->invoice_no;

        $data = array(
            'name' => $nick_name,
            'invoice_no' => $invoice_no,
            'status' => 'confirmed and processing',
            'request_message' => ''
        );

        Mail::send('emails.order_progress_email', $data, function($message) use($email, $invoice_no)
        {
            $message
                ->to($email)
                ->subject("Your Order#$invoice_no is Confirmed!");
        });

        return redirect()->back();
    }

    public function shipmentConfirm(Request $request, $order_id){
        $this->validate($request, [
            'shipment_by' => 'required'
        ]);

        $order = Order::find($order_id);
        $order->shipment_by = $request->shipment_by;
        $order->shipment_remarks = $request->shipment_remarks;
        $order->status = 3;
        $order->save();

        $order_customer = Order::find($order_id)->customer()->get();
        $nick_name = $order_customer[0]->nick_name;
        $email = $order_customer[0]->email;
        $invoice_no = $order->invoice_no;

        $data = array(
            'name' => $nick_name,
            'invoice_no' => $invoice_no,
            'status' => 'on shipment',
            'request_message' => ''
        );

        Mail::send('emails.order_progress_email', $data, function($message) use($email, $invoice_no)
        {
            $message
                ->to($email)
                ->subject("Your Order#$invoice_no is ON SHIPMENT!");
        });

        return redirect()->back();
    }

    public function orderDeliver($order_id){
        $order = Order::find($order_id);
        $order->status = 4;
        $order->save();

        $order_customer = Order::find($order_id)->customer()->get();
        $nick_name = $order_customer[0]->nick_name;
        $email = $order_customer[0]->email;
        $invoice_no = $order->invoice_no;

        $data = array(
            'name' => $nick_name,
            'invoice_no' => $invoice_no,
            'status' => 'delivered',
            'request_message' => 'Please help us by providing your precious review.',
        );

        Mail::send('emails.order_progress_email', $data, function($message) use($email, $invoice_no)
        {
            $message
                ->to($email)
                ->subject("Your Order#$invoice_no is Delivered!");
        });

        return redirect()->back();
    }
}
