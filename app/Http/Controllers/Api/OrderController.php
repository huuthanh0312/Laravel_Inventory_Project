<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use DB;
use DateTime;

class OrderController extends Controller
{
    public function todayOrder(){
        $date = date('d/m/Y');

        $order = DB::table('orders')->join('customers', 'customers.id', 'orders.customer_id')
                        ->where('order_date', $date)->select('customers.name','orders.*')->orderBy('id','desc')->get();
        return response()->json($order);
    }

    public function orderDetails($id){
        $order = DB::table('orders')->join('customers', 'customers.id', 'orders.customer_id')
                    ->where('orders.id', $id)->select('customers.name','customers.address','customers.phone','orders.*')->first();
        return response()->json($order);
    }
    public function orderDetailsAll($id){
        $details = DB::table('order_details')->join('products', 'products.id', 'order_details.product_id')
                    ->where('order_details.order_id', $id)
                    ->select('products.product_name','products.image','products.product_code','order_details.*')->get();
        return response()->json($details);
    }

    public function searchOrderDate(Request $request){
        $order_date = $request->date;
        $newdate = new DateTime($order_date);
        $done = $newdate->format('d/m/Y');

        $order = DB::table('orders')->join('customers', 'customers.id', 'orders.customer_id')
                        ->where('orders.order_date', $done)->select('customers.name','orders.*')->get();
        return response()->json($order);
    }
}
