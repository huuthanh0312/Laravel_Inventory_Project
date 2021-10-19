<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Pos;
use App\Models\Extra;

class CartController extends Controller
{
    
    public function addToCart($id){
        $product = Product::where('id', $id)->first();
        $check = Pos::where('pro_id', $id)->first();
        if($check){
            Pos::where('pro_id', $id)->increment('pro_quantity');  // add +1 product
            $pro = Pos::where('pro_id', $id)->first();;
            $pro->sub_total = $pro->pro_quantity * $pro->product_price;
            $pro->save();
            return response('Done');
        }else{
            $data = array();
            $data['pro_id'] = $id;
            $data['pro_name'] = $product->product_name;
            $data['pro_quantity'] = 1;
            $data['product_price'] = $product->selling_price;
            $data['sub_total'] = $product->selling_price;
    
            Pos::insert($data);
            return response('Done');
        }  

    }

    public function cartProduct() {
        $product = Pos::all();
        return response()->json($product);
    }

    public function removeCart($id) {
        Pos::find($id)->delete();
        return response()->json('Deleted Done');
    }

    public function incrementCart($id) {
        $quantity = Pos::where('id', $id)->increment('pro_quantity');
        $product = Pos::find($id);
        $product->sub_total = $product->pro_quantity * $product->product_price;
        $product->save();
        return response('Done');
    }
    public function decrementCart($id) {
        $quantity = Pos::where('id', $id)->decrement('pro_quantity');
        $product = Pos::find($id);
        $product->sub_total = $product->pro_quantity * $product->product_price;
        $product->save();
        return response('Done');
    }
    public function Vats() {
        $vat = Extra::first();
        return response()->json($vat);
    }

}
