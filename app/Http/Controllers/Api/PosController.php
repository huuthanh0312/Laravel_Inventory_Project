<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Pos;
use App\Models\OrderDetail;
use DB;

class PosController extends Controller
{
    public function getProduct($id) {
        $product = Product::where('category_id', $id)->get();
        return response()->json($product);
    }

    public function orderDone(Request $request){
        $validateData = $request->validate([
            'customer_id' => 'required',
            'payby' => 'required',
        ]);

        $data = array();
        $data['customer_id'] = $request->customer_id;
        $data['qty'] = $request->qty;
        $data['sub_total'] = $request->subtotal;
        $data['vat'] = $request->vat;
        $data['total'] = $request->total;
        $data['pay'] = $request->pay;
        $data['due'] = $request->due;
        $data['payby'] = $request->payby;
        $data['order_date'] = date('d/m/Y');
        $data['order_month'] = date('F');
        $data['order_year'] = date('Y');

        $order_id = Order::insertGetId($data);

        $contents = Pos::all();

        $odata = array();
        foreach ($contents as $content){
            $odata['order_id'] = $order_id;
            $odata['product_id'] = $content->pro_id;
            $odata['pro_quantity'] = $content->pro_quantity;
            $odata['product_price'] = $content->product_price;
            $odata['sub_total'] = $content->sub_total;
            OrderDetail::insert($odata);

            DB::table('products')->where('id',$content->pro_id)
                                ->update(['product_quantity'=> DB::raw('product_quantity -' .$content->pro_quantity)]);

        }
        DB::table('Pos')->delete();
        return response('Done');

    }

    public function todaySell(){
        $date = date('d/m/Y');
        $sell = DB::table('orders')->where('order_date', $date)->sum('total');
        return response()->json($sell);
    }

    public function todayIncome(){
        $date = date('d/m/Y');
        $income = DB::table('orders')->where('order_date', $date)->sum('pay');
        return response()->json($income);
    }

    public function todayDue(){
        $date = date('d/m/Y');
        $due = DB::table('orders')->where('order_date', $date)->sum('due');
        return response()->json($due);
    }

    public function todayExpense(){
        $date = date('d/m/Y');
        $expense = DB::table('expenses')->where('expense_date', $date)->sum('amount');
        if($expense == null){
            $expense = 0;
        }
        return response()->json($expense);
    }

    public function todayStockOut() {
        $stock = DB::table('products')->where('product_quantity', '<', '1')->get();
        return response()->json($stock);
    }
}
