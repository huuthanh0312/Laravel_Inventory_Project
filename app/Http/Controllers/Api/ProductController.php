<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::table('products')->join('suppliers', 'products.supplier_id', 'suppliers.id')
                                        ->join('categories', 'products.category_id', 'categories.id')
                                        ->select('categories.category_name', 'suppliers.name', 'products.*')
                                        ->orderBy('id', 'desc')
                                        ->get();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|max:255',
            'product_code' => 'required',
            'category_id' => 'required',
            'root' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',
            'supplier_id' => 'required',
            'buying_date' => 'required',
            'product_quantity' => 'required',

        ]);

        if($request->image){
            $position = strpos($request->image,';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1]; //get tail png, jpg, jpeg
            $img_name  =  time().'.'.$ext;    // merge image name  example.png
            $image = Image::make($request->image);
            $up_location = 'images/product/';
            $image_url = $up_location.$img_name;      //merge path image
            $image->save($image_url);
    
            $product = new Product(); 
            $product->product_name = $request->product_name; 
            $product->product_code = $request->product_code;
            $product->category_id = $request->category_id;
            $product->root = $request->root;
            $product->buying_price = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->supplier_id = $request->supplier_id;
            $product->buying_date = $request->buying_date;
            $product->product_quantity = $request->product_quantity;
            $product->image = $image_url;
            $product->save();
            return response()->json(['Insert Product Successfully']);
        }else{
            $product = new Product(); 
            $product->product_name = $request->product_name; 
            $product->product_code = $request->product_code;
            $product->category_id = $request->category_id;
            $product->root = $request->root;
            $product->buying_price = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->supplier_id = $request->supplier_id;
            $product->buying_date = $request->buying_date;
            $product->product_quantity = $request->product_quantity;
            $product->save();
            return response()->json(['Insert Product Successfully Not Image']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
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

        $product = Product::find($id);  
        $product->product_name = $request->product_name; 
        $product->product_code = $request->product_code;
        $product->category_id = $request->category_id;
        $product->root = $request->root;
        $product->buying_price = $request->buying_price;
        $product->selling_price = $request->selling_price;
        $product->supplier_id = $request->supplier_id;
        $product->buying_date = $request->buying_date;
        $product->product_quantity = $request->product_quantity;     
            
        $image = $request->newimage;
        if($image){
            $position = strpos($image,';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1]; //get tail png, jpg, jpeg
            $img_name  =  time().'.'.$ext;    // merge image name  example.png
            $image = Image::make($image);
            $up_location = 'images/product/';
            $image_url = $up_location.$img_name;      //merge path image
            $success = $image->save($image_url);

            if($success){
                unlink($product->image);
                $product->image = $image_url;
            }
            
        }
        $product->save();
        
        return response()->json(['Insert Product Successfully Not Image']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if($product->image){
            unlink($product->image);
            product::find($id)->delete();
        }else{
            product::find($id)->delete();
        }
        return response()->json(['Deleted Product Successfully']);
    }

    public function updateStock(Request $request, $id){
        $product = Product::find($id);  
        $product->product_quantity = $request->product_quantity;
        $product->save();
        
        return response()->json(['Update Stock Successfully']);
    }
}
