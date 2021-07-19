<?php

namespace App\Http\Controllers;

use App\CompanyInfo;
use App\Customer;
use App\Order;
use App\OrderDetail;
use App\ProductStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $title = 'ENZO | Orders';

        $company_info = CompanyInfo::all();
        $customers = Customer::all();
        $all_orders = Order::all();
        $orders = Order::wherein('status', [1, 2, 3])->orderBy('id', 'desc')->paginate(100);

        return view('enzo_admin.orders', compact('title', 'company_info', 'orders', 'all_orders', 'customers'));
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
            'request_message' => '',
            'note_message' => 'Please note, we are unable to change your delivery address once your order is placed.',
        );

        Mail::send('emails.order_progress_email', $data, function($message) use($email, $invoice_no)
        {
            $message
                ->to($email)
                ->subject("Your Order#$invoice_no is Confirmed!");
        });

        return redirect()->back();
    }

    public function orderCancel($order_id){

        $order = Order::find($order_id);
        $order->status = 0;
        $order->save();

        $order_customer = Order::find($order_id)->customer()->get();
        $nick_name = $order_customer[0]->nick_name;
        $email = $order_customer[0]->email;
        $invoice_no = $order->invoice_no;

        $data = array(
            'name' => $nick_name,
            'invoice_no' => $invoice_no,
            'status' => 'cancelled',
            'request_message' => '',
            'note_message' => 'Thank you for shopping with ENZO.',
        );

        Mail::send('emails.order_progress_email', $data, function($message) use($email, $invoice_no)
        {
            $message
                ->to($email)
                ->subject("Your Order#$invoice_no is Cancelled!");
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
            'request_message' => '',
            'note_message' => 'Please note, we are unable to change your delivery address once your order is placed.'
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
        $order->payment_status = 1;
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
            'note_message' => '',
        );

        Mail::send('emails.order_progress_email', $data, function($message) use($email, $invoice_no)
        {
            $message
                ->to($email)
                ->subject("Your Order#$invoice_no is Delivered!");
        });

        return redirect()->back();
    }

    public function searchOrder(Request $request){
        $invoice_no = $request->invoice_no;
        $order_status = $request->order_status;
        $customer = $request->customer;
        $order_date_from = $request->order_date_from;
        $order_date_to = $request->order_date_to;

        $query = Order::query();

        if ($invoice_no!=null) {
            $query = $query->where('id', $invoice_no);
        }

        if ($customer!=null) {
            $query = $query->where('customer_id', $customer);
        }

        if ($order_status!=null) {
            $query = $query->where('status', $order_status);
        }

        if (($order_date_from!=null) && ($order_date_to!=null)) {
            $query = $query->whereBetween(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), [$order_date_from, $order_date_to]);
        }

        $query = $query->orderBy('created_at', 'ASC');

        $orders = $query->get();

        $new_row = '';

        foreach ($orders AS $k => $order){

            if ($order->status == 0){
                $change_status_btn = '<span class="badge badge-danger">CANCELLED</span>';
            }
            elseif ($order->status == 1){
                $change_status_btn = '<span class="badge badge-info">RECEIVED</span>';
            }
            elseif($order->status == 2){
                $change_status_btn = '<span class="badge badge-primary">CONFIRMED</span>';
            }
            elseif($order->status == 3){
                $change_status_btn = '<span class="badge badge-warning">ON-SHIPMENT</span>';
            }
            elseif($order->status == 4){
                $change_status_btn = '<span class="badge badge-success">DELIVERED</span>';
            }else{
                $change_status_btn = '';
            }

            if ($order->payment_type == 1){
                $payment_type = 'Cash-on-Delivery';
            }
            elseif ($order->payment_type == 2){
                $payment_type = 'e-Payment';
            }else{
                $payment_type = '';
            }

            if ($order->payment_status == 0){
                $payment_status = '<span class="badge badge-danger">Not Paid</span>';
            }
            elseif ($order->payment_status == 1){
                $payment_status = '<span class="badge badge-success">Paid</span>';
            }else{
                $payment_status = '';
            }

            $new_row .= '<tr>';
            $new_row .= '<td class="text-center">'.($k+1).'</td>';
            $new_row .= '<td class="text-center">'.$order->invoice_no.'</td>';
            $new_row .= '<td class="text-center">'.$order->net_amount.'</td>';
            $new_row .= '<td class="text-center">'.$payment_type.' '.$payment_status.'</td>';
            $new_row .= '<td class="text-center">'.$change_status_btn.'</td>';
            $new_row .= '<td class="text-center"><a class="btn btn-info btn-sm" href="'.route('new_order_detail', $order->id).'"><i class="fas fa-tasks"></i></a></td>';
            $new_row .= '</tr>';

        }

        return $new_row;
    }

    public function generateInvoice($order_id){
        $title = 'ENZO | Invoice';

        $company_info = CompanyInfo::all();
        $order_info = Order::find($order_id);
        $order_detail = OrderDetail::where('order_details.order_id', $order_id)
                        ->join('products', 'products.id', '=', 'order_details.product_id')
                        ->join('product_colors', 'product_colors.id', '=', 'order_details.color_id')
                        ->join('product_sizes', 'product_sizes.id', '=', 'order_details.size_id')
                        ->select('order_details.*','products.product_name','product_colors.color',
                            'product_sizes.size','product_sizes.size_description')
                        ->get();

        return view('enzo_admin.invoice', compact('company_info', 'order_detail', 'order_info'));
    }
}
